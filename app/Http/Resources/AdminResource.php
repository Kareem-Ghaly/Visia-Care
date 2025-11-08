<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    public function toArray($request): array
    {
        $role = $this->getRoleNames()->first() ?? 'Unassigned';
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->admin->username,
            'role' => $role
        ];
    }
}
