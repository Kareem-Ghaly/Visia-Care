<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderStatusChangedNotification extends Notification
{
    use Queueable;

    private $order;
    private $status;
    private $message;

    public function __construct($order, string $status, string $message)
    {
        $this->order   = $order;
        $this->status  = $status;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'      => 'Order Update',
            'order_id'   => $this->order->id,
            'status'     => $this->status,
            'message'    => $this->message,
            'store_id'   => $this->order->items->first()?->product?->optical_store_id,
        ];
    }
}
