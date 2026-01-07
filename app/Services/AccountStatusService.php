<?php
namespace App\Services;

use App\Models\User;

use Illuminate\Http\JsonResponse;
use App\Notifications\AccountStatusNotification;
class AccountStatusService
{
    public function updateStatus(int $userId, string $status)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => $status]);
       
        $user->notify(new AccountStatusNotification($status));

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
        ]);
    }
}
    // public function getRejectedUsers(): JsonResponse
    // {
    //     $users = $this->getRejectedUsers();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $users
    //     ]);
    // }

