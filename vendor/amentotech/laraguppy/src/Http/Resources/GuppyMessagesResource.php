<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GuppyMessagesResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'list'          => GuppyMessageResource::collection($this->collection->reverse()),
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
