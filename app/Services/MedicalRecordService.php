<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\MedicalRecord;
use App\Models\Prescription;

class MedicalRecordService
{
    public function createRecord(array $data)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('Doctor')) {
            return response()->json([
                'success' => false,
                'message' => 'Only doctors can create medical records.'
            ], 403);
        }

        $patientProfileId = $data['patient_profile_id'] ?? null;

        if (!$patientProfileId) {
            return response()->json([
                'success' => false,
                'message' => 'Patient profile ID is required.'
            ], 422);
        }

        $existingRecord = MedicalRecord::where('patient_profile_id', $patientProfileId)->first();

        if ($existingRecord) {
            return response()->json([
                'success' => false,
                'message' => 'This patient already has a medical record.',
                'medical_record_id' => $existingRecord->id
            ], 409);
        }

        $record = MedicalRecord::create([
            'patient_profile_id' => $patientProfileId,
            'doctor_id' => $user->doctorProfile->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Medical record created successfully.',
            'data' => $record
        ], 201);
    }

    public function show($id)
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole(['Doctor', 'Patient'])) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }

        $record = MedicalRecord::find($id);

        if (!$record) {
            return response()->json([
                'message' => 'Medical record not found'
            ], 404);
        }

        if ($user->hasRole('Patient')) {
            if ($record->patient_profile_id !== optional($user->patientProfile)->id) {
                return response()->json([
                    'message' => 'Forbidden'
                ], 403);
            }
        }

        $prescriptions = Prescription::where('medical_record_id', $id)
            ->with('doctor.user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return response()->json([
            'medical_record' => [
                'id' => $record->id,
                'patient_profile_id' => $record->patient_profile_id,
                'name' => $record->name,
                'description' => $record->description,
                'created_at' => $record->created_at,
            ],
            'prescriptions' => $prescriptions
        ], 200);
    }
}
