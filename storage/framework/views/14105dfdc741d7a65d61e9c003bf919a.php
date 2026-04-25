

<?php $__env->startSection('content'); ?>
<main class="tb-main am-dispute-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4> <?php echo e(__('Inquiries') .' ('. $inquiries->total() .')'); ?></h4>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if( !$inquiries->isEmpty() ): ?>
                    <table class="tb-table <?php if(setting('_general.table_responsive') == 'yes'): ?> tb-table-responsive <?php endif; ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('#' )); ?></th>
                                <th><?php echo e(__('Full Name' )); ?></th>
                                <th><?php echo e(__('Organization/Designation' )); ?></th>
                                <th><?php echo e(__('Contact Info' )); ?></th>
                                <th><?php echo e(__('Inquiry Type' )); ?></th>
                                <th><?php echo e(__('Message' )); ?></th>
                                <th><?php echo e(__('Created Date' )); ?></th>
                                <th><?php echo e(__('Actions' )); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $inquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td data-label="<?php echo e(__('#' )); ?>"><span><?php echo e($inquiry->id); ?></span></td>
                                <td data-label="<?php echo e(__('Full Name' )); ?>">
                                    <span><?php echo e($inquiry->name); ?></span>
                                </td>
                                <td data-label="<?php echo e(__('Organization/Designation' )); ?>">
                                    <span>
                                        <?php echo e($inquiry->organization); ?> 
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($inquiry->designation): ?>
                                            / <?php echo e($inquiry->designation); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                </td>
                                <td data-label="<?php echo e(__('Contact Info' )); ?>">
                                    <span><?php echo e($inquiry->email); ?></span>
                                    <span><?php echo e($inquiry->phone); ?></span>
                                </td>
                                <td data-label="<?php echo e(__('Inquiry Type' )); ?>">
                                    <span><?php echo e($inquiry->inquiry_type); ?></span>
                                </td>
                                <td data-label="<?php echo e(__('Message' )); ?>">
                                    <span class="am-text-truncate"><?php echo e(Str::limit($inquiry->message, 50)); ?></span>
                                </td>
                                <td data-label="<?php echo e(__('Created Date' )); ?>">
                                    <span><?php echo e($inquiry->created_at->format('F d, Y')); ?></span>
                                </td>
                                <td data-label="<?php echo e(__('Actions' )); ?>" style="display: flex">
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span><?php echo e(__('View Details')); ?></span>
                                        </span>
                                        <a href="<?php echo e(route('admin.inquiries.show', $inquiry->id)); ?>">
                                            <i class="icon-eye"></i>
                                        </a>
                                    </div>
                                    <div class="am-custom-tooltip">
                                        <span class="am-tooltip-text am-tooltip-textimp">
                                            <span><?php echo e(__('Delete Inquiry')); ?></span>
                                        </span>
                                        <form action="<?php echo e(route('admin.inquiries.destroy', $inquiry->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" style="background:none; border:none; padding:0; cursor:pointer;">
                                                <i class="icon-trash-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                    <?php echo e($inquiries->links('pagination.custom')); ?>

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
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\well-known\resources\views/admin/inquiries/index.blade.php ENDPATH**/ ?>