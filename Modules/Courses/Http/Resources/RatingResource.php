<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class RatingResource extends JsonResource
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
            'name'                  => $this->whenHas('name'),
            'created_at'            => $this->whenHas('created_at', function () {
                return \Carbon\Carbon::parse($this->created_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'comment'               => $this->whenHas('comment'),
            'rating'                => floor($this->rating) ?? 0,
            'active_courses_count'  => $this->whenHas('active_courses_count'),
            'user'                  => $this->whenLoaded('student', function () {
                return [
                    'id'            => $this->student?->id ?? null,
                    'name'          => $this->student?->profile?->full_name ?? null,
                    'short_code'    => $this->student?->address?->country?->short_code,
                    'country_name'  => $this->student?->address?->country?->name,
                    'image'         => $this->student?->profile?->image ? url(Storage::url($this->student?->profile?->image)) : url(Storage::url('placeholder.png')),
                ];
            }),
        ];
    }
}