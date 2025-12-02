<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        //  return [
        //     'id' => $this->id,
        //     'appointment_date' => (string) $this->appointment_date,
        //     'appointment_time' => (string) $this->appointment_time,
        //     'status' => $this->status,

        //     'doctor' => [
        //         'name' => $this->doctor->user->name ?? null,
        //         'location' => $this->doctor->location ?? null,

        //     ],
        //     'patient' => [
        //         'name' => $this->patient->user->name ?? null,
        //         'gender' => $this->patient->user->gender ?? null,

        //     ]
        //     ];
        return [
            'id' => $this->id,
            'appointment_date' => $this->start_date
                ? Carbon::parse($this->start_date)->format('Y-m-d')
                : null,
            'appointment_time' => $this->start_date
                ? Carbon::parse($this->start_date)->format('H:i')
                : null,
            'status' => $this->status,
            'doctor' => [
                'name' => $this->doctor->user->name ?? null,
                'location' => $this->doctor->location ?? null,
            ],
            'patient' => [
                'name' => $this->patient->user->name ?? null,
                'gender' => $this->patient->user->gender ?? null,
            ],
        ];
    }
    protected $casts = [
    'appointment_date' => 'date',
    'appointment_time' => 'datetime:H:i',
];

}
