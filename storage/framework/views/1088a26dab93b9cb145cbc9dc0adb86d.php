<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> dir="rtl" <?php endif; ?>>
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
        ]); ?>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/main.css')); ?>">
        <?php echo $__env->yieldPushContent('styles'); ?>
        <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/rtl.css')); ?>">
        <?php endif; ?>
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('livewire-ui-spotlight');

$__html = app('livewire')->mount($__name, $__params, 'lw-2677658177-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    </head>
    <body class="font-sans antialiased <?php if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ): ?> am-rtl <?php endif; ?>"
        x-data="{ isDragging: false }"
        x-on:dragover.prevent="isDragging = true"
        x-on:drop="isDragging = false">
        <div class="am-dashboardwrap">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.common.navigation', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2677658177-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            <div class="am-mainwrap">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('header.header', []);

$__html = app('livewire')->mount($__name, $__params, 'lw-2677658177-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                <!-- Page Content -->
                <main class="am-main">
                    <div class="am-dashboard_box">
                        <div class="am-dashboard_box_wrap">
                            <?php echo $__env->yieldContent('content'); ?>
                            <?php echo e($slot ?? ''); ?>

                             <?php if(
                                setting('_api.active_conference') == 'google_meet' && 
                                empty(isCalendarConnected(Auth::user())) && 
                                !request()->routeIs(auth()->user()->role. '.profile.account-settings')
                             ): ?>
                                <div class="am-connect_google_calendar">
                                    <div class="am-connect_google_calendar_title">
                                        <figure>
                                            <img src="<?php echo e(asset('images/calendar.png')); ?>" alt="Image">
                                        </figure>
                                        <h4><?php echo e(__('passwords.connect_google_calendar')); ?></h4>
                                        <i class="am-icon-multiply-02" @click="jQuery('.am-connect_google_calendar').remove()"></i>
                                    </div>
                                    <p> <?php echo e(__('calendar.'.auth()->user()->role.'_calendar_alert_msg')); ?></p>
                                    <a href="<?php echo e(route(auth()->user()->role.'.profile.account-settings')); ?>" class="am-btn"><?php echo e(__('general.connect')); ?></a>
                                </div>
                            <?php endif; ?>   
                        </div>
                    </div>
                </main>
            </div>
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
        </div>
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
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/select2.min.js')); ?>"></script>
        <script defer src="<?php echo e(asset('js/main.js')); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
        <?php if(showAIWriter()): ?>
            <?php if (isset($component)) { $__componentOriginalc3f41cc696162cc94b0576cd383c52b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc3f41cc696162cc94b0576cd383c52b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.open_ai','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('open_ai'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc3f41cc696162cc94b0576cd383c52b4)): ?>
<?php $attributes = $__attributesOriginalc3f41cc696162cc94b0576cd383c52b4; ?>
<?php unset($__attributesOriginalc3f41cc696162cc94b0576cd383c52b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3f41cc696162cc94b0576cd383c52b4)): ?>
<?php $component = $__componentOriginalc3f41cc696162cc94b0576cd383c52b4; ?>
<?php unset($__componentOriginalc3f41cc696162cc94b0576cd383c52b4); ?>
<?php endif; ?>
        <?php endif; ?>
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
    </body>
</html>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/layouts/app.blade.php ENDPATH**/ ?>