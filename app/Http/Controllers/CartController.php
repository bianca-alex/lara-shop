<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Http\Requests\AddCartRequest;
use App\Models\ProductSku;
use App\Services\CartService;

class CartController extends Controller
{
    //
    protected $cartService;
    public function __construct(CartService $cartService){
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        //$cartItems = $request->user()->cartItems()->with(['ProductSku.product'])->get();
        $cartItems = $this->cartService->get();
        $addresses = $request->user()->addresses()->orderBy('last_used_at', 'desc')->get();
        return view('cart.index', ['cartItems' => $cartItems, 'addresses' => $addresses]);
    }

    public function add(AddCartRequest $request)
    {
        /*$user   = $request->user();
        $skuId  = $request->input('sku_id');
        $amount = $request->input('amount');
        if($cart = $user->cartItems()->where('product_sku_id', $skuId)->first()){
            $cart->update([
                'amount' => $cart->amount + $amount
            ]);
        }else{
            $cart = new CartItem(['amount' => $amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }*/
        $this->cartService->add($request->input('sku_id'), $request->input('amount'));

		return [];
    }

    public function remove(Request $request, ProductSku $sku)
    {
        //$request->user()->cartItems()->where('product_sku_id', $sku->id)->delete();
        $this->cartService->remove($sku->id);
        return [];
    }
    
}
