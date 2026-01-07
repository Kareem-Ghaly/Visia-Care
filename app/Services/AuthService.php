<?php

namespace App\Services;

use App\Http\Requests\DoctorLoginRequest;
use App\Http\Requests\DoctorRegisterRequest;
use App\Http\Requests\OpticalStoreRegisterRequest;
use App\Http\Requests\PatientRegisterRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\NewRegistrationRequestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthService
{
    
    public function registerDoctorService(DoctorRegisterRequest $request)
    {
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'gender'       => $request->gender,
            'status'       => 'pending',
        ]);

        $user->doctorProfile()->create([
            'license'  => $request->license,
            'location' => $request->location,
            'bio'      => $request->bio,
        ]);

        $user->assignRole('Doctor');


        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewRegistrationRequestNotification($user));
        }

        return response()->json([
            'message' => 'Your registration request has been submitted. Please wait for admin approval',
            'data'    => new DoctorResource($user),
        ], 201);
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

            if (!$user->hasRole(['Admin', 'Doctor', 'OpticalStore', 'Patient'])) {
                throw ValidationException::withMessages([
                    'role' => ['This account is not registered'],
                ]);
            }

            if ($user->status !== 'approved') {
                throw ValidationException::withMessages([
                    'status' => ['Your account has not been approved by the admin yet'],
                ]);
            }

            $token = $user->createToken('login-token')->plainTextToken;
            $role  = $user->getRoleNames()->first();

            $response = [
                'message' => 'Login successful.',
                'token'   => $token,
                'role'    => $role,
                'user_id' => $user->id,
            ];

            if ($user->hasRole('Patient')) {
                $response['patient_profile_id'] = optional($user->patientProfile)->id;
            }

            if ($user->hasRole('Doctor')) {
                $response['doctor_profile_id'] = optional($user->doctorProfile)->id;
            }

            if ($user->hasRole('OpticalStore')) {
                $response['optical_store_id'] = optional($user->opticalstore)->id;
            }

            return response()->json($response);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Login failed: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred during login. Please try again later.',
            ], 500);
        }
    }


    public function registerOpticalStoreService(OpticalStoreRegisterRequest $request)
    {
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'gender'       => $request->gender,
            'status'       => 'pending',
        ]);

        $user->opticalstore()->create([
            'storeName'   => $request->storeName,
            'shift'       => $request->shift ?? null,
            'description' => $request->description ?? null,
            'location'    => $request->location ?? null,
        ]);

        $user->assignRole('OpticalStore');


        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewRegistrationRequestNotification($user));
        }

        return response()->json([
            'success' => true,
            'message' => 'Your registration request has been submitted. Please wait for admin approval.',
            'data'    => new UserResource($user),
        ], 201);
    }

    public function registerPatientService(PatientRegisterRequest $request)
    {
        $user = User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'gender'       => $request->gender,
            'status'       => 'approved',
        ]);

        $user->patientProfile()->create([
            'location'           => $request->location,
            'national_number'    => $request->national_number,
            'chronic_conditions' => $request->chronic_conditions,
        ]);

        $user->assignRole('Patient');

        return response()->json([
            'message' => 'Your registration is complete. You can now login to VisiaCare.',
            'token'   => $user->createToken('register-token')->plainTextToken,
            'data'    => new PatientResource($user),
        ], 201);
    }


    public function logoutService(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout successfully.',
        ]);
    }
}
