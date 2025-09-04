<div class="am-quizsteps_box am-quizsteps_four">
    <div class="am-quizsteps_option">
       
        @include('quiz::livewire.student.quiz-attempt.answers.components.question-title')

        <div class="am-quizsteps_details_wrap">
            <div class="form-group">
                <label class="am-label {{ $question->answer_required ? 'am-important' : '' }}"  for="answer">Answer</label>

                <div 
                    wire:key="open_ended_answer_desc{{ time() }}"
                    id="open_ended_answer_desc{{ time() }}"
                    x-data="{
                        contentDesc: @entangle('answer')
                    }"
                    x-init="$wire.dispatch('initSummerNote', 
                        {
                            target: '#open_ended_answer_desc', 
                            wiremodel: 'answer', 
                            conetent: contentDesc,
                            componentId: @this
                        });" 
                    class="form-control_wrap am-custom-editor am-custom-textarea" 
                    wire:ignore>
                    <textarea wire:model.live="answer" id="open_ended_answer_desc" class="form-control am-question-desc" placeholder="Add answer explanation..." data-textarea="open_ended_answer_desc"></textarea>
                    <span class="characters-count"></span>
                </div>
            </div>
        </div>
    </div>

    @include('quiz::livewire.student.quiz-attempt.answers.components.question-image')  

</div>