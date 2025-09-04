<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [    
            "id"                => $this['id'] ?? null,
            "user_id"           => $this['user_id'] ?? null,
            'item_id'           => $this['cartable_id'] ?? null,
            "item_name"         => $this['name'] ?? null,
            "price"             => !empty($this['price']) ? formatAmount($this['price']) : null,
            "session_time"      =>  $this->when(
                isset($this['options']) && is_array($this['options']) && array_key_exists('session_time', $this['options']),
                $this['options']['session_time'] ?? null
            ),
            "subject_group"     => $this->when(
                isset($this['options']) && is_array($this['options']) && array_key_exists('subject_group', $this['options']),
                $this['options']['subject_group'] ?? null
            ),
            "category"   => $this->when(
                isset($this['options']) && is_array($this['options']) && array_key_exists('category', $this['options']),
                $this['options']['category'] ?? null
            ),
            "image"             => $this['options']['image'] ? url(Storage::url($this['options']['image'])) : url(Storage::url('placeholder.png')),
        ];
    }
}
