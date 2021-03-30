<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $delay)
    {
        //
        $this->order = $order;
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        if($this->order->paid_at){
            return ;
        }
        \DB::transaction(function(){
            $this->order->update(['closed' => true]);
            foreach($this->order->items as $item){
                $item->productSku->addStock($item->amount);
            }
            \Log::info($this->order->no.'订单'.config('app.order_ttl').'s内未支付,订单关闭');

            if ($this->order->couponCode) {
                $this->order->couponCode->changeUsed(false);
            }
        });

    }
}
