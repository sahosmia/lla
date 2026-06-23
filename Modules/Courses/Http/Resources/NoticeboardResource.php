<?php

namespace Modules\Courses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class NoticeboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->whenHas('id'),
            'content'                   => $this->whenHas('content'),
            'created_at'                => $this->whenHas('created_at', function () {
                return \Carbon\Carbon::parse($this->created_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
        ];

    }
}