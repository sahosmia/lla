<main class="tb-main am-dispute-system am-booking-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_booking') .' ('. $orders->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="status" data-wiremodel="status" >
                                            <option value="" <?php echo e($status == '' ? 'selected' : ''); ?> ><?php echo e(__('booking.all_bookings')); ?></option>
                                            <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?> ><?php echo e(__('booking.pending')); ?></option>
                                            <option value="complete" <?php echo e($status == 'complete' ? 'selected' : ''); ?> ><?php echo e(__('booking.complete')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-live='true' data-searchable="true" id="subject" data-wiremodel="selectedSubject">
                                            <option value=""><?php echo e(__('booking.select_subject')); ?></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($subject->name); ?>" <?php echo e($subject->name == $selectedSubject ? 'selected' : ''); ?>><?php echo e($subject->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-live='true' data-searchable="true" id="subject_group" data-wiremodel="selectedSubGroup">
                                            <option value=""><?php echo e(__('booking.select_subject_group')); ?></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjectGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($subjectGroup->name); ?>" <?php echo e($subjectGroup->name == $selectedSubGroup ? 'selected' : ''); ?>><?php echo e($subjectGroup->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="sort_by" data-wiremodel="sortby" >
                                            <option value="asc" <?php echo e($sortby == 'asc' ? 'selected' : ''); ?> ><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc" <?php echo e($sortby == 'desc' ? 'selected' : ''); ?> ><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if( !$orders->isEmpty() ): ?>
                        <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('booking.id')); ?></th>
                                    <th><?php echo e(__('booking.transaction_id')); ?></th>
                                    <th><?php echo e(__('booking.subject')); ?></th>
                                    <th><?php echo e(__('booking.student_name')); ?></th>
                                    <th><?php echo e(__('booking.tutor_name')); ?></th>
                                    <th><?php echo e(__('booking.amount')); ?></th>
                                    <th><?php echo e(__('booking.tutor_payout')); ?></th>
                                    <th><?php echo e(__('booking.status')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                       $options = $order?->options ?? [];
                                       $subject = $options['subject'] ?? '';
                                       $image   = $options['image'] ?? '';
                                       $subjectGroup = $options['subject_group'];
                                        if (\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions')) {
                                            $tutor_payout = $options['tutor_payout'] ?? 0;
                                        } else {
                                            $tutor_payout = $order?->price - getCommission($order?->price);
                                        }
                                    ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('booking.id')); ?>"><span><?php echo e($order?->order_id); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.transaction_id')); ?>"><span><?php echo e(!empty($order?->orders?->transaction_id) ? $order?->orders?->transaction_id : '-'); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.subject' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($image) && Storage::disk(getStorageDisk())->exists($image)): ?>
                                                    <img src="<?php echo e(resizedImage($image,34,34)); ?>" alt="<?php echo e($image); ?>" />
                                                    <?php else: ?> 
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <span>
                                                    <?php echo e($subject); ?>

                                                    <a href="javascript:void(0);" class="am-custom-tooltip">
                                                        <i class="icon-alert-circle am-custom-tooltip-icon"></i>
                                                        <span class="am-tooltip-text">
                                                            <?php echo e(\Carbon\Carbon::parse($order?->orderable?->start_time)->format('F j, Y, g:i a')); ?> - <?php echo e(\Carbon\Carbon::parse($order?->orderable?->end_time)->format('g:i a')); ?>

                                                        </span>        
                                                    </a>
                                                    <small><?php echo e($subjectGroup); ?></small>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.student_name' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orderable?->student?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->student?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($order?->orderable?->student?->image,34,34)); ?>" alt="<?php echo e($order?->orderable?->student?->image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->student?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <span><?php echo e($order?->orderable?->student?->first_name . ' ' . $order->orderable?->student?->last_name); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.tutor_name' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orderable?->tutor?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->tutor?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($order?->orderable?->tutor?->image,34,34)); ?>" alt="<?php echo e($order?->orderable?->tutor?->image); ?>" />
                                                    <?php else: ?> 
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($order?->orderable?->tutor?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <span><?php echo e($order?->orderable?->tutor?->first_name); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.amount')); ?>">
                                            <span><?php echo formatAmount($order?->price); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.tutor_payout')); ?>">
                                            <span><?php echo formatAmount($tutor_payout); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.status' )); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag <?php echo e($order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($order?->orders?->status); ?></em>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                            <?php echo e($orders->links('pagination.custom')); ?>

                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/empty.png'),'title' => __('general.no_record_title')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/empty.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_title'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $attributes = $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $component = $__componentOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
    </div>
</main>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/pages/admin/bookings/bookings.blade.php ENDPATH**/ ?>