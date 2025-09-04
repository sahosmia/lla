<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['image', 'title', 'description', 'btn_text']));

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

foreach (array_filter((['image', 'title', 'description', 'btn_text']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="am-page-error">
    <div class="am-norecord-wrap">
        <!--[if BLOCK]><![endif]--><?php if(!empty($image)): ?>
            <figure>
                <img src="<?php echo e($image); ?>">
            </figure>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if(!empty($title)): ?>
            <h3><?php echo e($title); ?></h3>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if(!empty($description)): ?>
            <p><?php echo $description; ?></p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]--><?php if(!empty($btn_text)): ?>
            <button <?php echo $attributes->merge(['class' => 'am-btn']); ?> wire:loading.class="am-btn_disable">
               <?php echo $btn_text; ?>

                <i class="am-icon-plus-01"></i>
            </button>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/no-record.blade.php ENDPATH**/ ?>