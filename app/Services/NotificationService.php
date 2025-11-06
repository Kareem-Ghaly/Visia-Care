<?php

namespace App\Services;

use App\Models\Notification;
use App\Http\Resources\NatificationResource;

class NotificationService
{
    public function getNotificationsService()
    {

        $notifications = Notification::where('receiver_id', auth()->id())->latest()->get();

        return response()->json([
            'data' => NatificationResource::collection($notifications),
        ]);
    }
}
