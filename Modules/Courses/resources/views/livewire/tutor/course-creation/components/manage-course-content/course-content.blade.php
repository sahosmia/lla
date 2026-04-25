<div wire:init="loadData">
    <div class="cr-course-box">
        <div class="cr-content-box">
            <h2>{{ __('courses::courses.course_content') }}</h2>
            <p>{{ __('courses::courses.organize_sections') }}</p>
        </div>
        <div class="cr-course-body">
            @foreach ($sections as $key => $section)
                <div wire:key="section-{{ $section->id }}" id="section-{{ $section->id }}" class="cr-faq-accordion">
                    <div class="cr-formarea accordion">
                        <div class="accordion-item">
                            <input type="radio" name="accordion" id="{{ 'accordion-item-' . $section->id }}"
                                class="accordion-checkbox">
                            <label for="{{ 'accordion-item-' . $section->id }}" class="cr-course-item accordion-header">
                                <div class="cr-contentbox">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16"
                                        viewBox="0 0 15 16" fill="none">
                                        <path
                                            d="M1.25 4.95C1.25 3.82989 1.25 3.26984 1.46799 2.84202C1.65973 2.46569 1.96569 2.15973 2.34202 1.96799C2.76984 1.75 3.3299 1.75 4.45 1.75H5.19795C5.62403 1.75 5.83707 1.75 6.03136 1.78888C6.50188 1.88303 6.92288 2.14322 7.21751 2.52196C7.33918 2.67835 7.43445 2.8689 7.625 3.25V3.25C7.75203 3.50407 7.81555 3.6311 7.89666 3.73536C8.09308 3.98785 8.37374 4.16131 8.68743 4.22408C8.81695 4.25 8.95898 4.25 9.24303 4.25H9.48333C10.9768 4.25 11.7235 4.25 12.294 4.54065C12.7957 4.79631 13.2037 5.20426 13.4594 5.70603C13.75 6.27646 13.75 7.02319 13.75 8.51667V9.98333C13.75 11.4768 13.75 12.2235 13.4594 12.794C13.2037 13.2957 12.7957 13.7037 12.294 13.9594C11.7235 14.25 10.9768 14.25 9.48333 14.25H5.51667C4.02319 14.25 3.27646 14.25 2.70603 13.9594C2.20426 13.7037 1.79631 13.2957 1.54065 12.794C1.25 12.2235 1.25 11.4768 1.25 9.98333V4.95Z"
                                            stroke="#585858" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <span> {{ $section->title }}</span>
                                </div>
                                <div class="am-itemdropdown">
                                    <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none">
                                                <path
                                                    d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z"
                                                    fill="#585858" />
                                                <path
                                                    d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z"
                                                    fill="#585858" />
                                                <path
                                                    d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z"
                                                    fill="#585858" />
                                            </svg>
                                        </i>
                                    </a>
                                    <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <li wire:click="editSectionFunction({{ $section }})">
                                            <a href="javascript:void(0);">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M16.6663 17.5H3.33301M13.333 3.33335C13.1247 4.79169 14.3747 6.04169 15.833 5.83335M5.83301 13.3334L6.23639 11.7198C6.39642 11.0797 6.47644 10.7596 6.60511 10.4612C6.71935 10.1963 6.86191 9.9445 7.03031 9.71024C7.22 9.44637 7.45328 9.21309 7.91985 8.74653L13.7498 2.91667C14.4401 2.22633 15.5594 2.22635 16.2498 2.91671V2.91671C16.9401 3.60706 16.9401 4.7263 16.2497 5.41663L10.4198 11.2465C9.95327 11.7131 9.71999 11.9464 9.45612 12.1361C9.22187 12.3045 8.97008 12.447 8.70515 12.5612C8.40675 12.6899 8.08669 12.7699 7.44657 12.93L5.83301 13.3334Z"
                                                            stroke="#585858" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </i>
                                                {{ __('courses::courses.edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="cr-delete-curriculum" data-id="{{ $section->id }}" data-component_id="@this">
                                                <i>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" viewBox="0 0 20 20" fill="none">
                                                        <path
                                                            d="M3.33317 4.16669L3.82396 12.5101C3.9375 14.4402 3.99427 15.4053 4.37553 16.1521C4.79523 16.9742 5.48635 17.6259 6.3317 17.9966C7.09962 18.3334 8.06636 18.3334 9.99984 18.3334V18.3334C11.9333 18.3334 12.9001 18.3334 13.668 17.9966C14.5133 17.6259 15.2044 16.9742 15.6241 16.1521C16.0054 15.4053 16.0622 14.4402 16.1757 12.5101L16.6665 4.16669M3.33317 4.16669H1.6665M3.33317 4.16669H16.6665M16.6665 4.16669H18.3332M13.3332 4.16669L13.0469 3.30774C12.8502 2.71763 12.7518 2.42257 12.5694 2.20442C12.4083 2.01179 12.2014 1.86268 11.9677 1.77077C11.7031 1.66669 11.3921 1.66669 10.77 1.66669H9.22966C8.60762 1.66669 8.29661 1.66669 8.03197 1.77077C7.79828 1.86268 7.5914 2.01179 7.4303 2.20442C7.24788 2.42257 7.14952 2.71763 6.95282 3.30774L6.6665 4.16669M8.33317 8.33335V14.1667M11.6665 8.33335V11.6667"
                                                            stroke="#585858" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </i>
                                                {{ __('courses::courses.delete') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <span class="accordion-icon">
                                    <i class="am-icon-chevron-down"></i>
                                </span>
                            </label>
                            <div class="accordion-content">
                                <livewire:courses::manage-course-content.components.curriculum :id="$section->id" :section="$section" :key="now() . $section->id . 'curriculum'" />
                            </div>
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($addSection)
                <div class="cr-formarea">
                    <div class="form-group">
                        <label class="am-important"
                            for="section-title">{{ __('courses::courses.section_title') }}</label>
                        <input wire:model="title" class="form-control @error('title') is-invalid @enderror"
                            type="text" id="section-title"
                            placeholder="{{ __('courses::courses.enter_course_title') }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group @error('description') cr-invalid @enderror">
                        <label class="am-important" for="description*">{{ __('courses::courses.description') }}</label>
                        <div wire:ignore class="am-custom-editor am-custom-textarea">
                            <textarea class="form-control cr-summernote" id="section-desc" data-id="@this" data-model_id="description"
                                placeholder="{{ __('courses::courses.enter_description') }}"></textarea>
                            <span class="characters-count"></span>
                        </div>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="cr-btns">
                        <button wire:click="addSectionState(false)" wire:loading.class="am-btn_disable" wire:target="addSectionState(false)" class="am-cancel-btn">{{ __('courses::courses.cancel') }}</button>
                        <button wire:click="createSection" type="submit" class="am-btn">
                            <span wire:loading wire:target="createSection">{{ __('courses::courses.loading') }}</span>
                            <span wire:loading.remove wire:target="createSection">{{ __('courses::courses.add_section') }}</span>
                        </button>
                    </div>
                </div>
            @else
                <button wire:click="addSectionState(true)" class="cr-addbtn" wire:loading.attr="disabled" wire:target="addSectionState(true)" wire:loading.class="am-btn_disable">
                    <svg class="am-border-svg ">
                        <rect width="100%" height="100%"></rect>
                    </svg>
                    {{ __('courses::courses.create_section') }}
                    <i class="am-icon-plus-02" wire:loading.remove wire:target="addSectionState(true)"></i>
                </button>
            @endif
        </div>
        {{ $sections->links('courses::pagination.pagination') }}

        <div class="am-themeform_footer">
            <a href="{{ route('courses.tutor.edit-course', ['tab' =>  (isPaidSystem() ? 'pricing' : 'media'), 'id' => $course->id]) }}">
                <button class="am-white-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                        fill="none">
                        <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    {{ __('courses::courses.back') }}
                </button>
            </a>
            <button wire:click="save" type="button" class="am-btn" wire:loading.remove
                wire:target="save">{{ __('courses::courses.save_continue') }}</button>
            <button class="am-btn am-btn_disable" wire:loading.flex
                wire:target="save">{{ __('courses::courses.save_continue') }}
            </button>
        </div>
    </div>
    <!-- edit model start -->
    <div wire:ignore.self class="modal fade cr-course-modal" id="edit-content" tabindex="-1" aria-labelledby="edit-contentlabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-contentlabel">{{ __('courses::courses.edit_course_section') }}</h5>
                    <span class="cr-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g opacity="0.7">
                                <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                        </svg>
                    </span>
                </div>
                <div class="modal-body">
                    <form class="am-themeform">
                        <fieldset>
                            <div class="form-group">
                                <label class="am-important"
                                    for="course-title">{{ __('courses::courses.title') }}</label>
                                <input type="text" wire:model="title" id="course-title"
                                    placeholder="{{ __('courses::courses.enter_title') }}"
                                    class="form-control @error('title') is-invalid @enderror">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group @error('description') cr-invalid @enderror">
                                <div wire:ignore class="am-editor-wrapper">
                                    <div class="am-custom-editor am-custom-textarea">
                                        <textarea id="edit_section_description" data-id="@this" data-model_id="description" class="form-control cr-summernote" placeholder="{{ __('courses::courses.enter_answer') }}"></textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                </div>
                                <x-input-error field_name='description' />
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="am-white-btn" data-bs-dismiss="modal">{{ __('courses::courses.close') }}</button>
                    <button type="button" class="am-btn" wire:click="updateSection" wire:loading.attr="disabled">
                        <span wire:loading.remove
                            wire:target="updateSection">{{ __('courses::courses.save_changes') }}</span>
                        <span wire:loading wire:target="updateSection">{{ __('courses::courses.saving') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete model start -->
    <div wire:ignore.self class="modal fade cr-course-modal cr-course-del-modal " id="delete-confirm-modal" tabindex="-1"
        aria-labelledby="delete-curriculum-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body">
                    <span class="cr-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g opacity="0.7">
                                <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                        </svg>
                    </span>
                    <figure class="cr-delete-icon">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M5 6.25L5.80705 19.9698C5.96296 22.6203 6.04091 23.9455 6.6066 24.9512C7.10457 25.8366 7.86039 26.5492 8.77345 26.9944C9.81064 27.5 11.1382 27.5 13.7932 27.5H16.2068C18.8618 27.5 20.1894 27.5 21.2266 26.9944C22.1396 26.5492 22.8954 25.8366 23.3934 24.9512C23.9591 23.9455 24.037 22.6203 24.193 19.9698L25 6.25M5 6.25H2.5M5 6.25H25M25 6.25H27.5M20 6.25L19.4338 4.55132C19.1879 3.81367 19.065 3.44485 18.8369 3.17217C18.6356 2.93138 18.377 2.74499 18.0848 2.6301C17.754 2.5 17.3653 2.5 16.5877 2.5H13.4123C12.6347 2.5 12.246 2.5 11.9152 2.6301C11.623 2.74499 11.3644 2.93138 11.1631 3.17217C10.935 3.44485 10.8121 3.81367 10.5662 4.55132L10 6.25M12.5 12.5V21.25M17.5 12.5V17.5"
                                stroke="#F04438" stroke-width="1.875" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <figcaption>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </figcaption>
                    </figure>
                    <div class="cr-delete-content">
                        <h3>{{ __('courses::courses.confirm') }}</h3>
                        <p>{{ __('courses::courses.confirm_delete') }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="am-white-btn" data-bs-dismiss="modal">{{ __('courses::courses.no') }}</button>
                    <button type="button" class="am-btn cr-del-btn cr-delete-action">
                        <span>{{ __('courses::courses.yes') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @vite([
        'public/summernote/summernote-lite.min.css', 
        'public/css/videojs.css'
    ])
@endpush
@push('scripts')
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="https://player.vimeo.com/api/player.js"></script>
    <script defer src="{{ asset('summernote/summernote-lite.min.js') }}"></script>
    <script defer src="{{ asset('js/livewire-sortable.js') }}"></script>
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', (event) => {

            document.addEventListener('toggleEditorModal', function(event) {
                const {target, action} = event.detail ?? {};
                $(target).modal(action);
            });

            jQuery(document).on('click', '.cr-delete-curriculum', function() {
                const _this = $(this);
                const id = _this.data('id');
                const componentId = _this.data('component_id');
                jQuery('.cr-delete-action').attr('data-curriculum_id', id);
                jQuery('.cr-delete-action').attr('data-component_id', componentId);
                const component = eval(componentId);
                callToggleEditorModal('#delete-confirm-modal', 'show');
            });

            // Function to call toggleEditorModal
            function callToggleEditorModal(target, action) {
                const event = new CustomEvent('toggleEditorModal', {
                    detail: { target, action }
                });
                document.dispatchEvent(event);
            }

            jQuery(document).on('click', '.cr-delete-action', async function() {
                let _this = $(this);
                let componentId = _this.attr('data-component_id');
                let component = eval(componentId);
                let id = _this.attr('data-curriculum_id');
                _this.attr('disabled', 'disabled');
                _this.addClass('am-btn_disable');
                _this.find('span').text('{{ __('courses::courses.deleting') }}');
                await component.deleteRecord(id);
                _this.removeAttr('disabled');
                _this.removeClass('am-btn_disable');
                _this.find('span').text('{{ __('courses::courses.yes') }}');
                callToggleEditorModal('#delete-confirm-modal', 'hide');
            });

            jQuery(document).on('summernote.change', '.cr-summernote', function(we, contents, $editable) {
                let _this = $(this);
                let componentId = _this.data('id');
                let modelId = _this.data('model_id');
                if (componentId) {
                    const component = eval(componentId);
                    component.set(modelId, contents, false);
                }
            });

            document.addEventListener('initEditor', function(event) {
                let {target, content, modal = ''} = event?.detail ?? {};
                initEditor(target, content);
                if(modal){
                    $(modal).modal('show');
                }
            });
        });

        function initEditor(target ='', content = '') {
            setTimeout(() => {
                $(target).summernote('destroy');
                $(target).summernote(summernoteConfigs(target,'.characters-count'));
                if(content){
                    $(target).summernote('code', content);
                    var charLength = $('<div>').html(content)?.text()?.length;
                    let charSelector = '.characters-count';
                    charLeft(charLength, charSelector)
                }
            }, 0);
        }
    </script>
@endpush