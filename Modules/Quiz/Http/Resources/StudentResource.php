<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\UserSubjectGroupSubject;

class StudentResource extends JsonResource
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
            'email'                 => $this->whenHas('email'),
            'profile' => $this->when(
                $this->relationLoaded('profile'),
                fn () => [
                    'id' => $this->profile?->id,
                    'name' => $this->profile?->full_name,
                    'image' => $this->profile?->image ? url(Storage::url($this->profile?->image)) : url(Storage::url('placeholder.png')),
                ]
            ),
        ];
    }
}
