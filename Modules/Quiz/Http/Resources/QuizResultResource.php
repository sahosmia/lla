<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class QuizResultResource extends JsonResource
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
            'quiz_title'                 => $this->whenLoaded('quiz', function () {
                return $this->quiz->title;
            }),
            'student_id'            => $this->whenHas('student_id'),
            'started_at'            => $this->whenHas('started_at'),
            'completed_at'          => $this->whenHas('completed_at'),
            'earned_marks'          => $this->whenHas('earned_marks'),
            'total_marks'           => $this->whenHas('total_marks'),
            'accuracy'              => round(($this->earned_marks / ($this->total_marks ?? 1) * 100), 2),
            'total_questions'       => $this->whenHas('total_questions'),
            'correct_answers'       => $this->whenHas('correct_answers'),
            'result'                => $this->whenHas('result'),
            'questions'             => $this->whenLoaded('quiz', function () {
                if (empty($this->quiz->questions)) {
                    return [];
                }
                return QuestionResource::collection($this->quiz->questions);
            }),
        ];
    }
}
