<div class="am-sidebar">
    <div class="am-sidebar_logo">
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
        <div class="am-sidebar_toggle">
            <a href="javascript:void(0);">
                <i class="am-icon-dashbard"></i>
            </a>
        </div>
    </div>
    <nav class="am-navigation">
        <ul>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!--[if BLOCK]><![endif]--><?php if(in_array($role, $item['accessibility'])): ?>
                <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                    'am-active-nav' => in_array($activeRoute, $item['onActiveRoute']),
                    'sidebar-sub-menu' => !empty($item['children'])
                ]); ?>">
                    <!--[if BLOCK]><![endif]--><?php if(!empty($item['route'])): ?>
                        <a href="<?php echo e(route($item['route'])); ?>" <?php echo e(empty($item['disableNavigate'])  ? 'wire:navigate.remove' : ''); ?>>
                            <?php echo $item['icon']; ?>

                            <?php echo e($item['title']); ?>

                        </a>
                    <?php else: ?>
                        <a href="#" <?php echo e(empty($item['disableNavigate'])  ? 'wire:navigate.remove' : ''); ?>>
                            <?php echo $item['icon']; ?>

                            <?php echo e($item['title']); ?>

                        </a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    
                    <!--[if BLOCK]><![endif]--><?php if(!empty($item['children'])): ?>
                        <ul class="am-submenu">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $item['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                <li <?php if(Route::currentRouteName() == $child['route']): ?> class="am-active" <?php endif; ?>>
                                    <a href="<?php echo e(route($child['route'])); ?>" <?php echo e(empty($child['disableNavigate'])  ? 'wire:navigate.remove' : ''); ?>>
                                        <?php echo e($child['title']); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </li>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </ul>
    </nav>
    <div class="am-navigation_footer">
        <div class="am-wallet">
            <div class="am-wallet_title">
                <span class="am-wallet_title_icon">
                    <i class="am-icon-invoices-01-5"></i>
                </span>
                <div class="am-wallet_balance">
                    <strong><?php echo formatAmount($balance, true); ?><span><?php echo e(__('general.wallet_balance')); ?></span></strong>
                </div>
            </div>
            <a href="javascript:void(0);" wire:click="openModel"  class="am-wallet_withdraw">
                <?php echo e(__('general.withdraw_now')); ?>

            </a>
        </div>
        <div class="am-signout" wire:click="logout">
            <a href="javascript:void(0);" class="am-signout_nav">
                <i class="am-icon-sign-out-02"></i>
                <?php echo e(__('general.sign_out')); ?>

            </a>
        </div>
    </div>
    <div wire:ignore.self class="modal fade am-setuppayoneerpopup" id="amount" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2><?php echo e(__('tutor.setup_payoneer_account',['payout_method' => ucfirst($userPayoutMethod?->payout_method)])); ?></h2>
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <figure class="am-setup_img">
                        <img src="<?php echo e(asset('images/account-info-bg.png')); ?>" alt="img description">
                        <figcaption class="am-setup_img_content">
                            <span><?php echo e(ucfirst($userPayoutMethod?->payout_method)); ?></span>
                            <figure class="am-setup_img_icon">
                                <!--[if BLOCK]><![endif]--><?php if($userPayoutMethod?->payout_method == 'paypal'): ?>
                                    <img src="<?php echo e(asset('images/paypal.svg')); ?>" alt="img description">
                                <?php elseif($userPayoutMethod?->payout_method == 'payoneer'): ?>
                                    <img src="<?php echo e(asset('images/payoneer.svg')); ?>" alt="img description">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </figure>
                        </figcaption>
                    </figure>
                    <form class="am-themeform">
                        <fieldset>
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('amount')]); ?>">
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'amount','class' => 'am-important','value' => __('tutor.withdraw_amount')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'amount','class' => 'am-important','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('tutor.withdraw_amount'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                <div class="am-maxamount">
                                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'amount','wire:model' => 'amount','name' => 'amount','placeholder' => ''.e(__('tutor.withdraw_amount')).'','type' => 'text']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'amount','wire:model' => 'amount','name' => 'amount','placeholder' => ''.e(__('tutor.withdraw_amount')).'','type' => 'text']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'maxamount','value' => __('tutor.max_limit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'maxamount','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('tutor.max_limit'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <span><?php echo e(number_format((float) $balance * (float) getExchangeRate(), 2, ".", ",")); ?></span>
                                </div>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'amount']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'amount']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>
                            <div class="form-group am-form-btns">
                                <button wire:target="addWithdarwals" wire:loading.class="am-btn_disable" wire:click="addWithdarwals" type="button" class="am-btn"><?php echo e(__('tutor.save_update')); ?></button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        jQuery(document).on('click', '.am-sidebar_toggle', function() {
           jQuery('.am-sidebar').toggleClass('am-togglesidebar');
        });
        jQuery(document).on('click', '.am-sidebar_toggle', function() {
           jQuery('.am-mainwrap').toggleClass('am-mainwrap_fullwidth');
        });
    });
</script><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/common/navigation.blade.php ENDPATH**/ ?>