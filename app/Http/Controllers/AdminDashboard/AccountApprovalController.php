<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Services\AccountApprovalService;
use Illuminate\Http\Request;

class AccountApprovalController extends Controller
{
    // public function dashboard(AccountApprovalService $approvalService)
    // {
    //     $data = $approvalService->getAccountRequests();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data,
    //     ]);
    // }

     public function __invoke(Request $request, AccountApprovalService $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service->handle($request)
        ]);
    }
}
