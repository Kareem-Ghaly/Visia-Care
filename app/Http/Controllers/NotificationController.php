<?php
namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __invoke(Request $request, NotificationService $service)
    {
        if ($request->route()->uri() === 'api/my-notifications') {
            return response()->json($service->getMyNotifications($request->user()));
        }

        $role = $request->route('role');
        return response()->json($service->getNotificationsByRole($role));
    }
}
