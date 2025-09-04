<div class="am-checkout_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-checkout_title">
                    <?php $__env->slot('title'); ?>
                        <?php echo e(__('thank_you.thank_you_page')); ?>

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
                   <h2><?php echo e(__('thank_you.thank_you')); ?></h2>
                   <p><?php echo e(__('thank_you.you_successfully_submitted')); ?></p>
                   <ul class="am-checkout_steptab">
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            <?php echo e(__('thank_you.select_best_tutor')); ?>

                        </li>
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            <?php echo e(__('thank_you.add_checkout_details')); ?>

                        </li>
                        <li class="am-checkout_steptab_checked">
                            <span><i class="am-icon-user-05"></i> <em class="am-checkicon"><i class="am-icon-check-circle03"></i></em> </span>
                            <?php echo e(__('thank_you.You_done')); ?>

                        </li>
                   </ul>
               </div>
            </div>
            <div class="col-12 col-xl-10 offset-xl-1">
                <div class="am-checkout_box">
                    <div class="am-checkout_methods">
                        <div class="am-reschudle-header am-order-confirmed">
                            <span>
                                <i class="am-icon-check-circle06"></i>
                            </span>
                            <h1><?php echo e(__('thank_you.thank_You_for_your_order')); ?>

                                <strong><?php echo e(__('thank_you.order_reference',['id' => $orderId])); ?></strong>
                            </h1>
                        </div>
                        <div class="am-checkout_perinfo">
                            <p><?php echo __('thank_you.thanks_detail'); ?></p> 
                        </div>
                        <div class="am-checkout-details">
                            <a href="<?php echo e(auth()->user()->role == 'student' ? route('student.bookings') : route('tutor.invoices')); ?>" class="am-btn"><?php echo e(__('thank_you.continue_profile')); ?></a>
                        </div>
                    </div>
                    <div class="am-ordersummary">
                        <div class="am-ordersummary_title">
                            <h3><?php echo e(__('thank_you.order_summary')); ?></h3>
                        </div>
                        <ul class="am-ordersummary_list">
                            <?php
                                $discount = 0;
                                $total = 0;
                            ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orderItem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <figure class="am-ordersummary_list_img">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($item->options['image']) && Storage::disk(getStorageDisk())->exists($item->options['image'])): ?>
                                        <img src="<?php echo e(resizedImage($item->options['image'],34,34)); ?>" alt="<?php echo e($item->options['image']); ?>" />
                                    <?php else: ?>
                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="default avatar" />
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </figure>
                                <div class="am-ordersummary_list_title">
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-ordersummary_list_info','am-w-full' => (!\Nwidart\Modules\Facades\Module::has('kupondeal') || \Nwidart\Modules\Facades\Module::isDisabled('kupondeal'))]); ?>">
                                        <!--[if BLOCK]><![endif]--><?php if($item->orderable_type == 'App\Models\SlotBooking'): ?>
                                            <span><?php echo e($item->options['session_time']); ?></span>
                                            <h3><a href="javascript:void(0);"><?php echo e($item->title); ?></a></h3>
                                            <span><?php echo e($item->options['subject_group']); ?></span>
                                        <?php elseif($item->orderable_type == 'Modules\Courses\Models\Course'): ?>
                                            <span><?php echo e($item->options['sub_category']); ?></span>
                                            <h3><a href="javascript:void(0);"><?php echo e(Str::ucfirst($item->title)); ?></a></h3>
                                        <?php elseif($item->orderable_type == 'Modules\Subscriptions\Models\Subscription'): ?>
                                            <span><?php echo e($item->options['period']); ?></span>
                                            <h3><a href="javascript:void(0);"><?php echo e($item->title); ?></a></h3>
                                        <?php elseif($item->orderable_type == 'Modules\CourseBundles\Models\Bundle'): ?>
                                            <span><?php echo e(__('coursebundles::bundles.course_bundle')); ?></span>
                                            <h3><a href="javascript:void(0);"><?php echo e(Str::ucfirst($item->title)); ?></a></h3>    
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="am-ordersummary_list_action">
                                        <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($item->discount_amount)): ?>
                                            <div class="am-ordersummary-discount">
                                                <strike><?php echo formatAmount($item->price, true); ?></strike>
                                                <strong>
                                                    <?php echo formatAmount(($item->price - ($item->discount_amount ?? 0)), true); ?>

                                                    <span>
                                                        <!--[if BLOCK]><![endif]--><?php if($item['cartable_type'] == 'App\Models\SlotBooking'): ?>
                                                            <span>/<?php echo e(__('checkout.session')); ?></span>
                                                        <?php elseif($item['cartable_type'] == 'Modules\Courses\Models\Course'): ?>
                                                            <span><?php echo e(__('tutor.per_course')); ?></span>
                                                        <?php elseif($item['cartable_type'] == 'Modules\CourseBundles\Models\Bundle'): ?>
                                                            <span><?php echo e(__('coursebundles::bundles.per_bundle')); ?></span>                                                                
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </span>
                                                </strong>
                                            </div>
                                        <?php else: ?>
                                            <strong><?php echo formatAmount($item->price, true); ?><span>
                                                <!--[if BLOCK]><![endif]--><?php if($item->orderable_type == 'Modules\Courses\Models\Course'): ?>
                                                    /<?php echo e(__('courses::courses.course')); ?>

                                                <?php elseif($item->orderable_type == 'App\Models\SlotBooking'): ?>
                                                    /<?php echo e(__('checkout.session')); ?>

                                                <?php elseif($item->orderable_type == 'Modules\CourseBundles\Models\Bundle'): ?>
                                                    <?php echo e(__('coursebundles::bundles.per_bundle')); ?>

                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </span></strong>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </li>
                            <?php
                                if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')){
                                    $discount += $item->discount_amount ?? 0;
                                    $total += ($item->price - ($item->discount_amount ?? 0));
                                }
                            ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                        <ul class="am-ordersummary_price">
                            <li>
                                <span><?php echo e(__('thank_you.subtotal')); ?></span>
                                <strong><?php echo formatAmount($orderItem[0]->total, true); ?></strong>
                            </li>
                            <?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && $discount > 0): ?>
                                <li>
                                    <span><?php echo e(__('general.discount')); ?></span>
                                    <strong><?php echo formatAmount($discount, true); ?></strong>
                                </li>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <li class="am-ordersummary_price_total">
                                <span><?php echo e(__('thank_you.grand_total')); ?></span>
                                <strong><?php echo formatAmount(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') ? $total : $orderItem[0]->total, true); ?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/frontend/thank-you.blade.php ENDPATH**/ ?>