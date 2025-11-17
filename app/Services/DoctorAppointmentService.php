<?php

namespace App\Services;

use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorAppointmentService
{
    public function getPendingAppointments()
    {
        $user = Auth::user();
        if (!$user->hasRole('Doctor')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $doctorprofile = $user->doctorprofile;
        $appointments = Appointment::where('doctor_id', $doctorprofile->id)->where('status', 'pending')->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => AppointmentResource::collection($appointments),
            'pagination' => [
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
                'per_page' => $appointments->perPage(),
                'total' => $appointments->total(),
            ],
        ]);
    }
    public function approveAppointment($appointmentId)
    {
        $user = Auth::user();
        if (!$user->hasRole('Doctor')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        $doctorProfile = $user->doctorProfile;

        $appointment = Appointment::where('id', $appointmentId)
            ->where('doctor_id', $doctorProfile->id)->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        $appointment->update(['status' => 'confirmed']);

        return response()->json([
            'status' => 'success',
            'message' => 'Appointment approved successfully.',
        ]);
    }
    public function rejectAppointment($appointmentId)
    {
        $user = Auth::user();
        if (!$user->hasRole('Doctor')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $doctorProfile = $user->doctorProfile;

        $appointment = Appointment::where('id', $appointmentId)
            ->where('doctor_id', $doctorProfile->id)
            ->first();

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }
        $appointment->update(['status' => 'cancelled']);
        return response()->json([
            'status' => 'success',
            'message' => 'Appointment rejected successfully.',
        ]);
    }
}
