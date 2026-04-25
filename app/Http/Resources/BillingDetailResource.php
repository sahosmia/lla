<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->whenHas('id'),
            'email'              => $this->whenHas('email'),
            'first_name'         => $this->whenHas('first_name'),
            'last_name'          => $this->whenHas('last_name'),
            'company'            => $this->whenHas('company'),
            'phone'              => $this->whenHas('phone'),
            'created_at'         => $this->whenHas('created_at'),
            'updated_at'         => $this->whenHas('updated_at'),
            'address'            => new AddressResource($this->whenLoaded('address')),
        ];
    }
}
