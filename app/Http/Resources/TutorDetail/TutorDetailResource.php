<?php

namespace App\Http\Resources\TutorDetail;

use App\Http\Resources\CountryResource;
use App\Http\Resources\LanguageResource;
use App\Http\Resources\SubjectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                             => $this->whenHas('id'),
            'is_favorite'                    => $this->whenHas('is_favorite'),
            'avg_rating'                     => $this->whenHas('avg_rating'),
            'min_price'                      => $this->whenHas('min_price', function ($min_price) {
                return formatAmount($min_price);
            }),
            'active_students'                => $this->whenHas('active_students'),
            'total_reviews'                  => $this->whenHas('total_reviews'),
            'email_verified_at'              => $this->whenHas('email_verified_at'),
            'is_online'                      => $this?->is_online,
            'sessions'                       => $this->whenLoaded('subjects', function () {
                $totalSessions = 0;
                foreach ($this->subjects as $sub) {
                    $totalSessions += $sub->sessions;
                }
                return $totalSessions;
            }),
            'profile'                        => new ProfileResource($this->whenLoaded('profile')),
            'languages'                      => LanguageResource::collection($this->whenLoaded('languages')),
            'country'                        => $this->whenLoaded('address', function () {
                return new CountryResource($this->address->country);
            }),
            'subjects'                      => $this->whenLoaded('subjects', function () {
                $subjectResources = [];
                foreach ($this->subjects as $sub) {
                    $subjectResources[] = new SubjectResource($sub->subject);
                }
                return $subjectResources;
            }),
        ];
    }
}
