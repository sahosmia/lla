<div class="am-quiz_questions">
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
        @include('quiz::livewire.tutor.quiz-creation.components.questions.score-settings')
    </div>
    @include('quiz::livewire.tutor.quiz-creation.components.questions.elements.action')
</div>