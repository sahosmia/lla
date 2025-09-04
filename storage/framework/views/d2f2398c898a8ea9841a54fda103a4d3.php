<?php

use Livewire\Volt\Component;
use Diglactic\Breadcrumbs\Breadcrumbs;

?>

<header class="am-header">
    <?php echo e(Breadcrumbs::render()); ?>

    <form class="am-header_form">
        <fieldset>
            <div class="form-group" @click="$dispatch('toggle-spotlight')">
                <i class="am-icon-search-02"></i>
                <input type="text" class="form-control" placeholder="<?php echo e(__('general.quick_search')); ?>">
                <span><?php echo e(__('general.ctrl_k')); ?></span>
            </div>
        </fieldset>
    </form>
    <div class="am-header_user">
        <?php if (isset($component)) { $__componentOriginal52832d31110f84da973eba1608c59933 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52832d31110f84da973eba1608c59933 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.user-menu','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.user-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52832d31110f84da973eba1608c59933)): ?>
<?php $attributes = $__attributesOriginal52832d31110f84da973eba1608c59933; ?>
<?php unset($__attributesOriginal52832d31110f84da973eba1608c59933); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52832d31110f84da973eba1608c59933)): ?>
<?php $component = $__componentOriginal52832d31110f84da973eba1608c59933; ?>
<?php unset($__componentOriginal52832d31110f84da973eba1608c59933); ?>
<?php endif; ?>
    </div>
</header><?php /**PATH D:\Sahos\Laravel\lla\resources\views\livewire/header/header.blade.php ENDPATH**/ ?>