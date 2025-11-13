<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountApprovalService
{
    // public function getAccountRequests()
    // {
    //     return [
    //         'pendingDoctors' => User::role('Doctor')->where('status', 'pending')->get(),
    //         'pendingOpticals' => User::role('OpticalStore')->where('status', 'pending')->get(),
    //         'approvedUsers' => User::where('status', 'approved')->get(),
    //         'rejectedUsers' => User::where('status', 'rejected')->get(),
    //     ];
    // }


    //  public function getAccountRequests()
    // {
    //     return [
    //         'pendingDoctors' => User::role('Doctor')->where('status', 'pending')->get(),
    //         'pendingOpticals' => User::role('OpticalStore')->where('status', 'pending')->get(),
    //         'approvedDoctors' => User::role('Doctor')->where('status', 'approved')->get(),
    //         'approvedOpticals' => User::role('OpticalStore')->where('status', 'approved')->get(),
    //         'rejectedUsers' => User::where('status', 'rejected')->get(),
    //     ];
    // }


     public function handle($request)
    {
        $map = [
            'doctors/pending' => ['Doctor', 'pending'],
            'opticals/pending' => ['OpticalStore', 'pending'],
            'doctors/approved' => ['Doctor', 'approved'],
            'opticals/approved' => ['OpticalStore', 'approved'],
            'doctors/rejected' => ['Doctor', 'rejected'],
            'opticals/rejected' => ['OpticalStore', 'rejected'],
        ];

        $path = str_replace(['api/', 'admin/'], '', $request->path());

        if (!isset($map[$path])) {
            return ['error' => 'Invalid request'];
        }

        [$role, $status] = $map[$path];

        return User::role($role)->where('status', $status)->get();
    }
}
