
<section class="am-works"> 
    <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
        <div class="am-page-title-wrap">
            <div class="am-content_box">
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
                <?php if(!empty(pagesetting('paragraph'))): ?> <p><?php echo pagesetting('paragraph'); ?></p> <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('student_btn_url')) || !empty(pagesetting('tutor_btn_url')) || !empty(pagesetting('tutor_btn_txt'))): ?>
        <div class="am-joincommunity_btn">
            <?php if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('student_btn_url'))): ?>
                <a href="<?php echo e(setting('_lernen.allow_register') !== 'no' ? pagesetting('student_btn_url') : '#'); ?>" class="am-btn">
                    <?php echo e(pagesetting('student_btn_txt')); ?>

                </a>
            <?php endif; ?>
            <?php if(!empty(pagesetting('tutor_btn_url')) || !empty(pagesetting('tutor_btn_txt'))): ?>
                <a href="<?php echo e(setting('_lernen.allow_register') !== 'no' ? pagesetting('tutor_btn_url') : '#'); ?>" class="am-white-btn">
                    <?php echo e(pagesetting('tutor_btn_txt')); ?>

                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/content-banner/view.blade.php ENDPATH**/ ?>