<div class="am-dbbox am-invoicelist_wrap">
    <div class="am-dbbox_content am-invoicelist">
        <div class="am-dbbox_title">
            <?php $__env->slot('title'); ?>
                <?php echo e(__('general.certificates')); ?>

            <?php $__env->endSlot(); ?>
            <h2><?php echo e(__('general.certificates')); ?></h2>
        </div>
        <!--[if BLOCK]><![endif]--><?php if($isLoading): ?>
            <?php echo $__env->make('skeletons.invoices', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php elseif($certificates && $certificates->isNotEmpty()): ?>
            <div class="am-invoicetable">
                <table class="am-table <?php if(setting('_general.table_responsive') == 'yes'): ?> am-table-responsive <?php endif; ?>">
                    <thead>
                        <tr>
                            <th>#<?php echo e(__('general.sr_no')); ?></th>
                            <th><?php echo e(__('general.title')); ?></th>
                            <th><?php echo e(__('calendar.certificate_for')); ?></th>
                            <th><?php echo e(__('general.date')); ?></th>
                            <th><?php echo e(__('general.issued_by')); ?></th>
                            <th><?php echo e(__('general.actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>       
                            <tr>
                                <td data-label="<?php echo e(__('general.no')); ?>"><span><?php echo e($key + 1); ?></span></td>
                                <td data-label="<?php echo e(__('general.title')); ?>"><span><?php echo e($certificate?->template->title ?? 'N/A'); ?> </span></td>
                                <td data-label="<?php echo e(__('calendar.subject')); ?>"><span><?php echo e($certificate?->wildcard_data['course_title'] ?? $certificate?->wildcard_data['subject_name'] ?? 'N/A'); ?></span></td>
                                <td data-label="<?php echo e(__('general.date')); ?>"><span><?php echo e($certificate?->created_at->format(setting('_general.date_format')) ?? 'N/A'); ?></span></td>
                                <td data-label="<?php echo e(__('general.issued_by' )); ?>">
                                    <span><?php echo e($certificate?->wildcard_data['tutor_name'] ?? 'N/A'); ?></span>
                                </td>
                                <td data-label="<?php echo e(__('general.actions' )); ?>">
                                    <div class="am-invoicetable_actions">
                                        <a href="<?php echo e(route('upcertify.certificate', $certificate?->hash_id)); ?>" target="_blank" class="am-custom-tooltip">
                                            <span class="am-tooltip-text"><span><?php echo e(__('general.view')); ?></span></span><i class="am-icon-eye-open-01"></i>
                                        </a>
                                        <a href="<?php echo e(route('upcertify.download', $certificate?->hash_id)); ?>" class="am-custom-tooltip">
                                            <i class="am-icon-download-01"></i>
                                            <span class="am-tooltip-text"><span><?php echo e(__('general.download')); ?></span></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        <?php elseif($certificates->isEmpty()): ?>
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
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/student/certificate-list.blade.php ENDPATH**/ ?>