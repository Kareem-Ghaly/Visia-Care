<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'appointment_date' => $this->appointment_date,
            'appointment_time' => $this->appointment_time,
            'status' => $this->status,

            'doctor' => [
                'id' => $this->doctor->id ?? null,
                'name' => $this->doctor->user->name ?? null,
                'location' => $this->doctor->location ?? null,
            ],

            'patient' => [
                'id' => $this->patient->id ?? null,
                'name' => $this->patient->user->name ?? null,
                'gender' => $this->patient->user->gender ?? null,
            ],
        ];
    }
}
