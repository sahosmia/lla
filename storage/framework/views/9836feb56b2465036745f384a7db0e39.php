<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variation' => 'default']));

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

foreach (array_filter((['variation' => 'default']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php
    if ($variation == 'default') {
        $logo    = setting('_general.logo_default');
        $logoImg = !empty($logo[0]['path']) ? url(Storage::url($logo[0]['path'])) : asset('demo-content/logo-default.svg');
    } elseif($variation == 'blue') {
        $logoImg  = asset('images/blue-logo.svg');
    } elseif($variation == 'purple') {  
        $logoImg  = asset('images/purple-logo.svg'); 
    } elseif($variation == 'green') {  
        $logoImg  = asset('images/green-logo.svg'); 
    } elseif($variation == 'black') {  
        $logoImg  = asset ('demo-content/home-v6/logo-black.svg'); 
    } elseif($variation == 'sky-blue') {  
        $logoImg  = asset ('images/sky-blue.svg'); 
    } else {
        $logo    = setting('_general.logo_white');
        $logoImg = !empty($logo[0]['path']) ? url(Storage::url($logo[0]['path'])) : asset('demo-content/logo-white.svg');
    }
?>
<a href="<?php echo e(url('/')); ?>">
    <img src="<?php echo e($logoImg); ?>" alt="<?php echo e(setting('_general.site_name') ?? config('app.name', __('general.app_name'))); ?>" <?php echo e($attributes); ?>>
</a>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/application-logo.blade.php ENDPATH**/ ?>