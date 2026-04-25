<div class="am-quizsteps_title">
    <!--[if BLOCK]><![endif]--><?php if(!empty($question->display_points)): ?>
        <span class="am-quizsteps_title_tag"><?php echo e($question->points); ?> <?php echo e($question->points > 1 ? __('quiz::quiz.points') : __('quiz::quiz.point')); ?></span>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if($question-> type == Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS): ?>
       <div class="am-quizsteps_heading">
           <em>*</em>
           <h2>
               <!--[if BLOCK]><![endif]--><?php if(!empty($question->settings['answer_required'])): ?>
               <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
               <?php echo e($questionNumber); ?>. <?php echo getStudentFillInBlanksText($question->title); ?>

           </h2>
       </div>
    <?php else: ?>
        <div class="am-quizsteps_heading">
            <em>*</em>
            <h2>
                <?php echo e($questionNumber); ?>. <?php echo e($question->title); ?>

            </h2>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-attempt/answers/components/question-title.blade.php ENDPATH**/ ?>