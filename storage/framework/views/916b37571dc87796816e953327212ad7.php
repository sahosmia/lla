<div class="am-whychooseus">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-whychooseus-section">
                    <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                        <div class="am-section_title am-section_title_center <?php echo e(pagesetting('section_title_variation')); ?>">
                            <?php if(!empty(pagesetting('pre_heading'))): ?>
                                <span class="am-tag"
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

                                </span> 
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('heading'))): ?><h2><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?><p><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('steps_repeater'))): ?>
                        <ul class="am-whychooseus-content">
                            <?php $__currentLoopData = pagesetting('steps_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($option['image']) || !empty($option['data_heading']) || !empty($option['data_description'])): ?> 
                                    <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="<?php echo e($loop->iteration * 400); ?>">
                                        <?php if(!empty($option['image'][0]['path'])): ?><img src="<?php echo e(url(Storage::url($option['image'][0]['path']))); ?>" alt="<?php echo $option['data_description']; ?> image"><?php endif; ?>
                                        <?php if(!empty($option['data_heading'])): ?><h3><?php echo $option['data_heading']; ?></h3><?php endif; ?>
                                        <?php if(!empty($option['data_description'])): ?><p><?php echo $option['data_description']; ?></p><?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('btn_txt'))): ?> 
                        <a class="am-getstarted-btn" href="<?php if(!empty(pagesetting('btn_url'))): ?> <?php echo e(pagesetting('btn_url')); ?> <?php endif; ?>">
                            <?php echo e(pagesetting('btn_txt')); ?>

                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty(pagesetting('bg_shape_img'))): ?>
        <?php if(!empty(pagesetting('bg_shape_img')[0]['path'])): ?>
            <img class="am-img" src="<?php echo e(url(Storage::url(pagesetting('bg_shape_img')[0]['path']))); ?>" alt="image-description">
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/why-choose-us/view.blade.php ENDPATH**/ ?>