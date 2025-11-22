<?php

namespace App\Services;

use App\Models\User;

class NotificationService
{
    public function getNotificationsByRole(string $role)
    {
        $user = User::role($role)->first();

        if (!$user) {
            return [
                'success' => false,
                'message' => "No user found with role {$role}"
            ];
        }

        return [
            'success' => true,
            'data' => $user->notifications()->latest()->get()
        ];
    }

    public function getMyNotifications($user)
    {
        return [
            'success' => true,
            'data' => $user->notifications()->latest()->get()
        ];
    }
}
