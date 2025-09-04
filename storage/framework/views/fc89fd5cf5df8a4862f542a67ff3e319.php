<main class="tb-main am-dispute-system am-enrollment-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('courses::courses.course_enrolments') .' ('. $orders->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
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
                        <table class="table tb-table tb-dbholder <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('courses::courses.id')); ?></th>
                                    <th><?php echo e(__('courses::courses.transaction_id')); ?></th>
                                    <th><?php echo e(__('courses::courses.course_title')); ?></th>
                                    <th><?php echo e(__('courses::courses.student_name')); ?></th>
                                    <th><?php echo e(__('courses::courses.tutor_name')); ?></th>
                                    <th><?php echo e(__('courses::courses.amount')); ?></th>
                                    <th><?php echo e(__('courses::courses.tutor_payout')); ?></th>
                                    <th><?php echo e(__('courses::courses.status')); ?></th>
                                    <th><?php echo e(__('courses::courses.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                      
                                       $options = $order?->options ?? [];
                                       $courseTitle = $options['title'] ?? '';
                                       $image = $options['image'] ?? '';
                                       $tutor_payout = $order?->price - getCommission($order?->price);
                                    ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('courses::courses.id')); ?>"><span><?php echo e($order?->order_id); ?></span></td>
                                        <td data-label="<?php echo e(__('courses::courses.transaction_id')); ?>"><span><?php echo e($order?->orders?->transaction_id); ?></span></td>
                                        <td data-label="<?php echo e(__('courses::courses.course_title' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($image) && Storage::disk(getStorageDisk())->exists($image)): ?>
                                                        <img src="<?php echo e(resizedImage($image,34,34)); ?>" alt="<?php echo e($image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
    
                                                <span><?php echo e($order?->orderable?->title); ?><br>
                                                    <small><?php echo e($order->orderable?->category?->name ?? ''); ?></small>
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.student_name' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orders?->userProfile?->image) && Storage::disk(getStorageDisk())->exists($order?->orders?->userProfile?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($order?->orders?->userProfile?->image,34,34)); ?>" alt="<?php echo e($order?->orders?->userProfile?->image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->student?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <span><?php echo e($order?->orders?->userProfile?->full_name); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.tutor_name' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                   
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orderable?->instructor->profile?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->instructor->profile?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($order?->orderable?->instructor->profile?->image,34,34)); ?>" alt="<?php echo e($order?->orderable?->instructor->profile?->image); ?>" />
                                                    <?php else: ?> 
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($order?->orderable?->instructor->profile?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <span><?php echo e($order?->orderable?->instructor->profile?->full_name); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.amount')); ?>">
                                            <span><?php echo formatAmount($order?->price); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.tutor_payout')); ?>">
                                            <span><?php echo formatAmount($tutor_payout); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.status' )); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag <?php echo e($order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($order?->orders?->status); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('courses::courses.course_enrolments_detail')); ?>">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-custom-tooltip">
                                                        <span class="am-tooltip-text"><?php echo e(__('courses::courses.view_details')); ?></span>
                                                        <a href="<?php echo e(route('courses.course-detail', ['slug' => $order->orderable->slug])); ?>" target="_blank">
                                                            <i class="icon-eye"></i>
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>
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
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/admin/course-enrollments.blade.php ENDPATH**/ ?>