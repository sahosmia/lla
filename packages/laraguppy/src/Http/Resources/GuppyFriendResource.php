<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Amentotech\LaraGuppy\Services\MyUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuppyFriendResource extends JsonResource {
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): mixed {
       
        $profile = (new MyUser)->extractUserInfo($this);
        return [
            'isOnline'           => $this->isOnline,
            'userId'             => $this->id,
            'threadId'           => $this->thread_id ?? $this->threads->first()?->id,
            'name'               => $profile['name'],
            'photo'              => $profile['photo'],
            'threadType'         => 'private',
            'blockedBy'          => $this->pivot?->blocked_by,
            'friendStatus'       => $this->pivot?->friend_status,
        ];
    }
}
