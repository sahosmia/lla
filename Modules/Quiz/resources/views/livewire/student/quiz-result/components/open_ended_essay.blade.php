@php 
    $question_index = array_search($attemptedQuestions->question_id, array_column($requiredAnswers, 'question_id'));
@endphp
<div class="am-question {{!$attemptedQuestions?->is_correct ? 'am-wrong-answer' :  '' }}">
    <div class="am-question_title">
        <h4>
            <em>{{ $loop->index + 1 }}</em> 
            {{$attemptedQuestions?->question?->question_title }}
        </h4>
        @error("requiredAnswers.{$question_index}.marks_awarded")
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @if($show_result || $user->role == 'tutor')
            <div class="am-question_points">
                @if(!$show_result)
                    <input type="number" placeholder="Add remarks" wire:model="requiredAnswers.{{ $question_index }}.marks_awarded" max="{{ $attemptedQuestions?->question->points }}" min="0" /> 
                 @endif
                <span>
                    {{ __('quiz::quiz.result_point', ['points' => $attemptedQuestions?->marks_awarded ?? 0, 'total_points' =>  $attemptedQuestions?->question->points]) }}
                </span>
            </div>
            <div class="am-checkbox">
                <label>/{{ $attemptedQuestions?->question->points }} Answer is correct </label>
                <input type="checkbox" wire:model="requiredAnswers.{{ $question_index }}.is_correct" checked={{ !empty($requiredAnswers[$question_index ]['is_correct']) }} name="{{ 'answer_'.$loop->index + 1  }}"/>
                    @error("requiredAnswers.{$question_index}.is_correct")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                @endif
            </div>
        </div>
    <div class="am-answer">
        <span>{{ __('quiz::quiz.answer') }}</span>
        <div class="am-answer_wrap">
            {!! $attemptedQuestions?->answer !!}
        </div>
    </div>

    @if(!empty($show_result) && !empty($attemptedQuestions?->question?->answer_explanation))
        <div class="am-question_answer">
            <h3>
                <i class="am-icon-check-circle03"></i>
                {{ $attemptedQuestions?->is_correct ? __('quiz::quiz.correct_answer') : __('quiz::quiz.wrong_answer') }}
            </h3>
            <p>{!! $attemptedQuestions?->question?->answer_explanation !!}</p>
        </div>
    @endif
</div>