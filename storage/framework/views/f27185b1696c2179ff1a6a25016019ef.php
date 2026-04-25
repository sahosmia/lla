<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['element']));

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

foreach (array_filter((['element']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div 
    class="<?php echo e(!empty($element['classes']) ? implode(' ', $element['classes']) : ''); ?>" 
    data-wildcard_name="<?php echo e($element['wildcardName']); ?>" 
    data-actions="<?php echo e(!empty($element['actions']) ? $element['actions'] : ''); ?>" 
    style="<?php echo e($element['inlineStyle']); ?>"
    data-handles="<?php echo e(!empty($element['handles']) ? $element['handles'] : 'e, w'); ?>"
    >
    <span class="uc-wildcard_content"><?php echo nl2br(e($element['custom_message'])); ?></span>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/components/custom_message.blade.php ENDPATH**/ ?>