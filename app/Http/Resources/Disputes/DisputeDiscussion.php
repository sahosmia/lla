<?php

namespace App\Http\Resources\Disputes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProfileResource;
use Carbon\Carbon;


class DisputeDiscussion extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->whenHas('id'),
            'uuid'              => $this->whenHas('uuid'),
            'message'           => $this->whenHas('message'),
            'created_at'        => $this->whenHas('created_at', function () {
                if(setting('_lernen.time_format') == '12') {
                    return Carbon::parse($this->created_at)->format('h:i A');
                } else {
                    return Carbon::parse($this->created_at)->format('H:i');
                }
            }),
            'user'              => $this->whenLoaded('user', function () {
                return [
                    'id'        => $this->user?->id ?? null,    
                    'email'     => $this->user?->email ?? null,
                    'is_online' => $this->user?->is_online,
                    'profile'   => new ProfileResource($this->user?->profile),
                ];
            }),
        ];
    }
}