<div class="form-group @error('activeForm.question_title') am-invalid @enderror">
    <label class="am-label am-important">{{ __('quiz::quiz.question_title') }}
        @if($questionType == \Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS)
            <i class="am-tooltip am-icon-exclamation-01">
                <span class="am-tooltip-text">
                    <span>{!! __('quiz::quiz.fill_in_blanks_tooltip') !!}</span>
                </span>
            </i>
        @endif
        {!! $tippyContent ?? '' !!}
    </label>
    <input wire:model='activeForm.question_title' class="form-control" placeholder="{{ __('quiz::quiz.question_title_placeholder') }}" type="text">

    @error('activeForm.question_title')
        <x-quiz::input-error field_name='activeForm.question_title' /> 
    @enderror
</div>