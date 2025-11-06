<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'location', 'national_number', 'chronic_conditions'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_profile_id');
    }
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_profile_id');
    }
}
