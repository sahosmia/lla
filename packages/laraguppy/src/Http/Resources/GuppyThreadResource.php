<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Services\MyUser;
use Illuminate\Http\Resources\Json\JsonResource;

class GuppyThreadResource extends JsonResource {
    public $preserveKeys = true;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array {
        $profile           = (new MyUser)->extractUserInfo($this->allParticipants->first()->user);
 
        return [
            'threadId'          => $this->id,
            'threadType'        => $this->thread_type,
            'friendStatus'      =>  $this->allParticipants->first()?->participant_status,
            'blockedBy'         =>  $this->allParticipants->first()?->blocked_by,
            'name'              => $profile['name'],
            'photo'             => $profile['photo'],
            'userId'            => $profile['userId'],
            'isOnline'          => $this->allParticipants->first()?->user?->isOnline,
            'body'              => $this->whenLoaded('latestMessage', function(){return $this->latestMessage?->body;}),
            'messageType'       => $this->whenLoaded('latestMessage', function(){return $this->latestMessage?->message_type;}),
            'unSeenMessages'    => $this->messages->diff($this->readMessages)->pluck('id')->all(),
            'createdAt'         => $this->whenLoaded('latestMessage', function(){return $this->latestMessage?->created_at;}),
            'isMuted'           => $this->isMutedSpecific ?? false,
        ];
    }
}
