<div class="form-group" wire:key="question_group_desc_{{ time() }}">
    <label for="introduction" class="am-label">{{ __('quiz::quiz.question_description') }}</label>
    <div class="am-editor-wrapper @error('activeForm.question_text') am-invalid @enderror">
        <div 
            wire:key="question_desc_{{ time() }}"
            id="question_desc_{{ time() }}"
            x-data="{
                contentDesc: @entangle('activeForm.question_text')
            }"
            x-init="$wire.dispatch('initSummerNote', 
                {
                    target: '#question_desc', 
                    wiremodel: 'activeForm.question_text', 
                    conetent: contentDesc,
                    componentId: @this
                });" 
            class="am-custom-editor am-custom-textarea" 
            wire:ignore>
            <textarea id="question_desc" class="form-control am-question-desc" placeholder="{{ __('quiz::quiz.answer_explanation_placeholder') }}" data-textarea="question_desc"></textarea>
            <span class="characters-count"></span>
        </div>
    </div>
    
    @error('activeForm.question_text')
    <x-quiz::input-error field_name='activeForm.question_text' /> 
    @enderror
</div>
