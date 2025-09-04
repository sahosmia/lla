<section class="am-steps"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('left_image')) || !empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                    <div class="am-works_info am-home-support-section">
                        <?php if(!empty(pagesetting('left_image'))): ?>
                            <div class="am-works_info_user">
                                <?php if(!empty(pagesetting('left_image')[0]['path'])): ?>
                                    <figure><img src="<?php echo e(url(Storage::url(pagesetting('left_image')[0]['path']))); ?>" alt="Comprehensive support image"></figure>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                            <div class="am-home-support">                           
                                <div class="am-works_info_description">
                                    <?php if(!empty(pagesetting('pre_heading'))): ?>
                                        <span
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
                                    <?php if(!empty(pagesetting('heading'))): ?> <h3><?php echo pagesetting('heading'); ?></h3> <?php endif; ?>
                                    <?php if(!empty(pagesetting('paragraph'))): ?> <?php echo pagesetting('paragraph'); ?> <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty(pagesetting('right_image')) || !empty(pagesetting('sub_heading')) || !empty(pagesetting('second_heading')) || !empty(pagesetting('second_paragraph'))): ?>
                    <div class="am-works_info am-home-guide-section">
                        <?php if(!empty(pagesetting('sub_heading')) || !empty(pagesetting('second_heading')) || !empty(pagesetting('second_paragraph'))): ?>
                            <div class="am-home-guide">
                                <div class="am-works_info_description">
                                    <?php if(!empty(pagesetting('sub_heading'))): ?> 
                                        <span
                                            <?php if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')): ?>
                                                style="
                                                    <?php if(!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)'): ?>
                                                        color: <?php echo e(pagesetting('pre_heading_text_color')); ?>;
                                                    <?php endif; ?>
                                                    <?php if(!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'): ?>
                                                        background-color: <?php echo e(pagesetting('sub_heading_bg_color')); ?>;
                                                    <?php endif; ?>
                                                "
                                            <?php endif; ?>>
                                            <?php echo e(pagesetting('sub_heading')); ?>

                                        </span> 
                                    <?php endif; ?> 
                                    <?php if(!empty(pagesetting('second_heading'))): ?> <h3><?php echo pagesetting('second_heading'); ?></h3> <?php endif; ?>
                                    <?php if(!empty(pagesetting('second_paragraph'))): ?> <?php echo pagesetting('second_paragraph'); ?> <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('right_image'))): ?>
                        <div class="am-works_info_user">
                            <?php if(!empty(pagesetting('right_image')[0]['path'])): ?>
                                <figure><img src="<?php echo e(url(Storage::url(pagesetting('right_image')[0]['path']))); ?>" alt="User guide image"></figure>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section><?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/user-guide/view.blade.php ENDPATH**/ ?>