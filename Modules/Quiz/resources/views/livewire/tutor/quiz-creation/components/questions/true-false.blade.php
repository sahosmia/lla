<div class="am-quiz_questions am-true-false">
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
            <div class="am-quiz_answer_option">
                <div class="am-quiz_answer_option_wrap">
                    <div class="am-radio">
                        <input  type="radio" id="true" name="ture&false" wire:model.live="activeForm.correct_answer" value="true">
                        <label for="true"></label>
                    </div>
                    <input for="true" class="form-control am-disabled" disabled placeholder="Ture" type="text">
                </div>
                <div class="am-quiz_answer_option_wrap">
                    <div class="am-radio">
                        <input type="radio" id="false" name="ture&false" wire:model.live="activeForm.correct_answer" value="false">
                        <label for="false"></label>
                    </div>
                    <div class="am-input-control">
                        <input for="false" class="form-control am-disabled" disabled placeholder="False" type="text">
                    </div>
                </div>
            </div> 
            @error('activeForm.correct_answer')
                <x-quiz::input-error field_name='activeForm.correct_answer' /> 
            @enderror
        </div>
        @include('quiz::livewire.tutor.quiz-creation.components.questions.score-settings')
    </div>
    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.action')
</div>