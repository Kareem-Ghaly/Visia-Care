<?php

namespace App\Services;

use App\Models\DoctorAvailability;
use App\Models\User;
use App\Http\Resources\DoctorAvailabilityResource;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorProfile;

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


            $existingAvailability = $doctorProfile->availabilities()->first();
            if ($existingAvailability) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have already created an availability schedule. Please update it instead.',
                ], 400);
            }

            $availability = $doctorProfile->availabilities()->create([
                'day_in_week' => $data['day_in_week'],
                'start_time'  => $data['start_time'],
                'end_time'    => $data['end_time'],

            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Doctor availability created successfully',
                'data' => new DoctorAvailabilityResource($availability)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while creating doctor availability',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function getAvailabilitiesByDocto($doctorid)
    {
        try {
            $doctor = DoctorProfile::with('user')->find($doctorid);
            if (!$doctor) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Doctor not found.',
                ], 404);
            }
            $availabilities = $doctor->availabilities()->get();
            if ($availabilities->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'This doctor has no availability records yet.',
                    'data' => [],
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Doctor availabilities fetched successfully.',

                'data' => DoctorAvailabilityResource::collection($availabilities),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while fetching doctor availabilities.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    public function updateDoctorAvailability(array $data)
    {
        try {
            $user = Auth::user();
            if (!$user->hasRole('Doctor')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only doctors can update availability records',
                ], 403);
            }
            $doctorprofile = $user->doctorprofile;
            if (!$doctorprofile) {
                return response()->json(['status' => 'error', 'message' => 'Doctor profile not found.',], 404);
            }
            $availability = $doctorProfile->availabilities()->first();
            if (!$availability) {
                return response()->json(['status' => 'error', 'message' => 'No availability record found to update.',], 404);
            }
            $availability->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Doctor availability updated successfully.',
                'data' => new DoctorAvailabilityResource($availability),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while updating doctor'], 500);
        }
    }
    public function deleteDoctorAvailability()
    {
        try {
            $user = Auth::user();
            if (!$user->hasRole('Doctor')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only doctors can delete availability records.',
                ], 403);
            }
            $doctorProfile = $user->doctorProfile;
            if (!$doctorProfile) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Doctor profile not found.',
                ], 404);
            }
            $availability = $doctorProfile->availabilities()->first();


            if (!$availability) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No availability record found to delete.',
                ], 404);
            }
            $availability->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Doctor availability deleted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while deleting doctor availability.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
