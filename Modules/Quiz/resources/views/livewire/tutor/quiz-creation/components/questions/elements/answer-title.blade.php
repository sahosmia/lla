<div class="am-quiz_answer_title">
    <div class="am-quiz_answer_heading">
        <h5>{{ __('quiz::quiz.options') }}</h5>
         @if($questionType == 'mcq')
        <p>{{ __('quiz::quiz.answer_description') }}</p>
        @elseif($questionType == 'fill_in_blanks')
        <p>{{ __('quiz::quiz.fill_in_blanks_answer_desc') }}</p>
        @endif
    </div>
    @if($questionType == 'mcq')
        <a href="javascript:void(0);" wire:click.prevent="addMcqOption">
            {{-- <i class="am-icon-plus-02"></i>  --}}
            {{ __('quiz::quiz.add_more') }}
        </a>
    @endif
    @if($questionType == 'fill_in_blanks')
        <a href="javascript:void(0);" wire:click.prevent="addFillInBlanksOption">
            <div class="am-fill-blanks">
                <div class="form-group">
                    <div class="am-fill-blanks_space">
                        <span class="am-label" for=""><i class="am-icon-plus-02"></i> 
                            {{__('quiz::quiz.add_blank_space') }}
                        </span>
                    </div>
                </div>
            </div>
        </a>
    @endif
</div>

