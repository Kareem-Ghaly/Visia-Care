<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpticalStore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'shift',
        'description',
    'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opticalProducts()
    {
        return $this->hasMany(OpticalProduct::class);
    }
}
