<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'user_id'               => $this->whenHas('user_id'),
            'employment_type' => $this->whenHas('employment_type', function () {
                $employmentTypes = [
                    'full_time'     => __('experience.full_time'),
                    'part_time'     => __('experience.part_time'),
                    'self_employed' => __('experience.self_employed'),
                    'contract'      => __('experience.contract'),
                ]; 
                return $employmentTypes[$this->employment_type] ?? null;
            }),
            'company'               => $this->whenHas('company'),
            'location'              => $this->whenHas('location'),
            'country_id'            => $this->whenHas('country_id'),
            'city'                  => $this->whenHas('city'),
            'start_date'            => $this->whenHas('start_date', function () {
                return \Carbon\Carbon::parse($this->start_date)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),

            'end_date'            => $this->whenHas('end_date', function () {
                return \Carbon\Carbon::parse($this->end_date)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'is_current'            => $this->whenHas('is_current'),
            'description'           => $this->whenHas('description'),
            'country'               => $this->whenLoaded('country', function () {
                return [
                    'short_code'    => $this->country->short_code ?? null,
                    'name'          => $this->country->name ?? null,
                ];
            }),

        ];
    }
}
