<div class="am-quizsteps_box am-quizsteps_four">
    <div class="am-quizsteps_option">
        <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.components.question-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="am-quizsteps_details_wrap">
            <div class="form-group">
                <label class="am-label <?php echo e($question->answer_required ? 'am-important' : ''); ?>"  for="answer">Answer</label>
                
                <div 
                    wire:key="answer_desc<?php echo e(time()); ?>"
                    id="answer_desc<?php echo e(time()); ?>"
                    x-data="{
                        contentDesc: <?php if ((object) ('answer') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('answer'->value()); ?>')<?php echo e('answer'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('answer'); ?>')<?php endif; ?>
                    }"
                    x-init="$wire.dispatch('initSummerNote', 
                        {
                            target: '#answer_desc', 
                            wiremodel: 'answer', 
                            conetent: contentDesc,
                            componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')
                        });" 
                    class="form-control_wrap am-custom-editor am-custom-textarea" 
                    wire:ignore>
                    <textarea id="answer_desc" class="form-control am-question-desc" placeholder="Add answer explanation..." data-textarea="answer_desc"></textarea>
                    <span class="characters-count"></span>
                </div>
            </div>
        </div>

    </div>
    
    <?php echo $__env->make('quiz::livewire.student.quiz-attempt.answers.components.question-image', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/student/quiz-attempt/answers/short_answer.blade.php ENDPATH**/ ?>