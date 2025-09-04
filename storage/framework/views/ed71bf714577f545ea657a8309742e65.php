<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;

?>

<div class="tb-sidebarwrapperholder">
    <aside id="tb-sidebarwrapper" class="tb-sidebarwrapper">
        <div id="tb-btnmenutoggle" class="tb-btnmenutoggle">
            <a href="javascript:void(0);"><i class="ti-pin2"></i></a>
        </div>
        <div class="tb-sidebartop">
            <strong class="am-logo">
                <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
            </strong>
            <a class="tb-icongray" href="javascript:void(0)"><i class="icon-layout"></i></a>
        </div>
        <nav id="tb-navdashboard" class="tb-navdashboard">
            <ul class="tb-siderbar-nav ">
                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $hasParentPermission = !empty($item['permission']) ? auth()->user()->can($item['permission']) : false;    
                        $allowedRoutes = $hasParentPermission
                        ? $item['routes'] 
                        : array_values(array_filter($item['routes'], function ($route) {
                            return isset($route['permission']) &&!empty($route['permission']) && auth()->user()->can($route['permission']);
                        }));     
                    ?>
                    <!--[if BLOCK]><![endif]--><?php if(count($allowedRoutes) > 0): ?> 
                        <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([ 
                            'menu-has-children' => count($allowedRoutes) > 1, 
                            'active' => in_array($activeRoute, array_column($allowedRoutes, 'route')), 
                            'tb-openmenu' => in_array($activeRoute, array_column($allowedRoutes, 'route')) && count($allowedRoutes) > 1 
                        ]); ?>">
                            <a href="<?php echo e(count($allowedRoutes) > 1 ? 'javascript:void(0);' : route($allowedRoutes[0]['route'])); ?>" class="tb-menuitm">
                                <i class="<?php echo e($item['icon']); ?>"></i>
                                <span class="tb-navdashboard__title"><?php echo e($item['title']); ?></span>
                            </a>
                
                            <!--[if BLOCK]><![endif]--><?php if(count($allowedRoutes) > 0 && count($item['routes']) > 1): ?>
                                <ul class="sidebar-sub-menu" style="display:<?php echo e(in_array($activeRoute, array_column($allowedRoutes, 'route')) ? 'block' : ''); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $allowedRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php echo e(request()->routeIs($route['route']) ? 'active' : ''); ?>">
                                            <a href="<?php echo e(route($route['route'])); ?>">
                                                <span class="tb-navdashboard__title"><?php echo e($route['title']); ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </ul>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </li>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                
                <!--[if BLOCK]><![endif]--><?php if(auth()->user()->can('view_disputes')): ?> 
                    <li class="<?php echo e(request()->routeIs('admin.disputes') || request()->routeIs('admin.manage-dispute') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('admin.disputes')); ?>" class="tb-menuitm">
                            <i class="icon-alert-triangle"></i>
                            <span class="tb-navdashboard__title"><?php echo e(__('sidebar.disputes')); ?></span>
                        </a>
                    </li>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </ul>
            <div class="admin-sidebar-footer">
                <?php if(auth()->user()->can('can-manage-insights')): ?>
                    <div class="am-wallet">
                        <div class="am-wallet_title">
                            <span class="am-wallet_title_icon">
                                <i class="icon-dollar-sign"></i>
                            </span>
                            <div class="am-wallet_balance">
                                <strong><?php echo formatAmount($totalCommission, true); ?><span><?php echo e(__('general.total_commission')); ?></span></strong>
                            </div>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div class="am-signout">
                    <a href="javascript:void(0)" wire:click="logout" class="tb-haslogout tb-menuitm">
                        <i class="ti-power-off"></i><span class="tb-navdashboard__title"> <?php echo e(__('sidebar.logout')); ?></span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:initialized', function() {
        document.addEventListener('update_image', (event) => {
            $('#adminImage img').attr('src', event.detail.image);
        });
     })
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/admin/sidebar.blade.php ENDPATH**/ ?>