<?php

namespace Modules\Courses\Http\Resources;

use Modules\Courses\Http\Resources\SectionResource;
use Modules\Courses\Http\Resources\RatingResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Courses\Http\Resources\AddressResource;
use Modules\Courses\Http\Resources\FaqResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CoursesDetailResource extends JsonResource
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
            'subtitle'              => $this->whenHas('subtitle'),
            'enrollments_count'     => $this->whenHas('enrollments_count'),
            'description'           => $this->whenHas('description'),
            'progress'              => $this->whenHas('progress'),
            'updated_at'            => $this->whenHas('updated_at', function () {
                return \Carbon\Carbon::parse($this->updated_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'learning_objectives'   => $this->whenHas('learning_objectives'),
            'sections_count'        => $this->whenHas('sections_count'),
            'curriculums_count'     => $this->whenHas('curriculums_count'),  
            'content_length'        => $this->whenHas('content_length'),  
            'slug'                  => $this->whenHas('slug'),
            'country_id'            => $this->whenHas('country_id'),
            'tags'                  => $this->whenHas('tags'),
            'level'                 => $this->whenHas('level'),
            'ratings_count'         => $this->whenHas('ratings_count'),
            'views_count'           => $this->whenHas('views_count'),
            'ratings_avg_rating'    => $this->whenHas('ratings_avg_rating'),
            'curriculums_count'     => $this->whenHas('curriculums_count'),
            'is_enrolled'           => $this->whenHas('is_enrolled'),
            'likes'                 => $this->whenHas('likes'),
            'prerequisites'         => $this->whenHas('prerequisites'),
            'sections'              => SectionResource::collection($this->whenLoaded('sections')),
            'ratings'               => RatingResource::collection($this->whenLoaded('ratings')),
            'instructor'            => $this->whenLoaded('instructor', function () {
                return [
                    'id'                       => $this->instructor?->id ?? null,
                    'name'                     => $this->instructor?->profile?->full_name ?? null,
                    'is_online'                => $this->instructor?->is_online ?? false,
                    'tagline'                  => $this->instructor?->profile?->tagline ?? null,
                    'verified_at'              => $this->instructor?->profile?->verified_at ?? null,
                    'image'                    => $this->instructor?->profile?->image ? url(Storage::url($this->instructor?->profile?->image)) : url(Storage::url('placeholder.png')),
                    'country_short_code'       => $this->instructor?->address ? $this->instructor?->address?->country?->short_code : null,
                     
                ];
            }),
            'pricing'               => $this->whenLoaded('pricing', function () {
                return [
                    'price'         => $this->pricing?->price ?? null,
                    'discount'      => $this->pricing?->discount ?? null,
                    'final_price'   => $this->pricing?->final_price ?? null,
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
            'faqs'                  => FaqResource::collection($this->whenLoaded('faqs')),

            'noticeboards'          => NoticeboardResource::collection($this->whenLoaded('noticeboards')),
        ];
    }
}