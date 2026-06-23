<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuppyAttachmentsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'list'          => GuppyAttachmentResource::collection($this->collection),
            'pagination'    => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'perPage'      => $this->perPage(),
                'currentPage'  => $this->currentPage(),
                'totalPages'   => $this->lastPage()
            ],
        ];
    }
}
