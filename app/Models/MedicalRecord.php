<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = ['patient_profile_id', 'doctor_id', 'name', 'description', 'doctor_notes'];

    public function doctor() { return $this->belongsTo(DoctorProfile::class, 'doctor_id'); }
    public function patient() { return $this->belongsTo(PatientProfile::class, 'patient_profile_id'); }
    public function prescriptions() { return $this->hasMany(Prescription::class, 'medical_record_id'); }
}
