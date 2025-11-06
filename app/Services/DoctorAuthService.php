<?php

namespace App\Services;

use App\Models\Notification;
use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\NatificationResource;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class DoctorAuthService
{
    // public function Register(DoctorRegisterRequest $request)
    // {
    //     // try {
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'phone_number' => $request->phone_number,
    //         'gender' => $request->gender,
    //         'status' => 'pending'
    //     ]);

    //     $user->doctorProfile()->create([
    //         'license' => $request->license,
    //         'location' => $request->location,
    //         'shift' => $request->shift,
    //         'bio' => $request->bio
    //     ]);

    //     $user->assignRole('Doctor');

    //     return response()->json([
    //         'message' => 'Your registration request has been submitted. Please wait for admin approval',
    //         'data' => new DoctorResource($user),
    //     ], 201);

    //     // } catch (\Exception $e) {
    //     //     Log::error("message");
    //     //     ('Doctor registration failed: ' . $e->getMessage());

    //     //     return response()->json([
    //     //         'message' => 'An error occurred during registration please try again later',
    //     //     ], 500);
    //     // }
    // }

    // public function Login(DoctorLoginRequest $request)
    // {
    //     try {
    //         if (!Auth::attempt($request->only('email', 'password'))) {
    //             throw ValidationException::withMessages([
    //                 'email' => ['Invalid login credentials'],
    //             ]);
    //         }

    //         $user = Auth::user();

    //         if (!$user->hasRole(['Doctor' , 'OpticalStore'])) {
    //             throw ValidationException::withMessages([
    //                 'role' => ['This account is not registered'],
    //             ]);
    //         }

    //         if ($user->status !== 'approved') {
    //             throw ValidationException::withMessages([
    //                 'status' => ['Your account has not been approved by the admin yet'],
    //             ]);
    //         }

    //         return response()->json([
    //             'message' => 'Login successful.',
    //             'token' => $user->createToken('login-token')->plainTextToken,
    //         ]);

    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'errors' => $e->errors(),
    //         ], 422);
    //     } catch (\Exception $e) {
    //         Log::error('Doctor login failed: ' . $e->getMessage());

    //         return response()->json([
    //             'message' => 'An error occurred during login please try again later',
    //         ], 500);
    //     }
    // }

    public function getNotifications()
    {

        $notifications = Notification::where('receiver_id', auth()->id())->latest()->get();

        return response()->json([
            'data' => NatificationResource::collection($notifications),
        ]);
    }
}
