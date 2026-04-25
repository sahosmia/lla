<div class="am-createquiz">
    @include('quiz::livewire.tutor.quiz-creation.components.quiz-tab')
    <div class="am-userperinfo am-quizsetting">
        <div class="am-title_wrap">
            <div class="am-title">
                <h2>{{ __('quiz::quiz.basic_settings') }}</h2>
                <p>{{ __('quiz::quiz.basic_settings_description') }}</p>
            </div>
        </div>
        <form class="am-themeform am-themeform_personalinfo">
            <fieldset>
                <div class="form-group">
                    <label class="am-label">{{ __('quiz::quiz.quiz_duration') }}
                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong>{{ __('quiz::quiz.this_set_quiz_duration') }}</strong>
                                <span>{{ __('quiz::quiz.quiz_duration_description') }}</span>
                            </span>
                        </i>
                    </label>
                    <div class="form-group-two-wrap quiz-time">
                        <div class="form-control_wrap">
                            <label class="am-label" for="">{{__('quiz::quiz.hours') }}</label>
                            <span class="am-select" wire:ignore>
                                <select 
                                    data-componentid="@this" 
                                    class="am-select2" 
                                    data-parent=".quiz-time" 
                                    data-wiremodel="form.hours" 
                                    data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                    <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                    @for ($i = 0; $i < 24; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" 
                                            {{ isset($form->hours) && $form->hours == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </span>
                            <x-quiz::input-error field_name="form.hours" />
                        </div>
                        <div class="form-control_wrap">
                            <label class="am-label" for="">{{__('quiz::quiz.minutes') }}</label>
                            <span class="am-select" wire:ignore>
                                <select 
                                    data-componentid="@this" 
                                    class="am-select2" 
                                    data-wiremodel="form.minutes" 
                                    data-parent=".quiz-time"
                                    data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                    <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                    @for ($i = 0; $i < 60; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" 
                                            {{ isset($form->minutes) && $form->minutes == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </span>
                            <x-quiz::input-error field_name="form.minutes" />
                        </div>
                    </div>

                </div>
                {{-- <div class="form-group  @error('form.attempts_allowed') am-invalid @enderror">
                    <label class="am-label" for="">{{ __('quiz::quiz.attempts_allowed') }}
                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong>{{ __('quiz::quiz.this_attempts_allowed') }}</strong>
                                <span>{{ __('quiz::quiz.attempts_allowed_description') }}</span>
                            </span>
                        </i>
                    </label>
                    <input class="form-control" wire:model="form.attempts_allowed" placeholder="5" type="text">
                    <x-quiz::input-error field_name="form.attempts_allowed" />
                </div> --}}
                <div class="form-group  @error('form.passing_grade') am-invalid @enderror">
                    <label class="am-label" for="">{{ __('quiz::quiz.passing_grade') }}
                        <i class="am-tooltip am-icon-exclamation-01">
                            <span class="am-tooltip-text">
                                <strong>{{ __('quiz::quiz.this_passing_grade') }}</strong>
                                <span>{{ __('quiz::quiz.passing_grade_description') }}</span>
                            </span>
                        </i>
                    </label>
                    <div class="form-control_wrap">
                        <div class="am-passing-grade">
                            <input class="form-control" wire:model="form.passing_grade" placeholder="100" type="text">
                            <span>%</span>
                        </div>
                        <x-quiz::input-error field_name='form.passing_grade' />
                    </div>        
                </div>
                <div class="form-group">
                    <label class="am-label">{{ __('quiz::quiz.hide_quiz_timer') }}</label>
                    <div class="form-group-two-wrap">
                        <div class="am-quiz-switchbtn">
                            <input wire:model.live="form.hide_Quiz" type="checkbox" checked>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('quiz::quiz.advanced_settings') }}</h2>
                    <p>{{ __('quiz::quiz.advanced_settings_description') }}</p>
                </div>
            </div>
            <fieldset>
                <div class="form-group">
                    <label class="am-label">{{ __('quiz::quiz.question_order') }}</label>
                    <div class="form-group-two-wrap @error('form.question_order') am-invalid @enderror" wire:loading.class="am-disabled">
                        <div class="form-group-half">
                            <span class="am-select" wire:ignore>
                                <select class="am-select2" data-componentid="@this" id="question_order" data-live="true" data-wiremodel="form.question_order" data-placeholder="{{ __('quiz::quiz.select_option') }}">
                                    <option value="">{{ __('quiz::quiz.select_option') }}</option>
                                    <option value="asc" @if($form->question_order == 'asc') selected @endif >{{ __('quiz::quiz.ascending') }}</option>
                                    <option value="desc" @if($form->question_order == 'desc') selected @endif >{{ __('quiz::quiz.descending') }}</option>
                                    <option value="random" @if($form->question_order == 'random') selected @endif >{{ __('quiz::quiz.random') }}</option>
                                </select>
                            </span>
                            <x-quiz::input-error field_name='form.question_order' />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="am-label">{{ __('quiz::quiz.character_limit') }}</label>
                    <div class="form-group-two-wrap">
                        <div class="form-group-half @error('form.limit_short_answers') am-invalid @enderror">
                            <label class="am-label" for="">{{ __('quiz::quiz.short_answer_character_limit') }}</label>
                            <input class="form-control"  wire:model="form.limit_short_answers" placeholder="500" type="text">
                            <x-quiz::input-error field_name='form.limit_short_answers' />
                        </div>
                        <div class="form-group-half @error('form.limit_max_answers') am-invalid @enderror ">
                            <label class="am-label" for="">{{ __('quiz::quiz.essay_max_characters') }}</label>
                            <div class="form-control_wrap">
                                <input class="form-control" wire:model="form.limit_max_answers" placeholder="5000" type="text">
                                <x-quiz::input-error field_name='form.limit_max_answers' />
                            </div>        
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="am-label" for="">{{ __('quiz::quiz.auto_result_generate') }}
                        <i class="am-tooltip am-icon-exclamation-01 am-resulttooltip">
                            <span class="am-tooltip-text">
                                <span>{{ __('quiz::quiz.auto_result_generate_description') }}</span>
                            </span>
                        </i>
                    </label>
                    <div class="form-group-two-wrap">
                        <div class="am-quiz-switchbtn">
                            <input type="checkbox" wire:model.live="form.auto_result_generate" checked>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="am-label">{{ __('quiz::quiz.hide_question_numbers') }}</label>
                    <div class="form-group-two-wrap">
                        <div class="am-quiz-switchbtn">
                            <input type="checkbox" wire:model.live="form.hide_question"  checked>
                        </div>
                    </div>
                </div>
                <div class="form-group am-form-btns">
                    <a href="{{ route('quiz.tutor.quizzes') }}" class="am-white-btn">{{ __('quiz::quiz.cancel') }}</a>
                    <button type="button" wire:click="saveQuizSetting" wire:loading.class="am-btn_disable" wire:target="saveQuizSetting" class="am-btn">{{ __('quiz::quiz.save') }} &amp; {{ __('quiz::quiz.update') }}</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>    

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush