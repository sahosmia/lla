<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->whenHas('id'),
            'title'                     => $this->whenHas('title'),
            'curriculums_count'         => $this->curriculums ? number_format( count($this->curriculums)) : null,
            'content_length'            => getCourseDuration($this->curriculums->sum('content_length')),
            'description'               => $this->whenHas('description'),
            'curriculums'               => CurriculumsResource::collection($this->whenLoaded('curriculums')),        
        ];

    }
}