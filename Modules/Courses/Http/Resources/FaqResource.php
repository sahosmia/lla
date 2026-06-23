<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class FaqResource extends JsonResource
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
            'question'              => $this->whenHas('question'),
            'answer'                => $this->whenHas('answer'),
        ];
    }
}