<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;

class MedicalRecordService
{
    public function createRecord(array $data)
    {

        $user=Auth::user();
        if(!$user->hasRole('Doctor')){
            return response()->json([
                 'success' => false,
                'message' => 'Only doctors can create medical records.'

            ],403);
        }
        $patientProfileId = $data['patient_profile_id'] ;

    if (!$patientProfileId) {
        return response()->json([
            'success' => false,
            'message' => 'Patient profile ID is required.'
        ],422);
    }
     $existingRecord = MedicalRecord::where('patient_profile_id', $patientProfileId)->first();

    if ($existingRecord) {
        return response()->json( [
            'success' => false,
            'message' => 'This patient already has a medical record.',
            'medical_record_id' => $existingRecord->id
        ],409);
    }

       $record = MedicalRecord::create([
        'patient_profile_id' => $patientProfileId,
        'doctor_id'=>Auth::user()->doctorProfile->id,
        'name' => $data['name'],
        'description' => $data['description'] ?? null,
    ]);
   return response()->json([
            'message' => 'Medical record created successfully.',
            'data' => $record
        ], 201);
}
}
