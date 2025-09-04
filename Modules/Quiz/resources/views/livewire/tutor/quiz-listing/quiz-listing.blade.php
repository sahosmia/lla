<div class="am-quizlist" wire:init="loadData" x-data="{quizType: 'manual',duplicateQuizId: @entangle('duplicateQuizId')}">
    @php
        if(!empty(auth()?->user()?->profile->image) && Storage::disk(getStorageDisk())->exists(auth()?->user()?->profile?->image)) {
            $userImage = resizedImage(auth()?->user()?->profile?->image, 36, 36);
        } else {
            $userImage = resizedImage('placeholder.png', 36, 36);
        }
    @endphp
    
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ empty($filters['status']) ? __('quiz::quiz.my_quizzes') : __('quiz::quiz.'. $filters['status'] ) . ' ' . __('quiz::quiz.quizzes') }}</h2>
            <p>{{ __('quiz::quiz.track_student_progress' ) }}</p>
        </div>
        @if($quizzes->isNotEmpty() || !empty($filters['keyword']) || !empty($filters['status']))
        <div class="am-_btn_wrap">
            <button class="am-btn"
                @if(!empty(setting('_quiz.enable_ai')) && setting('_quiz.enable_ai') == '1')
                    @click="$nextTick(() => $wire.dispatch('toggleModel', {id: 'quiz-creation',action:'show'}) )"
                @else
                    @click="quizType = 'manual'; $nextTick(() => $wire.dispatch('toggleModel', {id: 'create-quiz-model',action:'show'}) )"
                @endif        
                >
                {{ __('quiz::quiz.create_quiz') }}
                <i class="am-icon-plus-02"></i>
            </button>
        </div>
           <div class="am-quizsearuch_header">
                <div class="am-quizlist_search">
                    <input type="text" wire:model.live.debounce.300ms="filters.keyword" class="form-control" placeholder="Search by keyword">
                    <i class="am-icon-search-02"></i>
                </div>
                <div class="am-slots_wrap">
                    <ul class="am-category-slots">
                        <li>
                            <button wire:click="filterStatus('')" class="{{ $filters['status'] === '' ? 'active' : '' }}">
                                {{ __('quiz::quiz.all') }}
                            </button>
                        </li>
                        @foreach ($statuses as $status)
                            @php
                                $activeStatus =  $status != 'all' ? $status : ''
                            @endphp
                            <li>
                                <button wire:click="filterStatus('{{ $activeStatus }}')" class="{{ $activeStatus === $filters['status'] ? 'active' : '' }}">
                                    {{ __('quiz::quiz.'.$status) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
    
    @if(!$isLoading)
        <div class="am-quizlist_wrap" wire:loading.remove wire:target="loadData, filterStatus, filters">
            @if($quizzes->isNotEmpty())
                <ul>
                    @foreach ($quizzes as $quiz) 
                    <li>
                        <div class="am-quizlist_item">
                            <figure>
                                @php
                                    $image = null;

                                    if ($quiz->quizzable_type == 'App\Models\UserSubjectGroupSubject') {
                                        $image = $quiz?->quizzable?->image 
                                            ? Storage::url($quiz->quizzable->image) 
                                            : resizedImage('placeholder.png', 342, 176);
                                    } else {
                                        $image = $quiz?->quizzable?->thumbnail?->path 
                                            ? Storage::url($quiz->quizzable->thumbnail->path) 
                                            : resizedImage('placeholder.png', 342, 176);
                                    }
                                @endphp
                                <img src="{{ $image }}" alt="card image">
                                <figcaption>
                                   @if(in_array($quiz->status, ['archived','published']) && $quiz?->quiz_attempts_count > 0)
                                        <span class="am-quizattempted">{{ number_format($quiz?->quiz_attempts_count) }}{{ __('quiz::quiz.total_attempted')}}<i class="am-icon-check-circle03"></i></span>
                                    @else
                                        @php
                                        $statusClass = match ($quiz?->status) {
                                            'draft' => 'am-quizstatus_draft',
                                            'archived' => 'am-quizstatus_archived',
                                            default => 'am-quizstatus_published',
                                        };
                                        @endphp
                                        <span class="am-quizstatus {{ $statusClass }}">
                                            {{ __('quiz::quiz.status', ['status' => ucfirst($quiz?->status)]) }}
                                        </span>
                                    @endif
                                </figcaption>
                            </figure>
                            <div class="am-quizlist_item_content">
                                <div class="am-quizlist_coursename">
                                    <div class="am-quizlist_coursetitle">
                                        <h3>{{ $quiz?->title }}</h3>
                                        @if($quiz->quizzable_type == 'App\Models\UserSubjectGroupSubject')
                                            <span>{{ $quiz?->quizzable?->subject?->name }}</span>
                                        @else
                                            <span>{{ $quiz?->quizzable?->title }}</span>
                                        @endif
                                    </div>
                                    <div class="am-itemdropdown">
                                        <a href="javascript:void(0);" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="am-icon-ellipsis-vertical-02"></i>
                                        </a>
                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @if( in_array($quiz->status, ['draft']) )
                                                <li>
                                                    <a href="{{ route('quiz.tutor.quiz-details', ['quizId' => $quiz->id]) }}">
                                                        <i class="am-icon-pencil-02"></i>
                                                        {{ __('quiz::quiz.edit_quiz') }}
                                                    </a>
                                                </li>
                                            @endif
                                            @if( in_array($quiz->status, ['archived','published']) )
                                            <li>
                                                <a href="{{ route('quiz.tutor.quiz-attempts', ['quizId' => $quiz->id]) }}">
                                                    <i class="am-icon-eye-open-01"></i>
                                                    {{ __('quiz::quiz.view_attempts') }}
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a href="javascript:void(0);" @click=" duplicateQuizId = @js($quiz->id) ; $nextTick(() => $wire.dispatch('toggleModel', {id: 'duplicate_popup',action:'show'}) )" >
                                                    <i class="am-icon-copy-01"></i>
                                                    {{ __('quiz::quiz.duplicate_quiz') }}
                                                </a>
                                            </li>
                                            @if( !in_array($quiz->status, ['draft']) )
                                            <li>
                                                <a href="javascript:void(0);" wire:click="archivedQuiz({{ $quiz?->id }}, '{{ $quiz?->status }}')">
                                                    <i class="am-icon-archive-01"></i>
                                                    {{ $quiz?->status == 'archived' ? __('quiz::quiz.unarchived_quiz') : __('quiz::quiz.archived_quiz') }}
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <ul class="am-quizlist_item_footer">
                                    <li>
                                       <span>
                                            <i class="am-icon-chat-03"></i>
                                            {{__('quiz::quiz.total_questions')}}
                                        </span> 
                                        <em>{{ $quiz->questions_count }}</em>
                                    </li>
                                    <li>
                                       <span>
                                            <i class="am-icon-calender-day"></i>
                                            {{__('quiz::quiz.created_at')}}
                                        </span> 

                                        <em>{{ \Carbon\Carbon::parse($quiz->created_at)->format('M d, Y') }}</em>
                                    </li>
                                    <li>
                                       <span>
                                            <i class="am-icon-file-02"></i>
                                            {{__('quiz::quiz.total_marks')}}
                                        </span> 
                                        <em>{{ $quiz->questions_sum_points ?? 0 }}</em>
                                    </li>
                                    <li>
                                       <span>
                                        <i class="am-icon-time"></i>
                                            {{__('quiz::quiz.duration')}}
                                        </span> 
                                        <em>{{ $quiz->settings->where('meta_key', 'duration')->first()?->meta_value ??  0 }} {{ __('quiz::quiz.hrs') }}.</em>
                                    </li>
                                    {{-- <span>
                                        <svg width="19" height="18" viewBox="0 0 19 18" fill="none">
                                            <path d="M9.89282 12C9.89282 12.2071 9.72493 12.375 9.51782 12.375C9.31071 12.375 9.14282 12.2071 9.14282 12M9.89282 12C9.89282 11.7929 9.72493 11.625 9.51782 11.625C9.31071 11.625 9.14282 11.7929 9.14282 12M9.89282 12H9.14282M8.01782 7.875V7.5C8.01782 6.67157 8.68939 6 9.51782 6C10.3462 6 11.0178 6.67157 11.0178 7.5V7.59099C11.0178 8.01295 10.8502 8.41762 10.5518 8.71599L9.51782 9.75M17.0178 9C17.0178 13.1421 13.66 16.5 9.51782 16.5C8.6633 16.5 7.93048 16.3783 7.25003 16.1349C6.60692 15.9048 6.28535 15.7898 6.16196 15.7608C5.02352 15.4931 4.55125 16.2733 3.57006 16.4368C3.08814 16.5171 2.65933 16.1225 2.69932 15.6356C2.73429 15.2098 3.02874 14.8072 3.14623 14.3983C3.39049 13.5483 3.05904 12.9039 2.70887 12.148C2.26543 11.1907 2.01782 10.1243 2.01782 9C2.01782 4.85786 5.37569 1.5 9.51782 1.5C13.66 1.5 17.0178 4.85786 17.0178 9Z" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        {{ $quiz?->questions_count }}
                                        <em>{{ trans_choice('Question|Questions', $quiz?->questions_count) }}</em>
                                    </span> 
                                     @if($quiz->settings->isNotEmpty())
                                        <span>
                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                <g clip-path="url(#clip0_21162_106001)">
                                                    <path d="M9 5.99414V8.99414L11.25 10.4941M9 16.4941C4.85786 16.4941 1.5 13.1363 1.5 8.99414C1.5 4.852 4.85786 1.49414 9 1.49414C13.1421 1.49414 16.5 4.852 16.5 8.99414C16.5 13.1363 13.1421 16.4941 9 16.4941Z" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_21162_106001">
                                                    <rect width="18" height="18" fill="white" transform="translate(0 -0.00585938)"/>
                                                    </clipPath>
                                                </defs>
                                                </svg>
                                            <em>{{$quiz->settings[0]->meta_value }} min.</em>
                                        </span>
                                    @endif
                                    <span>
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <g clip-path="url(#clip0_21247_44689)">
                                            <path d="M16.5 9C16.5 13.1421 13.1421 16.5 9 16.5M16.5 9C16.5 4.85786 13.1421 1.5 9 1.5M16.5 9C16.5 7.34315 13.1421 6 9 6C4.85786 6 1.5 7.34315 1.5 9M16.5 9C16.5 10.6569 13.1421 12 9 12C4.85786 12 1.5 10.6569 1.5 9M9 16.5C4.85786 16.5 1.5 13.1421 1.5 9M9 16.5C10.6569 16.5 12 13.1421 12 9C12 4.85786 10.6569 1.5 9 1.5M9 16.5C7.34315 16.5 6 13.1421 6 9C6 4.85786 7.34315 1.5 9 1.5M1.5 9C1.5 4.85786 4.85786 1.5 9 1.5" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                            <defs>
                                            <clipPath id="clip0_21247_44689">
                                            <rect width="18" height="18" fill="white"/>
                                            </clipPath>
                                            </defs>
                                        </svg>
                                        <em>English</em>
                                    </span>
                                    <span>
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                                            <path d="M6.85338 3.54325C7.54429 2.16143 7.88974 1.47052 8.35722 1.24881C8.76402 1.05587 9.23598 1.05587 9.64279 1.24881C10.1103 1.47052 10.4557 2.16143 11.1466 3.54325L11.4161 4.08218C11.6294 4.50883 11.7361 4.72216 11.8921 4.88549C12.0303 5.03007 12.1959 5.14557 12.3793 5.22521C12.5865 5.31517 12.8236 5.34151 13.2977 5.39419L13.5423 5.42137C15.1985 5.60538 16.0265 5.69739 16.4008 6.07921C16.726 6.41101 16.8791 6.87479 16.8154 7.335C16.742 7.86458 16.1314 8.43152 14.9103 9.56539L14.6521 9.8052C14.2353 10.1922 14.0269 10.3858 13.9064 10.6203C13.8 10.8276 13.7433 11.0568 13.7408 11.2898C13.738 11.5534 13.8334 11.8253 14.0242 12.3691V12.3691C14.647 14.144 14.9584 15.0315 14.7547 15.5504C14.578 16.0004 14.1953 16.3377 13.7266 16.4563C13.1862 16.5931 12.3576 16.1788 10.7003 15.3501L10.0733 15.0367C9.67977 14.8399 9.483 14.7415 9.2766 14.7028C9.0938 14.6685 8.90621 14.6685 8.72341 14.7028C8.51701 14.7415 8.32024 14.8399 7.92669 15.0367L7.29974 15.3501C5.64244 16.1788 4.81379 16.5931 4.27343 16.4563C3.80474 16.3377 3.42196 16.0004 3.24527 15.5504C3.04157 15.0315 3.35297 14.144 3.97576 12.3691V12.3691C4.16656 11.8253 4.26195 11.5534 4.25918 11.2898C4.25674 11.0568 4.20004 10.8276 4.09358 10.6203C3.97314 10.3858 3.76473 10.1922 3.34791 9.8052L3.08965 9.56539C1.86856 8.43152 1.25801 7.86458 1.18465 7.335C1.1209 6.87479 1.274 6.41101 1.59922 6.07921C1.97345 5.69739 2.80153 5.60538 4.4577 5.42137L4.70232 5.39419C5.17642 5.34151 5.41346 5.31517 5.62067 5.22521C5.80409 5.14557 5.96974 5.03007 6.10787 4.88549C6.26392 4.72216 6.37058 4.50883 6.58391 4.08218L6.85338 3.54325Z" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        85/100
                                        <em>Marks</em>
                                    </span> --}}
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @if (!$isLoading && $quizzes->links()->paginator->hasPages())
                    <div class='am-pagination am-quiz-pagination'>
                        @if (!empty($parPageList))
                            <div class="am-pagination-filter" wire:ignore>
                                <em>{{ __('quiz::quiz.show') }}</em>
                                <span class="am-select">
                                    <select wire:model.live="filters.per_page" x-init="$wire.dispatch('initSelect2', {target: '#per-page-select'});" class="am-select2" id="per-page-select" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="filters.per_page">
                                        @if (!empty($filters['per_page']) && !in_array($filters['per_page'], $parPageList))
                                            <option value="{{ $filters['per_page'] }}">{{ $filters['per_page'] }}</option>
                                        @endif
                                        @foreach ($parPageList as $option)
                                            <option {{ $filters['per_page'] == $option ? 'selected' : '' }} value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </span>
                                <em>{{ __('quiz::quiz.listing_per_page') }}</em>
                            </div>
                        @endif
                        {{ $quizzes->links('quiz::pagination.pagination') }}
                    </div>
                @endif
            @else
                 <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        @if(!empty($filters['status']) || !empty($filters['keyword']))
                            <h3>{{ __('quiz::quiz.no_quiz_found') }}</h3>
                            <p>{{ __('quiz::quiz.no_quiz_found_desc') }}</p>
                        @else
                            <h3>{{ __('quiz::quiz.empty_box_heading') }}</h3>
                            <p>{{ __('quiz::quiz.empty_box_para') }}</p>
                            <p>{{ __('quiz::quiz.get_started') }}</p>
                            <div class="am-emptyview_btn_wrap">
                                <button class="am-btn" @click="$nextTick(() => $wire.dispatch('toggleModel', {id: 'quiz-creation',action:'show'}) )">
                                    {{ __('quiz::quiz.create_quiz') }}
                                    <i class="am-icon-plus-02"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>     
            @endif
        </div>
    @else
        <div class="am-quizlist_wrap" wire:loading wire:target="loadData, filterStatus, filters">
            @include('quiz::skeletons.quiz-listing-skeleton', ['total' => $filters['per_page']])
        </div>
    @endif
    
    <div  wire:ignore.self  class="modal fade am-successfully-popup" id="duplicate_popup">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-body">
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                    <div class="am-deletepopup_icon confirm-icon">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30" fill="none">
                                <path d="M15.2109 20V13.75M15.8359 10C15.8359 10.3452 15.5561 10.625 15.2109 10.625C14.8658 10.625 14.5859 10.3452 14.5859 10M15.8359 10C15.8359 9.65482 15.5561 9.375 15.2109 9.375C14.8658 9.375 14.5859 9.65482 14.5859 10M15.8359 10H14.5859M27.7109 15C27.7109 21.9036 22.1145 27.5 15.2109 27.5C8.30738 27.5 2.71094 21.9036 2.71094 15C2.71094 8.09644 8.30738 2.5 15.2109 2.5C22.1145 2.5 27.7109 8.09644 27.7109 15Z" stroke="#295C51" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </div>
                    <div class="am-successfully_title">
                        <h3>{{ __('quiz::quiz.confirmation_title') }}</h3>
                        <p>{{ __('quiz::quiz.confirmation_desc') }}</p>
                    </div>
                    <div class="am-successfully-popup_btns">
                        <a href="#" data-bs-dismiss="modal" class="am-white-btn">{{ __('quiz::quiz.cancel') }}</a>
                        <button  
                            wire:click="duplicateQuiz" 
                            wire:loading.attr="disabled" 
                            wire:loading.class="am-btn_disable" 
                            wire:target="duplicateQuiz" 
                            class="am-btn">
                            {{ __('quiz::quiz.confirm') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- model start  --}}
        <div wire:ignore.self class="modal fade ai-quiz-modal" id="create-quiz-model" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <div class="am-createquiz_details_title">
                            <h2>{{ __('quiz::quiz.qiz_details') }}                 
                                @if(request()->routeIs('quiz.tutor.create-quiz') === 'quiz.tutor.create-quiz' && !empty(setting('_quiz.enable_ai')) && setting('_quiz.enable_ai') == '1') 
                                    <button class="am-aigenearted" wire:click="prepareAiQuiz" wire:loading.class="am-btn_disable" wire:target="generateAiQuiz"><img src="{{asset('modules/quiz/images/ai-generated.png')}}" alt="image">{{ __('quiz::quiz.generate_with_ai') }}</button></h2>
                                @endif
                            </h2>
                            <p>{{ __('quiz::quiz.quiz_with_title_description') }}</p>
                            <button type="button" class="btn-close am-close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    <div class="am-modal-body">
                        <div>
                            <form class="am-createquiz_details_form" id="create-quiz-form"
                                x-data="{
                                    selectedValues: {{ !empty($selectedSubjectSlots) ? json_encode($selectedSubjectSlots) : '[]' }},
                                    init() {
                                        console.log(this.selectedValues)
                                        this.selectedValues = Array.isArray(this.selectedValues)
                                        ? this.selectedValues
                                        : Object.values(this.selectedValues);
                                        let selectElement = document.getElementById('user_subject_slots');
                                        Livewire.on('slotsList', () => {
                                            setTimeout(() => {
                                                $('#user_subject_slots').select2().on('change', (e)=>{
                                                    let textInput = jQuery(e.target).siblings('span').find('textarea');
                                                    if(textInput){
                                                        setTimeout(() => {
                                                            textInput.val('');
                                                            textInput.attr('placeholder', 'Select session');
                                                        }, 50);
                                                    }
                                                    this.updateSelectedValues()
                                                });
                                            }, 50);
                                        });
                                        $('#user_subject_slots').select2().on('change', ()=>{
                                            this.updateSelectedValues()
                                        });
                                    },
                                    updateSelectedValues(){
                                    let selectElement = document.getElementById('user_subject_slots');
                                        this.selectedValues = Array.from(selectElement.selectedOptions)
                                            .filter(option => option.value)
                                            .map(option => ({
                                                value: option.value,
                                                text: option.text,
                                                price: option.getAttribute('data-price')
                                            })
                                        );
                                    },
                                    removeValue(value) {
                                        const selectElement = document.getElementById('user_subject_slots');
                                        const optionToDeselect = Array.from(selectElement.options).find(option => option.value === value);
                                        if (optionToDeselect) {
                                            optionToDeselect.selected = false;
                                            $(selectElement).trigger('change');
                                        }
                                    },
                                    submitFilter() {
                                        const selectElement = document.getElementById('user_subject_slots');
                                        @this.set('subjectGroupIds', $(selectElement).select2('val'));
                                    }
                                }">
                                <fieldset>
                                    @if(isActiveModule('Courses'))
                                        <div class="form-group @error('form.quizzable_type') am-invalid @enderror">
                                            <x-input-label class="am-important" for="quizzable_type" wire:loading.class="am-disabled">{{ __('quiz::quiz.quiz_type') }}</x-input-label>
                                            <span class="am-select" wire:ignore>
                                                <select class="am-select2" data-componentid="@this" id="quizzable_type" data-parent="#create-quiz-model" data-live="true" data-wiremodel="form.quizzable_type" data-placeholder="{{ __('quiz::quiz.select_quiz_type') }}">
                                                    <option value="">{{ __('quiz::quiz.select_quiz_type') }}</option>
                                                    @foreach ($quizzable_types as $quizzable_type)
                                                        <option value="{{ $quizzable_type['value'] }}" @if($form?->quizzable_type == $quizzable_type['value']) selected @endif>{{ $quizzable_type['label'] }}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            <x-quiz::input-error field_name='form.quizzable_type' />
                                        </div>
                                    @endif
                                    <div class="form-group @error('form.quizzable_id') am-invalid @enderror" wire:loading.class="am-disabled" wire:loading.target="form.quizzable_type">
                                        <x-input-label class="am-important" for="quizzable_id">{{ isActiveModule('Courses') ? __('quiz::quiz.select_option') :  __('quiz::quiz.select_subject')}}</x-input-label>
                                        <span class="am-select" wire:ignore>
                                            <select class="am-select2" data-componentid="@this" id="quizzable_id" data-parent="#create-quiz-model" data-live="true" data-wiremodel="form.quizzable_id" @if(isActiveModule('Courses')) disabled @endif data-placeholder="{{ __('quiz::quiz.select_option') }}">
                                                <option value="">{{ __('quiz::quiz.select_option') }}</option>
                                                @foreach ($quizzable_ids as $quiz)
                                                    <option value="{{ $quiz['id'] }}" @if($form->quizzable_id == $quiz['id']) selected @endif>{{ $quiz['title'] }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <x-quiz::input-error field_name='form.quizzable_id' />
                                    </div>
                                    @if($form->quizzable_type == 'App\Models\UserSubjectGroupSubject')
                                        <div class="form-group am-knowlanguages @error('form.user_subject_slots') am-invalid @enderror" wire:loading.class="am-disabled" wire:loading.target="form.quizzable_id">
                                            <x-input-label for="Slots" class="am-important" :value="__('quiz::quiz.select_session')" />
                                            <div class="form-group-two-wrap am-nativelang">
                                                <div id="user_slot" wire:ignore>
                                                    <span class="am-select am-multiple-select">
                                                        <select data-componentid="@this" data-disable_onchange="true" data-parent="#create-quiz-model" class="slots am-select2" data-hide_search_opt="true" id="user_subject_slots" @if(!$form->quizzable_id) disabled @endif data-wiremodel="form.user_subject_slots" multiple data-placeholder="{{ __('quiz::quiz.select_session') }}">
                                                            <option value="" >{{ __('quiz::quiz.select_session') }}</option>
                                                            @foreach($slots as $slot)
                                                                <option @if(!empty($slot['selected'])) selected @endif value="{{ $slot['id'] }}">{{ $slot['text']  }}</option>      
                                                            @endforeach
                                                        </select>
                                                        <template x-if="selectedValues.length > 0">
                                                            <ul class="am-subject-tag-list">
                                                                <template x-for="(subject, index) in selectedValues">
                                                                    <li>
                                                                        <a href="javascript:void(0)" class="am-subject-tag" @click="removeValue(subject.value)">
                                                                            <span x-text="`${subject.text}`"></span>
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
                                    <template x-if="quizType === 'manual'">
                                        <div>
                                            <div class="form-group @error('form.title') am-invalid @enderror">
                                                <label class="am-label am-important">{{ __('quiz::quiz.quiz_title') }}</label>
                                                <input class="form-control" wire:model="form.title" placeholder="Add title here" type="text">
                                                <x-quiz::input-error field_name='form.title' />
                                            </div>
                                            <div wire:ignore class="form-group am-custom-textarea">
                                                <label class="am-label">{{ __('quiz::quiz.quiz_descriptions') }}</label>
                                                <div class="am-editor-wrapper">
                                                    <div x-init="$wire.dispatch('initSummerNote', {target: '#profile_desc', wiremodel: 'form.description', conetent: '{{ $form?->description }}', componentId: @this});" class="am-custom-editor am-custom-textarea" wire:ignore>
                                                        <textarea id="profile_desc" class="form-control am-question-desc" placeholder="{{ __('profile.description_placeholder') }}" data-textarea="profile_desc">{{ $form?->description ?? '' }}</textarea>
                                                        <span class="characters-count"></span>
                                                    </div>
                                                    <x-input-error field_name="form.description" />
                                                </div>
                                            </div>
                                            <div class="form-group am-form-btns">
                                                @if($activeRoute === 'quiz.tutor.quiz-question-bank')
                                                    <button type="button" class="am-btn-light" wire:click="onCancel">
                                                        {{ __('quiz::quiz.cancel') }}
                                                    </button>
                                                    <button type="button" wire:click="updateQuiz" wire:loading.class="am-btn_disable" wire:target="updateQuiz" class="am-btn">{{ __('quiz::quiz.update') }}</button>
                                                @else
                                                    <button type="button" class="am-btn-light" data-bs-dismiss="modal">
                                                        {{ __('quiz::quiz.cancel') }}
                                                    </button>
                                                    <button 
                                                        type="button" 
                                                        wire:loading.class="am-btn_disable" 
                                                        wire:target="saveQuiz" 
                                                        class="am-btn" 
                                                        wire:click.prevent="saveQuiz($event.target).then((url) => {
                                                        if(url?.length){
                                                            window.location.href = url;
                                                        }
                                                    })">{{ __('quiz::quiz.save') }}</button>
                                                @endif
                                            </div>
                                        <div>
                                    </template>
                                    <template x-if="quizType=='ai'">
                                        <div>
                                            <div class="form-group @error('form.description') am-invalid @enderror">
                                                <label class="am-label am-important">{{ __('quiz::quiz.quiz_ai_descriptions') }}</label>
                                                <textarea id="profile_desc" wire:model="form.description" class="form-control am-question-desc" placeholder="{{ __('quiz::quiz.quiz_ai_description_placeholder') }}" >{{ $form?->description ?? '' }}</textarea>
                                                <x-input-error field_name="form.description" />
                                            </div>
                                            <div class="form-group ai-questions">
                                                <h6 class="am-label">{{ __('quiz::quiz.question_types_label') }}
                                                    <i class="am-tooltip am-icon-exclamation-01">
                                                        <span class="am-tooltip-text">
                                                            <span>{{ __('quiz::quiz.question_types_tooltip') }}</span>
                                                        </span>
                                                    </i>
                                                </h6>
                                                <ul class="ai-questions_list">
                                                    @foreach ($form->question_types as $questionType => $value)
                                                        <li>
                                                            <span>{{ __('quiz::quiz.'.$questionType) }}</span>
                                                            <div class="am-question_value">
                                                                <input type="number" min="0" max="{{ $value }}" id="question_type_{{ $questionType }}" wire:model="form.question_types.{{ $questionType }}">
                                                                <button type="button" class="am-question_emptybtn btn-close" @click="jQuery(`#question_type_${@js($questionType)}`).val('0'); $wire.set(`form.question_types.${@js($questionType)}`, '0', false)"></button>
                                                            </div>
                                                        </li>
                                                        @error("form.question_types.$questionType")
                                                            <x-input-error field_name="form.question_types.{{ $questionType }}" />
                                                        @enderror
                                                    @endforeach
                                                </ul>
                                               @error('question_types')
                                                    <x-input-error field_name="question_types" />
                                               @enderror
                                            </div>
                                            <div class="form-group am-form-btns">
                                                <button type="button" class="am-btn-light" data-bs-dismiss="modal">
                                                    {{ __('quiz::quiz.cancel') }}
                                                </button>
                                                <button type="button" wire:key="ai-quiz-btn" wire:loading.class="am-btn_disable" wire:target="generateAiQuiz" wire:click="generateAiQuiz" class="am-btn">
                                                    {{ __('quiz::quiz.generate_with_ai') }}
                                                </button>
                                            </div>
                                        </div>
                                    </template> 
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- model end  --}}
    <div wire:ignore.self class="modal fade am-create-quiz-modal" id="quiz-creation" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">   
                    <h4>{{ __('quiz::quiz.create_new_quiz') }}</h4>
                    <p>{{ __('quiz::quiz.create_quiz_para') }}</p>
                    <button type="button" class="btn-close am-close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="am-create-quiz-modal_list">
                    <a href="#" @click="jQuery('#quiz-creation').modal('hide'); quizType = 'manual'; $nextTick(() => $wire.dispatch('toggleModel', {id: 'create-quiz-model',action:'show'}) )">
                        <span class="am-create-quiz-modal_icon"><i class="am-icon-plus-02"></i></span>
                        <h6>{{ __('quiz::quiz.create_manual_quiz') }}</h6>
                        <p>{{ __('quiz::quiz.create_manual_quiz_desc') }}</p>
                    </a>
                    <a href="#"  @click="jQuery('#quiz-creation').modal('hide'); quizType = 'ai'; $nextTick(() => $wire.dispatch('toggleModel', {id: 'create-quiz-model',action:'show'}) )">
                        <span class="am-create-quiz-modal_icon"><img src="{{asset('modules/quiz/images/ai-generated.png')}}" alt="image"></span>
                        <h6>{{ __('quiz::quiz.generate_with_ai') }}</h6>
                        <p>{{ __('quiz::quiz.generate_with_ai_desc') }}</p>
                    </a>
                </div>            
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
    <link href="{{ asset('modules/quiz/css/main.css') }}" rel="stylesheet">
    @vite(['public/summernote/summernote-lite.min.css'])
