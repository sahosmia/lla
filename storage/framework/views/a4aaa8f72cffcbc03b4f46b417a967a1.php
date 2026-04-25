<?php if (isset($component)) { $__componentOriginalc9d48edc8c31926555ca456dbb414bcd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc9d48edc8c31926555ca456dbb414bcd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('email.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('logo', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginal965c5cb3c04a77e6ec592eab9afca423 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal965c5cb3c04a77e6ec592eab9afca423 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.email.logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('email.logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal965c5cb3c04a77e6ec592eab9afca423)): ?>
<?php $attributes = $__attributesOriginal965c5cb3c04a77e6ec592eab9afca423; ?>
<?php unset($__attributesOriginal965c5cb3c04a77e6ec592eab9afca423); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal965c5cb3c04a77e6ec592eab9afca423)): ?>
<?php $component = $__componentOriginal965c5cb3c04a77e6ec592eab9afca423; ?>
<?php unset($__componentOriginal965c5cb3c04a77e6ec592eab9afca423); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>
     <?php $__env->slot('content', null, []); ?> 
        <?php echo $greeting ?? ''; ?> <br /> <br />                               
        <?php echo $content ?? ''; ?>

     <?php $__env->endSlot(); ?>
     <?php $__env->slot('signature', null, []); ?> 
        <?php echo nl2br($signature) ?? ''; ?>

     <?php $__env->endSlot(); ?>
     <?php $__env->slot('copyright', null, []); ?> 
        <?php echo nl2br($copyright) ?? ''; ?>

     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc9d48edc8c31926555ca456dbb414bcd)): ?>
<?php $attributes = $__attributesOriginalc9d48edc8c31926555ca456dbb414bcd; ?>
<?php unset($__attributesOriginalc9d48edc8c31926555ca456dbb414bcd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc9d48edc8c31926555ca456dbb414bcd)): ?>
<?php $component = $__componentOriginalc9d48edc8c31926555ca456dbb414bcd; ?>
<?php unset($__componentOriginalc9d48edc8c31926555ca456dbb414bcd); ?>
<?php endif; ?><?php /**PATH C:\Users\User\Desktop\well-known\resources\views/emails/template.blade.php ENDPATH**/ ?>