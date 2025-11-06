<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpticalProduct extends Model
{
    use HasFactory;
    protected $fillable = ['optical_store_id', 'name', 'type', 'price', 'amount', 'image'];

    public function opticalStore()
    {
        return $this->belongsTo(OpticalStore::class, 'optical_store_id');
    }

    public function orders()
    {
        return $this->hasMany(ProductOrder::class, 'optical_product_id');
    }
}
