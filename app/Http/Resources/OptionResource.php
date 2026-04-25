<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this['id'],
            'image'                 => !empty($this['image']) ? url(Storage::url($this['image'])) : url(Storage::url('placeholder.png')),
            'price'                 => !empty($this['price']) ? formatAmount($this['price']) : null,
            'slot_id'               => $this['slot_id'] ?? null ,
            'subject'               => $this['subject'] ?? null,
            'tutor_id'              => $this['tutor_id'] ?? null,
            'tutor_name'            => $this['tutor_name'] ?? null,
            'session_time'          => $this['session_time'] ?? null,
            'subject_group'         => $this['subject_group'] ?? null,
            'currency_symbol'       => $this['currency_symbol'] ?? null,
        ];
    }
}
