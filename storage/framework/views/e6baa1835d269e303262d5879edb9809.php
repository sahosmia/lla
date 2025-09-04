<div class="am-quiz_questions_title">
    <h2>
        <a href="<?php echo e(route('quiz.tutor.question-manager', ['quizId' => $quiz->id])); ?>"><svg width="25" height="24" viewBox="0 0 25 24" fill="none">
            <path d="M14.2109 6L8.21094 12L14.2109 18" stroke="#585858" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
        <?php echo e(__('quiz::quiz.question_count',['count' => !$questionId ? $question_count : ''])); ?> 
    </h2>
    <div class="am-select" wire:ignore>
        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="status" <?php if($questionId): ?> disabled <?php endif; ?> data-wiremodel="questionType">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $questionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php if(!$type['is_disabled']): ?>
                    <option value="<?php echo e($type['type']); ?>" <?php if($type['type'] == $questionType): ?> selected <?php endif; ?>><?php echo e(__('quiz::quiz.' . $type['type'])); ?></option>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </select>
        <span class="am-select-type"><?php echo e(__('quiz::quiz.type')); ?>:</span>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/elements/question-header.blade.php ENDPATH**/ ?>