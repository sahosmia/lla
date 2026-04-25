<?php

namespace App\Http\Resources\Disputes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProfileResource;
use Carbon\Carbon;


class DisputeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $createdatFormat = setting('_general.date_format') ?? 'F j, Y';
        $createdatFormat .= setting('_lernen.time_format') == '12' ? ' g:i a' : ' H:i';

        return [
            'id'                => $this->whenHas('id'),
            'uuid'              => $this->whenHas('uuid'),
            'status'            => $this->whenHas('status'),
            'dispute_title'     => $this->whenHas('dispute_reason'),
            'created_at'        => $this->whenHas('created_at', function () use ($createdatFormat) {
                return Carbon::parse($this->created_at)->format($createdatFormat);
            }),
            'responsible_by' => $this->whenLoaded('responsibleBy', function () {
                return [
                    'email'     => $this->responsibleBy->email,
                    'profile'   => new ProfileResource($this->responsibleBy->profile),
                ];
            }),
            'creator_by' => $this->whenLoaded('creatorBy', function () {
                return [
                    'email'     => !empty($this->creatorBy->email) ? $this->creatorBy->email : null,
                    'profile'   => new ProfileResource($this->creatorBy->profile),
                ];
            }),
            'subject' => $this->when(!empty($this->booking?->slot?->subjectGroupSubjects?->subject), function(){
                return $this->booking->slot->subjectGroupSubjects->subject->name;
            }),
            'group' => $this->when(!empty($this->booking?->slot?->subjectGroupSubjects?->group), function(){
                return $this->booking->slot->subjectGroupSubjects->group->name;
            }),
            'start_time' => $this->when($this->booking?->slot?->start_time, function () {
                return Carbon::parse($this->booking->slot->start_time)->format(
                    setting('_lernen.time_format') === '12' ? 'g:i a' : 'H:i'
                );
            }),
            'end_time' => $this->when($this->booking?->slot?->end_time, function () {
                return Carbon::parse($this->booking->slot->end_time)->format(
                    setting('_lernen.time_format') === '12' ? 'g:i a' : 'H:i'
                );
            }),
        ];
    }
}

