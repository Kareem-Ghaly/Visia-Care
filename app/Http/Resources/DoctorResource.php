<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'license' => $this->DoctorProfile->license,
            'location' => $this->DoctorProfile->location,
            'shift' => $this->DoctorProfile->shift,
            'bio' => $this->DoctorProfile->bio,
            'role' => $role
        ];
    }
}
