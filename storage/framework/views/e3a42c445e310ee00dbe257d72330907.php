<main class="tb-main am-dispute-system am-invoice-system">
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.invoices') .' ('. $orders->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="status" data-wiremodel="status" >
                                            <option value="" <?php echo e($status == '' ? 'selected' : ''); ?> ><?php echo e(__('invoices.all_invoices')); ?></option>
                                            <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?> ><?php echo e(__('booking.pending')); ?></option>
                                            <option value="complete" <?php echo e($status == 'complete' ? 'selected' : ''); ?> ><?php echo e(__('booking.complete')); ?></option>
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
                                <th><?php echo e(__('booking.id')); ?></th>
                                <th><?php echo e(__('booking.transaction_id')); ?></th>
                                <th><?php echo e(__('booking.items')); ?></th>
                                <th><?php echo e(__('booking.student_name')); ?></th>
                                <th><?php echo e(__('booking.payment_method')); ?></th>
                                <th><?php echo e(__('booking.amount')); ?></th>
                                <th><?php echo e(__('booking.tutor_payout')); ?></th>
                                <th><?php echo e(__('booking.commission')); ?></th>
                                <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee'))): ?>
                                    <th><?php echo e(setting('_platform_fee.platform_fee_title')); ?></th>
                                <?php else: ?>
                                    <th><?php echo e(__('booking.platform_fee')); ?></th>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <th><?php echo e(__('booking.status')); ?></th>
                                <th><?php echo e(__('general.actions')); ?></th>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                       $options = $order?->options ?? [];
                                       $subject = $options['subject'] ?? '';
                                       $image   = $options['image'] ?? '';
                                    ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('booking.id')); ?>"><span><?php echo e($order?->id); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.transaction_id')); ?>"><span><?php echo e(!empty($order?->transaction_id) ? $order->transaction_id : '-'); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.items' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img tb-adminhead__session">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($order?->slot_bookings_count)): ?>
                                                        <?php echo e($order?->slot_bookings_count == 1 ? __('booking.session_count', ['count' => $order?->slot_bookings_count]) : __('booking.sessions_count', ['count' => $order?->slot_bookings_count])); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && !empty($order?->courses_count) ): ?>
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($order?->slot_bookings_count)): ?> | <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php echo e($order?->courses_count == 1 ? __('booking.course_count', ['count' => $order?->courses_count]) : __('booking.courses_count', ['count' => $order?->courses_count])); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && !empty($order?->subscriptions_count)): ?>
                                                        <?php if(!empty($order?->slot_bookings_count) || !empty($order?->courses_count)): ?> | <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php echo e($order?->subscriptions_count == 1 ? __('booking.subscription_count', ['count' => $order?->subscriptions_count]) : __('booking.subscriptions_count', ['count' => $order?->subscriptions_count])); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('coursebundles') && \Nwidart\Modules\Facades\Module::isEnabled('coursebundles') && !empty($order?->coursebundles_count)): ?>
                                                        <?php if(!empty($order?->slot_bookings_count) || !empty($order?->courses_count) || !empty($order?->subscriptions_count)): ?> | <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php echo e($order?->coursebundles_count == 1 ? __('booking.coursebundle_count', ['count' => $order?->coursebundles_count]) : __('booking.coursebundles_count', ['count' => $order?->coursebundles_count])); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.student_name' )); ?>">
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($order?->userProfile?->image) && Storage::disk(getStorageDisk())->exists($order?->userProfile?->image)): ?>
                                                    <img src="<?php echo e(resizedImage($order?->userProfile?->image,34,34)); ?>" alt="<?php echo e($order?->userProfile?->image); ?>" />
                                                    <?php else: ?>
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="<?php echo e($order?->orderable?->student?->image); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </strong>
                                                <span><?php echo e($order?->userProfile?->full_name); ?></span>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.payment_method' )); ?>">
                                            <span><?php echo e(__("settings." .$order?->payment_method. "_title")); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.amount')); ?>">
                                            <span><?php echo formatAmount($order?->amount); ?></span>
                                        </td>
                                        <?php
                                            $firstItem      = $order?->items?->first();
                                            $commission     = is_numeric(getCommission($firstItem?->total)) ? getCommission($firstItem?->total) : 0;
                                            $options        = $firstItem?->options;
                                            $tutor_payout   = !empty($options['tutor_payout']) && is_numeric($options['tutor_payout']) ? $options['tutor_payout'] : ($firstItem?->total - $commission);
                                        ?>
                                        <td data-label="<?php echo e(__('booking.tutor_payout')); ?>"><span><?php echo e(formatAmount($tutor_payout)); ?></span></td>
                                        <td data-label="<?php echo e(__('booking.commission')); ?>">
                                            <span><?php echo empty($order?->subscription_id) ? formatAmount($order?->admin_commission) : formatAmount(0); ?></span>
                                        </td>
                                        <td data-label="<?php echo e(__('booking.platform_fee')); ?>">
                                            <!--[if BLOCK]><![endif]--><?php if( !empty($order?->items?->first()?->extra_fee)): ?>
                                                <span><?php echo empty($order?->subscription_id) ? formatAmount($order?->items?->first()?->extra_fee) : formatAmount(0); ?></span>
                                            <?php else: ?>
                                                <span>-</span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->  
                                        </td>
                                        <td data-label="<?php echo e(__('booking.status' )); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag  <?php echo e($order?->status == 'complete' ? 'tk-hourly-tag' : 'tk-fixed-tag'); ?>"><?php echo e($order?->status); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.actions')); ?>">
                                            <ul class="tb-action-icon">
                                                <li>
                                                    <div class="am-itemdropdown">
                                                        <a href="#" id="am-itemdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2.62484 5.54166C1.82275 5.54166 1.1665 6.19791 1.1665 6.99999C1.1665 7.80207 1.82275 8.45832 2.62484 8.45832C3.42692 8.45832 4.08317 7.80207 4.08317 6.99999C4.08317 6.19791 3.42692 5.54166 2.62484 5.54166Z" fill="#585858"/><path d="M11.3748 5.54166C10.5728 5.54166 9.9165 6.19791 9.9165 6.99999C9.9165 7.80207 10.5728 8.45832 11.3748 8.45832C12.1769 8.45832 12.8332 7.80207 12.8332 6.99999C12.8332 6.19791 12.1769 5.54166 11.3748 5.54166Z" fill="#585858"/><path d="M5.5415 6.99999C5.5415 6.19791 6.19775 5.54166 6.99984 5.54166C7.80192 5.54166 8.45817 6.19791 8.45817 6.99999C8.45817 7.80207 7.80192 8.45832 6.99984 8.45832C6.19775 8.45832 5.5415 7.80207 5.5415 6.99999Z" fill="#585858"/></svg></i>
                                                        </a>
                                                        <ul class="am-itemdropdown_list dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                            <li>
                                                                <a href="<?php echo e(route('download.invoice', $order?->id)); ?>" target="_blank">
                                                                    <i class="icon-download"></i>
                                                                    <span><?php echo e(__('admin/general.pdf')); ?></span>
                                                                </a>
                                                            </li>
                                                            <li wire:click.prevent="viewInvoice(<?php echo e($order?->id); ?>)">
                                                                <i class="icon-eye"></i>
                                                                <span><?php echo e(__('admin/general.preview')); ?></span>
                                                            </li>
                                                        </ul>   
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

    <!-- Add Invoice detail Modal -->
    <div class="modal fade tb-invoice-detail-modal" data-bs-backdrop="static" id="invoicedetailwModal" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true" wire:ignore.self>
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
                    <div class="tb-invoice-container">
                        <div class="tb-invoice-head">
                            <div class="tb-logo-invoicedetail">
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
                                <em><?php echo e($invoice?->updated_at->format(setting('_general.date_format')) ?? 'd M, Y'); ?></em>
                            </li>
                            <li>
                                <h5><?php echo e(__('invoices.transaction_id')); ?></h5>
                                <em><?php echo e($invoice?->transaction_id ? $invoice?->transaction_id : '-'); ?></em>
                            </li>
                        </ul>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($invoice?->items)): ?>
                            <div class="tb-invoice-items">
                                <div class="tb-items-header">
                                    <div class="tb-col tb-col-title"><?php echo e(__('invoices.items')); ?></div>
                                    <div class="tb-col tb-col-qty"><?php echo e(__('invoices.invoice_qty')); ?></div>
                                    <div class="tb-col tb-col-price"><?php echo e(__('invoices.invoice_price')); ?></div>
                                    <div class="tb-col tb-col-tutorpayout"><?php echo e(__('booking.tutor_payout')); ?></div>
                                    <div class="tb-col tb-col-admincommission"><?php echo e(__('booking.commission')); ?></div>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_platform_fee.platform_fee_title')) && !empty(setting('_platform_fee.platform_fee'))): ?>
                                        <div class="tb-col tb-col-platformfee"><?php echo e(setting('_platform_fee.platform_fee_title')); ?></div>
                                    <?php else: ?>
                                        <div class="tb-col tb-col-platformfee"><?php echo e(__('booking.platform_fee')); ?></div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="tb-col tb-col-discount"><?php echo e(__('invoices.amount')); ?></div>
                                </div>
                    
                                <div class="tb-items-body">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $invoice?->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $subTotal       = $subTotal + $item->price;
                                            $discountAmount = $discountAmount + $item?->discount_amount;
                                        ?>
                                        <div class="tb-item-row">
                                            <div class="tb-col tb-col-title" data-label="<?php echo e(__('invoices.items')); ?>">
                                                <?php echo e($item->title); ?>

                                                <!--[if BLOCK]><![endif]--><?php if(!empty($item?->options['discount_code'])): ?>
                                                <span>Code: #<?php echo e($item?->options['discount_code']); ?></span> 
                                               <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <div class="tb-col tb-col-qty" data-label="<?php echo e(__('invoices.invoice_qty')); ?>"><?php echo e($item->quantity); ?></div>
                                            <div class="tb-col tb-col-price" data-label="<?php echo e(__('invoices.invoice_price')); ?>">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($item?->discount_amount)): ?>
                                                    <em><?php echo e(formatAmount($item->price)); ?></em>
                                                    <?php echo e(formatAmount($item->total)); ?>

                                                <?php else: ?>     
                                                    <?php echo e(!empty($item->extra_fee) ? formatAmount($item->price + $item->extra_fee) : formatAmount($item->price)); ?>

                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <?php
                                                $commission     = is_numeric(getCommission($item->total)) ? getCommission($item->total) : 0;
                                                $tutor_payout   = !empty($item->options['tutor_payout']) && is_numeric($item->options['tutor_payout']) ? $item->options['tutor_payout'] : ($item->total - $commission);
                                            ?>
                                            <div class="tb-col tb-col-tutorpayout" data-label="<?php echo e(__('booking.tutor_payout')); ?>"><?php echo e(formatAmount($tutor_payout)); ?></div>
                                            <div class="tb-col tb-col-admincommission" data-label="<?php echo e(__('booking.commission')); ?>"><?php echo e(formatAmount($item->platform_fee)); ?></div>
                                            <div class="tb-col tb-col-platformfee" data-label="<?php echo e(__('booking.platform_fee')); ?>">
                                              <?php echo e(!empty($item->extra_fee) ? formatAmount($item->extra_fee) : '-'); ?>

                                            </div>
                                            <div class="tb-col tb-col-discount" data-label="<?php echo e(__('invoices.amount')); ?>"><?php echo e(formatAmount($item->total)); ?></div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="tb-item-row tb-item-subtotal">
                                        <div class="tb-col tb-col-title"><strong><?php echo e(__('invoices.invoice_subtotal')); ?></strong></div>
                                        <div class="tb-col tb-col-qty"></div>
                                        <div class="tb-col tb-col-price" ></div>
                                        <div class="tb-col tb-col-tutorpayout"></div>
                                        <div class="tb-col tb-col-admincommission"></div>
                                        <div class="tb-col tb-col-platformfee"></div>
                                        <div class="tb-col tb-col-discount"><?php echo e(formatAmount($subTotal)); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="tb-invoice-summary">
                            <h6><?php echo e(__('invoices.invoice_summary')); ?></h6>
                            <?php
                                $grossTotal = 0;
                                if($invoice?->items) {
                                    foreach($invoice?->items as $item) {
                                        $grossTotal += ( $item?->price - $item?->discount_amount ?? 0) * $item->quantity;
                                    }
                                }
                            ?>
                            <div class="tb-summary-row">
                                <span class="tb-label" data-label="Subtotal"><?php echo e(__('invoices.invoice_subtotal')); ?>:</span>
                                <span class="tb-value"><?php echo e(formatAmount($subTotal)); ?></span>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($discountAmount > 0): ?>
                                <div class="tb-summary-row">
                                    <span class="tb-label" data-label="Total"><?php echo e(__('invoices.invoice_discount_amount')); ?></span>
                                    <span class="tb-value"><?php echo e(formatAmount($discountAmount)); ?></span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="tb-summary-row">
                                <span class="tb-label" data-label="Total"><?php echo e(__('invoices.grand_total')); ?></span>
                                <span class="tb-value"><?php echo e(formatAmount($grossTotal)); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo e(isset($invoice->id) ? route('download.invoice', $invoice->id) : '#'); ?>">
                        <button type="button" class="tb-btn"><?php echo e(__('invoices.download_pdf')); ?></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Invoice detail Modal -->
</main>


<?php $__env->startPush('scripts'); ?>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('openInvoiceModal', function(event) {
                setTimeout(() => {
                    $('#invoicePreviewModal').modal('show');
                    $('#invoicedetailwModal').modal('show');
                }, 500);
            });
       });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/invoices/invoices.blade.php ENDPATH**/ ?>