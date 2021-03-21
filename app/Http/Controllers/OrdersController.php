<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\ProductSku;
use App\Models\UserAddress;
use App\Models\Order;
use Carbon\Carbon;
use App\Exceptions\InvalidRequestException;
use App\Jobs\CloseOrder;

class OrdersController extends Controller
{
    //
    public function store(OrderRequest $request)
    {
        $user = $request->user();
        $order = \DB::transaction(function() use ($user, $request){
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
            $user->cartItems()->whereIn('product_sku_id', $skuIds)->delete();
            return $order;
        });

        $this->dispatch(new CloseOrder($order, config('app.order_ttl')));
        return $order;
    }
}
