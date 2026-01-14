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

            'prescription' => $this->whenLoaded('prescription', function() {
                return [
                    'id' => $this->prescription->id,
                    'doctor_name' => $this->prescription->doctor->user->name ?? 'N/A',
                    'details' => $this->prescription->details,
                    'created_at' => $this->prescription->created_at,
                    'right_sphere' =>$this->prescription->right_sphere,
                    'right_cylinder' =>$this->prescription->right_cylinder,
                    'right_axis' =>$this->prescription->right_axis,
                    'left_sphere' =>$this->prescription->left_sphere,
                    'left_cylinder' =>$this->prescription->left_cylinder,
                    'left_axis' =>$this->prescription->left_axis,
                    'medication_name' =>$this->prescription->medication_name,
                     'effective_period' =>$this->prescription->effective_period,
                ];
            }),
        ];
    }
}
