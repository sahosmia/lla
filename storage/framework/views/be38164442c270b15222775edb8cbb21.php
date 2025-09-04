<main class="tb-main am-dispute-system>
    <div class ="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('general.all_requests') .' ('. $requests->total() .')'); ?></h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="filter_request" data-wiremodel="filter_request">
                                            <option value =""> <?php echo e(__('general.all')); ?> </option>
                                            <option value ="pending"> <?php echo e(__('general.pending')); ?> </option>
                                            <option value ="processed"> <?php echo e(__('general.processed_payment')); ?> </option>
                                            <option value ="complete"> <?php echo e(__('general.completed')); ?> </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="sortby" data-wiremodel="sortby">
                                            <option value="asc"><?php echo e(__('general.asc')); ?></option>
                                            <option value="desc"><?php echo e(__('general.desc')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2 form-control" data-searchable="false" data-live='true' id="per_page" data-wiremodel="per_page">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $per_page_opt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($opt); ?>"><?php echo e($opt); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.debounce.500ms="search_request"  autocomplete="off" placeholder="<?php echo e(__('general.search')); ?>">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <!--[if BLOCK]><![endif]--><?php if( !$requests->isEmpty() ): ?>
                        <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('#' )); ?></th>
                                    <th><?php echo e(__( 'general.name' )); ?></th>
                                    <th><?php echo e(__('general.date' )); ?></th>
                                    <th><?php echo e(__('general.withdraw_amount' )); ?></th>
                                    <th><?php echo e(__('general.payout_type' )); ?></th>
                                    <th><?php echo e(__('general.status')); ?></th>
                                    <th><?php echo e(__('general.account_detail' )); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($single->id); ?></span></td>
                                        <td data-label="<?php echo e(__( 'general.name' )); ?>"><span><?php echo $single->User->full_name; ?></span></td>
                                        <td data-label="<?php echo e(__('general.date' )); ?>"><span><?php echo e(date($date_format, strtotime( $single->created_at ))); ?></span></td>
                                        <td data-label="<?php echo e(__('general.withdraw_amount' )); ?>"><span><?php echo e(formatAmount($single->amount)); ?></span></td>
                                        <td data-label="<?php echo e(__('general.payout_type' )); ?>">
                                            <!--[if BLOCK]><![endif]--><?php if($single->payout_method == 'escrow'): ?>
                                                <span><?php echo e(__('billing_info.escrow')); ?></span>
                                            <?php elseif($single->payout_method == 'paypal'): ?>
                                                <span><?php echo e(__('billing_info.paypal')); ?></span>
                                            <?php elseif($single->payout_method == 'payoneer'): ?>
                                                <span><?php echo e(__('billing_info.payoneer')); ?></span>
                                            <?php elseif($single->payout_method == 'bank'): ?>
                                                <span><?php echo e(__('billing_info.bank')); ?></span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </td>
                                        <td data-label="<?php echo e(__('general.status')); ?>">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag <?php echo e($single->status == 'pending' ? 'tk-fixed-tag' : 'tk-hourly-tag'); ?>"><?php echo e($single?->status); ?></em>
                                            </div>
                                        </td>
                                        <td data-label="<?php echo e(__('general.account_detail' )); ?>">
                                            <ul class="tb-action-status">
                                                <li>
                                                    <!--[if BLOCK]><![endif]--><?php if( $single->status == 'pending' ): ?>
                                                    <span class="tb-unapproved">
                                                        <a href="javascript:;"  @click="$wire.dispatch('showConfirm', { id : <?php echo e($single->id); ?>, action : 'approve-request' })"><i class="fas fa-check"></i><?php echo e(__('general.approve')); ?></a>
                                                    </span>
                                                    <?php else: ?>
                                                        <span class="tb-approved"><i class="fas fa-check"></i><?php echo e(__('general.approved')); ?></span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </li>
                                                <li>
                                                    <a href="javascript:;" wire:click.prevent="accountInfo(<?php echo e($single->id); ?>)" target="_blank" ><i class="icon-eye"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                        <?php echo e($requests->links('pagination.custom')); ?>

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

    <div wire:ignore.self class="modal fade tb-addonpopup" id="account-info-modal"  data-bs-backdrop="static">
        <div class="modal-dialog tb-modaldialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="tb-popuptitle">
                    <!--[if BLOCK]><![endif]--><?php if( $payment_method == 'escrow' ): ?>
                        <h4> <?php echo e(__('billing_info.escrow_acc_info')); ?> </h4>
                    <?php elseif( $payment_method == 'paypal' ): ?>
                        <h4> <?php echo e(__('billing_info.paypal_info')); ?> </h4>
                    <?php elseif( $payment_method == 'payoneer' ): ?>
                        <h4> <?php echo e(__('billing_info.payoneer_acc_info')); ?> </h4>
                    <?php elseif( $payment_method == 'bank'  ): ?>
                        <h4> <?php echo e(__('billing_info.bank_acc_info')); ?> </h4>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                </div>
                <div class="modal-body">
                    <ul class="tb-userinfo">

                        <!--[if BLOCK]><![endif]--><?php if( $payment_method == 'escrow' ): ?>
                            <li>
                                <span><?php echo e(__('general.email')); ?>:</span>
                                <h6><?php echo e($account_info['escrow_email']); ?></h6>
                            </li>
                        <?php elseif( $payment_method == 'paypal' ): ?>
                            <li>
                                <span><?php echo e(__('general.email')); ?>:</span>
                                <h6><?php echo e($account_info[0]['email']); ?></h6>
                            </li>
                        <?php elseif( $payment_method == 'payoneer'  ): ?>
                            <li>
                                <span><?php echo e(__('general.email')); ?>:</span>
                                <h6><?php echo e($account_info[0]['email']); ?></h6>
                            </li>
                        <?php elseif( $payment_method == 'bank' ): ?>
                            <li>
                                <span><?php echo e(__('billing_info.account_title')); ?>:</span>
                                <h6><?php echo e($account_info['title']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.account_number')); ?>:</span>
                                <h6><?php echo e($account_info['account_number']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.bank_name')); ?>:</span>
                                <h6><?php echo e($account_info['bank_name']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.routing_number')); ?>:</span>
                                <h6><?php echo e($account_info['bank_routing_number']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.bank_iban')); ?>:</span>
                                <h6><?php echo e($account_info['bank_iban']); ?></h6>
                            </li>
                            <li>
                                <span><?php echo e(__('billing_info.bank_bic_swift')); ?>:</span>
                                <h6><?php echo e($account_info['bank_btc']); ?></h6>
                            </li>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
<Script>
    document.addEventListener('openModal', (e) => {
        setTimeout(() => {
            $('#account-info-modal').modal('show');
        }, 500);
    });
</Script><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/admin/payments/withdraw-request.blade.php ENDPATH**/ ?>