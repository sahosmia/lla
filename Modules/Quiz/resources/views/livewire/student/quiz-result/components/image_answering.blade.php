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
    <div class="am-question_selections">
        <ul class="am-selectoptions">
            @foreach ($attemptedQuestions?->question?->options as $option)
                <li>
                    @php
                        $className = '';
                        if ($option?->id === $attemptedQuestions?->question_option_id) {
                            $className = $option?->is_correct == 1 ? 'am-isanswer-true' : 'am-isanswer-false';
                        }
                    @endphp
                    <div class="am-radio {{ $className }}">
                        <input type="radio" id="{{ 'option_' .$question_number.'_' .$option?->id }}" name="option_{{ $attemptedQuestions?->question?->id }}" value="{{ $option?->id }}" disabled>
                        <label for="{{ 'option_' .$question_number.'_' .$option?->id }}">
                            <span>{{  chr(65 + $loop->index) }}</span>
                            <img src="{{ url(Storage::disk(getStorageDisk())->url($option->image?->path)) }}" alt="image">
                        </label>
                    </div>
                </li>
            @endforeach            
        </ul>
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