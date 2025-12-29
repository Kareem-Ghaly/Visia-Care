<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $fillable = [

        'patient_id',
        'prescription_id',
        
        'status',
        'total_price',
        'delivery_time'
    ];



    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
}
