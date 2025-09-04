<main wire:loading.class="am-isloading" wire:target="removeCoupon, removeCart" class="am-main">
    <div class="am-section-load" wire:loading.flex wire:target="removeCoupon, removeCart">
        <p><?php echo e(__('general.loading')); ?></p>
    </div>
    <div class="am-checkout_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-checkout_title">
                        <?php $__env->slot('title'); ?>
                            <?php echo e(__('checkout.checkout')); ?>

                        <?php $__env->endSlot(); ?>
                        <strong class="am-checkout_logo">
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
                        <h2><?php echo e(__('checkout.you_almost_there')); ?></h2>
                        <p><?php echo e(__('checkout.fill_details_mentioned_below_purchase_courses')); ?></p>
                        <ul class="am-checkout_steptab">
                            <li class="am-checkout_steptab_checked">
                                <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                                <?php echo e(__('checkout.select_best_tutor')); ?>

                            </li>
                            <li class="am-checkout_steptab_active">
                                <span><i class="am-icon-lock-close"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em></span>
                                <?php echo e(__('checkout.add_checkout_details')); ?>

                            </li>
                            <li>
                                <span><i class="am-icon-flag-02"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em></span>
                                <?php echo e(__('checkout.you_done')); ?>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12" x-data="{
                    form:<?php if ((object) ('form') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'->value()); ?>')<?php echo e('form'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'); ?>')<?php endif; ?>,
                    charLeft:500,
                    init(){
                        this.updateCharLeft();
                    },
                    tutorInfo:{},
                    updateCharLeft() {
                        let maxLength = 500;
                        if (this.form.dec.length > maxLength) {
                            this.form.dec = this.form.dec.substring(0, maxLength);
                        }
                        this.charLeft = maxLength - this.form.dec.length;
                    }
                }">
                    <div class="am-checkout_box">
                        <div class="am-checkout_methods">
                            <div class="am-checkout_methods_title">
                                <h3><?php echo e(__('checkout.payment_methods')); ?> </h3>
                                <p><?php echo e(__('checkout.secure_and_convenient_payment_purchase')); ?></p>
                            </div>
                            <div class="am-checkout_accordion">
                                
                                <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && !empty($subscriptions)): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="accordion-item am-learner-plan">
                                            <div class="am-radiowrap">
                                                <div class="am-radio">
                                                    <input wire:model.lazy="chosenSubscription"  <?php echo e($chosenSubscription == $item->subscription_id ? 'checked' : ''); ?>  type="radio" id="payment-<?php echo e($item->subscription_id); ?>" name="payment" value=<?php echo e($item->subscription_id); ?> >
                                                    <label for="payment-<?php echo e($item->subscription_id); ?>">
                                                        <?php echo e(__('subscriptions::subscription.subscription')); ?>

                                                        <span class="am-radiowrap-img"><?php echo formatAmount($item?->price, true); ?> <em>/ <?php echo e(__('subscriptions::subscription.'.$item->subscription?->period)); ?></em></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="am-learner-plan_options">
                                                <h4><?php echo e($item->subscription?->name); ?></h4>
                                                <ul>
                                                    <li>
                                                        <span><?php echo e(__('subscriptions::subscription.max_sessions_'.auth()->user()->role)); ?></span>
                                                        <em><?php echo e($item->remaining_credits['sessions'] ?? 0); ?> <?php echo e(__('subscriptions::subscription.left')); ?></em>
                                                    </li>
                                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses')): ?>    
                                                        <li>
                                                            <span><?php echo e(__('subscriptions::subscription.max_courses_'.auth()->user()->role)); ?></span>
                                                            <em><?php echo e($item->remaining_credits['courses'] ?? 0); ?> <?php echo e(__('subscriptions::subscription.left')); ?></em>
                                                        </li>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </ul>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if(!$checkoutReady): ?>
                                <span class="am-error-msg"><?php echo __('subscriptions::subscription.not_applicable_to_cart_item', ['name' => $invalidCartItem['name'] ?? '']); ?></span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="am-checkout_perinfo">
                                <span> <i class="am-icon-lock-close"></i> </span>
                                <p><?php echo e(__('checkout.personal_data')); ?></p>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.paymentMethod']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.paymentMethod']); ?>
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
                            <form class="am-themeform am-checkout_form">
                                <fieldset>
                                    <div class="form-group">
                                        <legend><?php echo e(__('checkout.billing_details')); ?></legend>
                                    </div>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-half', 'am-invalid' => $errors->has('form.firstName')]); ?>">
                                        <input wire:model="form.firstName" type="text" class="form-control"  placeholder="Add first name">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.firstName']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.firstName']); ?>
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
                                    <div  class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-half', 'am-invalid' => $errors->has('form.lastName')]); ?>">
                                        <input wire:model="form.lastName" type="text" class="form-control"  placeholder="Add last name">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.lastName']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.lastName']); ?>
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
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.company')]); ?>" class="">
                                        <input wire:model="form.company" type="text" class="form-control"  placeholder="Add company title">
                                    </div>
                                    <div  class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-half', 'am-invalid' => $errors->has('form.email')]); ?>" class="">
                                        <input wire:model="form.email" type="text" class="form-control"  placeholder="Add email">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.email']); ?>
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
                                    <div  class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-half', 'am-invalid' => $errors->has('form.phone')]); ?>">
                                        <input wire:model="form.phone" type="text" class="form-control"  placeholder="Add phone number">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.phone']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.phone']); ?>
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
                                    <div class="form-group">
                                        <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'country','value' => __('profile.country')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'country','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('profile.country'))]); ?>
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
                                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-control_wrap', 'am-invalid' => $errors->has('form.country')]); ?>">
                                             <span class="am-select" wire:ignore>
                                                <select class="am-select2" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" data-searchable="true" id="country" data-wiremodel="form.country">
                                                    <option value=""><?php echo e(__('profile.select_a_country')); ?></option>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($item->id); ?>" <?php echo e($item->id == $form->country ? 'selected' : ''); ?> ><?php echo e($item->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </select>
                                            </span>
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.country']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.country']); ?>
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
                                    <div  class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-3half', 'am-invalid' => $errors->has('form.city')]); ?>">
                                        <input wire:model="form.city" type="text" class="form-control"  placeholder="Add town/city">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.city']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.city']); ?>
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
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-3half', 'am-invalid' => $errors->has('form.state')]); ?>">
                                        <input wire:model="form.state" type="text" class="form-control"  placeholder="Add state/country">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.state']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.state']); ?>
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
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-3half', 'am-invalid' => $errors->has('form.zipcode')]); ?>">
                                        <input wire:model="form.zipcode" type="text" class="form-control"  placeholder="Add postcode/zip">
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.zipcode']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.zipcode']); ?>
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
                                </fieldset>
                            </form>
                            <form class="am-themeform am-checkout_form">
                                <fieldset>
                                    <div class="form-group">
                                        <legend><?php echo e(__('checkout.additional_information')); ?></legend>
                                    </div>
                                    <div class="form-group">
                                        <textarea wire:model='form.dec' class="form-control" placeholder="<?php echo e(__('checkout.note_about_your_order')); ?>" x-on:input="updateCharLeft" ></textarea>
                                        <span class="am-charleft" x-text="charLeft + ' <?php echo e(__('general.char_account')); ?>'"></span>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.dec']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.dec']); ?>
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
                                    <!--[if BLOCK]><![endif]--><?php if($walletBalance): ?>
                                    <div class="form-group">
                                        <div class="am-checkbox ">
                                            <input wire:model.live="useWalletBalance" id="remember_me" type="checkbox" name="remember">
                                            <label for="remember_me">
                                                <strong><span><?php echo e(__('general.wallet_balance')); ?></span><sup><?php echo e(getCurrencySymbol()); ?></sup><?php echo e($walletBalance); ?></strong>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="form-group form-groupbtns">
                                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => \Illuminate\Support\Arr::toCssClasses(['am-btn_disabled' => !$checkoutReady]),'wire:click' => 'updateInfo','wire:target' => 'updateInfo','type' => 'button','wire:loading.class' => 'am-btn_disable']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses(['am-btn_disabled' => !$checkoutReady])),'wire:click' => 'updateInfo','wire:target' => 'updateInfo','type' => 'button','wire:loading.class' => 'am-btn_disable']); ?><?php echo e(__('checkout.pay')); ?> <?php echo formatAmount($payAmount); ?><i class="am-icon-arrow-right"></i> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($content->count() > 0): ?>
                            <div class="am-ordersummary">
                                <div class="am-ordersummary_title">
                                    <h3><?php echo e(__('checkout.order_summary')); ?></h3>
                                </div>
                                <ul class="am-ordersummary_list">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                            <figure class="am-ordersummary_list_img">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($item['options']['image']) && Storage::disk(getStorageDisk())->exists($item['options']['image'])): ?>
                                                    <img src="<?php echo e(resizedImage($item['options']['image'],34,34)); ?>" alt="<?php echo e($item['options']['image']); ?>" />
                                                <?php else: ?>
                                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="default avatar" />
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </figure>
                                            <div class="am-ordersummary_list_title">
                                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))]); ?>">
                                                    <!--[if BLOCK]><![endif]--><?php if($item['cartable_type'] == 'App\Models\SlotBooking'): ?>
                                                        <span><?php echo e($item['options']['session_time']); ?></span>
                                                        <h3><a href="javascript:void(0);"><?php echo e($item['name']); ?></a></h3>
                                                        <span><?php echo e($item['options']['subject_group']); ?></span>
                                                    <?php elseif($item['cartable_type'] == 'Modules\Courses\Models\Course'): ?>
                                                        <span><?php echo e($item['options']['sub_category']); ?></span>
                                                        <h3><a href="javascript:void(0);"><?php echo e($item['name']); ?></a></h3>
                                                    <?php elseif($item['cartable_type'] == 'Modules\Subscriptions\Models\Subscription'): ?>
                                                        <span><?php echo e($item['options']['period']); ?></span>
                                                        <h3><a href="javascript:void(0);"><?php echo e($item['name']); ?></a></h3>
                                                    <?php elseif($item['cartable_type'] == 'Modules\CourseBundles\Models\Bundle'): ?>
                                                        <span><?php echo e(__('coursebundles::bundles.course_bundle')); ?></span>
                                                        <h3><a href="javascript:void(0);"><?php echo e($item['name']); ?></a></h3>    
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="am-ordersummary_list_action">
                                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($item['discounted_total'])): ?>
                                                        <div class="am-ordersummary-discount">
                                                            <strike><?php echo formatAmount($item['price'], true); ?></strike>
                                                            <strong><?php echo $item['discounted_total']; ?><span>/<?php echo e($item['cartable_type'] == 'App\Models\SlotBooking' ? __('checkout.session')  : __('courses::courses.course')); ?></span></strong>
                                                        </div>
                                                    <?php else: ?>
                                                        <strong><?php echo formatAmount($item['price'], true); ?>

                                                            <!--[if BLOCK]><![endif]--><?php if($item['cartable_type'] == 'App\Models\SlotBooking'): ?>
                                                                <span>/<?php echo e(__('checkout.session')); ?></span>
                                                            <?php elseif($item['cartable_type'] == 'Modules\Courses\Models\Course'): ?>
                                                                <span><?php echo e(__('tutor.per_course')); ?></span>
                                                            <?php elseif($item['cartable_type'] == 'Modules\CourseBundles\Models\Bundle'): ?>
                                                                <span><?php echo e(__('coursebundles::bundles.per_bundle')); ?></span>                                                                
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </strong>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <a wire:click='removeCart(<?php echo e($item['cartable_id']); ?>, <?php echo json_encode($item['cartable_type'], 15, 512) ?>)'  href="javascript:void(0);"><?php echo e(__('checkout.remove')); ?></a>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </ul>
                                <ul class="am-ordersummary_price">
                                    <li>
                                        <span><?php echo e(__('checkout.subtotal')); ?></span>
                                        <strong><?php echo formatAmount($subTotal, true); ?></strong>
                                    </li>
                                    <!--[if BLOCK]><![endif]--><?php if( !empty($extraFee) && $extraFee > 0 && !empty(setting('_platform_fee.platform_fee_title'))): ?>
                                        <li>
                                            <span><?php echo e(setting('_platform_fee.platform_fee_title')); ?></span>
                                            <strong><?php echo formatAmount($extraFee, true); ?></strong>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && $discount > 0): ?>
                                        <li>
                                            <span><?php echo e(__('general.discount')); ?></span>
                                            <strong><?php echo formatAmount($discount, true); ?></strong>
                                        </li>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <li class="am-ordersummary_price_total">
                                        <span><?php echo e(__('checkout.grand_total')); ?></span>
                                        <strong><?php echo formatAmount($totalAmount, true); ?></strong>
                                    </li>
                                </ul>
                                <?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && $content->count() > 0): ?>
                                    <?php
                                        $cartHasCoupon = false;
                                        $appliedCoupons = [];
                                        foreach ($content as $item) {
                                            if(!empty($item['options']['discount_code']) && !empty($item['options']['discount_type']) && !empty($item['options']['discount_color']) && !empty($item['options']['discount_value'])){
                                                $cartHasCoupon = true;
                                                    break;
                                            }
                                        }
                                    ?>
                                    <div class="am-checkout_coupons">
                                        <!--[if BLOCK]><![endif]--><?php if($cartHasCoupon): ?>
                                            <div class="am-checkout_coupons_title">
                                                <h3><?php echo e(__('kupondeal::kupondeal.applied_coupon')); ?></h3>
                                            </div>
                                            <ul class="am-allcoupons_list">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $content; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <!--[if BLOCK]><![endif]--><?php if(
                                                    !in_array(($item['options']['discount_code'] ?? ''), $appliedCoupons) &&
                                                    !empty($item['discount_amount']) &&
                                                    !empty($item['options']['discount_code']) &&
                                                    !empty($item['options']['discount_type']) &&
                                                    !empty($item['options']['discount_color']) &&
                                                    !empty($item['options']['discount_value'])
                                                ): ?>
                                                    <li>
                                                        <div class="am-coupon_item">
                                                            <div class="am-coupon_header" style="background-color: <?php echo e($item['options']['discount_color']); ?>;">
                                                                <span>
                                                                    <!--[if BLOCK]><![endif]--><?php if($item['options']['discount_type'] == 'percentage'): ?>
                                                                        <?php echo e($item['options']['discount_value']); ?><sup>%</sup>
                                                                    <?php else: ?>
                                                                        <?php echo formatAmount($item['options']['discount_value'], true); ?>

                                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                    <em><?php echo e(__('general.discount')); ?></em>
                                                                </span>
                                                                <div class="am-coupon_shape" style="border-color: <?php echo e($item['options']['discount_color']); ?>"></div>
                                                            </div>
                                                            <div class="am-coupon_body" style="background-color: <?php echo e(addColorOpacity($item['options']['discount_color'])); ?>">
                                                                <h3 x-data="{ copied: false, textToCopy: '<?php echo e($item['options']['discount_code']); ?>' }">
                                                                    <em><?php echo e(__('kupondeal::kupondeal.promo_code')); ?></em>
                                                                    <?php echo e($item['options']['discount_code']); ?>

                                                                    <a href="javascript:void(0);" @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true; setTimeout(() => copied = false, 2000) }).catch(() => {})">
                                                                        <i class="am-icon-copy-01"></i>
                                                                    </a>
                                                                    <template x-if="copied">
                                                                        <span x-show="copied" x-transition><?php echo e(__('general.copied')); ?></span>
                                                                    </template>
                                                                </h3>
                                                                <!--[if BLOCK]><![endif]--><?php if($item['options']['auto_apply'] != '1'): ?>
                                                                    <a href="javascript:void(0);" class="am-removecoupon" wire:click="removeCoupon('<?php echo e($item['options']['discount_code']); ?>')"><i class="am-icon-multiply-02"></i></a>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php
                                                        if(!empty($item['options']['discount_code'])){
                                                            $appliedCoupons[] = $item['options']['discount_code'];
                                                        }
                                                    ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </ul>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="am-checkout_coupons_footer">
                                            <input type="text" wire:model="coupon" class="form-control" placeholder="<?php echo e(__('kupondeal::kupondeal.enter_coupon')); ?>">
                                            <a href="javascript:void(0);" wire:loading.class="am-btn_disable" wire:target="applyCoupon" wire:click="applyCoupon" class="am-btn"><?php echo e(__('kupondeal::kupondeal.apply')); ?></a>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['coupon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="am-error-msg"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!--[if BLOCK]><![endif]--><?php if(session()->get('error')): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.dispatch('showAlertMessage', {
            type: 'error',
            message: "<?php echo e(session()->get('error')); ?>"
        });
    });
</script>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->

<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/frontend/checkout.blade.php ENDPATH**/ ?>