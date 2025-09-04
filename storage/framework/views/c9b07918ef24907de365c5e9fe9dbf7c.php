
<div class="am-coming-section <?php echo e(pagesetting('select_verient')); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-coming-soon_wrap">
                    <div class="am-coming-soon">
                        <div class="am-coming-soon_content">
                            <?php if(!empty(pagesetting('pre_heading'))): ?>
                                <span data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"
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
                            <?php if(!empty(pagesetting('heading'))): ?><h3 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300"><?php echo pagesetting('heading'); ?></h3><?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?><p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400"><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                            <?php if(!empty(pagesetting('app_store_image')) || !empty(pagesetting('google_image'))): ?>
                            <div class="am-coming-soon_btns" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500">
                                <?php if(!empty(pagesetting('app_store_image')[0]['path'])): ?>
                                    <a href=" <?php if(!empty(pagesetting('apple_store_url'))): ?> <?php echo e(pagesetting('apple_store_url')); ?> <?php endif; ?>">
                                        <img src="<?php echo e(url(Storage::url(pagesetting('app_store_image')[0]['path']))); ?>" alt="App store image">
                                    </a>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('google_image')[0]['path'])): ?>
                                    <a href=" <?php if(!empty(pagesetting('play_store_url'))): ?> <?php echo e(pagesetting('play_store_url')); ?> <?php endif; ?>">
                                        <img src="<?php echo e(url(Storage::url(pagesetting('google_image')[0]['path']))); ?>" alt="Google play store image">
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty(pagesetting('mobile_image'))): ?>
                            <figure data-aos="fade-left"  data-aos-duration="500" data-aos-easing="linear" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                <?php if(!empty(pagesetting('mobile_image')[0]['path'])): ?>
                                    <img src="<?php echo e(url(Storage::url(pagesetting('mobile_image')[0]['path']))); ?>" alt="Mobile image">
                                <?php endif; ?>
                            </figure>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('shape_img_one'))): ?>
                            <?php if(!empty(pagesetting('shape_img_one')[0]['path'])): ?>
                                <img src="<?php echo e(url(Storage::url(pagesetting('shape_img_one')[0]['path']))); ?>" class="am-img" alt="Background shape image">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty(pagesetting('bg_image'))): ?>
        <?php if(!empty(pagesetting('bg_image')[0]['path'])): ?>
            <img src="<?php echo e(url(Storage::url(pagesetting('bg_image')[0]['path']))); ?>" class="am-bgimg2" alt="Background shape image">
        <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty(pagesetting('shape_img_one'))): ?>
        <?php if(!empty(pagesetting('shape_img_one')[0]['path'])): ?>
            <img src="<?php echo e(url(Storage::url(pagesetting('shape_img_one')[0]['path']))); ?>" class="am-img" alt="Background shape image">
        <?php endif; ?>
    <?php endif; ?>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/get-app/view.blade.php ENDPATH**/ ?>