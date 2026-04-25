

<?php $__env->startSection('content'); ?>
    <style>
        label,
        p {
            margin-bottom: 0px;
            padding: 0 2px
        }
        .flex{
            display: flex;
        }
    </style>
    <main class="tb-main am-dispute-system">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tb-dhb-mainheading flex">
                    <h4> <?php echo e(__('Inquiry Details')); ?></h4>
                        <a href="<?php echo e(route('admin.inquiries.index')); ?>" class="tb-btn"><?php echo e(__('Back to List')); ?></a>
                </div>
                <div class="am-disputelist_wrap">
                    <div class="am-disputelist am-custom-scrollbar-y p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Full Name:')); ?></strong></label>
                                    <p><?php echo e($inquiry->name); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Email Address:')); ?></strong></label>
                                    <p><?php echo e($inquiry->email); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Contact Number:')); ?></strong></label>
                                    <p><?php echo e($inquiry->phone); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Inquiry Type:')); ?></strong></label>
                                    <p><?php echo e($inquiry->inquiry_type); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Organization/University:')); ?></strong></label>
                                    <p><?php echo e($inquiry->organization ?: 'N/A'); ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Designation:')); ?></strong></label>
                                    <p><?php echo e($inquiry->designation ?: 'N/A'); ?></p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Message:')); ?></strong></label>
                                    <div class="p-3">
                                        <?php echo nl2br(e($inquiry->message)); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong><?php echo e(__('Received Date:')); ?></strong></label>
                                    <p><?php echo e($inquiry->created_at->format('F d, Y H:i:s')); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <form action="<?php echo e(route('admin.inquiries.destroy', $inquiry->id)); ?>" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="tb-btn tb-btn-primary bg-danger border-danger"><?php echo e(__('Delete Inquiry')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\well-known\resources\views/admin/inquiries/show.blade.php ENDPATH**/ ?>