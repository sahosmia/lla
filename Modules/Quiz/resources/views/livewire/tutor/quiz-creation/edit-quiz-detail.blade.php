<div class="am-createquiz">
    @include('quiz::livewire.tutor.quiz-creation.components.quiz-tab')
    <div class="am-createquiz">
        <div class="am-userperinfo am-quizsetting">
            <div class="am-title_wrap">
                <div class="am-title">
                    <h2>{{ __('quiz::quiz.qiz_details') }}</h2>
                    <p>{{ __('quiz::quiz.quiz_with_title_description') }}</p>
                </div>
            </div>
            <form x-cloak wire:ignore.self class="am-themeform am-themeform_personalinfo" id="create-quiz-form"
                x-data="{
                    selectedValues: {{ !empty($selectedSubjectSlots) ? json_encode($selectedSubjectSlots) : '[]' }},
                    init() {
                        this.selectedValues = Array.isArray(this.selectedValues) ? this.selectedValues : Object.values(this.selectedValues);
                        Livewire.on('slotsList', () => {
                            this.selectedValues = [];
                            setTimeout(() => {
                                this.onChnageSetValue();
                            }, 50);
                        });
                        this.onChnageSetValue();
                    },
                    onChnageSetValue(){
                        $('#user_subject_slots').select2().on('change', (e)=> {
                            @this.set('form.user_subject_slots', $(e.target).val());
                            let textInput = jQuery(e.target).siblings('span').find('textarea');
                            if(textInput){
                                setTimeout(() => {
                                    textInput.val('');
                                    textInput.attr('placeholder', 'Select session');
                                }, 50);
                            }
                            this.updateSelectedValues()
                        });
                    },
                    updateSelectedValues(){
                        let selectElement = document.getElementById('user_subject_slots');
                        this.selectedValues = Array.from(selectElement.selectedOptions).filter(option => option.value).map(option => ({
                                id: option.value,
                                text: option.text,
                            })
                        );
                    },
                    removeValue(value) {
                        const selectElement = document.getElementById('user_subject_slots');
                        const optionToDeselect = Array.from(selectElement.options).find(option => Number(option.value) === Number(value));
                        if (optionToDeselect) {
                            optionToDeselect.selected = false;
                            $(selectElement).trigger('change');
                        }
                    },
                }">
                <fieldset>
                    <div class="form-group @error('form.title') am-invalid @enderror">
                        <label class="am-label am-important">{{ __('quiz::quiz.quiz_title') }}</label>
                        <div class="form-control_wrap">
                            <input class="form-control" wire:model="form.title" placeholder="Add title here" type="text">
                            <x-quiz::input-error field_name='form.title' />
                        </div>
                    </div>
                    @if(isActiveModule('Courses'))
                        <div class="form-group @error('form.quizzable_type') am-invalid @enderror">
                            <x-input-label class="am-important" for="quizzable_type" wire:loading.class="am-disabled">{{ __('quiz::quiz.quiz_type') }}</x-input-label>
                            <div class="am-radiowrap">
                                <div class="am-radio">
                                    <input value="{{ Modules\Courses\Models\Course::class }}" wire:model.live="form.quizzable_type" id="quizfor_course" type="radio" name="quizfor">
                                    <label for="quizfor_course">
                                        <span>Course</span>
                                    </label>
                                </div>
                                <div class="am-radio">
                                    <input value="{{ App\Models\UserSubjectGroupSubject::class }}" wire:model.live="form.quizzable_type" id="quizfor_subject" type="radio" name="quizfor">
                                    <label for="quizfor_subject">
                                        <span>Subject</span>
                                    </label>
                                </div>
                            </div>
                            <x-quiz::input-error field_name='form.quizzable_type' />
                        </div>
                    @endif
                    <div 
                        x-init="$wire.dispatch('initSelect2', {target: '#quizzable_id', data: @js($quizzable_ids)});" 
                        class="form-group @error('form.quizzable_id') am-invalid @enderror" 
                        wire:loading.class="am-disabled" 
                        wire:loading.target="form.quizzable_type"
                        >
                        <x-input-label class="am-important" for="quizzable_id">{{ isActiveModule('Courses') ? __('quiz::quiz.select_option') :  __('quiz::quiz.select_subject') }}</x-input-label>
                        <div class="form-control_wrap">
                            <span class="am-select" wire:ignore>
                                <select class="am-select2" data-componentid="@this" id="quizzable_id" data-live="true" data-searchable="true" data-wiremodel="form.quizzable_id" data-placeholder="{{ __('quiz::quiz.select_option') }}">
                                    <option value="">{{ __('quiz::quiz.select_option') }}</option>
                                </select>
                            </span>
                            <x-quiz::input-error field_name='form.quizzable_id' />
                        </div>
                    </div>
                    @if($form->quizzable_type == 'App\Models\UserSubjectGroupSubject')
                        <div class="form-group @error('form.user_subject_slots') am-invalid @enderror" wire:loading.class="am-disabled" wire:loading.target="form.quizzable_id">
                            <x-input-label for="Slots" class="am-important" :value="__('quiz::quiz.select_session')" />
                            <div class="form-control_wrap">
                                <div id="user_slot" wire:ignore>
                                    <span class="am-select am-multiple-select">
                                        <select data-componentid="@this" data-disable_onchange="true" class="slots am-select2" data-hide_search_opt="true" id="user_subject_slots" @if(!$form->quizzable_id) disabled @endif data-live="true" multiple data-placeholder="{{ __('quiz::quiz.select_session') }}">
                                            <option value="" >{{ __('quiz::quiz.select_session') }}</option>
                                            @foreach($slots as $slot)
                                                <option @if(!empty($slot['selected'])) selected @endif value="{{ $slot['id'] }}">{{ $slot['text']  }}</option>      
                                            @endforeach
                                        </select>
                                        <template x-if="selectedValues.length > 0">
                                            <ul class="am-subject-tag-list">
                                                <template x-for="(slot, index) in selectedValues">
                                                    <li>
                                                        <a href="javascript:void(0)" class="am-subject-tag" @click="removeValue(slot.id)">
                                                            <span x-text="slot.text"></span>
                                                            <i class="am-icon-multiply-02"></i>
                                                        </a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </template>
                                    </span>
                                </div>
                                <x-quiz::input-error field_name='form.user_subject_slots' />
                            </div>
                        </div>
                    @endif
                    
                    <div x-init="$wire.dispatch('initSummerNote', {target: '#profile_desc', wiremodel: 'form.description', conetent: `{{ $form?->description }}`, componentId: @this});" class="form-group am-custom-textarea">
                        <label class="am-label">{{ __('quiz::quiz.quiz_descriptions') }}</label>
                        <div class="am-editor-wrapper">
                            <div wire:ignore class="am-custom-editor am-custom-textarea">
                                <textarea id="profile_desc" class="form-control am-question-desc" placeholder="{{ __('profile.description_placeholder') }}" data-textarea="profile_desc">{{ $form?->description ?? '' }}</textarea>
                                <span class="characters-count"></span>
                            </div>
                            <x-input-error field_name="form.description" />
                        </div>
                    </div>
                    <div class="form-group am-form-btns">
                        <button 
                            type="button" 
                            wire:loading.class="am-btn_disable" 
                            wire:target="updateQuiz" 
                            class="am-btn" 
                            wire:click.prevent="updateQuiz">
                            {{ __('quiz::quiz.update') }}
                        </button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>    
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
    @vite(['public/summernote/summernote-lite.min.css'])
@endpush

@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
    <script type="text/javascript">

        window.addEventListener('quizValuesUpdated', (event) => {            
            let { options, reset, target } = event.detail;
            initOptionList(options, target);
            if(reset) {
                jQuery(target).val('').trigger('change');
            }
        });

        function initOptionList (options, target) {
            let $select = jQuery(target);
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }
            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...options],
                theme: 'default',
                disabled: false
            });
        }

        window.addEventListener('addSlotsOptions', (event) => {
            let {options = []} = event.detail;
            const listItem = Object?.values(options) ?? []
            initOption(listItem);
        });

        function initOption (optionList) {
            let $select = jQuery('#user_subject_slots');
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }

            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...optionList],
                theme: 'default',
                disabled: false
            });
        }
    </script>
@endpush
