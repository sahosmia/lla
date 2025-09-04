<?php $__env->startPush(config('laraguppy.style_stack')); ?>
   
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/laraguppy/app.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection(config('laraguppy.content_yeild')); ?>
    <div id="chat-app" class="wpguppy-chat-app <?php if(config('laraguppy.enable_rtl') == 'yes' || !empty(setting('_general.enable_rtl'))): ?> lg-rtl <?php endif; ?>"></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush(config('laraguppy.script_stack')); ?>
    <script src="<?php echo e(asset('vendor/laraguppy/jquery.min.js')); ?>"></script>
    <script>
        window.guppy_auth_token = <?php echo e(\Js::from($guppyAuthToken)); ?>;
        window.pusherConfig     = <?php echo e(\Js::from($broadcastingSettings)); ?>;
    </script>
   
   <script defer type="module" src="<?php echo e(asset('vendor/laraguppy/app.js')); ?>"></script>
  
<?php $__env->stopPush(); ?>

<?php echo $__env->make(!empty(config('laraguppy.layout')) ? config('laraguppy.layout') : 'laraguppy::layouts.messenger', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/amentotech/laraguppy/src/../resources/views/messenger.blade.php ENDPATH**/ ?>