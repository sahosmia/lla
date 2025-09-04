<!-- asidebar -->
<aside class="pb-aside larabuild-pbsettings">
    <div class="pb-aside_title">
        <img src="<?php echo e(asset('vendor/pagebuilder/images/page-builder-logo.png')); ?>" alt="logo">
        <h6><?php echo e(__('pagebuilder::pagebuilder.product_name')); ?><em><?php echo e(__('pagebuilder::pagebuilder.the_page_builder')); ?></em></h6>
    </div>

    <div class="pb-tabs-wrapper">
        <nav>
            <div class="nav nav-tabs pb-tabs-btn">
                <button class="pb-tab-btn active" id="elements-btn" data-bs-toggle="tab" type="button"
                    data-bs-target="#blocks-tab" aria-selected="true"><i
                        class="icon-grid"></i><?php echo e(__('pagebuilder::pagebuilder.elements')); ?></button>
                <button id="settings-btn" class="pb-tab-btn" data-bs-toggle="tab" type="button"
                    data-bs-target="#section-settings-tab" aria-selected="false"><i
                        class="icon-settings"></i><?php echo e(__('pagebuilder::pagebuilder.settings')); ?></button>
                <button class="pb-tab-btn" id="advanced-btn" data-bs-toggle="tab" type="button"
                    data-bs-target="#advanced-settings-tab" aria-selected="false"><i
                        class="icon-sliders"></i><?php echo e(__('pagebuilder::pagebuilder.advanced')); ?></button>
            </div>
        </nav>
        <div class="tab-content pb-tabs-holder">
            <div class="pb-blocks-tab tab-pane fade show active" id="blocks-tab">
                <div id="pb-advanceaccordion" class="pb-collapse-wrapper">
                    <?php $__currentLoopData = $componentTabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => $elements): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="accordion pb-advanceaccordion" id="pb-advanceaccordion">
                        <div class="op-accordion-item">
                            <div class="pb-advancedtitle" data-bs-toggle="collapse"
                                data-bs-target="#<?php echo e(\Illuminate\Support\Str::slug($tab)); ?>-accord" aria-expanded="false">
                                <h2><?php echo e($tab); ?></h2>
                            </div>
                            <div id="<?php echo e(\Illuminate\Support\Str::slug($tab)); ?>-accord" class="accordion-collapse collapse"
                                data-bs-parent="#pb-advanceaccordion">
                                <ul class="pb-elementcontent-wrapper" id="draggable-<?php echo e(\Illuminate\Support\Str::slug($tab)); ?>">
                                    <?php if(!empty($elements)): ?>
                                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    $item = $components[$element];
                                    ?>
                                    <li class="draggable pb-placeholder-dragonly" data-section="<?php echo e($item['settings']['id']); ?>"
                                        id="<?php echo e($item['settings']['id']); ?>">
                                        <a href="javascript:void(0)" class="pb-elementcontent">
                                            <?php echo $item['settings']['icon'] ?? '<i class="icon-slash"></i>'; ?>

                                            <span><?php echo e($item['settings']['name'] ??
                                                __('pagebuilder::pagebuilder.no_name')); ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="pb-sec-settings-tab tab-pane fade " id="section-settings-tab">
                <div class="pb-collapse-wrapper">
                    <form method="post" id="current-section-form">
                        <input type="hidden" name="section_id" id="current-section-id" />
                        <div id="section-settings-wrapper">
                            <div>
                                <span
                                    class="at-empty-settings"><?php echo e(__('pagebuilder::pagebuilder.select_any_element')); ?></span>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="pb-adv-setting-tab tab-pane fade" id="advanced-settings-tab">
                <div class="pb-collapse-wrapper">
                    <form id="current-advanced-settings-form">
                        <input type="hidden" name="grid_id" id="current-grid-id" />
                        <div id="advanced-settings-wrapper">
                            <span class="at-empty-settings"><?php echo e(__('pagebuilder::pagebuilder.select_any_element')); ?></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="pb-btn-wrapper">
        <a href="<?php echo e(route('pagebuilder')); ?>" class="pb-gobackbtn"><i
                title="<?php echo e(__('pagebuilder::pagebuilder.go_back')); ?>" class="icon-arrow-left"></i></a>
        <a target="_blank" href="<?php echo e(URL($page->slug??'/').'?preview=yes'); ?>"> <i class="icon-monitor"></i>
            <?php echo e(__('pagebuilder::pagebuilder.view_changes')); ?></a>
        <button class="pb-btn savePageData"><?php echo e(__('pagebuilder::pagebuilder.publish')); ?><i
                class="icon-loader"></i></button>
    </div>
</aside>
<!-- asidebar --><?php /**PATH D:\Sahos\Laravel\lla\vendor\larabuild\pagebuilder\src/../resources/views/components/sidebar.blade.php ENDPATH**/ ?>