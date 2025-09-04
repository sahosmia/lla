<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GuppyAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'file'          => !empty($this->attachments['file']) ? url(Storage::url($this->attachments['file'])) : NULL,
            'fileName'      => $this->attachments['fileName'] ?? NULL,
            'thumbnail'     => !empty($this->attachments['thumbnail']) ? url(Storage::url($this->attachments['thumbnail'])) : NULL,
            'fileSize'      => !empty($this->attachments['fileSize']) ? number_format($this->attachments['fileSize'] / 1024, 2) . ' KB' : NULL,
            'fileType'      => $this->attachments['fileType'] ?? NULL,
            'latitude'      => $this->attachments['latitude'] ?? NULL,
            'longitude'     => $this->attachments['longitude'] ?? NULL,
        ];
    
    }
}
