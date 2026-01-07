<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    private $order;
    private $patient;

    public function __construct($order, $patient)
    {
        $this->order   = $order;
        $this->patient = $patient;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'      => 'New Order Received',
            'message'    => "New order #{$this->order->id} received",
            'order_id'   => $this->order->id,
            'patient_id'=> $this->patient->id,
            'status'     => $this->order->status,
        ];
    }
}
