<div class="am-createquiz" wire:init="loadData">
    @include('quiz::livewire.tutor.quiz-creation.components.quiz-tab')
    <div class="am-quizlist" wire:init="loadData">
            <div class="am-quizlist_filter">
                <div class="am-title">
                    <h2>{{ __('quiz::quiz.all_students') }}</h2>
                </div>
                <div class="am-quizlist_filter_wrap">
                    <div class="am-quizlist_search">
                        <input type="text" wire:model.live.debounce.500ms="filters.keyword" class="form-control" placeholder="Search by keyword">
                        <i class="am-icon-search-02"></i>
                    </div>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="@this" data-live="true" class="am-select2" id="status"  data-wiremodel="filters.status">
                            <option value="">{{ __('quiz::quiz.all') }}</option>
                            @foreach ($statuses as $key => $status)
                                <option value="{{ $key }}">{{ __('quiz::quiz.' . $status) }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="@this" data-live="true" class="am-select2" id="sortby"  data-wiremodel="filters.sort_by">
                            <option value="desc">{{ __('quiz::quiz.newest_first') }}</option>
                            <option value="asc">{{ __('quiz::quiz.oldest_first') }}</option>
            
                        </select>
                    </span>
                </div>
            </div>
        <div class="am-quizlist_table">
            <div wire:loading wire:target="loadData, filters">
                @include('quiz::skeletons.attempted-listing-skeleton', ['total' => $filters['per_page']])
            </div>
            @if(!$isLoading)
                <div class="am-quiztablewrap" wire:loading.remove wire:target="loadData, filters">
                    @if($quizzes->isNotEmpty())
                        <table class="am-table ">
                            <thead>
                                <tr>
                                    <th>{{ __('quiz::quiz.student') }}</th>
                                    <th>{{ __('quiz::quiz.date_time') }}</th>
                                    <th>{{ __('quiz::quiz.question') }}</th>
                                    <th>{{ __('quiz::quiz.total_marks') }}</th>
                                    <th>{{ __('quiz::quiz.correct_answer') }}</th>
                                    <th>{{ __('quiz::quiz.incorrect_answer') }}</th>
                                    <th>{{ __('quiz::quiz.earned_marks') }}</th>
                                    <th>{{ __('quiz::quiz.result') }}</th>
                                    <th>{{ __('quiz::quiz.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quizzes as $quiz)
                                    <tr>
                                        <td data-label="Student">
                                            <div class="am-quizlist_info am-quizlist_info_student">
                                                <figure class="am-quizlist_info_img">
                                                    @if (!empty($quiz->student?->profile?->image) && Storage::disk(getStorageDisk())->exists($quiz->student?->profile?->image))
                                                        <img src="{{ resizedImage($quiz->student?->profile?->image,30,30) }}" alt="{{$quiz->student?->profile?->full_name}}" />
                                                    @else
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',30,30) }}" alt="Quiz image" />
                                                    @endif
                                                </figure>
                                                <div class="am-quizlist_info_details">
                                                    <strong>{{ $quiz->student?->profile?->full_name }}</strong>
                                                    <span>{{ $quiz->student?->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Date & Time">
                                
                                            <strong>
                                                {{ $quiz?->started_at?->format('j M Y') }}
                                                <time datetime=""> {{ $quiz?->started_at?->format('g:i A') }}</time>
                                            </strong>
                                        </td>
                                        <td data-label="{{ __('quiz::quiz.question') }}">{{ $quiz->total_questions }}</td>
                                        <td data-label="{{ __('quiz::quiz.total_marks') }}">{{ $quiz->total_marks }}</td>
                                        <td data-label="{{ __('quiz::quiz.correct_answer') }}">{{ $quiz->correct_answers }}</td>
                                        <td data-label="{{ __('quiz::quiz.incorrect_answer') }}">{{ $quiz->incorrect_answers }}</td>
                                        <td data-label="{{ __('quiz::quiz.earned_marks') }}">
                                            {{ $quiz->earned_marks }} 
                                            ({{ round(($quiz->earned_marks / $quiz->total_marks) * 100, 2) }}%)
                                        </td>
                                        <td data-label="{{ __('quiz::quiz.result') }}">
                                            <span class="am-status am-status_{{ $quiz->result }}">
                                                <em class="am-quizstatus_{{ $quiz->result }}"></em>
                                                {{ __('quiz::quiz.' . $quiz->result) }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('quiz::quiz.actions') }}">
                                            @php 
                                                $actionRoute = $quiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW ? route('quiz.tutor.quiz-mark', ['attemptId' => $quiz->id]) : route('quiz.quiz-result', ['attemptId' => $quiz->id]);
                                            @endphp
                                            <a href="{{ $actionRoute }}" class="am-btn am-btn-light {{ $quiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_ASSIGNED ? 'am-btn_disabled' : '' }}">
                                                @if($quiz->result == Modules\Quiz\Models\QuizAttempt::RESULT_IN_REVIEW)
                                                    {{ __('quiz::quiz.mark_result') }}
                                                @else 
                                                    {{ __('quiz::quiz.view_details') }}
                                                @endif
                                            </a>
                                        </td>
                                    </tr>    
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="am-emptyview">
                            <figure class="am-emptyview_img">
                                <img src="{{ asset('modules/quiz/images/quiz-list/empty.png') }}" alt="img description">
                            </figure>
                            <div class="am-emptyview_title">
                                <h3>{{ __('quiz::quiz.no_records_found') }}</h3>
                                <p>{{ __('quiz::quiz.empty_box_para') }}</p>
                            </div>
                        </div>
                    @endif 
                </div>
            @endif
            @if(!$isLoading && $quizzes->links()->paginator->hasPages())
                <div class='am-pagination am-quiz-pagination'>
                    @if (!empty($parPageList))
                        <div class="am-pagination-filter" wire:ignore>
                            <em>{{ __('quiz::quiz.show') }}</em>
                            <span class="am-select">
                                <select x-init="$wire.dispatch('initSelect2', {target: '#per-page-select'});" class="am-select2" id="per-page-select" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="filters.per_page">
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
                    {{ $quizzes->links('quiz::pagination.pagination',) }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/quiz/css/main.css') }}">
@endpush

