<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'medical_record_id', 'medication_name', 'dosage', 'instructions', 'status'];

    public function doctor()
    {
        return $this->belongsTo(DoctorProfile::class);
    }
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
