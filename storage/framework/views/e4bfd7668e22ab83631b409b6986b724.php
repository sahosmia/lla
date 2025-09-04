<div class="am-quiz_questions am-fill-in-blanks">
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-quiz_questions_box">
        <div class="am-quiz_questions_section">
            <form>
                <fieldset>
                    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.question-image', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </fieldset>
            </form>
        </div>
        <div class="am-quiz_answer_section">
            <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.answer-title', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <div wire:sortable="updateOptionPosition" class="am-quiz_answer_option">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $activeForm->blanks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div wire:sortable.item="<?php echo e($loop->index); ?>" wire:key="question-<?php echo e($loop->index); ?>" id="question-<?php echo e($loop->index); ?>" class="am-quiz_answer_label">
                        <label class="am-short-label"> <?php echo e(__('quiz::quiz.blank_answer', ['number' => $loop->index + 1])); ?></label>
                        <div class="am-quiz_answer_option_wrap">
                            <i wire:sortable.handle>
                                <i class="am-icon-youtube-1"></i>
                            </i>
                            <div class="am-input-control">
                                <input wire:model="activeForm.blanks.<?php echo e($loop->index); ?>.option_text" class="form-control" placeholder="Add fill in the blank option" type="text">
                            </div>
                            <span wire:click.prevent="removeFillInBlanksOption(<?php echo e($loop->index); ?>)">
                                <i class="am-icon-trash-02"></i>
                            </span>
                        </div>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["activeForm.blanks.{$loop->index}.option_text"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'activeForm.blanks.'.e($loop->index).'.option_text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'activeForm.blanks.'.e($loop->index).'.option_text']); ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]--> 
            </div> 
        </div>
        <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.score-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.action', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/fill-in-blanks.blade.php ENDPATH**/ ?>