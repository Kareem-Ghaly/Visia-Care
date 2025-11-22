<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountStatusNotification extends Notification
{
    use Queueable;

    protected string $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $status)
    {
        $this->status = $status; // approved أو rejected
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Status Update')
            ->greeting('Hello ' . $notifiable->name)
            ->line("Your account has been {$this->status} by the admin")
            ->action('Login Now', url('/login'))
            ->line('Thank you for using VisiaCare');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'status' => $this->status,
        ];
    }
}
