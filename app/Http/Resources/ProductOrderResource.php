<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'status'       => $this->status,
            'total_price'  => $this->total_price,
            'created_at'   => $this->created_at,


            'patient' => [
                'patient_id'   => $this->patient?->id,
                'name' => $this->patient?->user?->name,
            ],


            'optical_store' => $this->items->isNotEmpty()
                ? [
                    'optical_id'   => $this->items->first()->product?->opticalStore?->id,
                    'store_name'   => $this->items->first()->product?->opticalStore?->storeName,
                ]
                : null,


            'items' => $this->items->map(function ($item) {
                return [
                    'product_id'   => $item->product?->id,
                    'product_name' => $item->product?->name,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'total_price'  => $item->total_price,
                ];
            }),

            'prescription_id' => $this->prescription_id,
        ];
    }
}
