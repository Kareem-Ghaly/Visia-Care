<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id'    => $this['user']->id,
                'name'  => $this['user']->name,
                'email' => $this['user']->email,
                'role'  => $this['user']->getRoleNames()->first(),
            ],
            'profile' => $this['profile'],
        ];
    }
    
}
