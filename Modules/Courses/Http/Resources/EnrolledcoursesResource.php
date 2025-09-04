<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EnrolledcoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id'                            => $this->whenHas('id'),
            'is_favorite'                   => $this->whenHas('is_favorite'),
            'progress'                      => $this->whenHas('progress'),
            'course'                        => new CoursesResource($this->course),
        ];
    }
}