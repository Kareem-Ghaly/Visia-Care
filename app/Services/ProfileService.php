<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;

use App\Http\Resources\ProfileResource;
class ProfileService{


    public function doctorProfile()
    {
        $user = Auth::user();

        if (!$user->hasRole('Doctor')) {
            abort(403, 'Unauthorized');
        }

        $data = [
            'user' => $user,
            'profile' => $user->doctorProfile
        ];

        return response()->json([
            'status' => 'success',
            'data' => new ProfileResource($data)
        ]);
    }
public function opticalStoreProfile()
    {
        $user = Auth::user();

        if (!$user->hasRole('OpticalStore')) {
            abort(403, 'Unauthorized');
        }

        $data = [
            'user' => $user,
            'profile' => $user->opticalStore
        ];

        return response()->json([
            'status' => 'success',
            'data' => new ProfileResource($data)
        ]);
    }
     public function patientProfile()
    {
        $user = Auth::user();

        if (!$user->hasRole('Patient')) {
            abort(403, 'Unauthorized');
        }

        $data = [
            'user' => $user,
            'profile' => $user->patientProfile
        ];

        return response()->json([
            'status' => 'success',
            'data' => new ProfileResource($data)
        ]);
    }
}
