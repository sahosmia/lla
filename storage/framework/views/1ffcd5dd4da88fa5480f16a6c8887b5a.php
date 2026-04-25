<div class="am-quizsteps_box am-quizsteps_three">
    <div class="am-quizsteps_option">

        <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.components.question-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!--[if BLOCK]><![endif]--><?php if(!empty($question->options)): ?>
            <div class="am-quizsteps_details_wrap">
                <ul class="am-quizsteps_details">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                            
                        <li>
                            <div class="am-radio">
                                <input wire:model.live="answer" id="<?php echo e($option->id); ?>" type="radio" value="<?php echo e($option->id); ?>" name="true_false">
                                <label for="<?php echo e($option->id); ?>">
                                    
                                    <span><?php echo e($option->option_text); ?></span>
                                </label>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>

    <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.components.question-image', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-attempt/answers/true_false.blade.php ENDPATH**/ ?>