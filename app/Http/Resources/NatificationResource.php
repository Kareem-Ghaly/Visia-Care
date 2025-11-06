<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NatificationResource extends JsonResource
{
     public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'reminder'    => $this->reminder,
            'created_at'  => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
