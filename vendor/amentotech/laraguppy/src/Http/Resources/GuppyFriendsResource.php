<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GuppyFriendsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request): array
    {   
        return [
            'list'          => (!$this->collection->isEmpty()? GuppyFriendResource::collection($this->collection->keyBy(function ($item) {
                return $item->threads->first()->id ?? null;
            })): null),
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
