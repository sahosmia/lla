<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php if( !empty(setting('_general.enable_rtl')) ): ?> dir="rtl" <?php endif; ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <?php
            $siteTitle        = setting('_general.site_name');
        ?>
        <title><?php echo e($siteTitle); ?> <?php echo request()->is('messenger') ? ' | Messages' : (!empty($title) ? ' | ' . $title : ''); ?></title>
        <?php if (isset($component)) { $__componentOriginal82e3f864bb766fbb95cb0a10b750823c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82e3f864bb766fbb95cb0a10b750823c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.favicon','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('favicon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82e3f864bb766fbb95cb0a10b750823c)): ?>
<?php $attributes = $__attributesOriginal82e3f864bb766fbb95cb0a10b750823c; ?>
<?php unset($__attributesOriginal82e3f864bb766fbb95cb0a10b750823c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82e3f864bb766fbb95cb0a10b750823c)): ?>
<?php $component = $__componentOriginal82e3f864bb766fbb95cb0a10b750823c; ?>
<?php unset($__componentOriginal82e3f864bb766fbb95cb0a10b750823c); ?>
<?php endif; ?>
        <?php echo app('Illuminate\Foundation\Vite')([
            'public/css/bootstrap.min.css',
            'public/css/fonts.css',
            'public/css/icomoon/style.css',
            'public/css/select2.min.css',
            'public/css/main.css',
        ]); ?>
        <?php echo $__env->yieldPushContent('styles'); ?>
        <?php if( !empty(setting('_general.enable_rtl')) ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/rtl.css')); ?>">
        <?php endif; ?>
    </head>
    <body class="am-bodywrap <?php if( !empty(setting('_general.enable_rtl')) ): ?> am-rtl <?php endif; ?>">
        <main class="am-main">
            <?php echo e($slot ?? ''); ?>

            <?php echo $__env->yieldContent('content'); ?>
            <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


            <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
            <script defer src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
            <script defer src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
            <script defer src="<?php echo e(asset('js/main.js')); ?>"></script>
            <?php echo $__env->yieldPushContent('scripts'); ?>
        </main>
    </body>
</html>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/layouts/app.blade.php ENDPATH**/ ?>