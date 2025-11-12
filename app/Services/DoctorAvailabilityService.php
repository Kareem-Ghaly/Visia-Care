<?php

namespace App\Services;

use App\Models\DoctorAvailability;
use App\Models\User;
use App\Http\Resources\DoctorAvailabilityResource;
use Illuminate\Support\Facades\Auth;

class DoctorAvailabilityService
{
    public function createDoctorAvailability(array $data)
    {
        try {
            $user = Auth::user();
            if (!$user->hasRole('Doctor')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only doctors can create availability records.',
                ], 403);
            }
            $doctorProfile = $user->doctorProfile;
            if (!$doctorProfile) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Doctor profile not found.',
                ], 404);
            }

            $availability = $doctorProfile->availabilities()->create([
                'day_in_week' => $data['day_in_week'],
                'start_time'  => $data['start_time'],
                'end_time'    => $data['end_time'],

            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Doctor availability created successfully',
                'data' => new DoctorAvailabilityResource($availability)],201);
               } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while creating doctor availability',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
