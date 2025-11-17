<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'appointment_date' => (string) $this->appointment_date,
            'appointment_time' => (string) $this->appointment_time,
            'status' => $this->status,

            'doctor' => [
                'name' => $this->doctor->user->name ?? null,
                'location' => $this->doctor->location ?? null,
            ]
            ];
    }
    protected $casts = [
    'appointment_date' => 'date',
    'appointment_time' => 'datetime:H:i',
];

}
