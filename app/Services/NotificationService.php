<?php

namespace App\Services;
use App\Http\Resources\NotificationResource;
use App\Models\User;

class NotificationService
{
     public function getMyNotifications(User $user)
    {
        return [
            'success' => true,
            'data' => NotificationResource::collection(
                $user->notifications()->latest()->get()
            )
        ];
    }
}
