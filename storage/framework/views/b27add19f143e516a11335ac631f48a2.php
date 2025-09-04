<div class="am-quiz_questions">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-quiz_questions_box">
        <div class="am-quiz_questions_section">
            <form>
                <fieldset>
                    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-description', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-image', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </fieldset>
            </form>
        </div>
        <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.score-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.action', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/short-answer.blade.php ENDPATH**/ ?>