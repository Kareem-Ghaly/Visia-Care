<?php
namespace App\Services;

use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PrescriptionResource;
class PrescriptionService
{
    public function addPrescription(array $data)
    {
        $user = Auth::user();

        if (!$user->hasRole('Doctor')) {
            return response()->json([
                'success' => false,
                'message' => 'Only doctors can add prescriptions'
            ], 403);
        }

        return Prescription::create([
            'doctor_id'          => $user->doctorProfile->id,
            'patient_profile_id' => $data['patient_profile_id'],
            'right_sphere'       => $data['right_sphere'] ?? null,
            'right_cylinder'     => $data['right_cylinder'] ?? null,
            'right_axis'         => $data['right_axis'] ?? null,
            'left_sphere'        => $data['left_sphere'] ?? null,
            'left_cylinder'      => $data['left_cylinder'] ?? null,
            'left_axis'          => $data['left_axis'] ?? null,
            'dosage'             => $data['dosage'] ?? null,
            'medication_name'    => $data['medication_name'],
            'effective_period'   => $data['effective_period'],
        ]);
    }

    public function getPrescriptionsForPatient(int $patientProfileId)
    {
        return  PrescriptionResource::collection(Prescription::where('patient_profile_id', $patientProfileId)
            ->with(['doctor.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(5)
        );
    }

    public function getPrescriptionById(int $id)
    {
        $prescription = Prescription::with(['doctor.user', 'patient.user'])
        ->findOrFail($id);

    return new PrescriptionResource($prescription);
    }
}
