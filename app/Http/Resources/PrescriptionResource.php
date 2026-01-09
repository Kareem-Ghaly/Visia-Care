<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrescriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'patient_profile_id' => $this->patient_profile_id,
            'right_sphere' => $this->right_sphere,
            'right_cylinder' => $this->right_cylinder,
            'right_axis' => $this->right_axis,
            'left_sphere' => $this->left_sphere,
            'left_cylinder' => $this->left_cylinder,
            'left_axis' => $this->left_axis,
            'dosage' => $this->dosage,
            'medication_name' => $this->medication_name,
            'effective_period' => $this->effective_period,
            'doctor_name' => $this->doctor->user->name,
            'patient_name' => $this->patient->user->name,
            'created_at' => $this->created_at,
            
        ];
    }
}
