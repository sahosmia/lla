<?php

namespace App\Http\Resources\TutorRating;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorRating extends JsonResource
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
            'comment'                        => $this->whenHas('comment'),
            'rating'                         => $this->whenHas('rating'),
            'created_at'            => $this->whenHas('created_at', function () {
                return \Carbon\Carbon::parse($this->created_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'profile'                        => new ProfileResource($this->whenLoaded('profile')),
            'country'                        => $this->when(
                $this->profile && $this->profile->user && $this->profile->user->address,
                fn () => $this->profile->user->address->country
            ),
        ];
    }
}
