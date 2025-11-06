<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApprovalRequestsService
{
    public function approvalRequestService($id)
    {
        $user = User::findOrFail($id);

        if (!$user->hasRole(['Doctor' , 'OpticalStore'])) {
            return response()->json(['message' => 'This user is not authintcated']
            , 400);
        }

        $user->update(['status' => 'approved']);

        Notification::create([
            'receiver_id' => $user->id,
            'sender_id' => auth()->id(),
            'title' => 'Your account has been accepted',
            'description' => 'You can now login to VisiaCare',
        ]);

        return response()->json(['message' => 'The user was accepted and notified']);
    }
}
