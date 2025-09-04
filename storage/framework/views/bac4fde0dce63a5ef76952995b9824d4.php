<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['page'=> null]));

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

foreach (array_filter((['page'=> null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php
    $headerVariations = setting('_front_page_settings.header_variation_for_pages');
    $headerVariation  = '';
    if (!empty($headerVariations)) {
        foreach ($headerVariations as $key => $variation) {
           if($variation['page_id'] == $page?->id) {
                $headerVariation = $variation['header_variation'];
                break;
           }
        }
    }
?>

<?php if($headerVariation == 'am-header_four'): ?>  
    <header class="am-header_four">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap am-header-bg">
                        <strong class="am-logo">
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
                        <nav class="am-navigation am-navigation-four navbar-expand-xxl">
                            
                            <div class="am-navbar-toggler">
                                <div  class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="Toggle navigation" role="button">
                                </div>
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox" class="toggler-menu">
                                    <span class="menu-bars" id="menu-bar1"></span>
                                    <span class="menu-bars" id="menu-bar2"></span>
                                    <span class="menu-bars" id="menu-bar3"></span>
                                </label>
                            </div>
                            <ul id="tenavbar" class="collapse navbar-collapse">
                                <?php if(!empty(getMenu('header'))): ?>
                                    <?php $__currentLoopData = getMenu('header'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if (isset($component)) { $__componentOriginalce95f69c1ef890487f9ea684119db87d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce95f69c1ef890487f9ea684119db87d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu-item','data' => ['menu' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $attributes = $__attributesOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__attributesOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $component = $__componentOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__componentOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php if(auth()->guard()->check()): ?>
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
                        <?php endif; ?>
                        <?php if(auth()->guard()->guest()): ?>
                            <div class="am-loginbtns">
                                <?php if (isset($component)) { $__componentOriginalf058f939673b28ed69913a9622e5fd75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf058f939673b28ed69913a9622e5fd75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-currency','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $attributes = $__attributesOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__attributesOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $component = $__componentOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__componentOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-lingual','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-lingual'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $attributes = $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $component = $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
                                <a href="<?php echo e(route('login')); ?>" class="am-white-btn"><?php echo e(__('general.login')); ?></a>
                                <?php if(setting('_lernen.allow_register') !== 'no'): ?>
                                    <a href="<?php echo e(route('register')); ?>" class="am-btn"><?php echo e(__('general.get_started')); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php elseif($headerVariation == 'am-header_seven'): ?>
    <header class="am-header-six">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap">
                        <strong class="am-logo">
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
                        <div class="am-loginbtns">
                            <?php if(auth()->guard()->guest()): ?>
                                <a href="<?php echo e(route('login')); ?>" class="am-btn"><?php echo e(__('general.login')); ?></a>
                            <?php endif; ?>
                            <button type="button" class="navbar-toggler am-menubtn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"><?php echo e(__('general.menu')); ?> 
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                        <path d="M2.93359 14.0283H14.9336M8.26693 8.695H14.9336M2.93359 3.36166H14.9336" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </button>
                            <?php if(auth()->guard()->check()): ?>
                                <?php if (isset($component)) { $__componentOriginal52832d31110f84da973eba1608c59933 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52832d31110f84da973eba1608c59933 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.user-menu','data' => ['multiLang' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.user-menu'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['multiLang' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
                            <?php endif; ?>
                            <div class="am-sidebar-menu offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <strong class="am-logo">
                                        <a href="#">
                                            <img src="<?php echo e(asset ('demo-content/logo-white.svg')); ?>" alt="">
                                        </a>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M6 18L18 6M6 6L18 18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav flex-grow-1">
                                        <?php if(!empty(getMenu('header'))): ?>
                                            <?php $__currentLoopData = getMenu('header'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if (isset($component)) { $__componentOriginalce95f69c1ef890487f9ea684119db87d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce95f69c1ef890487f9ea684119db87d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu-item','data' => ['menu' => $item,'enableToggle' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item),'enableToggle' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $attributes = $__attributesOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__attributesOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $component = $__componentOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__componentOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php if(auth()->guard()->guest()): ?>
                                            <?php if (isset($component)) { $__componentOriginalf058f939673b28ed69913a9622e5fd75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf058f939673b28ed69913a9622e5fd75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-currency','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $attributes = $__attributesOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__attributesOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $component = $__componentOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__componentOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
                                            <?php if (isset($component)) { $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-lingual','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-lingual'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $attributes = $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $component = $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
                                        <?php endif; ?>
                                    </ul>
                                    <?php if(auth()->guard()->guest()): ?>
                                        <div class="am-btns">
                                            <a href="<?php echo e(route('login')); ?>" class="am-btn am-joinnow-btn"><?php echo e(__('general.login')); ?></a>
                                            <?php if(setting('_lernen.allow_register') !== 'no'): ?>
                                                <a href="<?php echo e(route('register')); ?>" class="am-btn"><?php echo e(__('general.get_started')); ?></a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php else: ?>
    <header class="<?php echo \Illuminate\Support\Arr::toCssClasses([
        'am-header_two', $headerVariation,
        'am-header-bg' => (empty($page) && !in_array(request()->route()->getName(), ['find-tutors','tutor-detail'])) || in_array($page?->slug, ['about-us', 'how-it-works', 'faq', 'terms-condition', 'privacy-policy'])
        ]); ?>">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap">
                        <strong class="am-logo">
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
                        <nav class="am-navigation navbar-expand-xl">
                            <div class="am-navbar-toggler">
                                <div  class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="Toggle navigation" role="button">
                                </div>
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox" class="toggler-menu">
                                    <span class="menu-bars" id="menu-bar1"></span>
                                    <span class="menu-bars" id="menu-bar2"></span>
                                    <span class="menu-bars" id="menu-bar3"></span>
                                </label>
                            </div>
                            <ul id="tenavbar" class="collapse navbar-collapse">
                            <?php if(!empty(getMenu('header'))): ?>
                                <?php $__currentLoopData = getMenu('header'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (isset($component)) { $__componentOriginalce95f69c1ef890487f9ea684119db87d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce95f69c1ef890487f9ea684119db87d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.menu-item','data' => ['menu' => $item]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('menu-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menu' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($item)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $attributes = $__attributesOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__attributesOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce95f69c1ef890487f9ea684119db87d)): ?>
<?php $component = $__componentOriginalce95f69c1ef890487f9ea684119db87d; ?>
<?php unset($__componentOriginalce95f69c1ef890487f9ea684119db87d); ?>
<?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </ul>
                        </nav>
                        <?php if(auth()->guard()->check()): ?>
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
                        <?php endif; ?>
                        <?php if(auth()->guard()->guest()): ?>
                            <div class="am-loginbtns">
                                <?php if (isset($component)) { $__componentOriginalf058f939673b28ed69913a9622e5fd75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf058f939673b28ed69913a9622e5fd75 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-currency','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-currency'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $attributes = $__attributesOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__attributesOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf058f939673b28ed69913a9622e5fd75)): ?>
<?php $component = $__componentOriginalf058f939673b28ed69913a9622e5fd75; ?>
<?php unset($__componentOriginalf058f939673b28ed69913a9622e5fd75); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.multi-lingual','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('multi-lingual'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $attributes = $__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__attributesOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f)): ?>
<?php $component = $__componentOriginalfa4bf5cb1572938e537fa690884d8b6f; ?>
<?php unset($__componentOriginalfa4bf5cb1572938e537fa690884d8b6f); ?>
<?php endif; ?>
                                <a href="<?php echo e(route('login')); ?>" class="am-btn"><?php echo e(__('general.login')); ?></a>
                                <?php if(setting('_lernen.allow_register') !== 'no'): ?>
                                    <a href="<?php echo e(route('register')); ?>" class="am-white-btn"><?php echo e(__('general.get_started')); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/front/header.blade.php ENDPATH**/ ?>