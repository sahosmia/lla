<div class="am-quizsteps_box">
    <div class="am-quizsteps_option">

        <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.components.question-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!--[if BLOCK]><![endif]--><?php if(!empty($question->options)): ?>
            <div class="am-quizsteps_details_wrap">
                <ul class="am-quizsteps_details">
                    <?php
                        $letter = 'A';
                        if(!empty($question->settings['random_choice'])){
                            $options = $question?->options?->shuffle();
                        }else{
                            $options = $question->options;
                        }
                    ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="am-radio">
                                <input wire:model.live="answer" value="<?php echo e($option->id); ?>" id="<?php echo e($option->id); ?>" type="radio" name="learning">
                                <label for="<?php echo e($option->id); ?>">
                                    <span><?php echo e($option->option_text); ?></span>
                                </label>
                            </div>
                        </li>
                    <?php
                        $letter = chr(ord($letter) + 1);
                    ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.components.question-image', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-attempt/answers/mcq.blade.php ENDPATH**/ ?>