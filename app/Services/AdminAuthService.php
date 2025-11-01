<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAuthService
{
    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }
        if (! $user->admin) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied not an admin account',
            ], 403);
        }

        $token = $user->createToken('admin_token')->plainTextToken;

        return[
            'success' => true,
            'message' => 'Admin login successful',
            'data' => [
                'admin' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'username' => $user->admin->username,
                ],
                'role' => $user->getRoleNames()->first(),
                'token' => $token,
            ]
        ];
    }
}
