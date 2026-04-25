<?php

namespace Modules\Quiz\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\UserSubjectGroupSubject;

class QuizResource extends JsonResource
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
            'title'                 => $this->whenHas('title'),
            'quizzable_type'        => $this->whenHas('quizzable_type') == UserSubjectGroupSubject::class ? 'subject' : 'course',
            'quizzable_id'          => $this->whenHas('quizzable_id'),
            'user_subject_slots'    => $this->whenHas('user_subject_slots'),
            'description'           => $this->whenHas('description'),
            'created_at'                    => $this->whenHas('created_at', function () {
                return \Carbon\Carbon::parse($this->created_at)->format(!empty(setting('_general.date_format')) ? setting('_general.date_format') : 'M d, Y');
            }),
            'status'                => $this->whenHas('status'),
            'quiz_attempts_count'   => $this->whenHas('quiz_attempts_count'),
            'questions_count'       => $this->whenHas('questions_count'),
            'questions_sum_points'  => $this->whenHas('questions_sum_points'),
            'quiz_author'           => $this->whenLoaded('tutor', function () {
                return [
                    'id'            => $this->tutor?->id,
                    'full_name'     => $this->tutor?->profile?->full_name,
                    'image'         => $this->tutor?->profile?->image ? url(Storage::url($this->tutor?->profile?->image)) : url(Storage::url('placeholder.png')),
                ];
            }),
            'settings'              => $this->when(
                $this->relationLoaded('settings'),
                fn() => $this->settings->map(function ($setting) {
                    return [
                        'meta_key'      => $setting->meta_key,
                        'meta_value'    => $setting->meta_value
                    ];
                })
            ),

            'auto_marking' => $this->whenLoaded('settings', fn() => $this->auto_result_generate),
            'quizzable' => $this->when(
                $this->relationLoaded('quizzable'),
                fn() => [
                    'id'                    => $this->quizzable?->id,
                    'user_subject_group_id' => $this->quizzable?->user_subject_group_id,
                    'hour_rate'             => $this->quizzable?->hour_rate,
                    'description'           => $this->quizzable?->description,
                    'image'                 => $this->getQuizImage(),
                ]
            ),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
        ];
    }

    private function getQuizImage()
    {
        if (isActiveModule('courses') && $this->quizzable_type == \Modules\Courses\Models\Course::class && !empty($this->quizzable?->thumbnail?->path)) {
            return url(Storage::url($this->quizzable?->thumbnail?->path));
        }

        if ($this->quizzable_type == UserSubjectGroupSubject::class && !empty($this->quizzable?->image)) {
            return url(Storage::url($this->quizzable?->image));
        }

        url(Storage::url('placeholder.png'));
    }
}
