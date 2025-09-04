<div x-cloak class="am-quizsteps_wrap">
    <div class="am-quizsteps_bar">
        <div class="am-quizsteps_bar_title">
            <div class="am-quizsteps_bar_title_wrap">
                @if (!empty($quizAttempt->quiz->title))
                    <h3>{{ $quizAttempt->quiz->title }}</h3>
                @endif
            </div>
        </div>
        <div class="am-quizsteps_bar_time">
            <span id="remainingTime" 
                x-data="{
                    timeElapsed: '{{ $remainingTime }}',
                    totalTime: '{{ $duration }}',
                    countDown: `{{ getDurationFormatted($remainingTime) }}`,
                    formatTime: function(seconds) {
                        const minutes = Math.floor(seconds / 60);
                        const remainingSeconds = seconds % 60;
                        const hours = Math.floor(minutes / 60);
                        const remainingMinutes = minutes % 60;
                        if (hours > 0) {
                            return `${this.pad(hours)}:${this.pad(remainingMinutes)}:${this.pad(remainingSeconds)}`;
                        }
                        return `${this.pad(minutes)}:${this.pad(remainingSeconds)}`;
                    },
                    pad: function(num) {
                        return num < 10 ? '0' + num : num;
                    },
                    getProgress: function() {
                        return (this.timeElapsed / this.totalTime) * 360;
                    },
                    init(){
                        const interval = setInterval(() => {
                            this.timeElapsed--;
                            this.countDown = this.formatTime(this.timeElapsed);
                            document.getElementById('progress-bar-timer').style.background = `conic-gradient(#17B26A ${this.getProgress()}deg, #F7F7F8 ${this.getProgress()}deg)`;
                            if (this.timeElapsed <= 0) {
                                clearInterval(interval);
                                @this.call('finishQuiz');
                            }
                        }, 1000);
                    }
                }">
                <span x-text="countDown"></span>  
                <em>{{ __('quiz::quiz.time_remaining') }}</em>
            </span>
            <div id="progress-bar-timer" class="anti-clock-progessbar" 
                style="background: conic-gradient(#17B26A {{ ($remainingTime/$duration)*360 }}deg, #F7F7F8 {{ ($remainingTime/$duration)*360 }}deg);">
            </div>
        </div>
    </div>
    <div class="am-quizsteps_status" 
     x-data="{
        currentQuestion: @entangle('questionIndex'),
        totalQuestions: {{ intval($quizAttempt->total_questions) }},
        progress: 0,
        init() {
            this.updateProgress();
            $watch('currentQuestion', (newValue, oldValue) => {
                this.updateProgress();
            });
        },
        updateProgress() {
            this.progress = Math.round((Number(this.currentQuestion) / Number(this.totalQuestions)) * 100);
        }
    }"
>
    <em x-ref="progressBar" 
        x-bind:style="'width: ' + progress + '%'" 
        x-bind:aria-valuenow="progress"
        wire:ignore
    ></em>
</div>
    <div x-data="{
        animateClass: 'am-animate-fadeinup',
        changedValue: @entangle('questionIndex')
    }" class="am-quizsteps" x-init="$watch('changedValue', (newValue, oldValue) => {
        setTimeout(() => {
            $el.classList.add('am-animate-fadeoutup');
            setTimeout(() => {
                $el.classList.remove('am-animate-fadeoutup');
                $el.classList.add('am-animate-fadeinup');
            }, 300);
        }, 0)
    
    })">
        @include('quiz::livewire.student.quiz-attempt.answers.' . $question->type)
    </div>
    <div class="am-quizsteps_footer">
        <button wire:click="submitQuestion" wire:loading.attr="disabled" wire:loading.class="am-btn_disable" wire:target="submitQuestion" class="am-btn">
            Next
            <i class="am-icon-chevron-right"></i>
        </button>
    </div>
    <div class="modal fade am-deletepopup" id="back-confirm-popup" data-bs-backdrop="static">
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
                        <h3>{{ __('quiz::quiz.quiz_leave_heading') }}</h3>
                        <p>{{ __('quiz::quiz.quiz_leave_para') }}</p>
                    </div>
                    <div class="am-deletepopup_btns">
                        <a href="javascript:void(0);"
                            class="am-btn am-btn-del am-confirm-yes">{{ __('general.yes') }}</a>
                        <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel"
                            data-bs-dismiss="modal">{{ __('general.no') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('styles')
    <link href="{{ asset('modules/quiz/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
    @vite(['public/summernote/summernote-lite.min.css'])
@endpush

@push('scripts')
    <script defer src="{{ asset('js/splide.min.js') }}"></script>
    <script defer src="{{ asset('summernote/summernote-lite.min.js') }}"></script>
@endpush
