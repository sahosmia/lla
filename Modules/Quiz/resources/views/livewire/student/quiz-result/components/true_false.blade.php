@php 
     $question_number = $loop->index + 1;
@endphp
<div class="am-question {{!$attemptedQuestions?->is_correct ? 'am-wrong-answer' :  '' }}">
    <div class="am-question_title">
        <h4>
            <em>{{ $question_number }}</em> 
            {{ $attemptedQuestions?->question?->question_title}}
        </h4>
        
        @if(!empty($show_result))
            <div class="am-question_points">
                <span>
                    {{ __('quiz::quiz.result_point', ['points' => $attemptedQuestions?->marks_awarded, 'total_points' =>  $attemptedQuestions?->question->points]) }}
                </span>
            </div>
        @endif
    </div>
    <ul class="am-question_options">
        @foreach ($attemptedQuestions?->question?->options as $option)
            <li>
                @php
                    $className = '';
                    if ($option?->id === $attemptedQuestions?->question_option_id) {
                        $className = $option?->is_correct == 1 ? 'am-isanswer-true' : 'am-isanswer-false';
                    }
                @endphp
                <div class="am-radio {{ $className }}">
                    <input type="radio" id="a" name="price_type" value="paid" disabled>
                    <label for="a">{{ $option?->option_text }}</label>
                </div>
            </li>
        @endforeach
    </ul>

    @if(!empty($show_result) && !empty($attemptedQuestions?->question?->answer_explanation))
        <div class="am-question_answer">
            <h3>
                <i class="am-icon-check-circle03"></i>
                {{ $attemptedQuestions?->is_correct ? __('quiz::quiz.correct_answer') : __('quiz::quiz.wrong_answer') }}
            </h3>
            <p>{{ $attemptedQuestions?->question?->answer_explanation }}</p>
        </div>
    @endif
</div>