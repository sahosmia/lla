 <!-- Faq section start  -->
 <div class="cr-course-box" wire:init="loadData">
    <div class="cr-titlewrap">
        <div class="cr-content-box">
            <h2>{{ __('courses::courses.faqs') }}</h2>
            <p>{{ __('courses::courses.faqs_description') }}:</p>
        </div>
        @if (!$faqs->isEmpty())
            <span wire:click="addMoreFaq" wire:loading.class="am-btn_disable" wire:target="addMoreFaq">{{ __('courses::courses.plus_add_more') }}</span>
        @endif
    </div>
    @if ($faqs->isEmpty())
        <div class="cr-no-record-container">
            <h6>{{ __('courses::courses.no_records_added_yet') }}</h6>
            <p>{{ __('courses::courses.no_records_available') }}</p>
            <button type="button" wire:click="addMoreFaq" class="am-btn" wire:loading.class="am-btn_disable" wire:target="addMoreFaq">
                {{ __('courses::courses.create_faq') }}
                <i class="am-icon-plus-02" wire:loading.remove wire:target="addMoreFaq"></i>
            </button>
        </div>
    @else
        <div class="cr-faq-accordion">
            <div class="accordion">

                @foreach ($faqs as $faq)
                    <div class="accordion-item">
                        <input type="radio" name="accordion" id="faq-{{ $faq->id }}" class="accordion-checkbox">
                        <label for="faq-{{ $faq->id }}" class="accordion-header">
                            {{ $faq->question }}
                            <div class="am-itemdropdown">
                                <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i><svg  width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858" />
                                            <path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858" />
                                            <path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858" />
                                        </svg></i>
                                </a>
                                <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li>
                                        <a href="javascript:void(0);" wire:click="editFaq({{ $faq }})">
                                            <i>
                                                <svg  width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.6663 17.5H3.33301M13.333 3.33335C13.1247 4.79169 14.3747 6.04169 15.833 5.83335M5.83301 13.3334L6.23639 11.7198C6.39642 11.0797 6.47644 10.7596 6.60511 10.4612C6.71935 10.1963 6.86191 9.9445 7.03031 9.71024C7.22 9.44637 7.45328 9.21309 7.91985 8.74653L13.7498 2.91667C14.4401 2.22633 15.5594 2.22635 16.2498 2.91671V2.91671C16.9401 3.60706 16.9401 4.7263 16.2497 5.41663L10.4198 11.2465C9.95327 11.7131 9.71999 11.9464 9.45612 12.1361C9.22187 12.3045 8.97008 12.447 8.70515 12.5612C8.40675 12.6899 8.08669 12.7699 7.44657 12.93L5.83301 13.3334Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </i>
                                            {{ __('courses::courses.edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="cr-delete-option" @click="$wire.dispatch('showConfirm', { id : {{ $faq->id }}, action : 'delete-faq' })">
                                            <i>
                                                <svg  width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M3.33317 4.16669L3.82396 12.5101C3.9375 14.4402 3.99427 15.4053 4.37553 16.1521C4.79523 16.9742 5.48635 17.6259 6.3317 17.9966C7.09962 18.3334 8.06636 18.3334 9.99984 18.3334V18.3334C11.9333 18.3334 12.9001 18.3334 13.668 17.9966C14.5133 17.6259 15.2044 16.9742 15.6241 16.1521C16.0054 15.4053 16.0622 14.4402 16.1757 12.5101L16.6665 4.16669M3.33317 4.16669H1.6665M3.33317 4.16669H16.6665M16.6665 4.16669H18.3332M13.3332 4.16669L13.0469 3.30774C12.8502 2.71763 12.7518 2.42257 12.5694 2.20442C12.4083 2.01179 12.2014 1.86268 11.9677 1.77077C11.7031 1.66669 11.3921 1.66669 10.77 1.66669H9.22966C8.60762 1.66669 8.29661 1.66669 8.03197 1.77077C7.79828 1.86268 7.5914 2.01179 7.4303 2.20442C7.24788 2.42257 7.14952 2.71763 6.95282 3.30774L6.6665 4.16669M8.33317 8.33335V14.1667M11.6665 8.33335V11.6667" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </i>
                                            {{ __('courses::courses.delete_faq') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <span class="accordion-icon">
                                <svg  width="18" height="18" viewBox="0 0 18 18" fill="none">
                                    <path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </label>
                        <div class="accordion-content">
                            <p>{!! $faq->answer !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <div class="cr-pre-requisites">
        <div class="cr-content-box">
            <h2>{{ __('courses::courses.prerequisites_title') }}</h2>
            <p>{{ __('courses::courses.prerequisites_description') }}</p>
        </div>
        <form class="am-themeform">
            <fieldset>
                <div class="am-themeform__wCoursesrap">
                    <div class="form-group-wrap">
                        <div class="form-group @error('prerequisites') cr-invalid @enderror">
                            {{-- <label for="course-description">{{ __('courses::courses.prerequisites') }}</label> --}}
                            <div class="am-editor-wrapper">
                                <div class="am-custom-editor am-custom-textarea" wire:ignore>
                                    <textarea class="form-control summernote" wire:model="prerequisites" placeholder="Enter text" id="prerequisites"></textarea>
                                </div>
                            </div>
                            <x-input-error field_name='prerequisites' />
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="am-themeform_footer">
        <a href="{{ route('courses.tutor.edit-course', ['tab' => 'content', 'id' => $courseId]) }}" class="am-white-btn">
            <svg  width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M10.5 4.5L6 9L10.5 13.5" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            {{ __('courses::courses.back') }}
        </a>
        <button type="button" wire:click.prevent='save' class="am-btn" wire:loading.attr="disabled" wire:target="save" wire:loading.class="am-btn_disable">{{ __('courses::courses.save_continue') }}</button>

    </div>
    <!-- create FAQs model start -->
    <div wire:ignore.self class="modal fade cr-course-modal " id="create-faq" tabindex="-1" aria-labelledby="create-faqLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
            <div class="modal-header">
                @if ($updateMode)
                    <h5 class="modal-title" id="create-faqLabel">{{ __('courses::courses.update_faq') }}</h5>
                @else
                    <h5 class="modal-title" id="create-faqLabel">{{ __('courses::courses.add_faq') }}</h5>
                @endif
                <span class="cr-close" data-bs-dismiss="modal" aria-label="{{ __('courses::courses.close') }}">
                    <svg  width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <g opacity="0.7">
                            <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                </span>
            </div>
            <div class="modal-body">
            <form class="am-themeform">
                <fieldset>
                    <div class="am-themeform__wrap">
                        <div class="form-group @error('question') cr-invalid @enderror">
                            <label class="am-important" for="course-title">{{ __('courses::courses.question') }}</label>
                            <x-text-input wire:model="question" id="course-title" placeholder="{{ __('courses::courses.enter_question') }}" />
                            <x-input-error field_name='question' />
                        </div>
                        <div class="form-group @error('answer') cr-invalid @enderror">
                            <label class="am-important" for="answer">{{ __('courses::courses.answer') }}</label>
                            <div class="am-editor-wrapper">
                                <div class="am-custom-editor am-custom-textarea" wire:ignore>
                                    <textarea class="form-control summernote" wire:model="answer" placeholder="Enter answer" id="answer"></textarea>
                                </div>
                            </div>
                            <x-input-error field_name='answer' />
                        </div>
                    </div>
                </fieldset>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="am-white-btn" data-bs-dismiss="modal">{{ __('courses::courses.close') }}</button>
                <button type="button" wire:click='addFaq' wire:loading.class="am-btn_disable" wire:target="addFaq" class="am-btn">{{ __('courses::courses.save_changes') }}</button>
            </div>
            </div>
        </div>
    </div>
    <!-- create FAQs model end -->
</div>
 <!-- Faq section end  -->

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
     document.addEventListener('DOMContentLoaded', (event) => {
         setTimeout(() => {
             $('#answer').summernote('destroy');
             $('#answer').summernote(summernoteConfigs('#answer','.characters-count'));
             $('#prerequisites').summernote('destroy');
             $('#prerequisites').summernote(summernoteConfigs('#prerequisites','.characters-count'));
         }, 0);
     });

    document.addEventListener('livewire:initialized', function() {
        $(document).on('summernote.change', '#answer', function(we, contents, $editable) {
            @this.set("answer",contents, false);
        });

        $(document).on('summernote.change', '#prerequisites', function(we, contents, $editable) {
            @this.set("prerequisites",contents, false);
        });
    });

     document.addEventListener('initializeSummernote', function() {
         setTimeout(() => {
             $('#answer').summernote('destroy');
             $('#answer').summernote(summernoteConfigs('#answer','.characters-count'));
             $('#prerequisites').summernote('destroy');
             $('#prerequisites').summernote(summernoteConfigs('#prerequisites','.characters-count'));
         }, 0);
     });
 </script>
@endpush
