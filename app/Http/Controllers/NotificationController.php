<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function myNotifications(Request $request, NotificationService $service)
    {
        return response()->json(
            $service->getMyNotifications($request->user())
        );
    }
}
