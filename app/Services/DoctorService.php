<?php

namespace App\Services;

use App\Http\Resources\DoctorResource;
use App\Models\User;

use App\Http\Resources\UserResource;

class DoctorService
{
    public function getApprovedDoctors()
    {
        try {
            $doctors = User::role('Doctor')->with('doctorProfile')->where('status', 'approved')->paginate(10);
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
            'data' => [
                'doctors' => DoctorResource::collection($doctors),
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
                'status'  => 'error',
                'message' => 'An error occurred while fetching the list of doctors',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
