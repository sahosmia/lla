<div class="am-dbbox am-payouthistory_wrap" wire:init="loadData">
    <div class="am-title_wrap">
        <div class="am-title">
            <h2><?php echo e(__('tutor.payouts_history')); ?></h2>
            <p><?php echo e(__('tutor.payouts_dec')); ?></p>
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php if($isLoading): ?>
         <?php echo $__env->make('skeletons.payout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <div class="am-dbbox_content am-payouthistory">
            <div class="am-dbbox_title">
                <h2><?php echo e(__('tutor.payouts_history')); ?></h2>
                <div class="am-dbbox_title_sorting">
                    <em><?php echo e(__('tutor.filter_by')); ?></em>
                    <span class="am-select" wire:ignore>
                        <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-live="true" class="am-select2" id="status"
                            data-wiremodel="status">
                            <option value=""><?php echo e(__('tutor.all')); ?></option>
                            <option value="pending"><?php echo e(__('tutor.pending')); ?></option>
                            <option value="declined"><?php echo e(__('tutor.declined')); ?></option>
                            <option value="paid"><?php echo e(__('tutor.paid')); ?></option>
                        </select>
                    </span>
                </div>
            </div>
            <div class="am-payouttable">
                <table class="am-table <?php if(setting('_general.table_responsive') == 'yes'): ?> am-table-responsive <?php endif; ?>">
                    <thead>
                        <tr>
                            <th><?php echo e(__('tutor.ref_no')); ?></th>
                            <th><?php echo e(__('tutor.method')); ?></th>
                            <th><?php echo e(__('tutor.date')); ?></th>
                            <th><?php echo e(__('tutor.amount')); ?></th>
                            <th><?php echo e(__('tutor.status')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php if(!$withdrawalDetails->isEmpty()): ?>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $withdrawalDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawalDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="<?php echo e(__('tutor.ref_no')); ?>"><?php echo e($withdrawalDetail?->id); ?></td>
                                <td data-label="<?php echo e(__('tutor.method')); ?>"><?php echo e(ucfirst($withdrawalDetail?->payout_method)); ?></td>
                                <td data-label="<?php echo e(__('tutor.date')); ?>"><?php echo e($withdrawalDetail?->created_at?->format('m/d/Y')); ?></td>
                                <td data-label="<?php echo e(__('tutor.amount')); ?>"><?php echo formatAmount($withdrawalDetail?->amount); ?></td>
                                <td data-label="<?php echo e(__('tutor.status')); ?>">
                                    <span class="am-status">
                                        <em
                                            class="<?php echo e($withdrawalDetail?->status == 'paid' ? 'am-status_paid' : 'am-status_declined'); ?>"></em>
                                        <?php echo e(ucfirst($withdrawalDetail?->status)); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
            <!--[if BLOCK]><![endif]--><?php if($withdrawalDetails->isEmpty()): ?>
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
            <?php echo e($withdrawalDetails->links('pagination.pagination')); ?>

            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/payouts.blade.php ENDPATH**/ ?>