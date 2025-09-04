<div class="am-createquiz" wire:init="loadData">
    @include('quiz::livewire.tutor.quiz-creation.components.quiz-tab')
    <div class="am-createques">
        <div class="am-createques_header">
            <div class="am-createques_title">
                <h3>{{ __('quiz::quiz.question_manager') }}</h3>
                <p>{{ __('quiz::quiz.question_manager_desc') }}</p>
            </div>
            @if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED && $quiz->questions_count > 0)
                <div class="question-manager">
                    @if(!empty($quiz->questions_count))
                        <button class="am-publish" data-bs-toggle="modal" data-bs-target="#course_completed_popup">
                            <i class="am-icon-compare-1"></i>
                            {{ __('quiz::quiz.publish') }}
                        </button>
                    @endif
                    
                    <button class="am-btn" data-bs-toggle="modal" data-bs-target="#am-createques-modal">
                        <i class="am-icon-plus-02"></i>
                        {{ __('quiz::quiz.add_question') }}
                    </button>
                </div>
            @endif
        </div>
        @if(!empty($quiz->questions_count) )
            <div class="am-createques_search">
                <div class="am-quizlist_search">
                    <input type="text" wire:model.live.debounce.500ms="keyword" class="form-control" placeholder="{{ __('quiz::quiz.search_by_keyword') }}" />
                    <i class="am-icon-search-02"></i>
                </div>
                <div class="am-select" wire:ignore>

                    <select data-componentid="@this" data-live="true" class="am-select2" id="status"  data-wiremodel="questionType">
                        <option value="">{{ __('quiz::quiz.all') }}</option>
                        @foreach ($questionTypes as $questionType)
                            <option value="{{ $questionType['value'] }}" @if(!empty($questionType['is_disabled'])) disabled="disabled" @endif>{{ __('quiz::quiz.' . $questionType['type']) }}</option>
                        @endforeach
                    </select>
                    @if($autoResultGenerte)
                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong>{{ __('quiz::quiz.alert') }}</strong>
                                <span>{{ __('quiz::quiz.not_allowed_to_create') }}</span>
                            </span>
                        </i>
                    @endif
                </div>
            </div>
        @endif

        <div class="am-quizlist_wrap" wire:loading wire:target="loadData, questionType, keyword">
            @include('quiz::skeletons.question-skeleton', ['total' => $perPage])
        </div>
        @if(!$isLoading)
        <div class="am-question_manager" wire:loading.remove wire:target="loadData, questionType, keyword">
            @if($questions->isNotEmpty())
                <ul @if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED) wire:sortable="updateQuistionPosition" @endif class="am-createques_details" id="am-accordion-questionlist">
                    @foreach ($questions as $index => $question)
                        <li wire:sortable.item="{{ $question->id }}" wire:key="question-{{ $question->id }}" id="question-{{ $question->id }}" class="am-resume_item">
                            <div class="am-resume_item_question">
                                <div class="am-resume_content" data-bs-toggle="collapse" data-bs-target="#am-content-question-{{ $question->id }}" aria-expanded="false" aria-controls="question-{{ $question->id }}">
                                    <h4>
                                        <span>{{__('quiz::quiz.question_number', ['number' => $index + 1])}}</span>
                                        {{ str_replace(array('[blank]', '[Blank]'), '______', $question?->title )  }}
                                    </h4>
                                    <ul class="am-resume_item_info">
                                        <li>
                                            <div class="am-resume_item_list">
                                                <span>
                                                    <i class="am-icon-layer-01"></i>
                                                    {{ __('quiz::quiz.type') }}
                                                </span>
                                                <h6>{{ __('quiz::quiz.'.$question?->type) }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="am-resume_item_list">
                                                <span>
                                                    <i class="am-icon-shield-check"></i>
                                                    {{ __('quiz::quiz.marks') }}
                                                </span>
                                                <h6>{{ $question?->points }}</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                @if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED)
                                    <span class="am-dropdown-icon" data-bs-container="body" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="am-icon-ellipsis-horizontal-02"></i>
                                    </span>
                                    <ul class="dropdown-menu am-dropdown">
                                        <li wire:key="edit-{{ $question?->id }}">
                                            <a href="{{route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => $question?->type, 'questionId' => $question?->id])}}"  class="dropdown-item">
                                                <i class="am-icon-pencil-02"></i>
                                                {{ __('quiz::quiz.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a  @click="$wire.dispatch('showConfirm', { id : {{ $question?->id }}, action : 'delete-question' })" class="dropdown-item">
                                                <i class="am-icon-trash-02"></i>
                                                {{ __('quiz::quiz.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            @if (
                                (in_array($question?->type, [Modules\Quiz\Models\Question::TYPE_MCQ, Modules\Quiz\Models\Question::TYPE_TRUE_FALSE, Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS]) && $question?->options->count() > 0) ||
                                !empty($question?->description)
                            )
                                <div class="am-createques_collapse accordion-collapse collapse" id="am-content-question-{{ $question->id }}" aria-labelledby="am-content-question-{{ $question->id }}" 
                                    data-bs-parent="#am-accordion-questionlist">
                                    <div class="am-createques_list_wrap">
                                        @if(in_array($question?->type, [Modules\Quiz\Models\Question::TYPE_MCQ, Modules\Quiz\Models\Question::TYPE_TRUE_FALSE]) && $question?->options->count() > 0)
                                            <ul class="am-createques_list">
                                                @foreach ($question?->options as $option)
                                                    <li @class(['am-correct-answer' =>  !empty($option?->is_correct)])>
                                                        <div class="am-radio">
                                                            <input type="radio" disabled {{ $option?->is_correct == 1 ? 'checked' : '' }} id="am-option-{{ $option->id }}" name="option-{{ $question->id }}" value="{{ $option?->option_text }}">
                                                            <label for="am-option-{{ $option->id }}">{{ $option?->option_text }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @elseif($question?->type == Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS && $question?->options->count() > 0)
                                            <ul class="am-createques_list am-createques_fitb-options">
                                                @foreach ($question?->options as $option)
                                                    <li>
                                                        <span>{{ $option?->option_text }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if(!empty($question?->description))
                                            <p>{!! $question?->description !!}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if($quiz->status != Modules\Quiz\Models\Quiz::STATUS_PUBLISHED)
                                <span wire:sortable.handle ><i class="am-icon-youtube-1"></i></span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        <h3>{{ __('quiz::quiz.no_questions_added_yet') }}</h3>
                        <p>{{ __('quiz::quiz.no_questions_added_yet_desc') }}</p>
                        <div class="am-emptyview_btn_wrap">
                            <button class="am-btn" data-bs-toggle="modal" data-bs-target="#am-createques-modal">
                                <i class="am-icon-plus-02"></i>
                                {{ __('quiz::quiz.add_question') }}
                            </button>
                        </div>
                    </div>
                </div>     
            @endif
            </div>    
        @endif 
        
        <div class="modal fade am-createques-modal" id="am-createques-modal" >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div >
                            <h4>{{ __('quiz::quiz.select_question_type') }}</h4>
                            <p>{{ __('quiz::quiz.select_question_type_desc') }}</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="am-createques-modal_list">
                            <li>
                                <a href="{{route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'fill_in_blanks'])}}">
                                    <i class="am-icon-pencil-02"></i>
                                    {{ __('quiz::quiz.fill_in_blanks') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'mcq'])}}">
                                    <i class="am-icon-list-02"></i>
                                    {{ __('quiz::quiz.multiple_choice') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'true_false'])}}">
                                    <i class="am-icon-check-circle01"></i>
                                    {{ __('quiz::quiz.true_false') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ $autoResultGenerte ? 'javascript:void(0);' : route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'short_answer'])}}">
                                    <i class="am-icon-screen"></i>
                                    {{ __('quiz::quiz.short_answer') }}
                                    @if($autoResultGenerte)
                                        <i class="am-tooltip am-icon-exclamation-01">
                                            <span class="am-tooltip-text">
                                                <strong>{{ __('quiz::quiz.alert') }}</strong>
                                                <span>{{ __('quiz::quiz.not_allowed_to_create') }}</span>
                                            </span>
                                        </i>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ $autoResultGenerte ? 'javascript:void(0);' :  route('quiz.tutor.create-question', ['quizId' => $quiz->id, 'questionType' => 'open_ended_essay'])}}">
                                    <i class="am-icon-menu-5"></i>
                                    {{ __('quiz::quiz.essay') }}
                                    @if($autoResultGenerte)
                                        <i class="am-tooltip am-icon-exclamation-01">
                                            <span class="am-tooltip-text">
                                                <strong>{{ __('quiz::quiz.alert') }}</strong>
                                                <span>{{ __('quiz::quiz.not_allowed_to_create') }}</span>
                                            </span>
                                        </i>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade am-successfully-popup" id="course_completed_popup">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-body">
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                        <div class="am-deletepopup_icon confirm-icon">
                            <span>
                                <i class="am-icon-exclamation-01"></i>
                            </span>
                        </div>
                        <div class="am-successfully_title">
                            <h3>{{ __('quiz::quiz.publish_quiz_confirmation_title') }}</h3>
                            <p>{{ __('quiz::quiz.publish_quiz_confirmation_desc') }}</p>
                        </div>
                        <div class="am-successfully-popup_btns">
                            <a href="#" data-bs-dismiss="modal" class="am-white-btn">{{ __('quiz::quiz.cancel') }}</a>
                            <a  
                            wire:loading.class="am-btn_disable" 
                            wire:target="publishQuiz"
                            wire:click="publishQuiz" class="am-btn">{{ __('quiz::quiz.publish') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush

@push('scripts')
<script defer src="{{ asset('js/livewire-sortable.js')}}"></script>
@endpush