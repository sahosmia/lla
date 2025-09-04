<div class="uc-sidebar_wrap uc-template">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2><?php echo e(__('upcertify::upcertify.templates')); ?></h2>
            <a href="javascript:void(0);" class="uc-sidebar-hidebtn">
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
                            <input type="search" wire:model.live.debounce.500ms="search" class="uc-search-wildcard form-control" placeholder="Search" >
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
        <div class="uc-sidebar uc-sidebar_templates">
            <!--[if BLOCK]><![endif]--><?php if(!empty($loadingTemplates)): ?>
                <ul class="uc-template_list">
                    <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 12; $i++): ?>
                        <li class="uc-skeleton">
                            <figure class="uc-template_item">
                            </figure>
                        </li>
                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            <?php elseif($templates && $templates?->isNotEmpty()): ?>
                <ul class="uc-template_list">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <figure class="uc-template_item">
                                <img src="<?php echo e(!empty($template->thumbnail_url) ? Storage::url($template->thumbnail_url) : asset('modules/upcertify/images/card-bg.webp')); ?>" alt="<?php echo e($template->title); ?>">
                                <figcaption >
                                    <a href="javascript:void(0);" class="uc-usebtn uc-use-template" data-id="<?php echo e($template->id); ?>">
                                        <i><?php if (isset($component)) { $__componentOriginal201346d59f8140011c0c514248eecb50 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal201346d59f8140011c0c514248eecb50 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'upcertify::components.icons.template','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('upcertify::icons.template'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal201346d59f8140011c0c514248eecb50)): ?>
<?php $attributes = $__attributesOriginal201346d59f8140011c0c514248eecb50; ?>
<?php unset($__attributesOriginal201346d59f8140011c0c514248eecb50); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal201346d59f8140011c0c514248eecb50)): ?>
<?php $component = $__componentOriginal201346d59f8140011c0c514248eecb50; ?>
<?php unset($__componentOriginal201346d59f8140011c0c514248eecb50); ?>
<?php endif; ?></i>
                                        <?php echo e(__('upcertify::upcertify.use_template')); ?>

                                    </a>
                                </figcaption>
                            </figure>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            <?php else: ?>
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
    <div class="uc-sidebar_toggler">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14 6L8 12L14 18" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Upcertify/resources/views/livewire/sidepanel/templates/templates.blade.php ENDPATH**/ ?>