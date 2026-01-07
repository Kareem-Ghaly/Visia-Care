<?php

namespace App\Services;

use App\Models\Prescription;
use App\Models\MedicalRecord;

class PrescriptionService
{
    public function addPrescription(array $data)
    {
        $record = MedicalRecord::findOrFail($data['medical_record_id']);
        return $record->prescriptions()->create($data);
    }

    public function getPrescriptionsForPatient(int $patientId)
    {
        return Prescription::whereHas('medicalRecord', function ($query)
        use ($patientId) {
            $query->where('patient_profile_id', $patientId);
        })
            ->with(['medicalRecord', 'doctor'])
            ->get();
    }
    public function getPrescriptionsbyid(int $PrescriptionsId){
        $Prescriptions=Prescription::findOrFail($PrescriptionsId);
        return $Prescriptions;

    }

}
