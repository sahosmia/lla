<div class="am-createquiz">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.quiz-tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div x-cloak class="am-createques">
        <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.' . str_replace('_', '-', $questionType), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>        
</div>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/quiz/css/main.css')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/summernote/summernote-lite.min.css',
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/livewire-sortable.js')); ?>"></script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/create-question.blade.php ENDPATH**/ ?>