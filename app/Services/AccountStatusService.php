<?php
namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class AccountStatusService
{
    public function updateStatus(int $userId, string $status)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => $status]);

        Notification::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'title' => $status === 'approved' ? 'Account Approved' : 'Account Rejected',
            'description' => $status === 'approved'
                ? 'Your account has been approved. You can now login'
                : 'Your registration request has been rejected',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }
    // public function getRejectedUsers(): JsonResponse
    // {
    //     $users = $this->getRejectedUsers();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $users
    //     ]);
    // }
}
