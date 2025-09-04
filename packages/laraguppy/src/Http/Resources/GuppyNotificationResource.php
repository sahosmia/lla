<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuppyNotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'messageId'             => $this->message_id, 
            'notificationType'      => $this->notification_type, 
        ];
    }
}
