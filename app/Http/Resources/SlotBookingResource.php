<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlotBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                           => $this->whenHas('id'),
            'student_id'                   => $this->whenHas('student_id'),
            'tutor_id'                     => $this->whenHas('tutor_id'),
            'user_subject_slot_id'         => $this->whenHas('user_subject_slot_id'),
            'dispute_id'                      => $this->whenLoaded('dispute', function ($dispute) {
                return $dispute->id;
            }),
            'date'                         => $this->whenHas('start_time', function ($start_time) {
                return parseToUserTz($start_time)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'F j, Y');
            }),
            'start_time'                   => $this->whenHas('start_time', function ($start_time) {
                if(setting('_lernen.time_format') == '12'){
                    return parseToUserTz($start_time)->format('g:i a');
                }else{
                    return parseToUserTz($start_time)->format('H:i');
                }
            }),
            'end_time'                     => $this->whenHas('end_time', function ($end_time) {
                if(setting('_lernen.time_format') == '12'){
                    return parseToUserTz($end_time)->format('g:i a');
                }else{
                    return parseToUserTz($end_time)->format('H:i');
                }
            }),
            'left_time'                    => timeLeft($this->start_time),
            'session_fee'                  => $this->whenHas('session_fee', function ($session_fee) {
                return formatAmount($session_fee);
            }),
            'booked_at'                    => $this->whenHas('booked_at'),
            'calendar_event_id'            => $this->whenHas('calendar_event_id'),
            'review_submitted'             => $this->when(isset($this->rating_exists), (bool) $this->rating_exists), 
            'status'                       => $this->whenHas('status'),
            'awaiting_complete'            => $this->whenHas('status', function($status){
                return $status == 'active' && parseToUserTz($this->start_time)->isPast();
            }), 
            'meta_data'                    => $this->whenHas('meta_data'),
            'tutor'                        => new ProfileResource($this->whenLoaded('tutor')),
            'slot'                         => new UserSlotResource($this->whenLoaded('slot')),
        ];
    }
}
