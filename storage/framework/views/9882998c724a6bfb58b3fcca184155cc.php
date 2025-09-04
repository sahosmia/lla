<div class="am-quiz_answer_title">
    <div class="am-quiz_answer_heading">
        <h5><?php echo e(__('quiz::quiz.options')); ?></h5>
         <!--[if BLOCK]><![endif]--><?php if($questionType == 'mcq'): ?>
        <p><?php echo e(__('quiz::quiz.answer_description')); ?></p>
        <?php elseif($questionType == 'fill_in_blanks'): ?>
        <p><?php echo e(__('quiz::quiz.fill_in_blanks_answer_desc')); ?></p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <!--[if BLOCK]><![endif]--><?php if($questionType == 'mcq'): ?>
        <a href="javascript:void(0);" wire:click.prevent="addMcqOption">
            
            <?php echo e(__('quiz::quiz.add_more')); ?>

        </a>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if($questionType == 'fill_in_blanks'): ?>
        <a href="javascript:void(0);" wire:click.prevent="addFillInBlanksOption">
            <div class="am-fill-blanks">
                <div class="form-group">
                    <div class="am-fill-blanks_space">
                        <span class="am-label" for=""><i class="am-icon-plus-02"></i> 
                            <?php echo e(__('quiz::quiz.add_blank_space')); ?>

                        </span>
                    </div>
                </div>
            </div>
        </a>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/elements/answer-title.blade.php ENDPATH**/ ?>