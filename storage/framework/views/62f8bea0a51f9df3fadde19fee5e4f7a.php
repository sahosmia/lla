<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['body', 'isPreview' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['body', 'isPreview' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="uc-certificatebox">
    <div class="uc-course_box" id="uc-canvas-boundry" 
    <?php if(!empty($body['backgroundColorStyle']) && $body['backgroundColorStyle'] !== 'rgb(255, 255, 255)'): ?>
        style="background-color: <?php echo e($body['backgroundColorStyle']); ?>;"
    <?php elseif(!empty($body['backgroundImage'])): ?>
        style="background-image: url('<?php echo e($body['backgroundImage']); ?>'); <?php echo e($body['inlineStyle'] ?? ''); ?>"
    <?php endif; ?>
    >
        <!--[if BLOCK]><![endif]--><?php if(!empty($body['elementsInfo'])): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $body['elementsInfo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php if($element['wildcardName'] == 'custom_message'): ?>
                    <?php if (isset($component)) { $__componentOriginal96bee6840ed7b942889cae334fde79c2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal96bee6840ed7b942889cae334fde79c2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.custom_message','data' => ['element' => $element]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::custom_message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['element' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($element)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal96bee6840ed7b942889cae334fde79c2)): ?>
<?php $attributes = $__attributesOriginal96bee6840ed7b942889cae334fde79c2; ?>
<?php unset($__attributesOriginal96bee6840ed7b942889cae334fde79c2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal96bee6840ed7b942889cae334fde79c2)): ?>
<?php $component = $__componentOriginal96bee6840ed7b942889cae334fde79c2; ?>
<?php unset($__componentOriginal96bee6840ed7b942889cae334fde79c2); ?>
<?php endif; ?>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal0a12ed6909ab84a1547cc684b2e6974e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a12ed6909ab84a1547cc684b2e6974e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.wildcard','data' => ['element' => $element,'isPreview' => $isPreview]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::wildcard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['element' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($element),'isPreview' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($isPreview)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a12ed6909ab84a1547cc684b2e6974e)): ?>
<?php $attributes = $__attributesOriginal0a12ed6909ab84a1547cc684b2e6974e; ?>
<?php unset($__attributesOriginal0a12ed6909ab84a1547cc684b2e6974e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a12ed6909ab84a1547cc684b2e6974e)): ?>
<?php $component = $__componentOriginal0a12ed6909ab84a1547cc684b2e6974e; ?>
<?php unset($__componentOriginal0a12ed6909ab84a1547cc684b2e6974e); ?>
<?php endif; ?>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if(!$isPreview): ?>
            <svg class="uc-border-svg "><rect width="100%" height="100%"></rect></svg>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/components/body.blade.php ENDPATH**/ ?>