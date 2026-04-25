<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuppyLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'latitude'  => $this->attachments['latitude'],
            'longitude'  => $this->attachments['longitude'],
        ];
    }
}
