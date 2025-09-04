<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__('Page Builder') . ' | '.$page->name); ?></title>
    <?php if( config('pagebuilder.add_bootstrap') === 'yes' ): ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/bootstrap.min.css')); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/jquery.mCustomScrollbar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/feather-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/jquery-confirm.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/flatpickr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/jquery.colorpicker.bygiro.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/summernote-lite.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/optionbuilder/css/nouislider.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/pagebuilder/css/larabuild-pagebuilder.css')); ?>">
</head>

<body>
    <?php echo $__env->yieldContent('builder-content'); ?>

    <?php if( config('pagebuilder.add_bootstrap') === 'yes' ): ?>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/bootstrap.min.js')); ?>"></script>
    <?php endif; ?>

    <script src="<?php echo e(asset('vendor/optionbuilder/js/jquery.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/select2.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/jquery-confirm.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/popper-core.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/tippy.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/flatpickr.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/jquery.colorpicker.bygiro.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/summernote-lite.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/nouislider.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/optionbuilder/js/optionbuilder.js')); ?>"></script>
    <script defer src="<?php echo e(asset('vendor/pagebuilder/js/Sortable.min.js')); ?>"></script>
    <?php echo $__env->yieldPushContent(config('pagebuilder.site_script_var')); ?>
    <?php echo $__env->yieldPushContent('builder-js'); ?>
    <?php echo $__env->yieldContent('builder-templates'); ?>
</body>

</html><?php /**PATH D:\Sahos\Laravel\lla\vendor\larabuild\pagebuilder\src/../resources/views/layouts/app.blade.php ENDPATH**/ ?>