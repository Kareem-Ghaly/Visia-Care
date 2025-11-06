<?php

namespace App\Services;

use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Requests\OpticalStoreRegisterRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\UserResource;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function loginAdminService(array $credentials)
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

        return [
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

    public function registerDoctorService(DoctorRegisterRequest $request)
    {
        // try {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'status' => 'pending'
        ]);

        $user->doctorProfile()->create([
            'license' => $request->license,
            'location' => $request->location,
            'shift' => $request->shift,
            'bio' => $request->bio
        ]);

        $user->assignRole('Doctor');

        return response()->json([
            'message' => 'Your registration request has been submitted. Please wait for admin approval',
            'data' => new DoctorResource($user),
        ], 201);

        // } catch (\Exception $e) {
        //     Log::error("message");
        //     ('Doctor registration failed: ' . $e->getMessage());

        //     return response()->json([
        //         'message' => 'An error occurred during registration please try again later',
        //     ], 500);
        // }
    }

    public function loginService(DoctorLoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid login credentials'],
                ]);
            }

            $user = Auth::user();

            if (!$user->hasRole(['Doctor' , 'OpticalStore'])) {
                throw ValidationException::withMessages([
                    'role' => ['This account is not registered'],
                ]);
            }

            if ($user->status !== 'approved') {
                throw ValidationException::withMessages([
                    'status' => ['Your account has not been approved by the admin yet'],
                ]);
            }

            return response()->json([
                'message' => 'Login successful.',
                'token' => $user->createToken('login-token')->plainTextToken,
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Doctor login failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred during login please try again later',
            ], 500);
        }
    }

    public function registerOpticalStoreService(OpticalStoreRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'status' => 'pending'
        ]);
        $user->opticalstore()->create([
            'storeName' => $request->storeName,
            'shift'      => $request->shift ?? null,
            'description' => $request->description ?? null,
            'location'    => $request->location ?? null,
        ]);
        $user->assignRole('OpticalStore');

        return response()->json([
            'success' => true,
            'message' => 'Your registration request has been submitted. Please wait for admin approval.',
            'data' => new UserResource($user),
        ], 201);
    }
}
