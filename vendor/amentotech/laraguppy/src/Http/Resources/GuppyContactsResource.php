<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuppyContactsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'list'           => (!$this->collection->isEmpty()? GuppyContactResource::collection($this->collection->keyBy->id):null),
            'pagination'     => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'perPage'      => $this->perPage(),
                'currentPage'  => $this->currentPage(),
                'totalPages'   => $this->lastPage()
            ],
        ];
    }
}