@endpush

@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js') }}"></script>
    <script type="text/javascript">

        window.addEventListener('editQuiz', (event) => {
            const {quizzable_type, option_list, session_slots} = event.detail.eventData;
            Livewire.dispatch('initSelect2', { target: '.am-select2', timeOut: 150 });
            setTimeout(() => {
                initOptionList(option_list);
                if(quizzable_type === '{{ UserSubjectGroupSubject::class }}'){
                    initOption(session_slots);
                }
            }, 300);

        });

        window.addEventListener('quizValuesUpdated', (event) => {            
            let { options, reset } = event.detail;
            initOptionList(options);
            if(reset) {
                jQuery('#quizzable_id').val('').trigger('change');
            }
        });

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

            setTimeout(() => {
                const event = new CustomEvent('slotsList', { detail: { } });
                document.dispatchEvent(event);
            }, 1000);
        }

        function initOptionList (options) {
            let $select = jQuery('#quizzable_id');
            if ($select.hasClass('select2-hidden-accessible')) {
                $select.select2('destroy').empty();
            }
            $select.select2({ 
                data: [{
                    id: '', 
                    text: 'Select an option'
                }, ...options],
                theme: 'default',
                dropdownParent: jQuery('#create-quiz-model'),
                disabled: false
            });
        }

        function initSummerNoteInput() {
            var initialContent = '';
            var initialContent = @this.get('form.description');
            $('.am-question-desc').summernote('destroy');
            $('.am-question-desc').summernote(summernoteConfigs('.am-question-desc'));
            $('.am-question-desc').summernote('code', initialContent);
            $(document).on('summernote.change', '.am-question-desc', function(we, contents, $editable) {             
                @this.set("form.description",contents, false);
            });
        }

        document.addEventListener('DOMContentLoaded', function( ) {
            jQuery(document).ready(function() {
                setTimeout(function() {
                    $(document).on('change', "#subject_list", function(e) {
                        @this.set('subject_list', $(this).select2('val'));
                    });
                }, 50);
            });
        });
    </script>
@endpush