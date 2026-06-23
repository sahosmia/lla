<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Amentotech\LaraGuppy\Services\MyUser;
use Illuminate\Http\Resources\Json\JsonResource;

class GuppyUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        if ($request->get('model_class') != 'Amentotech\LaraGuppy\Models\GuestAccount') {
            
            if ($request->get('model_class') != 'Amentotech\LaraGuppy\Models\GuestAccount') {
                $user = (new MyUser)->extractUserInfo($this);
                $returnUser = [
                    'userId'            => $this->id,
                    'shortName'         => !empty($user['name']) ? ucfirst(explode(' ',$user['name'])[0]) : '',
                    'name'              => $user['name'],
                    'email'             => $user['email'],
                    'photo'             => $user['photo'],
                    'phone'             => $user['phone'],
                    'isMuted'           => $user['isMuted']
                ];
            } else {
                $returnUser = [
                    'userId'            => $this->id,
                    'name'              => $this->name,
                    'shortName'         => !empty($user['name']) ? ucfirst(explode(' ',$user['name'])[0]) : '',
                    'email'             => $this->email,
                ];
            }
            return $returnUser;
        }        
    }
}
