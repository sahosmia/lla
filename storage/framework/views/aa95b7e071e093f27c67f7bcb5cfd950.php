<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($page->settings['grids'])): ?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $page->settings['grids']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($grid['data'])): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $grid['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $components): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php echo e($columns[$column]); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php setSectionId($component['id']);?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(view()->exists('pagebuilder.' . $component['section_id'] . '.view')): ?>
                <?php echo view('pagebuilder.' . $component['section_id']. '.view')->render(); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</section>
<!-- Section end -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\Users\User\Desktop\well-known\vendor\larabuild\pagebuilder\src/../resources/views/components/page-components.blade.php ENDPATH**/ ?>