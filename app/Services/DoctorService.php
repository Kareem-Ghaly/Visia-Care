<?php

namespace App\Services;

use App\Models\User;
use App\Http\Resources\DoctorResource;

class DoctorService
{
    public function getApprovedDoctors()
    {
        try {
            $doctors = User::role('Doctor')
                ->with('doctorProfile')
                ->where('status', 'approved')
                ->paginate(10);

            if ($doctors->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No doctors approved',
                    'data' => [],
                ], 200);
            }

            // تعديل الـ Resource لإضافة doctor_profile_id
            $data = DoctorResource::collection($doctors)->map(function ($doc) {
                return array_merge($doc->toArray(request()), [
                    'doctor_profile_id' => $doc->doctorProfile->id ?? null
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Approved doctors fetched successfully',
                'data' => [
                    'doctors' => $data,
                    'pagination' => [
                        'current_page' => $doctors->currentPage(),
                        'last_page' => $doctors->lastPage(),
                        'per_page' => $doctors->perPage(),
                        'total' => $doctors->total(),
                    ],
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching the list of doctors',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}



