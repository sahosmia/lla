<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\UserSubjectGroupSubject;

class QuestionResource extends JsonResource
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
            'quiz_id'               => $this->whenHas('quiz_id'),
            'quiz_title'            => $this->when(!empty($this->quiz?->title), $this->quiz?->title),
            'title'                 => $this->whenHas('title'),
            'type'                  => $this->whenHas('type'),
            'description'           => $this->whenHas('description'),
            'points'                => $this->whenHas('points'),
            'position'              => $this->whenHas('position'),
            'options'               => OptionResource::collection($this->whenLoaded('options')),
            'settings'              => $this->whenHas('settings'),
            'is_attempted'          => $this->attemptedQuestions->first()?->is_attempted ? true : false,
            'attempted_questions'   => AttemptedQuestionsResource::collection($this->whenLoaded('attemptedQuestions')),
            'thumbnail'             => $this->thumbnail?->path ? url(Storage::url($this->thumbnail?->path)) : null,
            'quiz'                  => $this->whenLoaded('quiz', fn() => new QuizResource($this->quiz)),

        ];
    }
}
