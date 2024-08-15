<?php

namespace App\Jobs;

use App\Notifications\NewOrderForDelivery;
use App\Notifications\WaiterNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class SendWaiterEmployeeNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order_id;
    public $delivery_user;
    public function __construct($order_id,$delivery_user)
    {
        $this->order_id = $order_id;
        $this->delivery_user = $delivery_user;
       
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $order_id= $this->order_id;
        $delivery_user= $this->delivery_user;
        
        $delivery_user->notify(new WaiterNotification($order_id));
    }
}