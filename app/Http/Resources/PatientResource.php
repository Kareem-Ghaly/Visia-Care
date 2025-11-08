<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray($request): array
    {
        $role = $this->getRoleNames()->first() ?? 'Unassigned';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'gender' => $this->gender,
            'status' => $this->status,
            'location' => $this->PatientProfile->location,
            'national_number' => $this->PatientProfile->national_number,
            'chronic_conditions' => $this->PatientProfile->chronic_conditions,
            'role' => $role
        ];
    }
}
