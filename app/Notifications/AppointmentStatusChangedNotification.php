<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentStatusChangedNotification extends Notification
{
    use Queueable;

    private $appointment;
    private $status;
    private $message;

    public function __construct($appointment, string $status, string $message)
    {
        $this->appointment = $appointment;
        $this->status = $status;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title'          => 'Appointment Update',
            'message'        => $this->message,
            'appointment_id' => $this->appointment->id,
            'status'         => $this->status,
            'doctor_id'      => $this->appointment->doctor_id,
            'date'           => $this->appointment->appointment_date,
            'appointment_time'=> $this->appointment->appointment_time,
        ];
    }
}
