<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class OptionResource extends JsonResource
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
            'question_id'           => $this->whenHas('question_id'),
            'option_text'           => $this->whenHas('option_text'),
            'is_correct'            => $this->whenHas('is_correct'),
            'position'              => $this->whenHas('position'),
        ];
    }
}
