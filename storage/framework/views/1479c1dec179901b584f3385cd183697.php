<div class="am-limitless-features">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('btn_txt')) 
                    || !empty(pagesetting('btn_url')) 
                    || !empty(pagesetting('image')) 
                    || !empty(pagesetting('shape_image')) 
                    || !empty(pagesetting('second_shape_image'))
                    || !empty(pagesetting('left_shape_image')) 
                    || !empty(pagesetting('right_shape_image'))): ?>
                    <div class="am-limitless-features-box" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                        <?php if(!empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph')) 
                            || !empty(pagesetting('btn_txt')) 
                            || !empty(pagesetting('btn_url'))): ?>
                            <div class="am-limitless-features-content">
                                <?php if(!empty(pagesetting('heading'))): ?><h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600"><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                                <?php if(!empty(pagesetting('paragraph'))): ?><p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="700"><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                                <?php if(!empty(pagesetting('btn_txt'))): ?>
                                    <div data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                                        <a href="<?php if(!empty(pagesetting('btn_url'))): ?> <?php echo e(pagesetting('btn_url')); ?> <?php endif; ?>" class="am-btn"><?php echo e(pagesetting('btn_txt')); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('image'))): ?>
                            <figure>
                                <?php if(!empty(pagesetting('image')[0]['path'])): ?>
                                    <img src="<?php echo e(url(Storage::url(pagesetting('image')[0]['path']))); ?>" alt="Limitless features image" data-aos="fade-up-left" data-aos-easing="ease" data-aos-delay="1000">
                                <?php endif; ?>
                            </figure>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('shape_image'))): ?>
                            <?php if(!empty(pagesetting('shape_image')[0]['path'])): ?>
                                <img src="<?php echo e(url(Storage::url(pagesetting('shape_image')[0]['path']))); ?>" class="am-limitless-features-img01" alt="Background shape image">
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('second_shape_image'))): ?>
                            <?php if(!empty(pagesetting('second_shape_image')[0]['path'])): ?>
                                <img src="<?php echo e(url(Storage::url(pagesetting('second_shape_image')[0]['path']))); ?>" class="am-limitless-features-img02" alt="Background shape image">
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('left_shape_image'))): ?>
                            <?php if(!empty(pagesetting('left_shape_image')[0]['path'])): ?>
                                <img src="<?php echo e(url(Storage::url(pagesetting('left_shape_image')[0]['path']))); ?>" class="am-limitless-features-img03" alt="Background shape image">
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('right_shape_image'))): ?>
                            <?php if(!empty(pagesetting('right_shape_image')[0]['path'])): ?>
                                <img src="<?php echo e(url(Storage::url(pagesetting('right_shape_image')[0]['path']))); ?>" class="am-limitless-features-img04" alt="Background shape image">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/limitless-features/view.blade.php ENDPATH**/ ?>