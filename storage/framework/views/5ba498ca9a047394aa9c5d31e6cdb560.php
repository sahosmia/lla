<section class="am-achievements_section">
    <?php if(!empty(pagesetting('shape_image'))): ?>
        <img class="am-placeholder-one" src="<?php echo e(url(Storage::url(pagesetting('shape_image')[0]['path']))); ?>" alt="Background shape image"> 
    <?php endif; ?>
    <?php if(!empty(pagesetting('shape_second_image'))): ?>
        <img class="am-placeholder-two" src="<?php echo e(url(Storage::url(pagesetting('shape_second_image')[0]['path']))); ?>" alt="Background shape image"> 
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')) || !empty(pagesetting('repeater_data'))): ?>
                <div class="col-12">
                    <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                        <div class="am-content_box lx-text-white">
                            <?php if(!empty(pagesetting('pre_heading'))): ?> 
                                <span 
                                    <?php if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')): ?>
                                    style="
                                        <?php if(!empty(pagesetting('pre_heading_text_color'))): ?>
                                            color: <?php echo e(pagesetting('pre_heading_text_color')); ?>;
                                        <?php endif; ?>
                                        <?php if(!empty(pagesetting('pre_heading_bg_color'))): ?>
                                            background-color: <?php echo e(pagesetting('pre_heading_bg_color')); ?>;
                                        <?php endif; ?>
                                    "
                                <?php endif; ?>>
                                    <?php echo e(pagesetting('pre_heading')); ?>

                                </span> 
                            <?php endif; ?> 
                            <?php if(!empty(pagesetting('heading'))): ?> <h3><?php echo pagesetting('heading'); ?></h3> <?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?> <p><?php echo pagesetting('paragraph'); ?></p> <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('repeater_data'))): ?>
                        <div class="am-achievements_reviews">
                            <ul>
                                <?php $__currentLoopData = pagesetting('repeater_data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($option['icon']) || empty($option['sub_heading'])): ?>
                                        <li>
                                            <div class="am-achievements_Commit">
                                                <?php if(!empty($option['icon'])): ?>
                                                    <span>
                                                        <i class="<?php echo $option['icon']; ?>"></i>
                                                    </span>
                                                <?php endif; ?>
                                                <?php if(!empty($option['sub_heading'])): ?>
                                                    <strong>
                                                        <?php echo $option['sub_heading']; ?>

                                                    </strong>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/achievements/view.blade.php ENDPATH**/ ?>