<div x-cloak class="am-quizsteps_wrap">
    <div class="am-quizsteps_bar">
        <div class="am-quizsteps_bar_title">
            <div class="am-quizsteps_bar_title_wrap">
                <!--[if BLOCK]><![endif]--><?php if(!empty($quizAttempt->quiz->title)): ?>
                    <h3><?php echo e($quizAttempt->quiz->title); ?></h3>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <div class="am-quizsteps_bar_time">
            <span id="remainingTime" 
                x-data="{
                    timeElapsed: '<?php echo e($remainingTime); ?>',
                    totalTime: '<?php echo e($duration); ?>',
                    countDown: `<?php echo e(getDurationFormatted($remainingTime)); ?>`,
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
                                window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('finishQuiz');
                            }
                        }, 1000);
                    }
                }">
                <span x-text="countDown"></span>  
                <em><?php echo e(__('quiz::quiz.time_remaining')); ?></em>
            </span>
            <div id="progress-bar-timer" class="anti-clock-progessbar" 
                style="background: conic-gradient(#17B26A <?php echo e(($remainingTime/$duration)*360); ?>deg, #F7F7F8 <?php echo e(($remainingTime/$duration)*360); ?>deg);">
            </div>
        </div>
    </div>
    <div class="am-quizsteps_status" 
     x-data="{
        currentQuestion: <?php if ((object) ('questionIndex') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('questionIndex'->value()); ?>')<?php echo e('questionIndex'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('questionIndex'); ?>')<?php endif; ?>,
        totalQuestions: <?php echo e(intval($quizAttempt->total_questions)); ?>,
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
        changedValue: <?php if ((object) ('questionIndex') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('questionIndex'->value()); ?>')<?php echo e('questionIndex'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('questionIndex'); ?>')<?php endif; ?>
    }" class="am-quizsteps" x-init="$watch('changedValue', (newValue, oldValue) => {
        setTimeout(() => {
            $el.classList.add('am-animate-fadeoutup');
            setTimeout(() => {
                $el.classList.remove('am-animate-fadeoutup');
                $el.classList.add('am-animate-fadeinup');
            }, 300);
        }, 0)
    
    })">
        <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.' . $question->type, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
                        <h3><?php echo e(__('quiz::quiz.quiz_leave_heading')); ?></h3>
                        <p><?php echo e(__('quiz::quiz.quiz_leave_para')); ?></p>
                    </div>
                    <div class="am-deletepopup_btns">
                        <a href="javascript:void(0);"
                            class="am-btn am-btn-del am-confirm-yes"><?php echo e(__('general.yes')); ?></a>
                        <a href="javascript:void(0);" class="am-btn am-btnsmall am-cancel"
                            data-bs-dismiss="modal"><?php echo e(__('general.no')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('modules/quiz/css/main.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/splide.min.css')); ?>" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['public/summernote/summernote-lite.min.css']); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/splide.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-attempt/quiz-attempt.blade.php ENDPATH**/ ?>