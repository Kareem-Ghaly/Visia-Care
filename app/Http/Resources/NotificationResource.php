<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NtificationResource extends JsonResource
{
     public function toArray($request): array
    {
        return [
             'id'         => $this->id,
            'title'      => $this->data['title'] ?? null,
            'message'    => $this->data['message'] ?? null,
            'read_at'    => $this->read_at,
            'created_at'=> $this->created_at,
        ];
    }
}
