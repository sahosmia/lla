<div class="am-categories <?php echo e(pagesetting('categories_verient')); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                    <div class="am-section_title <?php echo e(pagesetting('section_title_variation')); ?>">
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
                <?php if(!empty(pagesetting('categories_repeater'))
                    || !empty(pagesetting('all_category_heading')) 
                    || !empty(pagesetting('all_category_paragraph')) 
                    || !empty(pagesetting('view_category_btn_url')) 
                    || !empty(pagesetting('view_category_btn_txt'))): ?>
                     <ul class="am-card-container">
                        <?php $__currentLoopData = pagesetting('categories_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(!empty($option['category_image']) 
                                || !empty($option['category_heading']) 
                                || !empty($option['category_paragraph']) 
                                || !empty($option['explore_more_btn_url']) 
                                || !empty($option['explore_more_btn_txt'])): ?>
                                <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="<?php echo e($loop->iteration * 200); ?>">
                                    <?php if(pagesetting('categories_verient') == 'verient-two'): ?>
                                        <a class="am-card" href="<?php if(!empty($option['explore_more_btn_url'])): ?> <?php echo e($option['explore_more_btn_url']); ?> <?php endif; ?>">
                                    <?php else: ?>
                                        <div class="am-card">
                                    <?php endif; ?>
                                        <?php if(pagesetting('categories_verient') == 'verient-two'): ?>
                                            <?php if(!empty($option['category_image'])): ?>
                                                <div class="am-icon am-web-dev">
                                                    <?php if(!empty($option['category_image'][0]['path'])): ?>
                                                        <img src="<?php echo e(url(Storage::url($option['category_image'][0]['path']))); ?>" alt="Category image">
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($option['category_heading'])): ?><h3 class="am-title"><?php echo $option['category_heading']; ?></h3><?php endif; ?>
                                        <?php else: ?>
                                            <?php if(!empty($option['category_image'])): ?>
                                                <div class="am-icon am-web-dev">
                                                    <?php if(!empty($option['category_image'][0]['path'])): ?>
                                                        <a href="<?php if(!empty($option['explore_more_btn_url'])): ?> <?php echo e($option['explore_more_btn_url']); ?> <?php endif; ?>">
                                                            <img src="<?php echo e(url(Storage::url($option['category_image'][0]['path']))); ?>" alt="Category image">
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty($option['category_heading'])): ?>
                                                <a  href="<?php if(!empty($option['explore_more_btn_url'])): ?> <?php echo e($option['explore_more_btn_url']); ?> <?php endif; ?>">
                                                    <h3 class="am-title"><?php echo $option['category_heading']; ?></h3>
                                                </a>
                                            <?php endif; ?>
                                            <?php if(!empty($option['category_paragraph'])): ?><p class="am-description"><?php echo $option['category_paragraph']; ?></p><?php endif; ?>
                                            <?php if(!empty($option['explore_more_btn_txt'])): ?>
                                                <a href="<?php if(!empty($option['explore_more_btn_url'])): ?> <?php echo e($option['explore_more_btn_url']); ?> <?php endif; ?>" class="am-button am-explore-more">
                                                    <?php echo e($option['explore_more_btn_txt']); ?>

                                                    <i class="am-icon-arrow-right"></i>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php if(pagesetting('categories_verient') == 'verient-two'): ?>
                                        </a>
                                    <?php else: ?>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty(pagesetting('all_category_heading')) 
                            || !empty(pagesetting('all_category_paragraph')) 
                            || !empty(pagesetting('view_category_btn_url')) 
                            || !empty(pagesetting('view_category_btn_txt'))): ?>
                            <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="<?php echo e((count(pagesetting('categories_repeater')) + 1) * 200); ?>">
                                <div class="am-card am-highlighted">
                                    <?php if(!empty(pagesetting('all_category_heading'))): ?><a href="<?php if(!empty(pagesetting('view_category_btn_url'))): ?> <?php echo e(pagesetting('view_category_btn_url')); ?> <?php endif; ?>"><h3 class="am-title"><?php echo pagesetting('all_category_heading'); ?></h3></a><?php endif; ?>
                                    <?php if(!empty(pagesetting('all_category_paragraph'))): ?><p class="am-description"><?php echo pagesetting('all_category_paragraph'); ?></p><?php endif; ?>
                                    <?php if(!empty(pagesetting('view_category_btn_txt'))): ?>
                                        <a href="<?php if(!empty(pagesetting('view_category_btn_url'))): ?> <?php echo e(pagesetting('view_category_btn_url')); ?> <?php endif; ?>" class="am-btn">
                                            <?php echo e(pagesetting('view_category_btn_txt')); ?>

                                            <i class="am-icon-arrow-top-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/categories/view.blade.php ENDPATH**/ ?>