<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\UserSubjectGroupSubject;

class AttemptedQuestionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        return [

            "id"                => $this->whenHas('id'),
            "quiz_attempt_id"   => $this->whenHas('quiz_attempt_id'),
            "question_id"       => $this->whenHas('question_id'),
            "answer"            => $this->whenHas('answer'),
            "question_option_id"=> $this->whenHas('question_option_id'),
            "is_correct"        => $this->whenHas('is_correct'),
            "marks_awarded"     => $this->whenHas('marks_awarded'),
            "remarks"           => $this->whenHas('remarks'),
        ];
    }
}
