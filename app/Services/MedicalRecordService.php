<?php
namespace App\Services;

use App\Models\MedicalRecord;

class MedicalRecordService
{
    public function createRecord(array $data)
    {
        return MedicalRecord::create($data);
    }
}
