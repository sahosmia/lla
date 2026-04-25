<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class QuizAttemptsResource extends JsonResource
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
            'student_id'            => $this->whenHas('student_id'),
            'earned_marks'          => $this->whenHas('earned_marks'),
            'started_at'            => $this->whenHas('started_at', function () {
                return \Carbon\Carbon::parse($this->started_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'completed_at'            => $this->whenHas('started_at', function () {
                return \Carbon\Carbon::parse($this->completed_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') . ' @ H:i A' : 'M d, Y @ H:i A');
            }),
            'total_marks'           => $this->whenHas('total_marks'),
            'total_questions'       => $this->whenHas('total_questions'),
            'correct_answers'       => $this->whenHas('correct_answers'),
            'incorrect_answers'     => $this->whenHas('incorrect_answers'),
            'result'                => $this->whenHas('result'),
            'quiz'                  => new QuizResource($this->whenLoaded('quiz')),
            'student'               => new StudentResource($this->whenLoaded('student')),
        ];
    }
}
