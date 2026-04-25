<?php

namespace Modules\Upcertify\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->whenHas('id'),
            'title'                 => $this->whenHas('title'),
            'image'                 => !empty($this->thumbnail_url) ? url(Storage::url($this->thumbnail_url)) : url(Storage::url('placeholder.png')),
        ];
    }
}
