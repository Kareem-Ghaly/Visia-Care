<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id',
    'medical_record_id' ,
    'right_sphere' ,
    'right_cylinder',
    'right_axis',
    'left_sphere',
    'left_cylinder',
    'left_axis',
    'dosage',
    'medication_name',
    'effective_period'
    ];

    public function doctor()
    {
        return $this->belongsTo(DoctorProfile::class);
    }
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }
}
