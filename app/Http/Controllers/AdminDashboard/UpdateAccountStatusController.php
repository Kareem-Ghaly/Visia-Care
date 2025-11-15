<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountStatusRequest;
use App\Services\AccountStatusService;
use Illuminate\Http\Request;

class UpdateAccountStatusController extends Controller
{
    public function update(UpdateAccountStatusRequest $request, AccountStatusService $service)
    {
        return $service->updateStatus($request->user_id, $request->status);
    }
}
