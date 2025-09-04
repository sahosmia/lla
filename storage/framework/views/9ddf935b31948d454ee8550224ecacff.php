<?php $__env->startSection('title', __('general.403_title')); ?>
<?php $__env->startSection('heading', __('general.403_heading')); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('img', asset('images/error/403.png')); ?>
<?php $__env->startSection('message', __($exception->getMessage() ?: 'Forbidden')); ?>

<?php echo $__env->make('errors::minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/errors/403.blade.php ENDPATH**/ ?>