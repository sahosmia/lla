<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

class QuizAttemptsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'list'             => QuizAttemptsResource::collection($this->collection),
            'pagination'       => [
                'total'        => $this->total(),
                'count'        => $this->count(),
                'perPage'      => $this->perPage(),
                'currentPage'  => $this->currentPage(),
                'totalPages'   => $this->lastPage()
            ],
        ];
    }
}
