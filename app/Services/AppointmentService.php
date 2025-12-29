<?php
namespace App\Services;

use App\Models\Appointment;
use App\Models\DoctorAvailability;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Resources\AppointmentResource;
class AppointmentService{

    public function createAppointment(array $data)
    {
            try {
                $user = Auth::user();

                if (!$user->hasRole('Patient')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Only patients can create appointments.',
                    ], 403);
                }

                $patientProfile = $user->patientProfile;
                if (!$patientProfile) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Patient profile not found.',
                    ], 404);
                }

                $availability = DoctorAvailability::with('doctor.user')
                    ->find($data['availability_id']);

                if (!$availability) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Doctor availability not found.',
                    ], 404);
                }

                $appointmentDate = Carbon::parse($data['appointment_date']);
                $appointmentTime = Carbon::createFromFormat('H:i', $data['appointment_time']);

                $appointmentDay = strtolower($appointmentDate->format('l'));

                $availableDays = array_map(
            'trim',
            explode(',', strtolower($availability->day_in_week))
        );

        if (!in_array($appointmentDay, $availableDays)) {
            return response()->json([
                'status' => 'error',
                'message' => "The selected date does not match the doctor's available day ({$availability->day_in_week}).",
            ], 422);
        }


                $startTime = Carbon::createFromFormat('H:i:s', $availability->start_time);
                $endTime   = Carbon::createFromFormat('H:i:s', $availability->end_time);

                if ($appointmentTime->lt($startTime) || $appointmentTime->gte($endTime)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "The selected time ({$appointmentTime->format('H:i')}) is outside of the doctor's working hours ({$availability->start_time} - {$availability->end_time}).",
                    ], 422);
                }

                if ($appointmentDate->isPast()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You cannot book an appointment in the past.',
                    ], 422);
                }

                $exists = Appointment::where('availability_id', $availability->id)
                    ->where('appointment_date', $appointmentDate->toDateString())
                    ->where('appointment_time', $appointmentTime->format('H:i'))
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'This time slot is already booked.',
                    ], 409);
                }


                $appointment = Appointment::create([
                    'availability_id' => $availability->id,
                    'doctor_id' => $availability->doctor_id,
                    'patient_profile_id' => $patientProfile->id,
                    'appointment_date' => $appointmentDate->toDateString(),
                    'appointment_time' => $appointmentTime->format('H:i'),
                    'status' => 'pending',
                ]);

                return response()->json([
            'status' => 'success',
            'message' => 'Appointment created successfully.',
            'data' => new AppointmentResource(
                $appointment->load(['doctor.user', 'patient.user'])
            ),
        ], 201);


            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An error occurred while creating the appointment.',
                    'error' => $e->getMessage(),
                ], 500);
            }
    }

    public function getMyAppointments()
    {
        $user = Auth::user();
        $this->ensurePatient($user);
        $patientProfile = $this->getPatientProfile($user);
        $appointments = Appointment::with(['doctor.user', 'availability'])
            ->where('patient_profile_id', $patientProfile->id)
            ->latest('appointment_date')
            ->latest('appointment_time')
            ->get();

        return $this->success(
            'Appointments retrieved successfully.',
            AppointmentResource::collection($appointments)
        );
    }

    private function ensurePatient($user)
    {
        if (!$user->hasRole('Patient')) {
            abort(403, 'Only patients can perform this action.');
        }
    }

    private function getPatientProfile($user)
    {
        if (!$user->patientProfile) {
            abort(404, 'Patient profile not found.');
        }

        return $user->patientProfile;
    }

    private function success($message, $data = null, $code = 200)
    {
        return response()->json([
            'status'  => 'success',
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}

