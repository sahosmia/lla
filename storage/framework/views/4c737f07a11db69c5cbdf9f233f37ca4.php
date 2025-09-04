<div class="am-quiz_questions_btn">
    <button type="button" class="am-btn-light" onclick="window.location='<?php echo e(route('quiz.tutor.question-manager', ['quizId' => $quiz->id])); ?>'">
        <?php echo e(__('quiz::quiz.back')); ?>

    </button>
    <button type="button"
     wire:loading.class="am-btn_disable" 
     wire:target="saveQuestion"
     wire:click="saveQuestion" class="am-btn"><?php echo e(__('quiz::quiz.save')); ?></button>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/elements/action.blade.php ENDPATH**/ ?>