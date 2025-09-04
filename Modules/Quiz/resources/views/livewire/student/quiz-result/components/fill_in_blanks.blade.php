

@php 
    $question_number = $loop->index + 1;
    $answers = explode('|', $attemptedQuestions?->answer) ?? [];
    $option_text = $attemptedQuestions?->question?->options[0]?->option_text;
    $options = !empty($option_text) ? explode('|', $option_text) : [];
    $question_title = str_replace('{{option}}', '_____', $attemptedQuestions?->question?->question_title);
@endphp
<div class="am-question {{ $attemptedQuestions?->is_correct ? '': 'am-wrong-answer' }}">
    <div class="am-question_title">
        <h4>
            <em>{{ $question_number }}</em> 
            {{ $question_title}}
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
        @foreach ($options as $option)
            <li>
                @php
                    $className = strtolower($option) ==  strtolower($answers[$loop->index]) ? 'am-isanswer-true' : 'am-isanswer-false';
                @endphp
                <div class="am-radio {{ $className }}">
                    <input type="radio" id="{{ 'option_' .$question_number.'_'. $loop->index }}" name="price_type" value="paid" disabled>
                    <label for="{{ 'option_' .$question_number.'_'. $loop->index }}">{{ $option }}</label>
                </div>
            </li>
        @endforeach
    </ul>
    {{ $attemptedQuestions?->result }}
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