<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Amentotech\LaraGuppy\Services\MyUser;

class GuppyInvitedBlockFriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data       = parent::toArray($request);
        $profile    = (new MyUser)->extractUserInfo($data['friend']);

        return [
            'isOnline'           => auth()->user()->isOnline,
            'userId'             => $data['friend']->id,
            'threadId'           => null,
            'name'               => $profile['name'],
            'photo'              => $profile['photo'],
            'threadType'         => 'private',
            'blockedBy'          => $data['firendStatus']->blocked_by,
            'friendStatus'       => $data['firendStatus']->friend_status,
        ];
    }
}
