<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class UserSubjectResource extends JsonResource
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
            'user_id'                   => $this->whenHas('user_id'),
            'subject_group_id'          => $this->whenHas('subject_group_id'),
            'user_subject_group_id'     => $this->whenHas('user_subject_group_id'),
            'hour_rate'                 => $this->whenHas('hour_rate', function ($hour_rate) {
                return formatAmount($hour_rate);
            }),
            'description'               => $this->whenHas('description'),
            'image'                     => !empty($this->image) ? url(Storage::url($this->image)) : url(Storage::url('placeholder.png')),
            'sessions'                  => $this->whenHas('sessions'),
            'laravel_through_key'       => $this->whenHas('laravel_through_key'),
            'sort_order'                => $this->whenHas('sort_order'),
            'subject'                   => new SubjectResource($this->whenLoaded('subject')),
            'slots'                     => UserSlotResource::collection($this->whenLoaded('slots')),
            'group'                     => $this->whenLoaded('userSubjectGroup', function () {
                return new SubjectGroupResource($this->userSubjectGroup->group);
            }),
            'subject_group'                     => $this->whenLoaded('group', function () {
                return new SubjectGroupResource($this->group);
            }),
        ];
    }
}
