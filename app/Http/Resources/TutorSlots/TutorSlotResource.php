<?php

namespace App\Http\Resources\TutorSlots;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class TutorSlotResource extends JsonResource
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
            'date'                              => $this->whenHas('start_time', function ($start_time) use ($request) {
                return parseToUserTz($start_time, $request->user_time_zone)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'F j, Y');
            }),
            'start_time'                        => $this->when($this->start_time, function () use ($request) {
                if(setting('_lernen.time_format') == '12'){
                    return parsetoUserTz($this->start_time, $request->user_time_zone)->format('g:i a');
                }else{
                    return parsetoUserTz($this->start_time, $request->user_time_zone)->format('H:i');
                }
            }),
            'end_time'                          => $this->when($this->end_time, function () use ($request) {
                if(setting('_lernen.time_format') == '12'){
                    return parsetoUserTz($this->end_time, $request->user_time_zone)->format('g:i a');
                }else{
                    return parsetoUserTz($this->end_time, $request->user_time_zone)->format('H:i');
                }
            }),
            'formatted_time_range'              => $this->when($this->start_time && $this->end_time, function () use ($request) {
                if(setting('_lernen.time_format') == '12'){
                    return parsetoUserTz($this->start_time, $request->user_time_zone)->format('g:i a') . ' - ' . parsetoUserTz($this->end_time, $request->user_time_zone)->format('g:i a');
                }else{
                    return parsetoUserTz($this->start_time, $request->user_time_zone)->format('H:i') . ' - ' . parsetoUserTz($this->end_time, $request->user_time_zone)->format('H:i');
                }
            }),
            'total_slots'                            => $this->whenHas('spaces'),
            'spaces_type'                       => $this->whenHas('spaces') == 1 ? 'one' : 'group',
            'duration'                          => $this->whenHas('duration'),
            'booked_slots'                      => $this->whenHas('total_booked'),
            'available_slots'                    => $this->whenHas('total_booked', function () {
                return $this->spaces - $this->total_booked;
            }),
            'session_fee'                       => $this->whenHas('session_fee', function ($session_fee) {
                return formatAmount($session_fee);
            }),
            'type'                              => $this->whenHas('type'),
            'bookings_count'                    => $this->whenHas('bookings_count'),
            'description'                       => $this->whenHas('description'),
            'image'                             => $this->when($this->subjectGroupSubjects ,
                 fn () => !empty($this->subjectGroupSubjects->image) ? url(Storage::url($this->subjectGroupSubjects->image)) : url(Storage::url('placeholder.png'))),
            'subject'                           => $this->when(
                $this->subjectGroupSubjects && $this->subjectGroupSubjects->subject,
                fn () => $this->subjectGroupSubjects->subject
            ),
            'group'                             => $this->when(
                $this->subjectGroupSubjects && $this->subjectGroupSubjects->userSubjectGroup && $this->subjectGroupSubjects->userSubjectGroup->group,
                fn () => $this->subjectGroupSubjects->userSubjectGroup->group
            ),

        ];
        
    }
}
