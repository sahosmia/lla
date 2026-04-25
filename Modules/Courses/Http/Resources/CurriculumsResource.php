<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        if($request->route()->getName() == 'course-taking'){
            $media_path = url(Storage::url($this->media_path));
        } else{
            $media_path = $this->is_preview ? url(Storage::url($this->media_path)) : null;
        }

        return [
            'id'                        => $this->whenHas('id'),
            'title'                     => $this->whenHas('title'),
            'type'                      => $this->whenHas('type'),
            'media_path'                => $media_path,
            'is_preview'                => $this->whenHas('is_preview'),
            'is_watched'                => $this->watchtime?->duration == $this->content_length,
            'article_content'           => $this->whenHas('article_content'),
            'content_length'            => getCourseDuration($this->content_length),
            'description'               => $this->whenHas('description'),
        
        ];

    }
}