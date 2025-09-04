<?php

namespace App\Http\Resources\FindTutors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->whenHas('id'),
            'verified_at'           => $this->whenHas('verified_at'),
            'full_name'             => $this?->full_name,
            'slug'                  => $this->whenHas('slug'),
            'image'                 => $this->profile_image,
        ];
    }
}
