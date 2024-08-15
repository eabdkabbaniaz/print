<?php

namespace App\Notifications;

use App\Models\Order\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\Notification as FcmNotification;

class CustomerOrderReadyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;
    protected  $orderDelivery;
    public function __construct($order)
    {
        $this->order = $order;
        $this->orderDelivery = [
            'orderType' => 'order',
             'status' => 'مجهزة',
            'OrderId' => $this->order
        ];
    }
  
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
    public function toFcm($notifiable): FcmMessage
    {
        return FcmMessage::create()
            ->setData([
                'notificationtype' => json_encode($this->orderDelivery),

            ])
            ->setNotification(
                FcmNotification::create()
                    ->setTitle('تم تجهيز طلبيتك بنجاح ')
                    ->setBody('order ID: ' . $this->order)
            );
    }
}
