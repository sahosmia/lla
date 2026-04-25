<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class   UserSlotResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                                => $this->whenHas('id'),
            'user_subject_group_subject_id'     => $this->whenHas('user_subject_group_subject_id'),
            'date'                              => $this->whenHas('start_time', function ($start_time) {
                return parseToUserTz($start_time)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'F j, Y');
            }),
            'start_time'                        => $this->whenHas('start_time', function ($start_time) {
                if(setting('_lernen.time_format') == '12'){
                    return Carbon::parse($start_time)->format('g:i a');
                }else{
                    return Carbon::parse($start_time)->format('H:i');
                }
            }),
            'end_time'                          => $this->whenHas('end_time', function ($end_time) {
                if(setting('_lernen.time_format') == '12'){
                    return Carbon::parse($end_time)->format('g:i a');
                }else{
                    return Carbon::parse($end_time)->format('H:i');
                }
            }),
            'spaces'                            => $this->whenHas('spaces'),
            'space_type'                       => $this->whenHas('spaces') == 1 ? 'one' : 'group',
            'duration'                          => $this->whenHas('duration'),
            'total_booked'                      => $this->whenHas('total_booked'),
            'session_fee'                       => $this->whenHas('session_fee', function ($session_fee) {
                return formatAmount($session_fee);
            }),
            'type'                              => $this->whenHas('type'),
            'description'                       => $this->whenHas('description'),
            'meta_data'                         => $this->whenHas('meta_data'),
            'bookings_count'                    => $this->whenHas('bookings_count'),
            'subjectGroupSubjects'              => new UserSubjectResource($this->whenLoaded('subjectGroupSubjects')),
            'bookings'                          => SlotBookingResource::collection($this->whenLoaded('bookings')),
            'students'                          => ProfileResource::collection($this->whenLoaded('students')),
        ];
    }
}
