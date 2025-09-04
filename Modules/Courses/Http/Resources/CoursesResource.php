<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CoursesResource extends JsonResource
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
            'title'                 => $this->whenHas('title'),
            'slug'                  => $this->whenHas('slug'),
            'country_id'            => $this->whenHas('country_id'),
            'is_favorite'           => $this->whenHas('is_favorite'),
            'tags'                  => $this->whenHas('tags'),
            'category'              => $this->whenLoaded('category', fn() => $this->category->name),
            'level'                 => $this->whenHas('level'),
            'ratings_count'         => $this->whenHas('ratings_count'),
            'views_count'           => $this->whenHas('views_count'),
            'ratings_avg_rating'    => $this->whenHas('ratings_avg_rating'),
            'curriculums_count'     => $this->whenHas('curriculums_count'),
            'likes'                 => $this->whenHas('likes'),
            'content_length'        => $this->whenHas('content_length', fn() => getCourseDuration($this->content_length)),
            'instructor'            => $this->whenLoaded('instructor', function () {
                return [
                    'id'            => $this->instructor?->id ?? null,
                    'name'          => $this->instructor?->profile?->full_name ?? null,
                    'is_online'     => $this->instructor?->is_online ?? false,
                    'image'         => $this->instructor?->profile?->image ? url(Storage::url($this->instructor?->profile?->image)) : url(Storage::url('placeholder.png')),
                ];
            }),

            'pricing'               => $this->whenLoaded('pricing', function () {
                return [
                    'price'         => formatAmount($this->pricing?->price ?? 0),
                    'discount'      => formatAmount($this->pricing?->discount ?? 0),
                    'final_price'   => formatAmount($this->pricing?->final_price ?? 0),
                ];
            }),

            'language'              => $this->whenLoaded('language', function () {
                return [
                    'name'          => $this->language?->name ?? null,
                ];
            }),

            'thumbnail'             => $this->whenLoaded('thumbnail', function () {
                return [    
                    'url'           => $this->thumbnail?->path ? url(Storage::url($this->thumbnail?->path)) : url(Storage::url('placeholder.png')),
                ];            
            }),

            'promotional_video'     => $this->whenLoaded('promotionalVideo', function () {
                return [    
                    'url'           => !empty($this->promotionalVideo?->path) ? url(Storage::url($this->promotionalVideo?->path)) : null,
                ];            
            }),
        ];
    }
}