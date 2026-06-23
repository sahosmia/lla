<div class="am-quiz_setting_section">
    <div class="am-quiz_setting_title">
        <div class="am-quiz_setting_heading">
            <h5>{{ __('quiz::quiz.question_settings') }}</h5>
            <p>{{ __('quiz::quiz.question_settings_desc') }}</p>
        </div>
    </div>
    <div class="am-quiz_setting_listing">
        <div class="am-quiz_setting_item">
            <span>
            {{ __('quiz::quiz.points_for_correct_answer') }}
                <i class="am-tooltip am-icon-exclamation-01">
                    <span class="am-tooltip-text">
                        <span>{{ __('quiz::quiz.point_awarded_tooltip') }}</span>
                    </span>
                </i>
            </span>
            <input class="form-control" wire:model="points" placeholder="10" type="text">
            
        </div>
        <x-quiz::input-error field_name='points' /> 
        <div class="am-quiz_setting_item">
            <span>
                {{ __('quiz::quiz.answer_required') }}
                <i class="am-tooltip am-icon-exclamation-01">
                <span class="am-tooltip-text">
                    <span>{{ __('quiz::quiz.answer_required_tooltip') }}</span>
                </span>
            </i>
            </span>
            
            <div class="am-quiz-switchbtn">
                <input type="checkbox" wire:model="answerRequired">
            </div>
        </div>
        @if($questionType == 'mcq')
            <div class="am-quiz_setting_item">
                <span>
                    {{ __('quiz::quiz.random_choice') }}
                    <i class="am-tooltip am-icon-exclamation-01">
                        <span class="am-tooltip-text">
                            <span>{{ __('quiz::quiz.random_choice_tooltip') }}</span>
                        </span>
                    </i>
                </span>
                <div class="am-quiz-switchbtn">
                    <input type="checkbox" wire:model="displayPoints">
                </div>
            </div>
        @endif
        <div class="am-quiz_setting_item">
            <span>
                {{ __('quiz::quiz.display_points') }}
                <i class="am-tooltip am-icon-exclamation-01">
                    <span class="am-tooltip-text">
                        <span>{{ __('quiz::quiz.display_points_tooltip') }}</span>
                    </span>
                </i>
            </span>
            <div class="am-quiz-switchbtn">
                <input type="checkbox" wire:model="randomChoice">
            </div>
        </div>
    </div>
</div>