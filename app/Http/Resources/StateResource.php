<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->whenHas('id'),
            'country_id'      => $this->whenHas('country_id'),
            'short_code'      => $this->whenHas('short_code'),
            'name'            => $this->whenHas('name'),
            'is_district'     => $this->whenHas('is_district'),
        ];
    }
}
