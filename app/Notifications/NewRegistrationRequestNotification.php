<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewRegistrationRequestNotification extends Notification
{
    use Queueable;

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New registration request',
            'message' => $this->user->name .
                ' requested to register as ' .
                $this->user->roles->first()->name,
            'user_id' => $this->user->id,
            'role' => $this->user->roles->first()->name,
            'status' => 'pending',
        ];
    }
}
