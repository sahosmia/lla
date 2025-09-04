<div class="am-quiz_questions_btn">
    <button type="button" class="am-btn-light" onclick="window.location='{{ route('quiz.tutor.question-manager', ['quizId' => $quiz->id]) }}'">
        {{ __('quiz::quiz.back') }}
    </button>
    <button type="button"
     wire:loading.class="am-btn_disable" 
     wire:target="saveQuestion"
     wire:click="saveQuestion" class="am-btn">{{ __('quiz::quiz.save') }}</button>
</div>