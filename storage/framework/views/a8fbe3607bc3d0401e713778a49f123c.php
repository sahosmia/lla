<div class="am-dbbox am-invoicelist_wrap am-dispute-system" wire:init="loadData">
    <!--[if BLOCK]><![endif]--><?php if($isLoading): ?>
        <?php echo $__env->make('skeletons.invoices', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <div class="am-dbbox_content am-invoicelist">
            <div class="am-dbbox_title">
                <?php $__env->slot('title'); ?>
                    <?php echo e(__('invoices.invoices')); ?>

                <?php $__env->endSlot(); ?>
                <h2><?php echo e(__('invoices.invoices')); ?></h2>
                <div class="am-dbbox_title_sorting">
                    <em><?php echo e(__('invoices.filter_by')); ?></em>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="status"
                            data-wiremodel="status">
                            <option value="" <?php echo e($status == '' ? 'selected' : ''); ?>><?php echo e(__('invoices.all_invoices')); ?></option>
                            <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?>><?php echo e(__('invoices.pending')); ?></option>
                            <option value="complete" <?php echo e($status == 'complete' ? 'selected' : ''); ?>><?php echo e(__('invoices.complete')); ?></option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <table class="am-table <?php if(setting('_general.table_responsive') == 'yes'): ?> am-table-responsive <?php endif; ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('booking.id')); ?></th>
                                <th><?php echo e(__('booking.date')); ?></th>
                                <th><?php echo e(__('booking.transaction_id')); ?></th>
                                <th><?php echo e(__('general.item' )); ?></th>
                                <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
                                    <th><?php echo e(__('booking.student_name')); ?></th>
                                    <th><?php echo e(__('booking.amount')); ?></th>
                                    <th><?php echo e(__('booking.net_payout')); ?></th>
                                <?php elseif(auth()->user()->role == 'student'): ?>
                                    <th><?php echo e(__('booking.tutor_name')); ?></th>
                                    <th><?php echo e(__('booking.amount')); ?></th>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee'))): ?>
                                        <th><?php echo e(setting('_platform_fee.platform_fee_title')); ?></th>
                                    <?php else: ?>
                                        <th><?php echo e(__('booking.platform_fee')); ?></th>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <th>
                                    <div class="am-status-action">
                                        <span><?php echo e(__('booking.status')); ?></span>
                                        <span><?php echo e(__('booking.action')); ?></span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--[if BLOCK]><![endif]--><?php if(!$orders->isEmpty()): ?>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $options        = $order?->options;
                                        $subject        = !empty($options['subject']) ? $options['subject'] : '';
                                        $image          = !empty($options['image']) ? $options['image'] : '';
                                        $subjectGroup   = !empty($options['subject_group']) ? $options['subject_group'] : '';
                                        $orderTotal     = is_numeric($order?->total) ? $order?->total : 0;
                                        $commission     = is_numeric(getCommission($orderTotal)) ? getCommission($orderTotal) : 0;
                                        $tutor_payout   = !empty($options['tutor_payout']) && is_numeric($options['tutor_payout']) ? $options['tutor_payout'] : ($orderTotal - $commission);
                                    ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('booking.id')); ?>"><span><?php echo e($order?->order_id); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.date')); ?>"><span><?php echo e($order?->created_at->format('F j, Y')); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.transaction_id')); ?>"><span><?php echo e(!empty($order?->orders?->transaction_id) ? $order?->orders?->transaction_id : '-'); ?></span></td>
                                        <td data-label="<?php echo e(__('general.item' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($image) && Storage::disk(getStorageDisk())->exists($image)): ?>
                                                        <img src="<?php echo e(resizedImage($image,34,34)); ?>" alt="<?php echo e($image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(resizedImage('placeholder.png',34,34)); ?>" alt="<?php echo e($image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <!--[if BLOCK]><![endif]--><?php if($order->orderable_type == App\Models\SlotBooking::class): ?>
                                                    <span><?php echo e($subject); ?><small><?php echo e($subjectGroup); ?></small></span>
                                                <?php elseif($order->orderable_type == \Modules\Courses\Models\Course::class && !empty($options['title'])): ?>
                                                    <span><?php echo e($options['title']); ?></span>
                                                <?php elseif(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && $order->orderable_type == 'Modules\Subscriptions\Models\Subscription'): ?>
                                                    <span><?php echo e($order->options['name']); ?> <small><?php echo e(__($order->options['period'])); ?></small></span>
                                                <?php elseif(\Nwidart\Modules\Facades\Module::has('courseBundles') && \Nwidart\Modules\Facades\Module::isEnabled('courseBundles') && $order->orderable_type == 'Modules\CourseBundles\Models\Bundle'): ?>
                                                    <span><?php echo e($order->options['title']); ?></span>    
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </td>
                                        <?php if(auth()->user()->role == 'student'): ?>
                                            <td data-label="<?php echo e(__('booking.tutor_name' )); ?>">
                                                <div class="tb-varification_userinfo">
                                                    <!--[if BLOCK]><![endif]--><?php if($order?->orderable_type == \Modules\Courses\Models\Course::class): ?>
                                                        <strong class="tb-adminhead__img">
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orderable?->instructor?->profile?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->instructor?->profile?->image)): ?>
                                                            <img src="<?php echo e(resizedImage($order?->orderable?->instructor?->profile?->image,34,34)); ?>" alt="<?php echo e($order?->orderable?->instructor?->profile?->image); ?>" />
                                                            <?php else: ?>
                                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->instructor?->profile?->image); ?>" />
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </strong>
                                                        <span><?php echo e($order?->orderable?->instructor?->profile?->first_name); ?></span>
                                                    <?php elseif($order?->orderable_type == App\Models\SlotBooking::class): ?>
                                                        <strong class="tb-adminhead__img">
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orderable?->tutor?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->tutor?->image)): ?>
                                                            <img src="<?php echo e(resizedImage($order?->orderable?->tutor?->image,34,34)); ?>" alt="<?php echo e($order?->orderable?->tutor?->image); ?>" />
                                                            <?php else: ?>
                                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->tutor?->image); ?>" />
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </strong>
                                                        <span><?php echo e($order?->orderable?->tutor?->first_name); ?></span>
                                                    <?php elseif($order?->orderable_type == \Modules\CourseBundles\Models\Bundle::class): ?>
                                                        <strong class="tb-adminhead__img">
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orderable?->instructor?->profile?->image) && Storage::disk(getStorageDisk())->exists($order?->orderable?->instructor?->profile?->image)): ?>
                                                            <img src="<?php echo e(resizedImage($order?->orderable?->instructor?->profile?->image,34,34)); ?>" alt="<?php echo e($order?->orderable?->instructor?->profile?->image); ?>" />
                                                            <?php else: ?>
                                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->instructor?->profile?->image); ?>" />
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </strong>
                                                        <span><?php echo e($order?->orderable?->instructor?->profile?->first_name); ?></span>    
                                                    <?php else: ?>
                                                        <span>-</span>    
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </td>
                                            <td data-label="<?php echo e(__('booking.amount')); ?>">
                                                <span><?php echo formatAmount($order?->orders?->amount); ?></span>
                                            </td>
                                            <td data-label="<?php echo e(__('booking.platform_fee')); ?>">
                                                <span><?php echo !empty($order?->extra_fee) ? formatAmount($order?->extra_fee) : '-'; ?></span>
                                            </td>
                                        <?php elseif(auth()->user()->role == 'tutor'): ?>
                                            <td data-label="<?php echo e(__('booking.student_name' )); ?>">
                                                <div class="tb-varification_userinfo">
                                                    <!--[if BLOCK]><![endif]--><?php if($order->orderable_type != 'Modules\Subscriptions\Models\Subscription'): ?>
                                                        <strong class="tb-adminhead__img">
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($order?->orders?->userProfile?->image) && Storage::disk(getStorageDisk())->exists($order?->orders?->userProfile?->image)): ?>
                                                            <img src="<?php echo e(resizedImage($order?->orders?->userProfile?->image,34,34)); ?>" alt="<?php echo e($order?->orders?->userProfile?->image); ?>" />
                                                            <?php else: ?>
                                                                <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->student?->image); ?>" />
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </strong>
                                                        <span><?php echo e($order?->orders?->userProfile?->first_name); ?></span>
                                                    <?php else: ?>
                                                        <span>-</span> 
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </td>
                                            <td data-label="<?php echo e(__('booking.amount')); ?>">
                                                <span><?php echo formatAmount($order?->total); ?></span>
                                            </td>
                                            <td data-label="<?php echo e(__('booking.net_payout')); ?>">
                                                <!--[if BLOCK]><![endif]--><?php if($order->orderable_type != 'Modules\Subscriptions\Models\Subscription'): ?>
                                                    <span><?php echo formatAmount($tutor_payout); ?></span>
                                                <?php else: ?>
                                                    <span>-</span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </td>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <td data-label="<?php echo e(__('booking.status' )); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag-two <?php echo e($order?->orders?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($order?->orders?->status); ?></em>
                                            </div>
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-itemdropdown">
                                                        <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                        </a>
                                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a href="<?php echo e(route('download.invoice', $order?->order_id)); ?>" target="_blank">
                                                                    <i class="am-icon-download-01"></i>
                                                                    <span><?php echo e(__('invoices.pdf')); ?></span>
                                                                </a>
                                                            </li>
                                                            <li >
                                                                <a href="#" wire:click.prevent="viewInvoice(<?php echo e($order?->order_id); ?>)">
                                                                    <i class="am-icon-eye-open-01"></i>
                                                                    <span><?php echo e(__('invoices.preview')); ?></span>
                                                                </a>
                                                            </li>
                                                        </ul>   
                                                    </div>  
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                    <!--[if BLOCK]><![endif]--><?php if($orders->isEmpty()): ?>
                    <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/payouts.png'),'title' => __('general.no_record_title'),'description' => __('general.no_records_available')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/payouts.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_record_title')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('general.no_records_available'))]); ?>
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
                    <?php else: ?>
                </div>
            </div>
            <?php echo e($orders->links('pagination.pagination')); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <!--[if BLOCK]><![endif]--><?php if(!empty($invoice)): ?>
        <div class="modal fade am-invoice-detail-modal" data-bs-backdrop="static" id="invoicedetailwModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e(__('invoices.invoice')); ?></h5>
                        <span class="am-closepopup" data-bs-dismiss="modal" aria-label="Close">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <g opacity="0.7">
                                <path d="M4 12L12 4M4 4L12 12" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                </g>
                            </svg>
                        </span>
                    </div>
                    <div class="modal-body">
                        <div class="am-invoice-container">
                            <div class="am-invoice-head">
                                <div class="am-logo-invoicedetail">
                                    <strong>
                                        <a href="#">
                                            <img src="<?php echo e($company_logo); ?>" alt="<?php echo e($company_name); ?>" />
                                        </a>
                                    </strong>
                                    <span><?php echo e(__('invoices.invoice_id')); ?> #<?php echo e($invoice?->id); ?></span>
                                </div>
                            </div>
                            <ul class="am-payment-to-from">
                                <li>
                                    <strong><?php echo e(__('invoices.company')); ?></strong>
                                    <h6>
                                        <?php echo e($company_name); ?>

                                        <em><?php echo e($company_email); ?></em>
                                    </h6>
                                    <p><?php echo e($company_address); ?></p>
                                </li>
                                <li>
                                    <strong><?php echo e(__('invoices.payment_from')); ?></strong>
                                    <h6>
                                        <?php echo e($invoice?->first_name); ?> <?php echo e($invoice?->last_name); ?>

                                        <em><?php echo e($invoice?->email); ?></em>
                                    </h6>
                                    <p> <?php echo e($invoice?->city); ?>, <?php echo e($invoice?->countryDetails?->name ?? ''); ?>, <?php echo e($invoice?->state); ?></p>
                                </li>
                            </ul>
                            <ul class="am-payment-to-from">
                                <li>
                                    <h5><?php echo e(__('invoices.payment_date')); ?></h5>
                                    <em><?php echo e($invoice?->created_at->format(setting('_general.date_format')) ?? 'd M, Y'); ?></em>
                                </li>
                                <li>
                                    <h5><?php echo e(__('invoices.transaction_id')); ?></h5>
                                    <em><?php echo e($invoice?->transaction_id ? $invoice?->transaction_id : '-'); ?></em>
                                </li>
                            </ul>
                            <div class="am-invoice-items">
                                <div class="am-items-header">
                                    <div class="am-col am-col-title"><?php echo e(__('invoices.items')); ?></div>
                                    <div class="am-col am-col-qty"><?php echo e(__('invoices.invoice_qty')); ?></div>
                                    <div class="am-col am-col-price"><?php echo e(__('invoices.invoice_price')); ?></div>
                                    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
                                        <div class="am-col am-col-netpay"><?php echo e(__('booking.net_payout')); ?></div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php if(auth()->user()->role == 'student'): ?>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee'))): ?>
                                            <div class="am-col am-col-platform_fee"><?php echo e(setting('_platform_fee.platform_fee_title')); ?></div>
                                        <?php else: ?>
                                            <div class="am-col am-col-platform_fee"><?php echo e(__('booking.platform_fee')); ?></div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="am-col am-col-discount"><?php echo e(__('invoices.amount')); ?></div>
                                </div>
                                <div class="am-items-body">
                                    <!--[if BLOCK]><![endif]--><?php if(isset($invoice) && $invoice->items): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $subTotal       = $subTotal + $item->price;
                                                $discountAmount = $discountAmount + $item?->discount_amount;
                                            ?>
                                            <div class="am-item-row">
                                                <div class="am-col am-col-title" data-label="<?php echo e(__('invoices.items')); ?>">
                                                    <?php echo e($item->title); ?>

                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($item?->options['discount_code'])): ?>
                                                        <span>Code: #<?php echo e($item?->options['discount_code']); ?></span> 
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="am-col am-col-qty" data-label="<?php echo e(__('invoices.invoice_qty')); ?>"><?php echo e($item->quantity); ?></div>
                                                <div class="am-col am-col-price" data-label="<?php echo e(__('invoices.invoice_price')); ?>">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($item?->discount_amount)): ?>
                                                        <em><?php echo e(formatAmount($item->price)); ?></em>
                                                        <?php echo e(formatAmount($item->total)); ?>

                                                    <?php else: ?>     
                                                        <?php echo e(!empty($item->extra_fee) && (auth()->user()->role == 'student') ? formatAmount($item->price + $item->extra_fee) : formatAmount($item->price)); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
                                                    <?php
                                                        $commission     = is_numeric(getCommission($item->total)) ? getCommission($item->total) : 0;
                                                        $tutor_payout   = !empty($item->options['tutor_payout']) && is_numeric($item->options['tutor_payout']) ? $item->options['tutor_payout'] : ($item->total - $commission);
                                                    ?>
                                                    <div class="am-col am-col-netpay" data-label="<?php echo e(__('booking.net_payout')); ?>"><?php echo e(formatAmount($tutor_payout)); ?></div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php if(auth()->user()->role == 'student'): ?>
                                                    <div class="am-col am-col-platform_fee" data-label="<?php echo e(__('booking.platform_fee')); ?>"><?php echo e(!empty($item->extra_fee) ? formatAmount($item->extra_fee) : '-'); ?></div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <div class="am-col am-col-discount" data-label="<?php echo e(__('invoices.amount')); ?>"><?php echo e(formatAmount($item->total)); ?></div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="am-item-row am-item-subtotal">
                                            <div class="am-col am-col-title"><strong><?php echo e(__('invoices.invoice_subtotal')); ?></strong></div>
                                            <div class="am-col am-col-qty"></div>
                                            <div class="am-col am-col-price" ></div>
                                            <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
                                                <div class="am-col am-col-netpay"></div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <div class="am-col am-col-discount"><strong><?php echo e(formatAmount($subTotal)); ?></strong></div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <div class="am-invoice-summary">
                                <h6><?php echo e(__('invoices.invoice_summary')); ?></h6>
                                <?php
                                    $grossTotal = 0;
                                    if($invoice?->items) {
                                        foreach($invoice?->items as $item) {
                                            $grossTotal += ( $item?->price - $item?->discount_amount ?? 0) * $item->quantity;
                                        }
                                    }
                                ?>
                                <div class="am-summary-row">
                                    <span class="am-label" data-label="Subtotal"><?php echo e(__('invoices.invoice_subtotal')); ?>:</span>
                                    <span class="am-value"><?php echo e(formatAmount($subTotal)); ?></span>
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($discountAmount > 0): ?>
                                    <div class="am-summary-row">
                                        <span class="am-label" data-label="Total"><?php echo e(__('invoices.invoice_discount_amount')); ?></span>
                                        <span class="am-value"><?php echo e(formatAmount($discountAmount)); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="am-summary-row">
                                    <span class="am-label" data-label="Total"><?php echo e(__('invoices.grand_total')); ?></span>
                                    <span class="am-value"><?php echo e(formatAmount($grossTotal)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo e(isset($invoice->id) ? route('download.invoice', $invoice->id) : '#'); ?>">
                            <button type="button" class="am-btn"><?php echo e(__('invoices.download_pdf')); ?></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php $__env->startPush('scripts' ); ?>
<script type="text/javascript" data-navigate-once>
    var component = '';
    document.addEventListener('livewire:navigated', function() {
            component = window.Livewire.find('<?php echo e($_instance->getId()); ?>');
    },{ once: true });
    document.addEventListener('loadPageJs', (event) => {
        component.dispatch('initSelect2', {target:'.am-select2'});
    })
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('openInvoiceModal', function(event) {
            setTimeout(() => {
                $('#invoicePreviewModal').modal('show');
                $('#invoicedetailwModal').modal('show');
            }, 500);
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/student/invoices.blade.php ENDPATH**/ ?>