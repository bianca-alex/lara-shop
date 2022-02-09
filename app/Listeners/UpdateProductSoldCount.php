<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\OrderItem;

class UpdateProductSoldCount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderPaid  $event
     * @return void
     */
    public function handle(OrderPaid $event)
    {
        \Log::info('event sold_count测试');
        //
        $order = $event->getOrder();
        $order->load('items.product');
        foreach($order->items as $item){
            $product = $item->product;
            $soldCount = OrderItem::query()
                    ->where('product_id', $product->id)
                    ->whereHas('order', function($query){
                        $query->whereNotNull('paid_at');
                    })->sum('amount');
            $product->update([
                'sold_count' => $soldCount,
            ]);
        }
    }
}
