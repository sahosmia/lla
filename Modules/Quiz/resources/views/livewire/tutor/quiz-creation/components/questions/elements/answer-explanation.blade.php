<div class="form-group" wire:key="answer_group_{{ time() }}">
    <label for="introduction" class="am-label">{{ __('quiz::quiz.answer_explanation') }}</label>
    <div
        wire:key="anser_explanation_{{ time() }}"
        id="anser_explanation_{{ time() }}"
        x-data="{
            contentDesc: @entangle('activeForm.answer_explanation')
        }"
        x-init="$wire.dispatch('initSummerNote', 
            {
                target: '#answer_explanation', 
                wiremodel: 'activeForm.answer_explanation', 
                conetent: contentDesc,
                componentId: @this
            });" 
        class="am-custom-editor am-custom-textarea" 
        wire:ignore>
        <textarea id="answer_explanation" class="form-control am-question-desc" placeholder={{ __('quiz::quiz.answer_explanation_placeholder') }} data-textarea="answer_explanation"></textarea>
        <span class="characters-count"></span>
    </div>
</div>
@error('activeForm.answer_explanation')
    <x-quiz::input-error field_name='activeForm.answer_explanation' /> 
@enderror