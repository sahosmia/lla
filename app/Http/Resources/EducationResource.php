<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'user_id'               => $this->whenHas('user_id'),
            'course_title'          => $this->whenHas('course_title'),
            'institute_name'        => $this->whenHas('institute_name'),
            'country_id'            => $this->whenHas('country_id'),
            'city'                  => $this->whenHas('city'),
            'start_date'            => $this->whenHas('start_date', function () {
                return \Carbon\Carbon::parse($this->start_date)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),

            'end_date'            => $this->whenHas('end_date', function () {
                return \Carbon\Carbon::parse($this->end_date)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'ongoing'               => $this->whenHas('ongoing'),
            'description'           => $this->whenHas('description'),
            'country'               => $this->whenLoaded('country', function () {
                return [
                    'short_code' => $this->country->short_code ?? null,
                    'name'       => $this->country->name ?? null,
                ];
            }),

        ];
    }
}
