<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'optical_product_id',
        'patient_id',
        'prescription_id',
        'is_accepted',
        'status',
        'total_price',
        'delivery_time'
    ];

    public function product()
    {
        return $this->belongsTo(OpticalProduct::class, 'optical_product_id');
    }

    public function patient()
    {
        return $this->belongsTo(PatientProfile::class, 'patient_id');
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
}
