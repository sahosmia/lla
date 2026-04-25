
<div class="am-quizmark am-quiz_result">
    <div class="am-quiz_header">
        <div class="am-quiz_title">
            <div class="am-coursename">
                <h2><?php echo e($attemptQuiz?->quiz?->title); ?></h2>
            </div>
            <div class="am-quiz_tagline">
                <span>
                    <i class="am-icon-chat-03"></i>
                    <?php echo e(__('quiz::quiz.total_questions')); ?> <em><?php echo e(number_format($attemptQuiz->total_questions)); ?></em>
                </span>
                <span>
                    <?php 
                        $hours = floor(intval($completedDuration) / 3600);
                    ?>
                    <i class="am-icon-time"></i>
                    <?php echo e(__('quiz::quiz.duration')); ?> 
                    <!--[if BLOCK]><![endif]--><?php if(!empty($hours)): ?>
                        <em><?php echo e(getDurationFormatted( intval($completedDuration))); ?> <?php echo e(__('quiz::quiz.hrs')); ?></em>
                    <?php else: ?>
                        <em><?php echo e(getDurationFormatted( intval($completedDuration))); ?> <?php echo e(__('quiz::quiz.time_min')); ?></em>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </span>
            </div>
        </div>
    </div>

    <div class="am-quizmark_content">
        <div class="am-quizmark_title">
            <h2><?php echo e(__('quiz::quiz.quiz_summary')); ?>:</h2>
        </div>
        <div class="accordion am-accordions">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $attemptQuiz->quiz?->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="am-quiz-box">
                    <div class="am-quiz-box_question">
                        <h4>
                            <em><?php echo e(__('quiz::quiz.question_number', ['number' => $loop->index + 1])); ?></em>
                            <?php echo getQuestionTitle($question); ?>

                        </h4>
                        <!--[if BLOCK]><![endif]--><?php if(in_array($question->type, [Modules\Quiz\Models\Question::TYPE_OPEN_ENDED_ESSAY, Modules\Quiz\Models\Question::TYPE_SHORT_ANSWER])): ?>
                            <?php 
                                $question_index = array_search($question->id, array_column($requiredAnswers, 'question_id'));
                            ?>
                            <div class="am-quiz-box_points">
                                <span>
                                    <em><input type="number" placeholder="<?php echo e(__('quiz::quiz.add')); ?>" wire:model="requiredAnswers.<?php echo e($question_index); ?>.marks_awarded" max="<?php echo e($question->points); ?>" min="0" /> </em>
                                    /<?php echo e($question?->points); ?> <?php echo e(__('quiz::quiz.points')); ?>

                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["requiredAnswers.{$question_index}.marks_awarded"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <i class="am-tooltip am-icon-exclamation-01">
                                            <span class="am-tooltip-text">
                                                <strong><?php echo e(__('quiz::quiz.required_feild')); ?></strong>
                                                <span><?php echo e($message); ?></span>
                                            </span>
                                        </i>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="am-quiz-box_points">
                                <span><?php echo e($question->attemptedQuestions?->first()?->marks_awarded ?? 0); ?>

                                    /<?php echo e($question?->points); ?> 
                                    <?php echo e(__('quiz::quiz.points')); ?>

                                </span>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <span>
                        <i class="am-icon-layer-01"></i>
                        <?php echo e(__('quiz::quiz.type')); ?> <em><?php echo e(__('quiz::quiz.'.$question->type)); ?></em>
                    </span>                        
                    <!--[if BLOCK]><![endif]--><?php if(!empty($question->isMultiOption())): ?>
                        <div class="am-quiz-answers">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!--[if BLOCK]><![endif]--><?php if($option->id == $question->attemptedQuestions?->first()?->question_option_id): ?>
                                    <div class="am-quiz-answers_options <?php echo e($option->id == $question->attemptedQuestions?->first()?->question_option_id && $option->is_correct === 1 ? 'am-correct-ans' : 'am-wrong-ans'); ?>">
                                        <div class="am-radio">
                                            <input checked type="radio" id="<?php echo e($loop->index); ?>_option" name="correct-answer" disabled />
                                            <label for="<?php echo e($loop->index); ?>_option"><?php echo e($option->option_text); ?></label>
                                        </div>
                                        <?php if($option->id == $question->attemptedQuestions?->first()?->question_option_id && $option->is_correct === 1): ?>
                                            <span>
                                                <?php echo e(__('quiz::quiz.correct_answer')); ?>

                                                <i class="am-icon-check-circle06"></i>
                                            </span>
                                        <?php else: ?>
                                            <span>
                                                <?php echo e(__('quiz::quiz.wrong_answer_you')); ?>

                                                <i class="am-icon-multiply-02"></i>
                                            </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php else: ?>
                                    <div class="am-quiz-answers_options <?php echo e($option->is_correct ? 'am-correct-ans am-truefalse' : ''); ?>">
                                        <div class="am-radio">
                                            <input <?php echo e($option->is_correct ? 'checked':''); ?> type="radio" id="<?php echo e($loop->index); ?>_option" name="correct-answer" disabled />
                                            <label for="<?php echo e($loop->index); ?>_option"><?php echo e($option->option_text); ?></label>
                                        </div>
                                    </div>     
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php if($question->isDescriptive() && !empty($question->attemptedQuestions->first()?->answer)): ?>
                        <div class="am-quiz-answers">
                            <h5><?php echo e(__('quiz::quiz.answer')); ?></h5>
                            <div class="am-quiz-answers_answer">
                                <?php echo $question->attemptedQuestions->first()?->answer; ?>

                            </div>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
    <div class="am-quiz_footer">
        <button wire:click.prevent="submitResult" wire:loading.class="am-btn_disable" wire:loading.attr="disabled" wire:target="submitResult" class="am-btn"><?php echo e(__('quiz::quiz.submit_result')); ?></button>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-mark/quiz-mark.blade.php ENDPATH**/ ?>