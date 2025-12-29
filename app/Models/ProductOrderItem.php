<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderItem extends Model
{
    protected $fillable = [
        'product_order_id',
        'optical_product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];
     public function order()
    {
        return $this->belongsTo(ProductOrder::class, 'product_order_id');
    }
     public function product()
    {
        return $this->belongsTo(OpticalProduct::class, 'optical_product_id');
    }
}
