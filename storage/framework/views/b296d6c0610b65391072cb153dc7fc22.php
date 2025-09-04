<div class="am-quiz_questions am-true-false">
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
            <div class="am-quiz_answer_option">
                <div class="am-quiz_answer_option_wrap">
                    <div class="am-radio">
                        <input  type="radio" id="true" name="ture&false" wire:model.live="activeForm.correct_answer" value="true">
                        <label for="true"></label>
                    </div>
                    <input for="true" class="form-control am-disabled" disabled placeholder="Ture" type="text">
                </div>
                <div class="am-quiz_answer_option_wrap">
                    <div class="am-radio">
                        <input type="radio" id="false" name="ture&false" wire:model.live="activeForm.correct_answer" value="false">
                        <label for="false"></label>
                    </div>
                    <div class="am-input-control">
                        <input for="false" class="form-control am-disabled" disabled placeholder="False" type="text">
                    </div>
                </div>
            </div> 
            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['activeForm.correct_answer'];
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
        </div>
        <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.score-settings', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->make('quiz::livewire.tutor.quiz-creation.components.questions.elements.action', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/true-false.blade.php ENDPATH**/ ?>