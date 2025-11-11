<?php

namespace App\Services;

use App\Http\Resources\DoctorResource;
use App\Models\User;
use App\Models\DoctorProfile;

use App\Http\Resources\UserResource;

class DoctorService
{
    public function getApprovedDoctors()
    {
        try {
            $doctors = User::role('Doctor')->with('doctorProfile')->where('status', 'approved')->get();
            if ($doctors->isEmpty()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'no docotrs approved',
                    'data'    => [],

                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Approved doctors fetched successfully',
                'data' =>  DoctorResource::collection($doctors),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'An error occurred while fetching the list of doctors',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
