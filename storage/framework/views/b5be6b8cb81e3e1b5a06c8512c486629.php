<div class="uc-sidebar_wrap">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2><?php echo e(__('upcertify::upcertify.elements')); ?></h2>
            <a href="#" class="uc-sidebar-hidebtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16" fill="none">
                    <g>
                        <path d="M4 12L12 4M4 4L12 12" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="uc-sidebar-element">
            <form class="uc-themeform uc-sidebar_form">
                <fieldset>
                    <div class="form-group">
                        <div class="form-group-wrap">
                            <label for="title" class="uc-important">Title</label>
                            <input type="search" wire:model.live.debounce.500ms="searchTemplates" class="uc-search-wildcard form-control" placeholder="Search" >
                            <i class="uc-search-icon"><?php if (isset($component)) { $__componentOriginalcdd74584357f734893f55d8c11ad4183 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcdd74584357f734893f55d8c11ad4183 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcdd74584357f734893f55d8c11ad4183)): ?>
<?php $attributes = $__attributesOriginalcdd74584357f734893f55d8c11ad4183; ?>
<?php unset($__attributesOriginalcdd74584357f734893f55d8c11ad4183); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcdd74584357f734893f55d8c11ad4183)): ?>
<?php $component = $__componentOriginalcdd74584357f734893f55d8c11ad4183; ?>
<?php unset($__componentOriginalcdd74584357f734893f55d8c11ad4183); ?>
<?php endif; ?></i>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="uc-sidebar uc-sidebar_elements">
            <div class="uc-element-instructor">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $wildcards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wildcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="uc-element-drag" data-name="<?php echo e($wildcard); ?>">
                        <i class="uc-element-drag_icon"><?php if (isset($component)) { $__componentOriginalabc4da55d2925532e4fc3d249ad711dc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalabc4da55d2925532e4fc3d249ad711dc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.sorting','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.sorting'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalabc4da55d2925532e4fc3d249ad711dc)): ?>
<?php $attributes = $__attributesOriginalabc4da55d2925532e4fc3d249ad711dc; ?>
<?php unset($__attributesOriginalabc4da55d2925532e4fc3d249ad711dc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalabc4da55d2925532e4fc3d249ad711dc)): ?>
<?php $component = $__componentOriginalabc4da55d2925532e4fc3d249ad711dc; ?>
<?php unset($__componentOriginalabc4da55d2925532e4fc3d249ad711dc); ?>
<?php endif; ?></i>
                        <i class="uc-element-drag_user">
                        <!--[if BLOCK]><![endif]--><?php if(View::exists("upcertify::components.icons.$wildcard")): ?>
                            <?php echo $__env->make("upcertify::components.icons.$wildcard", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </i>
                        <span><?php echo e(__("upcertify::upcertify.".$wildcard)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="uc-no-found" style="display: none;" data-name="<?php echo e($wildcard); ?>">
                <?php if (isset($component)) { $__componentOriginal5e364663e558f8c04dc95208f654a921 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5e364663e558f8c04dc95208f654a921 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.no_record','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::no_record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5e364663e558f8c04dc95208f654a921)): ?>
<?php $attributes = $__attributesOriginal5e364663e558f8c04dc95208f654a921; ?>
<?php unset($__attributesOriginal5e364663e558f8c04dc95208f654a921); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5e364663e558f8c04dc95208f654a921)): ?>
<?php $component = $__componentOriginal5e364663e558f8c04dc95208f654a921; ?>
<?php unset($__componentOriginal5e364663e558f8c04dc95208f654a921); ?>
<?php endif; ?>
            </div>
        </div>
    </div>
    <div class="uc-sidebar_toggler">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14 6L8 12L14 18" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/livewire/sidepanel/elements/elements.blade.php ENDPATH**/ ?>