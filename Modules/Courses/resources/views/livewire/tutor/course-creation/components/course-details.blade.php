<div class="cr-course-box" wire:init="loadData">
    <div class="cr-content-box">
        <h1>{{ __('courses::courses.basic_details') }}</h1>
        <p>{{ __('courses::courses.course_info') }}</p>
    </div>

    <form class="am-themeform">
        <fieldset>
            <div class="am-themeform__wrap">
                <div class="form-group-wrap">
                    <div class="form-group @error('title') cr-invalid @enderror">
                        <x-input-label class="am-important" for="course-title">{{ __('courses::courses.course_title') }}</x-input-label>
                        <x-text-input class="form-control" type="text" wire:model='title' id="course-title" placeholder="{{ __('courses::courses.enter_course_title') }}" />
                        <x-input-error field_name='title' />
                    </div>
                    <div class="form-group @error('subtitle') cr-invalid @enderror">
                        <x-input-label class="am-important" for="course-subtitle">{{ __('courses::courses.course_subtitle') }}</x-input-label>
                        <x-text-input class="form-control" type="text" wire:model='subtitle' id="course-subtitle" placeholder="{{ __('courses::courses.enter_course_subtitle') }}" />
                        <x-input-error field_name='subtitle' />
                    </div>
                    <div class="form-group">
                        <div class="form-group-two-wrap">
                            <div class="form-contro_wrap @error('category_id') cr-invalid @enderror">
                                <x-input-label class="am-important" for="category">{{ __('courses::courses.select_category') }}</x-input-label>
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" data-placeholder="{{ __('courses::courses.select_a_category') }}" data-componentid="@this" id="category-select" data-live="true" data-searchable="true" data-wiremodel="category_id">
                                        <option></option>
                                        @if (!empty($categories))
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" @if($category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                                <x-input-error field_name='category_id' />
                            </div>
                            <div wire:loading.class="form-contro_wrap-disabled" wire:target="category_id" class="form-contro_wrap @error('sub_category_id') cr-invalid @enderror">
                                <x-input-label class="am-important" for="subcategory">{{ __('courses::courses.select_subcategory') }}</x-input-label>
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" data-placeholder="{{ __('courses::courses.select_subcategory') }}" data-componentid="@this" id="sub-category-select" data-live="true" data-searchable="true" data-wiremodel="sub_category_id">
                                        <option></option>
                                        @if (!empty($sub_categories))
                                            @foreach($sub_categories as $sub_category)
                                                <option wire:key='{{ $sub_category->id }}' value="{{ $sub_category->id }}" @if($sub_category_id == $sub_category->id) selected @endif>{{ $sub_category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                                <x-input-error field_name='sub_category_id' />
                            </div>
                        </div>
                    </div>
                    @if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify'))
                        <div @class(['am-certificate-template', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('template_id')])>
                            <label class="am-label">
                                {{ __('calendar.certificate_template') }}
                                <a href="javascript:void(0);" class="am-custom-tooltip">
                                    <i class="am-icon-exclamation-01"></i>
                                    <span class="am-tooltip-text">
                                        {{ __('calendar.certificate_info') }}
                                    </span>
                                </a>
                            </label>
                            <span class="am-select" wire:ignore>
                                <select data-componentid="@this" data-wiremodel="template_id" class="am-select2" data-parent=".am-certificate-template" data-searchable="true" data-placeholder="{{ __('calendar.certificate_template_placeholder') }}">
                                    <option label="{{ __('calendar.certificate_template_placeholder') }}"></option>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->id }}" @if($template_id == $template->id) selected @endif>{{ $template->title }}</option>
                                    @endforeach
                                </select>
                            </span>
                            <x-input-error field_name="template_id" />
                        </div>
                    @endif

                    @if(isActiveModule('upcertify') && isActiveModule('quiz'))
                        <div @class(['am-certificate-quiz', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('assign_quiz_certificate')])>
                            <label class="am-label">
                                {{ __('calendar.assign_certificate') }}
                                <a href="javascript:void(0);" class="am-custom-tooltip">
                                    <i class="am-icon-exclamation-01"></i>
                                    <span class="am-tooltip-text">
                                        {{ __('calendar.assign_certificate_info') }}
                                    </span>
                                </a>
                            </label>
                            <span class="am-select" wire:ignore>
                                <select data-componentid="@this" data-wiremodel="assign_quiz_certificate" class="am-select2" data-parent=".am-certificate-quiz" data-searchable="true" data-placeholder="{{ __('calendar.certificate_template_placeholder') }}">
                                    <option label="{{ __('calendar.certificate_template_placeholder') }}"></option>
                                        <option value="any" @if($assign_quiz_certificate == 'any') selected @endif>{{ __('calendar.any_quizzes') }}</option>
                                        <option value="all" @if($assign_quiz_certificate == 'all') selected @endif>{{ __('calendar.all_quizzes') }}</option>
                                        <option value="none" @if($assign_quiz_certificate == 'none') selected @endif>{{ __('calendar.no_quizzes') }}</option>
                                </select>
                            </span>
                            <x-input-error field_name="assign_quiz_certificate" />
                        </div>
                    @endif
                
                    <div class="form-group @error('description') cr-invalid @enderror">
                        <x-input-label class="am-important" for="description">{{ __('courses::courses.course_description') }}</x-input-label>
                        <div class="am-editor-wrapper" wire:ignore>
                            <div class="am-custom-editor am-custom-textarea">
                                <textarea class="form-control summernote" placeholder="{{ __('courses::courses.add_description') }}" id="description">{{ $description }}</textarea>
                                <span class="characters-count"></span>
                            </div>
                        </div>
                        <x-input-error field_name='description' />
                    </div>
                    <!-- Other form fields -->
                    <div class="form-group">
                        <x-input-label for="course-tags">{{ __('courses::courses.course_tags') }}</x-input-label>
                        <div x-data="{
                            tags: @entangle('tags'),
                            newTag: '',
                            addTag() {
                                if (this.newTag.trim() !== '' && !this.tags.includes(this.newTag.trim())) {
                                    this.tags.push(this.newTag.trim());
                                    this.newTag = '';
                                }
                            },
                            removeTag(tag) {
                                this.tags = this.tags.filter(t => t !== tag);
                            }
                        }">
                            <input type="text" x-model="newTag" @keydown.enter.prevent="addTag" placeholder="{{ __('courses::courses.enter_course_tags') }}" @error('tags') class="cr-invalid" @enderror>
                            <ul class="cr-labels">
                                <template x-for="tag in tags" :key="tag">
                                    <li>
                                        <span x-html="tag"></span>
                                        <a href="javascript:void(0);" @click="removeTag(tag)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14" fill="none">
                                                <path d="M3.25 10.44L9.75 3.94M3.25 3.94L9.75 10.44" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-group-two-wrap">
                            <div class="form-contro_wrap @error('type') cr-invalid @enderror">
                                <x-input-label class="am-important" for="course-type">{{ __('courses::courses.course_type') }}</x-input-label>
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" data-placeholder="{{ __('courses::courses.select_type') }}" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="type" >
                                        <option></option>
                                        @if(!empty($types))
                                            @foreach($types as $courseType=>$index)
                                                <option wire:key="{{ $index }}" value="{{ $courseType }}" @if ($courseType === $type) selected @endif>{{ $courseType == 'all' ? __('courses::courses.any') : __('courses::courses.'.$courseType) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                                <x-input-error field_name='type' />
                            </div>
                            <div class="form-contro_wrap @error('level') cr-invalid @enderror">
                                <x-input-label class="am-important" for="level">{{ __('courses::courses.level') }}</x-input-label>
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" data-placeholder="{{ __('courses::courses.select_level') }}" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="level">
                                        <option></option>
                                        @if (!empty($levels))
                                            @foreach($levels as $courseLevel=>$index)
                                                <option wire:key="{{ $index }}" value="{{ $courseLevel }}" @if ($courseLevel === $level) selected @endif>{{ Str::ucfirst($courseLevel) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                                <x-input-error field_name='level' />
                            </div>
                            <div class="form-contro_wrap @error('language_id') cr-invalid @enderror">
                                <x-input-label class="am-important" for="language">{{ __('courses::courses.language') }}</x-input-label>
                                <span class="am-select" wire:ignore>
                                    <select class="am-select2" data-placeholder="{{ __('courses::courses.select_language') }}" data-componentid="@this" data-live="true" data-searchable="true" id="language" data-wiremodel="language_id">
                                        <option></option>
                                    @if (!empty($languages))
                                        @foreach($languages as $language)
                                            <option wire:key="{{ $language->id }}" value="{{ $language->id }}" @if ($language_id === $language->id) selected @endif>{{ $language->name }}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </span>
                                <x-input-error field_name='language_id' />
                            </div>
                        </div>
                    </div>
                    <div class="form-group" wire:sortable="updateLearningObjectivePosition">
                        <div class="cr-titlewrap">
                            <x-input-label>{{ __('courses::courses.learning_objectives') }}</x-input-label>
                            <span wire:click='addLearningObjective'>+ {{ __('courses::courses.add_more') }}</span>
                        </div>
                        @if (!empty($learning_objectives))
                            @foreach ($learning_objectives as $objective)
                                <div class="cr-grap-input" wire:sortable.item="{{ $loop->index }}" wire:key="objective-{{ $loop->index }}">
                                    
                                    <span wire:sortable.handle>
                                        <i class="am-icon-youtube-1"></i>
                                    </span>
                                    
                                    <div class="am-inputfield">
                                        <x-text-input wire:model.live='learning_objectives.{{ $loop->index }}' placeholder="{{ __('courses::courses.add_learning_objective') }}" />
                                        <span class="am-inputfield_icon" wire:click='removeLearningObjective({{ $loop->index }})'>
                                            @if (count($learning_objectives) > 1)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                                <g opacity="0.5">
                                                    <path d="M4 12.19L12 4.19M4 4.19L12 12.19" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                            </svg>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
    <div class="am-themeform_footer">
        <button 
        wire:click="createOrUpdateCourse" 
        type="button" 
        class="am-btn" 
        wire:loading.delay.class="am-btn_disable" 
        wire:target="createOrUpdateCourse"
        >
            {{ __('courses::courses.save_continue') }}
        </button>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @vite([
        'public/summernote/summernote-lite.min.css',
    ])
@endpush
@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
    <script defer src="{{ asset('js/livewire-sortable.js')}}"></script>
    <script type="text/javascript">
        document.addEventListener('loadPageJs', (event) => {

            Livewire.dispatch('initSelect2', { target: '.am-select2', timeOut: 0 });

            setTimeout(() => {
                
                if (!$('#description').data('summernote')) {
                    $('#description').summernote('destroy');
                    $('#description').summernote(summernoteConfigs('#description','.characters-count'));
                }

            }, 0);
        });

        document.addEventListener('livewire:initialized', function() {
            $(document).on('summernote.change', '#description', function(we, contents, $editable) {
                @this.set("description",contents, false);
            });

            // Count characters on paste
            $(document).on('summernote.paste', '#description', function(we, e) {
                setTimeout(() => {
                    let content = $('#description').summernote('code');
                    let text = $('<div>').html(content).text();
                    let charCount = text.length;
                    $('.characters-count').text(charCount + ' characters');
                }, 0);
            });
        });

        Livewire.on('sub-categories-updated', (event) => {
            let subCategorySelect = $('#sub-category-select');
            subCategorySelect.empty();
            subCategorySelect.append('<option value="">{{ __('courses::courses.select_subcategory') }}</option>');
            event.sub_categories.forEach(sub_category => {
                subCategorySelect.append(`<option value="${sub_category.id}">${sub_category.name}</option>`);
            });
            
        });
    </script>
@endpush

