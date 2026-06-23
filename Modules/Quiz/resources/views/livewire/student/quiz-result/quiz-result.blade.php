<div class="am-quizmark am-quiz_result">
    <div class="am-quiz_header">
        @if(auth()->user()->role == 'tutor')
            <a href="{{ route('quiz.tutor.quiz-attempts', ['quizId' => $attemptQuiz->quiz_id]) }}"><i class="am-icon-chevron-left"></i></a>
        @endif
        <div class="am-quiz_title">
            <div class="am-coursename">
                <h2>{{ $attemptQuiz?->quiz?->title }}</h2>
            </div>
            <div class="am-quiz_tagline">
                <span>
                    {{__('quiz::quiz.finished') }} {{ \Carbon\Carbon::parse($attemptQuiz?->completed_at)->format('F j, Y @ h:i A') }}
                </span>
            </div>
        </div>
        @if($attemptQuiz->result != Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW)
            <div class="am-result_summary">
                <div class="am-result_detail">
                    <div class="am-result_info">
                        <h5>{{ round(($attemptQuiz->earned_marks / $attemptQuiz->total_marks * 100), 2) }}%</h5>
                        <span>{{ __('quiz::quiz.accuracy') }}</span>
                    </div>
                    <div id="progress-bar-timer" class="anti-clock-progessbar" 
                        style="background: conic-gradient(#17B26A {{ round(($attemptQuiz->earned_marks / $attemptQuiz->total_marks * 360), 2) }}deg, #F7F7F8 {{ round(($attemptQuiz->earned_marks / $attemptQuiz->total_marks * 360), 2) }}deg);">
                    </div>
                </div>
                <div class="am-result_detail">
                    <div class="am-result_info">
                        <h5>{{ $attemptQuiz->earned_marks }}</h5>
                        <span>{{ __('quiz::quiz.marks') }}</span>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <rect x="-0.00195312" width="20" height="20" rx="10" fill="#FEB000"/>
                        <path d="M9.62421 5.67982C9.75307 5.33157 10.2456 5.33157 10.3745 5.67982L11.376 8.38637C11.4165 8.49586 11.5028 8.58218 11.6123 8.62269L14.3189 9.62421C14.6671 9.75307 14.6671 10.2456 14.3189 10.3745L11.6123 11.376C11.5028 11.4165 11.4165 11.5028 11.376 11.6123L10.3745 14.3189C10.2456 14.6671 9.75307 14.6671 9.62421 14.3189L8.62269 11.6123C8.58218 11.5028 8.49586 11.4165 8.38637 11.376L5.67982 10.3745C5.33157 10.2456 5.33157 9.75307 5.67982 9.62421L8.38637 8.62269C8.49586 8.58218 8.58218 8.49586 8.62269 8.38637L9.62421 5.67982Z" fill="black"/>
                    </svg>
                </div>
                <div class="am-result_detail">
                    <div class="am-result_info">
                        <h5>{{ $attemptQuiz->correct_answers }} /{{ $attemptQuiz->total_questions }}</h5>
                        <span>{{ __('quiz::quiz.correct_answer') }}</span>
                    </div>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <g opacity="0.8">
                            <path d="M7.625 9.99935L9.20834 11.5827L12.7708 8.02018M7.94224 2.20557L5.13168 3.4547C4.31485 3.81773 3.90643 3.99925 3.60695 4.28618C3.34223 4.5398 3.13982 4.85126 3.01557 5.19617C2.875 5.58637 2.875 6.03331 2.875 6.92719L2.875 11.2461C2.875 12.2375 2.875 12.7332 3.01165 13.1831C3.13262 13.5814 3.33094 13.952 3.59527 14.2736C3.89386 14.6369 4.3063 14.9119 5.13119 15.4618L7.89214 17.3024C8.65394 17.8103 9.03484 18.0642 9.44654 18.1629C9.81036 18.2501 10.1896 18.2501 10.5535 18.1629C10.9652 18.0642 11.3461 17.8103 12.1079 17.3024L14.8688 15.4618C15.6937 14.9119 16.1061 14.6369 16.4047 14.2736C16.6691 13.952 16.8674 13.5814 16.9884 13.1831C17.125 12.7331 17.125 12.2375 17.125 11.2461L17.125 6.92718C17.125 6.0333 17.125 5.58637 16.9844 5.19617C16.8602 4.85126 16.6578 4.5398 16.3931 4.28617C16.0936 3.99925 15.6852 3.81773 14.8683 3.45469L12.0578 2.20557C11.3 1.86879 10.9211 1.70039 10.5273 1.63389C10.1782 1.57495 9.82177 1.57495 9.47272 1.63389C9.07889 1.7004 8.70001 1.86879 7.94224 2.20557Z" stroke="#585858" stroke-width="1.35714" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </div>
            </div> 
        @endif
    </div>
    <div class="am-quizmark_content">
        @if(auth()->user()->role == 'student')
            @if($attemptQuiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW)
                <div class="am-result_massage">
                    <div class="am-deletepopup_icon confirm-icon">
                        <span>
                            <i class="am-icon-check-circle06"></i>
                        </span>
                    </div>
                    <h3>{{__('quiz::quiz.quiz_submitted_successfully') }}</h3>
                    <p>{{__('quiz::quiz.quiz_submitted_details') }}</p>
                    <a href="{{ route('quiz.student.quizzes') }}"><button class="am-btn">{{ __('quiz::quiz.go_to_my_quizzes') }}</button></a>
                </div>
            @elseif($attemptQuiz->result == 'pass')
                <div class="am-result_massage">
                    <figure>
                        <img src='{{asset("demo-content/quiz/congrates.png")}}' alt="image">
                    </figure>
                    <h3>{{__('quiz::quiz.quiz_pass_heading') }}</h3>
                    <p>{{ __('quiz::quiz.quiz_pass_para') }}</p>
                    <a href="{{ route('quiz.student.quizzes') }}"><button class="am-btn">{{ __('quiz::quiz.go_to_my_quizzes') }}</button></a>
                </div>
            @elseif($attemptQuiz->result == 'fail')
                <div class="am-result_massage">
                    <div class="am-deletepopup_icon">
                        <span><i class="am-icon-exclamation-01"></i></span>
                    </div>
                    <h3>{{ __('quiz::quiz.quiz_fail_heading') }}</h3>
                    <p>{{ __('quiz::quiz.quiz_fail_para') }}</p>
                    <a href="{{ route('quiz.student.quizzes') }}"><button class="am-btn">{{ __('quiz::quiz.go_to_my_quizzes') }}</button></a>
                </div>
            @endif
        @endif

        @if($attemptQuiz->result != Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW)
            <div class="am-quizmark_title">
                <h2>{{ __('quiz::quiz.quiz_summary') }}:</h2>
            </div>
            <div class="accordion am-accordions" id="accordionPanelsStayOpenExample">
                @foreach($attemptQuiz->quiz?->questions as $question)
                    <div class="accordion-item">
                        <div class="accordion-header" id="panelsStayOpen-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#question-{{$question->id}}" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                               <div class="am-ans-detail_wrap">
                                    <h4>
                                        <em>{{ __('quiz::quiz.question_number', ['number' => $loop->index + 1]) }}</em>
                                        {!! getQuestionTitle($question)!!}
                                    </h4>
                                    <div class="am-ans-detail">
                                        <span>
                                            <i class="am-icon-layer-01"></i>
                                            {{ __('quiz::quiz.type') }} <em>{{__('quiz::quiz.'.$question->type)}}</em>
                                        </span>
                                        @php
                                            $attempt = $question->attemptedQuestions->first();
                                            $isOpenEnded = in_array($question->type, [Modules\Quiz\Models\Question::TYPE_OPEN_ENDED_ESSAY, Modules\Quiz\Models\Question::TYPE_SHORT_ANSWER]);
                                        @endphp

                                        @if(!empty($attempt) && $attempt->is_attempted)
                                            @if($attempt->is_correct && $attempt->marks_awarded > 0 && !($attemptQuiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW && $isOpenEnded))
                                                @include('quiz::livewire.student.quiz-result.components.correct')
                                            @elseif(!$isOpenEnded)
                                                @include('quiz::livewire.student.quiz-result.components.incorrect')
                                            @endif
                                        @else
                                            @include('quiz::livewire.student.quiz-result.components.not-attempted')
                                        @endif

                                        @if(!($attemptQuiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW && $isOpenEnded))
                                            <span>
                                                <svg width="15" height="16" viewBox="0 0 15 16" fill="none">
                                                    <rect y="0.5" width="15" height="15" rx="7.5" fill="#FEB000"/>
                                                    <path d="M7.21864 4.76035C7.31529 4.49917 7.68471 4.49917 7.78136 4.76035L8.53249 6.79026C8.56288 6.87238 8.62762 6.93712 8.70974 6.96751L10.7396 7.71864C11.0008 7.81529 11.0008 8.18471 10.7396 8.28136L8.70974 9.03249C8.62762 9.06288 8.56288 9.12762 8.53249 9.20974L7.78136 11.2396C7.68471 11.5008 7.31529 11.5008 7.21864 11.2396L6.46751 9.20974C6.43712 9.12762 6.37238 9.06288 6.29026 9.03249L4.26035 8.28136C3.99917 8.18471 3.99917 7.81529 4.26035 7.71864L6.29026 6.96751C6.37238 6.93712 6.43712 6.87238 6.46751 6.79026L7.21864 4.76035Z" fill="black"/>
                                                </svg>
                                                {{ __('quiz::quiz.points') }} <em>{{ $question->attemptedQuestions?->first()?->marks_awarded ?? 0 }}</em>/{{ $question?->points }}
                                            </span>
                                        @endif
                                    </div>
                               </div>
                                <span><i class="am-icon-chevron-down"></i></span>
                            </button>
                        </div>
                        <div id="question-{{$question->id}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                            <div class="accordion-body">
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
                                        <div class="am-quiz-answers_answer">
                                            {!! $question->attemptedQuestions->first()?->answer !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush