<div class="form-group <?php $__errorArgs = ['activeForm.question_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
    <label class="am-label am-important"><?php echo e(__('quiz::quiz.question_title')); ?>

        <!--[if BLOCK]><![endif]--><?php if($questionType == \Modules\Quiz\Models\Question::TYPE_FILL_IN_BLANKS): ?>
            <i class="am-tooltip am-icon-exclamation-01">
                <span class="am-tooltip-text">
                    <span><?php echo __('quiz::quiz.fill_in_blanks_tooltip'); ?></span>
                </span>
            </i>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php echo $tippyContent ?? ''; ?>

    </label>
    <input wire:model='activeForm.question_title' class="form-control" placeholder="<?php echo e(__('quiz::quiz.question_title_placeholder')); ?>" type="text">

    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['activeForm.question_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'activeForm.question_title']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'activeForm.question_title']); ?>
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
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/elements/question-title.blade.php ENDPATH**/ ?>