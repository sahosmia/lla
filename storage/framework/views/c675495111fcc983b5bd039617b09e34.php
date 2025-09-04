<?php $__env->startSection(config('pagebuilder.site_section')); ?>
<div class="page-<?php echo e($page->slug == "/" ? "home-page" : $page->slug); ?>">
    <?php echo $pageSections; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(config('pagebuilder.site_layout'),['page' => $page, 'edit' => false ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/pagebuilder/src/../resources/views/page.blade.php ENDPATH**/ ?>