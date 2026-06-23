<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'state_id'        => $this->whenHas('state_id'),
            'city'            => $this->whenHas('city'),
            'address'         => $this->whenHas('address'),
            'zipcode'         => $this->whenHas('zipcode'),
            'country'         => $this->whenLoaded('country', function () {
                return [
                    'short_code' => $this->country->short_code ?? null,
                    'name'       => $this->country->name ?? null,
                ];
            }),
            'state'         => $this->whenLoaded('state', function () {
                return [
                    'short_code' => $this->state->short_code ?? null,
                    'name'       => $this->state->name ?? null,
                ];
            }),
        ];
    }
}
