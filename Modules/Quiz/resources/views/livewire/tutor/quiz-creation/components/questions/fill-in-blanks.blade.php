<div class="am-quiz_questions am-fill-in-blanks">
    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-header')
    <div class="am-quiz_questions_box">
        <div class="am-quiz_questions_section">
            <form>
                <fieldset>
                    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-title')
                    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-image')
                </fieldset>
            </form>
        </div>
        <div class="am-quiz_answer_section">
            @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.answer-title')
             <div wire:sortable="updateOptionPosition" class="am-quiz_answer_option">
                @foreach($activeForm->blanks as $blank)
                    <div wire:sortable.item="{{ $loop->index }}" wire:key="question-{{ $loop->index }}" id="question-{{ $loop->index }}" class="am-quiz_answer_label">
                        <label class="am-short-label"> {{ __('quiz::quiz.blank_answer', ['number' => $loop->index + 1]) }}</label>
                        <div class="am-quiz_answer_option_wrap">
                            <i wire:sortable.handle>
                                <i class="am-icon-youtube-1"></i>
                            </i>
                            <div class="am-input-control">
                                <input wire:model="activeForm.blanks.{{ $loop->index }}.option_text" class="form-control" placeholder="Add fill in the blank option" type="text">
                            </div>
                            <span wire:click.prevent="removeFillInBlanksOption({{$loop->index}})">
                                <i class="am-icon-trash-02"></i>
                            </span>
                        </div>
                    </div>
                    @error("activeForm.blanks.{$loop->index}.option_text")
                        <x-quiz::input-error field_name='activeForm.blanks.{{ $loop->index }}.option_text' /> 
                    @enderror
                @endforeach 
            </div> 
        </div>
        @include('quiz::livewire.tutor.quiz-creation.components.questions.score-settings')
    </div>
    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.action')
</div>