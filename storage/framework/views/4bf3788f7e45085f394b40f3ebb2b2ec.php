<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['menu']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['menu']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<li class="dd-item" data-id="<?php echo e($menu->id); ?>">
    <div class="tb-menuaccordion_wrap">
        <div class="tb-menuaccordion_header" id="menu-accordion-<?php echo e($menu->id); ?>">
            <a href="javascript:void(0);" class="tb-slotchange dd-handle"><img src="<?php echo e(asset('images/sort-icon.svg')); ?>" ></a>
            <div class="tb-checkbox">
                <input id="item-<?php echo e($menu->id); ?>" value="<?php echo e($menu->id); ?>" type="checkbox">
                <label for="item-<?php echo e($menu->id); ?>"><?php echo $menu->label; ?></label>
            </div>
            <span class="tb-accordionmenu" data-bs-toggle="collapse" data-bs-target="#accordionmenu-<?php echo e($menu->id); ?>" aria-expanded="false"><?php echo e($menu->type == 'page' ? __('pages.pages') : __('pages.custom')); ?> <i class="icon-chevron-right"></i> </span>
        </div>
        <div id="accordionmenu-<?php echo e($menu->id); ?>" wire:key="accordionmenu-<?php echo e($menu->id); ?>" class="collapse" aria-labelledby="menu-accordion-<?php echo e($menu->id); ?>" data-parent="#menu-items">
            <div class="tb-menuaccordion_content">
                <div class="form-group">
                    <label class="tb-titleinput"> <?php echo e(__('pages.add_label')); ?>  </label>
                    <input type="text" name="item-name[<?php echo e($menu->id); ?>]" value="<?php echo $menu->label; ?>" class="form-control" placeholder="<?php echo e(__('pages.add_label')); ?>">
                </div>
                <div class=" form-group">
                    <label class="tb-titleinput"><?php echo e(__('pages.enter_url')); ?></label>
                    <input type="text" name="item-route[<?php echo e($menu->id); ?>]" value="<?php echo e($menu->route); ?>" class="form-control" placeholder="<?php echo e(__('pages.enter_url')); ?>">
                </div>
                <input type="hidden" name="item-type[<?php echo e($menu->id); ?>]" value="<?php echo e($menu->type); ?>" >
                <div class="form-group">
                    <a href="javascript:void(0);" class="tb-removemenu remove-item"><?php echo e(__('pages.delete_menu')); ?> <i class="icon-trash-2"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!--[if BLOCK]><![endif]--><?php if( !$menu->children->isEmpty() ): ?> 
        <ol class="tb-menuaccordion_child dd-list">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if (isset($component)) { $__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.menu-item','data' => ['menu' => $child]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($child)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae)): ?>
<?php $attributes = $__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae; ?>
<?php unset($__attributesOriginal7e1a13da8cff92eedd5dcb02aa2c65ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae)): ?>
<?php $component = $__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae; ?>
<?php unset($__componentOriginal7e1a13da8cff92eedd5dcb02aa2c65ae); ?>
<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </ol>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</li>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/admin/menu-item.blade.php ENDPATH**/ ?>