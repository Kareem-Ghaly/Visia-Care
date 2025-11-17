<?php

namespace App\Services;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentService{
     public function getPendingAppointments()
    {
        $user = Auth::user();
        if (!$user->hasRole('Doctor')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $doctorprofile=$user->doctorprofile;
        $appointments = Appointment::where('doctor_id', $doctorprofile->id)->where('status', 'pending')  ->paginate(10);
        return response()->json([
    'status' => 'success',
    'data' =>AppointmentResource::collection  ($appointments),
    'pagination' => [
                    'current_page' => $appointments->currentPage(),
                    'last_page' => $appointments->lastPage(),
                    'per_page' => $appointments->perPage(),
                    'total' => $appointments->total(),
                ],
]);

}
}
