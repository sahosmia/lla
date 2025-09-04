<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\RegisterService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

?>

<div>
    <?php $__env->slot('title'); ?>
        <?php echo e(__('auth.verify_email')); ?>

    <?php $__env->endSlot(); ?>
    <?php if (isset($component)) { $__componentOriginalc3ffbec469e53ba0c225d6242a0ccc8d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc3ffbec469e53ba0c225d6242a0ccc8d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('logo', null, []); ?> 
            <strong>
                <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['variation' => 'white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('white')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
            </strong>
         <?php $__env->endSlot(); ?>
         <?php $__env->slot('figure', null, []); ?> 
            <?php
                $src = !empty(setting('site.auth_bg')) ? resizedImage(setting('site.auth_bg')[0]['path'], 500, 320) : asset('images/login/img-01.png');
            ?>
            <?php if (isset($component)) { $__componentOriginal7fc5fbb9e38e437f7681624bf6734284 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7fc5fbb9e38e437f7681624bf6734284 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.figure','data' => ['src' => $src]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('figure'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['src' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($src)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7fc5fbb9e38e437f7681624bf6734284)): ?>
<?php $attributes = $__attributesOriginal7fc5fbb9e38e437f7681624bf6734284; ?>
<?php unset($__attributesOriginal7fc5fbb9e38e437f7681624bf6734284); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7fc5fbb9e38e437f7681624bf6734284)): ?>
<?php $component = $__componentOriginal7fc5fbb9e38e437f7681624bf6734284; ?>
<?php unset($__componentOriginal7fc5fbb9e38e437f7681624bf6734284); ?>
<?php endif; ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('formHeader', null, []); ?> 
            <strong class="am-mobile-logo">
                <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
            </strong>
            <div class="am-login-right_title">
                <h2><?php echo e(__('auth.verify_title')); ?></h2>
                <p class="am-description"><?php echo e(__('auth.verify_email_msg')); ?></p>
                <p class="am-description"><?php echo e(__('auth.verify_email_msg2')); ?></p>
            </div>
         <?php $__env->endSlot(); ?>

        <div class="am-login-right_btns">
            <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['wire:click' => 'sendVerification','wire:loading.class' => 'am-btn_disable']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'sendVerification','wire:loading.class' => 'am-btn_disable']); ?>
                <?php echo e(__('auth.resend_verification_email')); ?>

             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>

            <button wire:click="logout" wire:loading.class="am-btn_disable" type="submit" class="am-white-btn">
                <?php echo e(__('auth.log_out')); ?>

            </button>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc3ffbec469e53ba0c225d6242a0ccc8d)): ?>
<?php $attributes = $__attributesOriginalc3ffbec469e53ba0c225d6242a0ccc8d; ?>
<?php unset($__attributesOriginalc3ffbec469e53ba0c225d6242a0ccc8d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3ffbec469e53ba0c225d6242a0ccc8d)): ?>
<?php $component = $__componentOriginalc3ffbec469e53ba0c225d6242a0ccc8d; ?>
<?php unset($__componentOriginalc3ffbec469e53ba0c225d6242a0ccc8d); ?>
<?php endif; ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/auth/verify-email.blade.php ENDPATH**/ ?>