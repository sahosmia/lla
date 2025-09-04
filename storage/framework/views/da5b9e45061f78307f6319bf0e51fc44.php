<div x-cloak class="am-quiz_questions">
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
        <div class="am-quiz_answer_section">
            <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.answer-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="am-quiz_answer_option">
                <div wire:sortable="updateMcqPosition" class="am-quiz_answer_option">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($activeForm->mcqs)): ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $activeForm->mcqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                            <div wire:sortable.item="<?php echo e($loop->index); ?>" wire:key="question-<?php echo e($loop->index); ?>" id="question-<?php echo e($loop->index); ?>" class="am-quiz_answer_option_wrap">
                                <i wire:sortable.handle>
                                    <i class="am-icon-youtube-1"></i>
                                </i>
                                <div class="am-radio">
                                    <input wire:model="activeForm.correct_answer" value="<?php echo e($loop->index); ?>" id="<?php echo e($loop->index); ?>_option" name="mcqOption" <?php if($activeForm->correct_answer == $loop->index): ?> checked <?php endif; ?>  type="radio">
                                    <label for="<?php echo e($loop->index); ?>_option"></label>
                                </div>
                                <div class="am-input-control">
                                    <input class="form-control" wire:model="activeForm.mcqs.<?php echo e($loop->index); ?>.option_text" placeholder="Enter option" type="text">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["activeForm.correct_answer"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'activeForm.correct_answer']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'activeForm.correct_answer']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal87266e1d5ace8a508026121cd3fa4221)): ?>
<?php $attributes = $__attributesOriginal87266e1d5ace8a508026121cd3fa4221; ?>
<?php unset($__attributesOriginal87266e1d5ace8a508026121cd3fa4221); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal87266e1d5ace8a508026121cd3fa4221)): ?>
<?php $component = $__componentOriginal87266e1d5ace8a508026121cd3fa4221; ?>
<?php unset($__componentOriginal87266e1d5ace8a508026121cd3fa4221); ?>
<?php endif; ?> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["activeForm.mcqs.{$loop->index}.option_text"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'activeForm.mcqs.'.e($loop->index).'.option_text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'activeForm.mcqs.'.e($loop->index).'.option_text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal87266e1d5ace8a508026121cd3fa4221)): ?>
<?php $attributes = $__attributesOriginal87266e1d5ace8a508026121cd3fa4221; ?>
<?php unset($__attributesOriginal87266e1d5ace8a508026121cd3fa4221); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal87266e1d5ace8a508026121cd3fa4221)): ?>
<?php $component = $__componentOriginal87266e1d5ace8a508026121cd3fa4221; ?>
<?php unset($__componentOriginal87266e1d5ace8a508026121cd3fa4221); ?>
<?php endif; ?> 
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]--> 
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(count($activeForm->mcqs) > 1): ?>
                                    <span wire:click.prevent="removeMcq(<?php echo e($loop->index); ?>)">
                                        <i class="am-icon-trash-02"></i>
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>   
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->  
                    <?php else: ?> 
                        <li class="am-question-option">
                            <span><?php echo e(__('quiz::quiz.add_option_here')); ?></span>
                        </li> 
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->    
                </div>
            </div>

        </div>
        <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.score-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.action', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/mcq.blade.php ENDPATH**/ ?>