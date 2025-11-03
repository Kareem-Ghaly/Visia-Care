<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $role = $this->getRoleNames()->first() ?? 'Unassigned';

        $baseData = [
            'id'     => $this->id,
            'email'  => $this->email,
            'phone'  => $this->phone_number,
            'status' => $this->status,
            'role'   => $role,
        ];

        if ($role === 'OpticalStore' && $this->opticalStore) {
            $baseData['optical_store'] = [
                ' Store_name'      => $this->opticalStore->name,
                'shift'      => $this->opticalStore->shift ?? null,
                'description' => $this->opticalStore->description ?? null,
                'location'    => $this->opticalStore->location ?? null,

            ];
        }

        return $baseData;
    }
}
