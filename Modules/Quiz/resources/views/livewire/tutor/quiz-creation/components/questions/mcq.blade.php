<div x-cloak class="am-quiz_questions">
    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-header')
    <div class="am-quiz_questions_box">
        <div class="am-quiz_questions_section">
            <form>
                <fieldset>
                    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-title')
                    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-description')
                    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-image')
                </fieldset>
            </form>
        </div>
        <div class="am-quiz_answer_section">
            @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.answer-title')
            <div class="am-quiz_answer_option">
                <div wire:sortable="updateMcqPosition" class="am-quiz_answer_option">
                    @if(!empty($activeForm->mcqs))
                        @foreach ($activeForm->mcqs as $m )  
                            <div wire:sortable.item="{{ $loop->index }}" wire:key="question-{{ $loop->index }}" id="question-{{ $loop->index }}" class="am-quiz_answer_option_wrap">
                                <i wire:sortable.handle>
                                    <i class="am-icon-youtube-1"></i>
                                </i>
                                <div class="am-radio">
                                    <input wire:model="activeForm.correct_answer" value="{{ $loop->index }}" id="{{ $loop->index }}_option" name="mcqOption" @if($activeForm->correct_answer == $loop->index) checked @endif  type="radio">
                                    <label for="{{ $loop->index }}_option"></label>
                                </div>
                                <div class="am-input-control">
                                    <input class="form-control" wire:model="activeForm.mcqs.{{ $loop->index }}.option_text" placeholder="Enter option" type="text">
                                    @error("activeForm.correct_answer")
                                        <x-quiz::input-error field_name='activeForm.correct_answer' /> 
                                    @enderror
                                    @error("activeForm.mcqs.{$loop->index}.option_text")
                                        <x-quiz::input-error field_name='activeForm.mcqs.{{ $loop->index }}.option_text' /> 
                                    @enderror 
                                </div>
                                @if(count($activeForm->mcqs) > 1)
                                    <span wire:click.prevent="removeMcq({{ $loop->index }})">
                                        <i class="am-icon-trash-02"></i>
                                    </span>
                                @endif
                            </div>   
                        @endforeach  
                    @else 
                        <li class="am-question-option">
                            <span>{{ __('quiz::quiz.add_option_here') }}</span>
                        </li> 
                    @endif    
                </div>
            </div>

        </div>
        @include('quiz::livewire.tutor.quiz-creation.components.questions.score-settings')
    </div>
    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.action')
</div>