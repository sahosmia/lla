<?php

namespace App\Http\Resources\Notifications;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'is_read' => empty($this->read_at) ? false : true,
            'icon'  => !empty(setting('_general.notification_image')) ? url(Storage::url(setting('_general.notification_image')[0]['path'])) : asset('demo-content/notification-logo.svg'),
            'created_at' => $this->created_at->shortAbsoluteDiffForHumans(),
        ];
    }
}
