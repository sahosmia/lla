<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['element', 'isPreview' => false]));

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

foreach (array_filter((['element', 'isPreview' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div 
    class="<?php echo \Illuminate\Support\Arr::toCssClasses(
        $element['classes'] ?? [],
    ); ?>"
    data-wildcard_name="<?php echo e($element['wildcardName']); ?>"
    <?php if(!empty($element['actions'])): ?>
        data-actions="<?php echo e($element['actions']); ?>"
    <?php endif; ?>
    style="<?php echo e($element['inlineStyle'] ?? ''); ?>"
    data-handles="<?php echo e($element['handles'] ?? 'e, w'); ?>"
>
    <?php if($element['wildcardName'] === 'attachment'): ?>
        <div class="uc-wildcard_content">
            <?php if(Str::contains($element['attachment'], '<svg')): ?> 
                <?php echo $element['attachment']; ?>

            <?php else: ?>
                <img src="<?php echo e(asset($element['attachment'])); ?>" alt="Attachment image">
            <?php endif; ?>
        </div>
    <?php elseif($element['wildcardName'] === 'separation_horizontal'): ?>
    <div class="uc-element-wildcard uc-alignment-left uc-separation_card" data-font="SF Pro Text" data-wildcard_name="separation_horizontal" data-actions="delete, copy" data-handles="e, w"> 
        <div class="uc-wildcard_content uc-separation"><span class="signle-line uc-separation_horizontal"> </span></div>
    </div>
    <?php elseif($element['wildcardName'] === 'separation_vertical'): ?>
        <div class="uc-element-wildcard uc-alignment-left uc-separation_card" data-font="SF Pro Text" data-wildcard_name="separation_vertical" data-actions="delete, copy" data-handles="n, s"> 
            <div class="uc-wildcard_content uc-separation"><span class="signle-line uc-separation_vertical"> </span></div>
        </div>
    <?php else: ?>
        <span class="uc-wildcard_content">
            <?php if($isPreview): ?>
                <?php echo e($element['wildcardName']); ?>

            <?php else: ?>
            <?php echo e('[' . $element['wildcardName'] . ']'); ?>

            <?php endif; ?>
        </span>
    <?php endif; ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/components/wildcard.blade.php ENDPATH**/ ?>