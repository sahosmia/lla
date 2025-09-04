<ul class="am-userperinfo_tab">
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'am-active'     => $routeName == 'quiz.tutor.quiz-details',
        'pe-none'       => $quizStatus == \Modules\Quiz\Models\Quiz::STATUS_ARCHIVED
    ]); ?>">
        <a href="<?php echo e($routeName == 'quiz.tutor.quiz-details' ? 'javascript:void(0);': route('quiz.tutor.quiz-details', ['quizId' => $quizId])); ?>">
            <?php echo e(__('quiz::quiz.basic_details')); ?>

        </a>
    </li>
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'am-active'     => $routeName == 'quiz.tutor.quiz-settings',
        'pe-none'       => $quizStatus == \Modules\Quiz\Models\Quiz::STATUS_ARCHIVED
    ]); ?>">
        <a href="<?php echo e($routeName == 'quiz.tutor.quiz-settings' ? 'javascript:void(0);': route('quiz.tutor.quiz-settings', ['quizId' => $quizId])); ?>">
            <?php echo e(__('quiz::quiz.quiz_setting')); ?>

        </a>
    </li>
    <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'am-active'     => $routeName == 'quiz.tutor.question-manager',
        'pe-none'       => $quizStatus == \Modules\Quiz\Models\Quiz::STATUS_ARCHIVED
    ]); ?>">
        <a href="<?php echo e($routeName == 'quiz.tutor.question-manager' ? 'javascript:void(0);': route('quiz.tutor.question-manager', ['quizId' => $quizId])); ?>">
            <?php echo e(__('quiz::quiz.question_manager')); ?>

        </a>
    </li>
    <li class="<?php echo e($routeName == 'quiz.tutor.quiz-attempts' ? 'am-active' : ''); ?>">
        <a href="<?php echo e($routeName == 'quiz.tutor.quiz-attempts' ? 'javascript:void(0);': route('quiz.tutor.quiz-attempts', ['quizId' => $quizId])); ?>">
            <?php echo e(__('quiz::quiz.students')); ?>

        </a>
    </li>
</ul>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/quiz-tab.blade.php ENDPATH**/ ?>