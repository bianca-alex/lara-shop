<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Models\Order;
use App\Exceptions\InvalidRequestException;
use Carbon\Carbon;
use App\Http\Requests\SendReviewRequest;
/*use Carbon\Carbon;
use App\Exceptions\InvalidRequestException;
use App\Jobs\CloseOrder;*/
//use App\Services\CartService;
use App\Services\OrderService;
use App\Events\OrderReviewed;

class OrdersController extends Controller
{

    public function index(Request $request){
        $user = $request->user();
        $orders = Order::query()
            ->with(['items.product', 'items.productSku'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate();
        return view('orders.index', ['orders' => $orders]);
    }

    public function show(Request $request, Order $order){
        $this->authorize('own', $order);
        return view('orders.show', ['order' => $order->load(['items.product', 'items.productSku'])]);
    }

    //
    public function store(OrderRequest $request, OrderService $orderService)
    {
        $user = $request->user();
        $address = UserAddress::find($request->input('address_id'));
        return $orderService->store($user, $address, $request->input('remark'), $request->input('items'));
        /*$order = \DB::transaction(function() use ($user, $request, $cartService){
            $address = UserAddress::find($request->input('address_id'));
            $address->update(['last_used_at' => Carbon::now()]);
            $order = new Order([
                'address' => [
                    'address' => $address->full_address,
                    'zip'     => $address->zip,
                    'contact_name'   => $address->contact_name,
                    'contact_iphone' => $address->contact_iphone
                ],
                'remark' => $request->input('remark'),
                'total_amount' => 0,
            ]);
            $order->user()->associate($user);
            $order->save();
            $totalAmount = 0;
            $items = $request->input('items');
            foreach($items as $item){
                $sku = ProductSku::find($item['sku_id']);
                $orderitem = $order->items()->make([
                    'amount' => $item['amount'],
                    'price'  => $sku->price,
                ]);
                $orderitem->product()->associate($sku->product_id);
                $orderitem->productSku()->associate($sku);
                $orderitem->save();
                $totalAmount += $item['amount'] * $sku->price;
                if ($sku->decreaseStock($item['amount']) <= 0) {
                    throw new InvalidRequestException('该商品库存不足');
                }
            }
            $order->update(['total_amount' => $totalAmount]);
            $skuIds = collect($items)->pluck('sku_id');
            //$user->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
            $cartService->remove($skuIds);
            return $order;
        });

        $this->dispatch(new CloseOrder($order, config('app.order_ttl')));
        return $order;*/
    }

    public function received(Order $order, Request $request){
        $this->authorize('own', $order);
        if($order->ship_status != Order::SHIP_STATUS_DELIVERED){
            throw new InvalidRequestException('发货状态不正确');
        }

        $order->update(['ship_status' => Order::SHIP_STATUS_RECEIVED]);

        return $order;
    }

    public function review(Order $order)
    {
        $this->authorize('own', $order);
        if(!$order->paid_at){
            throw new InvalidRequestException('该订单未支付，不可评价');
        }

        return view('orders.review', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    public function sendReview(Order $order, SendReviewRequest $request)
    {
        // 校验权限
        $this->authorize('own', $order);
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        // 判断是否已经评价
        if ($order->reviewed) {
            throw new InvalidRequestException('该订单已评价，不可重复提交');
        }
        $reviews = $request->input('reviews');
        // 开启事务
        \DB::transaction(function () use ($reviews, $order) {
            // 遍历用户提交的数据
            foreach ($reviews as $review) {
                $orderItem = $order->items()->find($review['id']);
                // 保存评分和评价
                $orderItem->update([
                    'rating'      => $review['rating'],
                    'review'      => $review['review'],
                    'reviewed_at' => Carbon::now(),
                ]);
            }
            // 将订单标记为已评价
            $order->update(['reviewed' => true]);
        });    
        
        event(new OrderReviewed($order));
        return redirect()->back(); 
    }
}
