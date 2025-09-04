<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> dir="rtl" <?php endif; ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <?php
            $siteTitle = setting('_general.site_name');
        ?>
        <title><?php echo e($siteTitle); ?> <?php echo e(!empty($title) ? ' | ' . $title : ''); ?></title>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')([
            'public/css/bootstrap.min.css',
            'public/css/fonts.css',
            'public/css/select2.min.css',
            'public/css/icomoon/style.css',
            'public/css/videojs.css',
            'public/js/bootstrap.min.js',
            'public/js/video.min.js',
            'public/js/main.js',
        ]); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/main.css')); ?>">
        <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/rtl.css')); ?>">
        <?php endif; ?>
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
        <?php if( !empty(setting('_scripts_styles.custom_styles')) ): ?>
            <style><?php echo html_entity_decode(setting('_scripts_styles.custom_styles')); ?></style>
        <?php endif; ?>
    </head>
    <body class="font-sans text-gray-900 antialiased <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> am-rtl <?php endif; ?>">
        <main>
            <?php echo e($slot); ?>

        </main>
        <?php if (isset($component)) { $__componentOriginal4ef9ecdd483996f04550e6a728ea1421 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4ef9ecdd483996f04550e6a728ea1421 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.popups','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('popups'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4ef9ecdd483996f04550e6a728ea1421)): ?>
<?php $attributes = $__attributesOriginal4ef9ecdd483996f04550e6a728ea1421; ?>
<?php unset($__attributesOriginal4ef9ecdd483996f04550e6a728ea1421); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4ef9ecdd483996f04550e6a728ea1421)): ?>
<?php $component = $__componentOriginal4ef9ecdd483996f04550e6a728ea1421; ?>
<?php unset($__componentOriginal4ef9ecdd483996f04550e6a728ea1421); ?>
<?php endif; ?>
        <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
        <?php if( !empty(setting('_scripts_styles.footer_scripts')) ): ?>
            <?php echo setting('_scripts_styles.footer_scripts'); ?>

        <?php endif; ?>
    </body>
</html><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/layouts/guest.blade.php ENDPATH**/ ?>