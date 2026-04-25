<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GuppyThreadsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {
        $keyedCollection = $this->collection->mapWithKeys(function ($item) {
            return [ $item['thread_type'] . '_' . $item['id'] => $item];
        });

        return [
            'list'       => (object) GuppyThreadResource::collection($keyedCollection),
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
