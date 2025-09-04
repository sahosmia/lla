<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> dir="rtl" <?php endif; ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <?php if (isset($component)) { $__componentOriginalfad345ba8e9885f75fe8edddaef3cd8c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfad345ba8e9885f75fe8edddaef3cd8c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.meta-content','data' => ['pageTitle' => $pageTitle ?? null,'page' => $page ?? null,'pageDescription' => $pageDescription ?? null,'pageKeywords' => $pageKeywords ?? null,'metaImage' => $metaImage ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('meta-content'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageTitle ?? null),'page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page ?? null),'pageDescription' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageDescription ?? null),'pageKeywords' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($pageKeywords ?? null),'metaImage' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($metaImage ?? null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfad345ba8e9885f75fe8edddaef3cd8c)): ?>
<?php $attributes = $__attributesOriginalfad345ba8e9885f75fe8edddaef3cd8c; ?>
<?php unset($__attributesOriginalfad345ba8e9885f75fe8edddaef3cd8c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfad345ba8e9885f75fe8edddaef3cd8c)): ?>
<?php $component = $__componentOriginalfad345ba8e9885f75fe8edddaef3cd8c; ?>
<?php unset($__componentOriginalfad345ba8e9885f75fe8edddaef3cd8c); ?>
<?php endif; ?>
    
    <?php echo app('Illuminate\Foundation\Vite')([
            'public/css/bootstrap.min.css',
            'public/css/fonts.css',
            'public/css/icomoon/style.css',
            'public/css/select2.min.css',
            'public/css/splide.min.css',
        ]); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/main.css')); ?>">
   
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

    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/rtl.css')); ?>">
    <?php endif; ?>

    <?php if( !empty(setting('_scripts_styles.header_scripts')) ): ?>
        <?php echo setting('_scripts_styles.header_scripts'); ?>

    <?php endif; ?>

    <?php if( !empty(setting('_scripts_styles.custom_styles')) ): ?>
        <style><?php echo html_entity_decode(setting('_scripts_styles.custom_styles')); ?></style>
    <?php endif; ?>
     
</head>

<body class="am-bodywrap <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> am-rtl <?php endif; ?>">
    <?php if (isset($component)) { $__componentOriginale280ba8d55bbd76e5ea71c9ba0fc94c5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale280ba8d55bbd76e5ea71c9ba0fc94c5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.front.header','data' => ['page' => $page?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('front.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page?? null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale280ba8d55bbd76e5ea71c9ba0fc94c5)): ?>
<?php $attributes = $__attributesOriginale280ba8d55bbd76e5ea71c9ba0fc94c5; ?>
<?php unset($__attributesOriginale280ba8d55bbd76e5ea71c9ba0fc94c5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale280ba8d55bbd76e5ea71c9ba0fc94c5)): ?>
<?php $component = $__componentOriginale280ba8d55bbd76e5ea71c9ba0fc94c5; ?>
<?php unset($__componentOriginale280ba8d55bbd76e5ea71c9ba0fc94c5); ?>
<?php endif; ?>
    <main class="am-main">
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo e($slot ?? ''); ?>

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
    <?php if (isset($component)) { $__componentOriginal3c480fe32eca01afa89706656753ba58 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c480fe32eca01afa89706656753ba58 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.front.footer','data' => ['page' => $page?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('front.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['page' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($page?? null)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c480fe32eca01afa89706656753ba58)): ?>
<?php $attributes = $__attributesOriginal3c480fe32eca01afa89706656753ba58; ?>
<?php unset($__attributesOriginal3c480fe32eca01afa89706656753ba58); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c480fe32eca01afa89706656753ba58)): ?>
<?php $component = $__componentOriginal3c480fe32eca01afa89706656753ba58; ?>
<?php unset($__componentOriginal3c480fe32eca01afa89706656753ba58); ?>
<?php endif; ?>
    <?php if(session('impersonated_name')): ?>
        <div class="am-impersonation-bar">
            <span><?php echo e(__('general.impersonating')); ?> <strong><?php echo e(session('impersonated_name')); ?></strong></span>
            <a href="<?php echo e(route('exit-impersonate')); ?>" class="am-btn"><?php echo e(__('general.exit')); ?></a>
        </div>
    <?php endif; ?>
    <?php if(auth()->guard()->check()): ?>
        <?php if(
            session('default_role_id'   . auth()->user()->id) && 
            session('active_role_id'    . auth()->user()->id) && 
            session('default_role_id'   . auth()->user()->id) != session('active_role_id' . auth()->user()->id)
        ): ?>
            <div class="am-impersonation-bar" onclick="$(this).hide()">
                <span><?php echo __('app.switched_role_message', ['role' => Str::ucfirst(auth()->user()->role)]); ?></span>
                <a href="javascript:void(0);" class="am-btn"><?php echo e(__('general.close_btn')); ?></a>
            </div>  
        <?php endif; ?>
    <?php endif; ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/splide.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/main.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            Livewire.on('remove-cart', (event) => {
                const currentRoute = '<?php echo e(request()->route()->getName()); ?>';

                const { index, cartable_id, cartable_type } = event.params;
                if (currentRoute != 'tutor-detail') {
                    fetch('/remove-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ index, cartable_id, cartable_type })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const event = new CustomEvent('cart-updated', {
                            detail: {
                                cart_data: data.cart_data,
                                total: data.total,
                                subTotal: data.subTotal,
                                discount: data.discount,
                                toggle_cart: data.toggle_cart
                            }
                        });
                        window.dispatchEvent(event);
                    } else {
                        console.error('Failed to update cart:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
                }
            });
        });
    </script>
   
    <?php if( !empty(setting('_scripts_styles.footer_scripts')) ): ?>
        <?php echo setting('_scripts_styles.footer_scripts'); ?>

    <?php endif; ?>
    <?php if (isset($component)) { $__componentOriginalbc204d82cd558584c34dbb39cec4fcc4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbc204d82cd558584c34dbb39cec4fcc4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.gdpr','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('gdpr'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbc204d82cd558584c34dbb39cec4fcc4)): ?>
<?php $attributes = $__attributesOriginalbc204d82cd558584c34dbb39cec4fcc4; ?>
<?php unset($__attributesOriginalbc204d82cd558584c34dbb39cec4fcc4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbc204d82cd558584c34dbb39cec4fcc4)): ?>
<?php $component = $__componentOriginalbc204d82cd558584c34dbb39cec4fcc4; ?>
<?php unset($__componentOriginalbc204d82cd558584c34dbb39cec4fcc4); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/layouts/frontend-app.blade.php ENDPATH**/ ?>