<div class="am-quizlist am-quizlist_students" wire:init="loadData">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('quiz::quiz.quizzes') }}</h2>
            <p>{{ __('quiz::quiz.browse_and_manage_place') }}</p>
        </div>
        <div class="am-slots_right">
            <div class="am-searchinput">
                <input wire:model.live.debounce.250ms="filters.keyword" type="text" placeholder="{{ __('general.search_by_keyword') }}" class="form-control" id="keyword">
                <span class="am-searchinput_icon">
                    <i class="am-icon-search-02"></i>
                </span>
            </div>
            <ul class="am-category-slots">
                <li>
                    <button @class(['active'=> $filters['status'] === 'upcoming']) wire:click="filterStatus('upcoming')">
                        {{__('quiz::quiz.upcoming')}}
                    </button>
                </li>
                <li>
                    <button @class(['active'=> $filters['status'] === 'attempted']) wire:click="filterStatus('attempted')">
                        {{__('quiz::quiz.attempted')}}
                    </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="am-quizlist_wrap" wire:loading wire:target="loadData, filterStatus, filters">
        @include('quiz::skeletons.quiz-listing-skeleton', ['total' => $filters['per_page']])
    </div>
    @if(!$isLoading)
        <div class="am-quizlist_wrap" wire:loading.remove wire:target="loadData,filterStatus, filters">
            @if($quizAttempts->isNotEmpty())
                <ul>
                    @foreach ($quizAttempts as $quizAttempt)
                        <li>
                            <div class="am-quizlist_item">
                                <figure>
                                    @php 
                                        $routeURL = $quizAttempt->result == Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED ? route('quiz.student.quiz-details', ['attemptId' => $quizAttempt->id]) : route('quiz.quiz-result', ['attemptId' => $quizAttempt->id]);
                                    @endphp 
                                    <a href="{{ $routeURL }}">
                                        @if($quizAttempt->quiz?->quizzable_type == 'App\Models\UserSubjectGroupSubject')
                                            <img src="{{Storage::url($quizAttempt->quiz?->quizzable?->image)}}" alt="{{$quizAttempt->quiz?->title}}">
                                        @else
                                            <img src="{{Storage::url($quizAttempt->quiz?->quizzable?->thumbnail?->path)}}" alt="{{$quizAttempt->quiz?->title}}">  
                                        @endif
                                    </a>
                                    @if($quizAttempt->result != Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED)
                                        <figcaption>
                                            <span class="am-quizattempted">{{ __('quiz::quiz.total_attempted')}}<i class="am-icon-check-circle03"></i></span>
                                        </figcaption>
                                    @endif
                                </figure>
                                <div class="am-quizlist_item_content">
                                    <div class="am-quizlist_coursename">
                                        <div class="am-quizlist_coursetitle">
                                            <h3><a href="{{ $routeURL }}">{{ $quizAttempt->quiz?->title }}</a></h3>
                                            @if($quizAttempt->quiz?->quizzable_type == 'App\Models\UserSubjectGroupSubject')
                                                <span>{{ $quizAttempt->quizzable?->subject?->name }}</span>
                                            @else
                                                <span>{{ $quizAttempt->quiz?->quizzable?->title }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <ul class="am-quizlist_item_footer">
                                        <li>
                                            <span>
                                                <i>
                                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <g opacity="0.8">
                                                        <path d="M7.50293 9.33268C7.50293 9.49377 7.37235 9.62435 7.21126 9.62435C7.05018 9.62435 6.9196 9.49377 6.9196 9.33268M7.50293 9.33268C7.50293 9.1716 7.37235 9.04102 7.21126 9.04102C7.05018 9.04102 6.9196 9.1716 6.9196 9.33268M7.50293 9.33268H6.9196M6.0446 6.12435V5.83268C6.0446 5.18835 6.56693 4.66602 7.21126 4.66602C7.8556 4.66602 8.37793 5.18835 8.37793 5.83268V5.90345C8.37793 6.23164 8.24756 6.54639 8.01549 6.77845L7.21126 7.58268M13.0446 6.99935C13.0446 10.221 10.4329 12.8327 7.21126 12.8327C6.54663 12.8327 5.97666 12.738 5.44742 12.5487C4.94723 12.3698 4.69711 12.2803 4.60115 12.2578C3.7157 12.0495 3.34837 12.6564 2.58523 12.7835C2.2104 12.846 1.87688 12.5391 1.90798 12.1604C1.93518 11.8292 2.1642 11.516 2.25558 11.198C2.44556 10.5369 2.18777 10.0357 1.91541 9.44777C1.57052 8.70325 1.37793 7.87377 1.37793 6.99935C1.37793 3.77769 3.9896 1.16602 7.21126 1.16602C10.4329 1.16602 13.0446 3.77769 13.0446 6.99935Z" stroke="#585858" stroke-width="0.972222" stroke-linecap="round" stroke-linejoin="round"></path>
                                                        </g>
                                                    </svg>
                                                </i>
                                                {{ __('quiz::quiz.total_questions') }}
                                            </span> 
                                            <em>{{ $quizAttempt->total_questions }}</em>
                                        </li>
                                        <li>
                                            <span>
                                                <i class="am-icon-calender-day"></i>
                                                {{__('quiz::quiz.created_at')}}
                                            </span> 
    
                                            <em>{{ \Carbon\Carbon::parse($quizAttempt?->quiz?->created_at)->format('M d, Y') }}</em>
                                        </li>
                                        <li>
                                            <span>
                                                <i class="am-icon-file-02"></i>
                                                {{__('quiz::quiz.total_marks')}}
                                            </span> 
                                            <em>{{ number_format($quizAttempt?->total_marks) ?? 0 }}</em>
                                        </li>
                                        <li>
                                            <span>
                                            <i class="am-icon-time"></i>
                                                {{__('quiz::quiz.duration')}}
                                            </span> 
                                            <em>{{ $quizAttempt?->quiz->settings?->where('meta_key', 'duration')->first()?->meta_value ??  0 }} {{ __('quiz::quiz.hrs') }}.</em>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                @if (!$isLoading && $quizAttempts->links()->paginator->hasPages())
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
                        {{ $quizAttempts->links('quiz::pagination.pagination') }}
                    </div>
                @endif
            @else
                <div class="am-emptyview">
                    <figure class="am-emptyview_img">
                        <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                    </figure>
                    <div class="am-emptyview_title">
                        <h3>{{ __('quiz::quiz.no_quizzes_available') }}</h3>
                        <p>{{ __('quiz::quiz.no_quizzes_available_desc') }}</p>
                        
                    </div>
                </div>    
            @endif
        </div>
    @endIf
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush
