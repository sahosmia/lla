<?php $__env->startPush(config('upcertify.style_stack')); ?>

    <?php if($load_livewire_styles): ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css//icomoon/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css/main.css')); ?>">
    <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?>
        <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css/rtl.css')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css/fonts.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css/jquery-ui.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css/jquery.colorpicker.bygiro.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('modules/upcertify/css/smart-guides.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection(config('upcertify.content_yeild')); ?>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split("upcertify::$component", $props ?? []);

$__html = app('livewire')->mount($__name, $__params, 'lw-3090743736-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush(config('upcertify.script_stack')); ?>

    <?php if($load_livewire_scripts): ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php endif; ?>
    
    <?php if($load_jquery): ?>
        <script defer src="<?php echo e(asset('modules/upcertify/js/jquery.min.js')); ?>"></script>
    <?php endif; ?>

    <script src="<?php echo e(asset('modules/upcertify/js/html2canvas.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('modules/upcertify/js/jquery-ui.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('modules/upcertify/js/jquery.ui.rotatable.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('modules/upcertify/js/jquery.colorpicker.bygiro.js')); ?>"></script>
    <script defer src="<?php echo e(asset('modules/upcertify/js/jquery.draggable.smartguides.js')); ?>"></script>
    <script defer src="<?php echo e(asset('modules/upcertify/js/smart-guides.js')); ?>"></script>
    <script defer src="<?php echo e(asset('modules/upcertify/js/main.js')); ?>"></script>    
<?php $__env->stopPush(); ?>

<?php echo $__env->make($extends, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/index.blade.php ENDPATH**/ ?>