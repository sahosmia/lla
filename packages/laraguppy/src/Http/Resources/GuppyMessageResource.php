<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Http\Resources\GuppyAttachmentResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyLocationResource;
use Amentotech\LaraGuppy\Services\MyUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuppyMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
       
        $profile = (new MyUser)->extractUserInfo($this->messageable);
        return [
            'userId'         => $this->messageable?->id,
            'threadId'       => $this->thread?->id,
            'threadType'     => $this->thread?->thread_type,
            'friendStatus'   => $this->thread->allParticipants->first()?->participant_status,
            'blockedBy'      => $this->thread->allParticipants->first()?->blocked_by,
            'isOnline'       => $this->thread->allParticipants->first()?->user?->isOnline,
            'name'           => $profile['name'],
            'photo'          => $profile['photo'],
            'messageId'      => $this->id,
            'timeStamp'      => $this->timeStamp??null,
            'messageType'    => $this->message_type,
            'body'           => empty($this->deleted_at)? $this->body: null,
            'parent'         => new GuppyMessageResource($this->parentMessage),
            'seenAt'         => $this->read?->seen_at,
            'deliveredAt'    => $this->delivered?->created_at,
            'deletedAt'      => $this->deleted_at,
            'isSender'       => $this->messageable?->id == auth()?->user()?->id ?? false,
            'location'       => ($this->message_type == ConfigurationManager::MESSAGE_LOCATION ? new GuppyLocationResource($this->attachments->first()) : null),
            'attachments'    => empty($this->deleted_at) && $this->message_type !=ConfigurationManager::MESSAGE_LOCATION ? GuppyAttachmentResource::collection($this->attachments): null,
            'notification'   => new GuppyNotificationResource($this->notification),
            'createdAt'      => $this->created_at,
        ];
    }
}
