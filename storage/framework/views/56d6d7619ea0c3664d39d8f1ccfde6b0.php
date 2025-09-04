<?php if(!empty($page->settings['grids'])): ?>
<?php $__currentLoopData = $page->settings['grids']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php $columns = getColumnInfo($grid['grid']); ?>
<!-- Section start -->
<?php
setGridId($grid['grid_id']);
$css = getCss();
if(!empty(getBgOverlay()))
$css = 'position:relative;'.$css;
?>
<section class="pb-themesection <?php echo e(getClasses()); ?>" <?php echo getCustomAttributes(); ?> <?php echo !empty($css)? 'style="' .$css.'"':''; ?>>
    <?php echo getBgOverlay(); ?>

    <div <?php echo getContainerStyles(); ?>>
        <div class="row">
            <?php if(!empty($grid['data'])): ?>
            <?php $__currentLoopData = $grid['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $components): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php echo e($columns[$column]); ?>">
                <?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php setSectionId($component['id']);?>
                <?php if(view()->exists('pagebuilder.' . $component['section_id'] . '.view')): ?>
                <?php echo view('pagebuilder.' . $component['section_id']. '.view')->render(); ?>

                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Section end -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/vendor/larabuild/pagebuilder/src/../resources/views/components/page-components.blade.php ENDPATH**/ ?>