<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'short_code'      => $this->whenHas('short_code'),
            'name'            => $this->whenHas('name'),
            'status'          => $this->whenHas('status'),
        ];
    }
}
