<section class="am-marketplace am-marketplace-slider">
    <?php if(!empty(pagesetting('shape_image'))): ?>
        <?php if(!empty(pagesetting('shape_image')[0]['path'])): ?>
            <img class="am-section-shape" src="<?php echo e(url(Storage::url(pagesetting('shape_image')[0]['path']))); ?>" alt="image"> 
        <?php endif; ?> 
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')) || !empty(pagesetting('view_tutor_btn_text')) || !empty(pagesetting('view_tutor_btn_url'))): ?>
                    <div class="am-explore-tutor">
                        <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                            <div class="am-steps_content_unlock">
                                <?php if(!empty(pagesetting('pre_heading'))): ?> <span
                                    <?php if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')): ?>
                                        style="
                                            <?php if(!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)'): ?>
                                                color: <?php echo e(pagesetting('pre_heading_text_color')); ?>;
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'): ?>
                                                background-color: <?php echo e(pagesetting('pre_heading_bg_color')); ?>;
                                            <?php endif; ?>
                                        "
                                    <?php endif; ?>>
                                    <?php echo e(pagesetting('pre_heading')); ?>

                                </span> <?php endif; ?> 
                                <?php if(!empty(pagesetting('heading'))): ?> <h3><?php echo pagesetting('heading'); ?></h3> <?php endif; ?>
                                <?php if(!empty(pagesetting('paragraph'))): ?> <p><?php echo pagesetting('paragraph'); ?></p> <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('view_tutor_btn_text'))): ?> 
                            <a class="am-btn" href="<?php if(!empty(pagesetting('view_tutor_btn_url'))): ?> <?php echo e(pagesetting('view_tutor_btn_url')); ?> <?php endif; ?>">
                                <?php echo e(pagesetting('view_tutor_btn_text')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal2f4c902000ef425644a2667581bef38a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2f4c902000ef425644a2667581bef38a = $attributes; } ?>
<?php $component = App\View\Components\FeaturedTutors::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('featured-tutors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FeaturedTutors::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2f4c902000ef425644a2667581bef38a)): ?>
<?php $attributes = $__attributesOriginal2f4c902000ef425644a2667581bef38a; ?>
<?php unset($__attributesOriginal2f4c902000ef425644a2667581bef38a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2f4c902000ef425644a2667581bef38a)): ?>
<?php $component = $__componentOriginal2f4c902000ef425644a2667581bef38a; ?>
<?php unset($__componentOriginal2f4c902000ef425644a2667581bef38a); ?>
<?php endif; ?> 
</section><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/featured-tutors/view.blade.php ENDPATH**/ ?>