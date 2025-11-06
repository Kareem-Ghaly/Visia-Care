<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Services\ApprovalRequestsService;
use Illuminate\Http\Request;

class ApprovalRequestsController extends Controller
{
    public function __construct(protected ApprovalRequestsService $service) {}

    public function ApprovalRequest($id)
    {
        return $this->service->approvalRequestService($id);
    }
}
