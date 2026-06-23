<div class="am-quiz_questions_title">
    <h2>
        <a href="{{route('quiz.tutor.question-manager', ['quizId' => $quiz->id])}}"><svg width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path d="M14.2109 6L8.21094 12L14.2109 18" stroke="#585858" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        {{ __('quiz::quiz.question_count',['count' => !$questionId ? $question_count : '']) }} 
    </h2>
    <div class="am-select" wire:ignore>
        <select data-componentid="@this" data-live="true" class="am-select2" id="status" @if($questionId) disabled @endif data-wiremodel="questionType">
            @foreach ($questionTypes as $type)
                @if(!$type['is_disabled'])
                    <option value="{{ $type['type'] }}" @if($type['type'] == $questionType) selected @endif>{{ __('quiz::quiz.' . $type['type']) }}</option>
                @endif
            @endforeach
        </select>
        <span class="am-select-type">{{ __('quiz::quiz.type') }}:</span>
    </div>
</div>