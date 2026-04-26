<?php
    if(!empty($template_id)){
        $componentSettings = getComponentSettings($template_id);
    }
?>

<div class="pb-addsection <?php echo e($class ?? ''); ?> pb-addsection-wrap <?php echo e($droppable ? 'removeable':'sectionable pb-tooltip'); ?>"
    id="<?php echo e($id); ?>" data-section="<?php echo e($template_id); ?>">
    <?php echo e($slot); ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($componentSettings)): ?>
        <div class="component-placeholder">
            <a href="javascript:void(0)" class="pb-elementcontent">
                <?php echo $componentSettings['icon']; ?>

                <span><?php echo e($componentSettings['name']); ?></span>
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php $__env->startComponent('pagebuilder::components.component-actions'); ?> <?php echo $__env->renderComponent(); ?>
</div><?php /**PATH C:\Users\User\Desktop\well-known\vendor\larabuild\pagebuilder\src/../resources/views/components/grid.blade.php ENDPATH**/ ?>