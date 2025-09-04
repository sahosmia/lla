<?php $__env->startSection('title', __('general.404_title')); ?>
<?php $__env->startSection('heading', __('general.went_wrong')); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('img', asset('images/error/404.png')); ?>
<?php $__env->startSection('message', __('general.went_wrong_dec')); ?>

<?php echo $__env->make('errors::minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/errors/404.blade.php ENDPATH**/ ?>