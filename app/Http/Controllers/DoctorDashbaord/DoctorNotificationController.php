<?php

namespace App\Http\Controllers\DoctorDashbaord;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;

class DoctorNotificationController extends Controller
{
    public function __construct(protected NotificationService $service) {}

    public function getDoctorNotifications()
    {
        return $this->service->getNotificationsService();
    }
}

