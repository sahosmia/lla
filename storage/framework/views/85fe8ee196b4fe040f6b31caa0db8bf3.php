<div class="form-group" wire:key="question_group_desc_<?php echo e(time()); ?>">
    <label for="introduction" class="am-label"><?php echo e(__('quiz::quiz.question_description')); ?></label>
    <div class="am-editor-wrapper <?php $__errorArgs = ['activeForm.question_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <div 
            wire:key="question_desc_<?php echo e(time()); ?>"
            id="question_desc_<?php echo e(time()); ?>"
            x-data="{
                contentDesc: <?php if ((object) ('activeForm.question_text') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('activeForm.question_text'->value()); ?>')<?php echo e('activeForm.question_text'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('activeForm.question_text'); ?>')<?php endif; ?>
            }"
            x-init="$wire.dispatch('initSummerNote', 
                {
                    target: '#question_desc', 
                    wiremodel: 'activeForm.question_text', 
                    conetent: contentDesc,
                    componentId: window.Livewire.find('<?php echo e($_instance->getId()); ?>')
                });" 
            class="am-custom-editor am-custom-textarea" 
            wire:ignore>
            <textarea id="question_desc" class="form-control am-question-desc" placeholder="<?php echo e(__('quiz::quiz.answer_explanation_placeholder')); ?>" data-textarea="question_desc"></textarea>
            <span class="characters-count"></span>
        </div>
    </div>
    
    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['activeForm.question_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <?php if (isset($component)) { $__componentOriginal87266e1d5ace8a508026121cd3fa4221 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal87266e1d5ace8a508026121cd3fa4221 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'quiz::components.input-error','data' => ['fieldName' => 'activeForm.question_text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('quiz::input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'activeForm.question_text']); ?>
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
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Quiz/resources/views/livewire/tutor/quiz-creation/components/questions/elements/question-description.blade.php ENDPATH**/ ?>