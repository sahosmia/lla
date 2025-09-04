<?php

namespace App\Http\Resources\TutorRating;

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
            'short_name'            => $this?->short_name,
            'full_name'             => $this?->full_name,
            'slug'                  => $this->whenHas('slug'),
            'image'                 => $this->profile_image,
        ];
    }
}
