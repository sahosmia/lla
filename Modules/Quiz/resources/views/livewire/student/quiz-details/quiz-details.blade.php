<div class="am-quiz-detail">
    <div class="am-quiz-detail_box">
        @if(!empty(setting('_quiz.quiz_start_text')) || !empty(setting('_quiz.quiz_start_banner')))
        @php
            $bgImage = !empty(setting('_quiz.quiz_start_banner')[0]['path']) ? url(Storage::url(setting('_quiz.quiz_start_banner')[0]['path'])) : asset('modules/quiz/demo-content/quiz-detail-bg.png');
        @endphp
            <div class="am-quiz-detail_banner" style="background: url('{{ $bgImage }}')">
                <figure>
                    <x-application-logo :variation="'white'" />
                </figure>
                @if(!empty(setting('_quiz.quiz_start_text')))
                    <h3>{{ setting('_quiz.quiz_start_text') }}</h3>
                @endif
            </div>
        @endif
        <div class="am-quiz-detail_content">
            <div class="am-quiz-detail_info">
                @if(!empty($quizAttempt?->quiz?->tutor?->profile?->image) && Storage::disk(getStorageDisk())->exists($quizAttempt?->quiz?->tutor?->profile?->image))
                    <figure>
                        <img src="{{ resizedImage($quizAttempt?->quiz?->tutor?->profile?->image, 160, 160) }}" alt="{{ $quizAttempt?->quiz?->tutor?->profile?->full_name }}" />
                    </figure>
                @endif
                <h6>
                    {{ $quizAttempt?->quiz?->tutor?->profile?->full_name }}
                    <span>{{ __('quiz::quiz.quiz_author') }}</span>
                </h6>
            </div>
            <div class="am-quiz-detail_description">
                @if(!empty($quizAttempt?->quiz?->title))
                    <h3>{{ $quizAttempt?->quiz?->title }}</h3>
                @endif
                <div class="am-course-stats">
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <svg  width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path opacity="0.7" d="M8.3335 10.6673C8.3335 10.8514 8.18426 11.0007 8.00016 11.0007C7.81607 11.0007 7.66683 10.8514 7.66683 10.6673M8.3335 10.6673C8.3335 10.4832 8.18426 10.334 8.00016 10.334C7.81607 10.334 7.66683 10.4832 7.66683 10.6673M8.3335 10.6673H7.66683M6.66683 7.00065V6.66732C6.66683 5.93094 7.26378 5.33398 8.00016 5.33398C8.73654 5.33398 9.3335 5.93094 9.3335 6.66732V6.7482C9.3335 7.12327 9.1845 7.48298 8.91928 7.7482L8.00016 8.66732M14.6668 8.00065C14.6668 11.6826 11.6821 14.6673 8.00016 14.6673C7.24059 14.6673 6.58919 14.5591 5.98434 14.3428C5.41269 14.1383 5.12685 14.036 5.01717 14.0103C4.00523 13.7723 3.58543 14.4658 2.71326 14.6111C2.28489 14.6825 1.90372 14.3318 1.93927 13.899C1.97036 13.5205 2.23209 13.1626 2.33653 12.7991C2.55364 12.0436 2.25903 11.4708 1.94776 10.7988C1.55359 9.94796 1.3335 8.99999 1.3335 8.00065C1.3335 4.31875 4.31826 1.33398 8.00016 1.33398C11.6821 1.33398 14.6668 4.31875 14.6668 8.00065Z" stroke="#585858" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="am-stat-content">
                            <span class="am-stat-label">{{ __('quiz::quiz.total_questions') }}</span>
                            <span class="am-stat-value">{{ $quizAttempt?->total_questions }}</span>
                        </div>
                    </div>
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <i class="am-icon-trophy-04"></i>
                        </div>
                        <div class="am-stat-content">
                            <span class="am-stat-label">{{ __('quiz::quiz.total_marks') }}</span>
                            <span class="am-stat-value">{{ $quizAttempt?->total_marks }}</span>
                        </div>
                    </div>
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <i class="am-icon-shield-check"></i>
                        </div>
                        @if(!empty($quizAttempt?->quiz?->settings?->where('meta_key', 'passing_grade')->first()->meta_value))
                            <div class="am-stat-content">
                                <span class="am-stat-label">{{ __('quiz::quiz.passing_marks') }}</span>
                                <span class="am-stat-value">{{ $quizAttempt?->quiz?->settings?->where('meta_key', 'passing_grade')->first()->meta_value }}%</span>
                            </div>
                        @endif
                    </div>
                    @if(!empty($quizAttempt?->quiz?->settings?->where('meta_key', 'duration')->first()->meta_value))
                    <div class="am-stat-item">
                        <div class="am-stat-icon-wrapper">
                            <i class="am-icon-time"></i>
                        </div>
                        <div class="am-stat-content">
                            <span class="am-stat-label">{{ __('quiz::quiz.duration') }}</span>
                            <span class="am-stat-value">{{ $quizAttempt?->quiz?->settings?->where('meta_key', 'duration')->first()?->meta_value ?? null }}</span>
                        </div>
                    </div>
                    @endif
                </div>
               <p>
                    @if ($fullDescription)
                        {!! $quizAttempt?->quiz?->description !!}
                    @else
                        {{-- {!! Str::limit(strip_tags($quiz->description), 400, '...', preserveWords: true) !!} --}}
                        {!! $quizAttempt?->quiz?->description !!}
                    @endif
                </p>
                @if(!empty(setting('_quiz.quiz_instructions')))
                    <div class="am-instructions">
                        <h6>
                            <i class="am-icon-exclamation-01"></i>
                            {{ __('quiz::quiz.quiz_instructions') }}
                        </h6>
                        <ul>
                            @foreach (setting('_quiz.quiz_instructions') as $instrcustions)
                                <li>
                                    <p>{{ $instrcustions['instruction'] }}</p>
                                </li>     
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            @if($quizAttempt?->quiz?->questions?->count() > 0)
                <button  data-toggle="modal" data-bs-toggle="modal" data-bs-target="#back-confirm-popup" class="am-btn">
                    {{ __('quiz::quiz.start_quiz') }}
                    <i class="am-icon-chevron-right"></i>
                </button>
            @endif
    <div class="modal fade am-deletepopup am-startquiz-popup" id="back-confirm-popup" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-body">
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                    <div class="am-deletepopup_icon warning-icon">
                        <span>
                            <i class="am-icon-exclamation-01"></i>
                        </span>
                    </div>
                    <div class="am-deletepopup_title">
                        <h3>{{ __('quiz::quiz.start_quiz_alert_heading') }}</h3>
                        <p>{{ __('quiz::quiz.start_quiz_alert_para') }}</p>
                    </div>
                    <div class="am-deletepopup_btns">
                        <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel" data-bs-dismiss="modal">{{ __('general.cancel') }}</a>
                        <a href="javascript:void(0);" wire:click="startQuiz" class="am-btn am-btn-success am-confirm-yes">{{ __('quiz::quiz.start_quiz') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="{{ asset('modules/quiz/css/main.css') }}" rel="stylesheet">
    @vite([
    'public/css/flags.css',
])
@endpush