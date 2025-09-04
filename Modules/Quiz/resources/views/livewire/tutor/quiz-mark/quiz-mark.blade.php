
<div class="am-quizmark am-quiz_result">
    <div class="am-quiz_header">
        <div class="am-quiz_title">
            <div class="am-coursename">
                <h2>{{ $attemptQuiz?->quiz?->title }}</h2>
            </div>
            <div class="am-quiz_tagline">
                <span>
                    <i class="am-icon-chat-03"></i>
                    {{ __('quiz::quiz.total_questions') }} <em>{{ number_format($attemptQuiz->total_questions) }}</em>
                </span>
                <span>
                    @php 
                        $hours = floor(intval($completedDuration) / 3600);
                    @endphp
                    <i class="am-icon-time"></i>
                    {{ __('quiz::quiz.duration') }} 
                    @if(!empty($hours))
                        <em>{{getDurationFormatted( intval($completedDuration))}} {{ __('quiz::quiz.hrs') }}</em>
                    @else
                        <em>{{getDurationFormatted( intval($completedDuration))}} {{ __('quiz::quiz.time_min') }}</em>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="am-quizmark_content">
        <div class="am-quizmark_title">
            <h2>{{ __('quiz::quiz.quiz_summary') }}:</h2>
        </div>
        <div class="accordion am-accordions">
            @foreach($attemptQuiz->quiz?->questions as $question)
                <div class="am-quiz-box">
                    <div class="am-quiz-box_question">
                        <h4>
                            <em>{{ __('quiz::quiz.question_number', ['number' => $loop->index + 1]) }}</em>
                            {!! getQuestionTitle($question)!!}
                        </h4>
                        @if(in_array($question->type, [Modules\Quiz\Models\Question::TYPE_OPEN_ENDED_ESSAY, Modules\Quiz\Models\Question::TYPE_SHORT_ANSWER]))
                            @php 
                                $question_index = array_search($question->id, array_column($requiredAnswers, 'question_id'));
                            @endphp
                            <div class="am-quiz-box_points">
                                <span>
                                    <em><input type="number" placeholder="{{__('quiz::quiz.add')}}" wire:model="requiredAnswers.{{ $question_index }}.marks_awarded" max="{{ $question->points }}" min="0" /> </em>
                                    /{{ $question?->points }} {{ __('quiz::quiz.points') }}
                                    @error("requiredAnswers.{$question_index}.marks_awarded")
                                        <i class="am-tooltip am-icon-exclamation-01">
                                            <span class="am-tooltip-text">
                                                <strong>{{ __('quiz::quiz.required_feild') }}</strong>
                                                <span>{{ $message }}</span>
                                            </span>
                                        </i>
                                    @enderror
                                </span>
                            </div>
                        @else
                            <div class="am-quiz-box_points">
                                <span>{{ $question->attemptedQuestions?->first()?->marks_awarded ?? 0 }}
                                    /{{ $question?->points }} 
                                    {{ __('quiz::quiz.points') }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <span>
                        <i class="am-icon-layer-01"></i>
                        {{ __('quiz::quiz.type') }} <em>{{__('quiz::quiz.'.$question->type)}}</em>
                    </span>                        
                    @if(!empty($question->isMultiOption()))
                        <div class="am-quiz-answers">
                            @foreach($question->options as $option)
                                @if($option->id == $question->attemptedQuestions?->first()?->question_option_id)
                                    <div class="am-quiz-answers_options {{ $option->id == $question->attemptedQuestions?->first()?->question_option_id && $option->is_correct === 1 ? 'am-correct-ans' : 'am-wrong-ans' }}">
                                        <div class="am-radio">
                                            <input checked type="radio" id="{{ $loop->index }}_option" name="correct-answer" disabled />
                                            <label for="{{ $loop->index }}_option">{{ $option->option_text }}</label>
                                        </div>
                                        @if($option->id == $question->attemptedQuestions?->first()?->question_option_id && $option->is_correct === 1)
                                            <span>
                                                {{ __('quiz::quiz.correct_answer') }}
                                                <i class="am-icon-check-circle06"></i>
                                            </span>
                                        @else
                                            <span>
                                                {{ __('quiz::quiz.wrong_answer_you') }}
                                                <i class="am-icon-multiply-02"></i>
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="am-quiz-answers_options {{$option->is_correct ? 'am-correct-ans am-truefalse' : ''}}">
                                        <div class="am-radio">
                                            <input {{$option->is_correct ? 'checked':''}} type="radio" id="{{ $loop->index }}_option" name="correct-answer" disabled />
                                            <label for="{{ $loop->index }}_option">{{ $option->option_text }}</label>
                                        </div>
                                    </div>     
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if($question->isDescriptive() && !empty($question->attemptedQuestions->first()?->answer))
                        <div class="am-quiz-answers">
                            <h5>{{ __('quiz::quiz.answer') }}</h5>
                            <div class="am-quiz-answers_answer">
                                {!! $question->attemptedQuestions->first()?->answer !!}
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    <div class="am-quiz_footer">
        <button wire:click.prevent="submitResult" wire:loading.class="am-btn_disable" wire:loading.attr="disabled" wire:target="submitResult" class="am-btn">{{ __('quiz::quiz.submit_result') }}</button>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush