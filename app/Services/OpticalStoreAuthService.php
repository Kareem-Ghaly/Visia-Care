<?php

namespace App\Services;

use App\Models\OpticalStore;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;


class OpticalStoreAuthService
{
    public function register(array $credentials)
    {
        $user = User::create([
            'full_name'    => $credentials['name'],
            'email'        => $credentials['email'],
            'phone_number' => $credentials['phone_number'],
            'password'     => Hash::make($credentials['password']),
            'status'       => 'pending'
        ]);
        $user->opticalstore()->create([

            'name' => $credentials['name'],
            'shift'      => $credentials['shift'] ?? null,
            'description' => $credentials['description'] ?? null,
            'location'    => $credentials['location'] ?? null,


        ]);
        $user->assignRole('OpticalStore');

        return response()->json([
            'success' => true,
            'message' => 'Your registration request has been submitted. Please wait for admin approval.',
            'data' => new UserResource($user),
        ], 201);
    }
}
