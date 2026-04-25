<!--[if BLOCK]><![endif]--><?php if(!empty($question->thumbnail) && Storage::disk(getStorageDisk())->exists($question->thumbnail?->path)): ?>
    <figure class="am-quizsteps_img">
        <img src="<?php echo e(Storage::disk(getStorageDisk())->url($question->thumbnail?->path)); ?>" alt="<?php echo e($question->question_title); ?>">
    </figure>
<?php endif; ?><!--[if ENDBLOCK]><![endif]--><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-attempt/answers/components/question-image.blade.php ENDPATH**/ ?>