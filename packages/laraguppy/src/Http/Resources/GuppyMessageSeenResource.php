<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuppyMessageSeenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
