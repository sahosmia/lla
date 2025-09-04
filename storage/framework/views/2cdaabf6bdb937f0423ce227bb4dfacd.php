<!-- Unique Features Section Start -->
<div class="am-unique-features <?php echo e(pagesetting('select_verient')); ?>">
    <div class="container">
        <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
            <div class="row">
                <div class="col-12">
                    <div class="am-section_title am-section_title_center <?php echo e(pagesetting('section_title_variation')); ?>">
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
                        <?php if(!empty(pagesetting('heading'))): ?><h2><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                        <?php if(!empty(pagesetting('paragraph'))): ?><p><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) || !empty(pagesetting('section1_2nd_image'))
            || !empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) 
            || !empty(pagesetting('section2_3rd_image')) || !empty(pagesetting('section2_4th_image')) || !empty(pagesetting('section3_heading')) 
            || !empty(pagesetting('section3_image')) || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image'))
            || !empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image'))): ?>
            <div class="am-features-grid">
                <?php if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) 
                    || !empty(pagesetting('section1_2nd_image')) || !empty(pagesetting('section2_heading')) 
                    || !empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) 
                    || !empty(pagesetting('section2_3rd_image')) || !empty(pagesetting('section2_4th_image'))): ?>
                    <div class="am-features-row">
                        <?php if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) || !empty(pagesetting('section1_2nd_image'))): ?>
                            <div class="am-feature-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                <?php if(!empty(pagesetting('section1_heading'))): ?><h3><?php echo e(pagesetting('section1_heading')); ?></h3><?php endif; ?>
                                <?php if(!empty(pagesetting('section1_image'))): ?>
                                    <?php if(!empty(pagesetting('section1_image')[0]['path'])): ?>
                                        <img src="<?php echo e(url(Storage::url(pagesetting('section1_image')[0]['path']))); ?>" class="am-feature-image" alt="Schedule image" />
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('section1_2nd_image'))): ?>
                                    <?php if(!empty(pagesetting('section1_2nd_image')[0]['path'])): ?>
                                        <img src="<?php echo e(url(Storage::url(pagesetting('section1_2nd_image')[0]['path']))); ?>" class="am-feature-icon" alt="Bell icon image" />
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('bg_shape_img'))): ?>
                                    <?php if(!empty(pagesetting('bg_shape_img')[0]['path'])): ?>
                                        <img class="am-img" src="<?php echo e(url(Storage::url(pagesetting('bg_shape_img')[0]['path']))); ?>" alt="image-description">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_image')) 
                            || !empty(pagesetting('section2_2nd_image')) || !empty(pagesetting('section2_3rd_image')) 
                            || !empty(pagesetting('section2_4th_image'))): ?>
                            <div class="am-progress-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                <?php if(!empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) || !empty(pagesetting('section2_3rd_image'))): ?>
                                    <div class="am-images-group">
                                        <?php if(!empty(pagesetting('section2_image'))): ?>
                                            <?php if(!empty(pagesetting('section2_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section2_image')[0]['path']))); ?>" class="am-progress-image1" alt="Background shape image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(!empty(pagesetting('section2_2nd_image'))): ?>
                                            <?php if(!empty(pagesetting('section2_2nd_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section2_2nd_image')[0]['path']))); ?>" class="am-progress-image2" alt="Subject statistics image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(!empty(pagesetting('section2_3rd_image'))): ?>
                                            <?php if(!empty(pagesetting('section2_3rd_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section2_3rd_image')[0]['path']))); ?>" class="am-progress-image3" alt="Order summary image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_4th_image'))): ?>
                                    <?php if(!empty(pagesetting('section2_heading'))): ?><h3><?php echo e(pagesetting('section2_heading')); ?></h3><?php endif; ?>
                                    <?php if(!empty(pagesetting('section2_4th_image'))): ?>
                                        <?php if(!empty(pagesetting('section2_4th_image')[0]['path'])): ?>
                                            <img src="<?php echo e(url(Storage::url(pagesetting('section2_4th_image')[0]['path']))); ?>" class="am-progress-image4" alt="image description" />
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_image')) 
                    || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image')) 
                    || !empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) 
                    || !empty(pagesetting('section4_2nd_image'))): ?>
                    <div class="am-features-row">
                        <?php if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_image')) 
                            || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image'))): ?>
                            <div class="am-tutors-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                <?php if(!empty(pagesetting('section3_heading'))): ?><h3><?php echo e(pagesetting('section3_heading')); ?></h3><?php endif; ?>
                                <?php if(!empty(pagesetting('section3_image')) || !empty(pagesetting('section3_2nd_image'))): ?>
                                    <div class="am-tutor-img">
                                        <?php if(!empty(pagesetting('section3_image'))): ?>
                                            <?php if(!empty(pagesetting('section3_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section3_image')[0]['path']))); ?>" class="am-tutor-img-three" alt="Book image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(!empty(pagesetting('section3_2nd_image'))): ?>
                                            <?php if(!empty(pagesetting('section3_2nd_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section3_2nd_image')[0]['path']))); ?>" class="am-tutor-img-four" alt="User image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('section3_3rd_image'))): ?>
                                    <?php if(!empty(pagesetting('section3_3rd_image')[0]['path'])): ?>
                                        <img src="<?php echo e(url(Storage::url(pagesetting('section3_3rd_image')[0]['path']))); ?>" class="am-tutor-img-five" alt="Students image" />
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image'))): ?>
                            <div class="am-personalize-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                <?php if(!empty(pagesetting('section4_heading'))): ?><h3><?php echo e(pagesetting('section4_heading')); ?></h3><?php endif; ?>
                                <?php if(!empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image'))): ?>
                                    <div class="am-personalize-img">
                                        <?php if(!empty(pagesetting('section4_image'))): ?>
                                            <?php if(!empty(pagesetting('section4_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section4_image')[0]['path']))); ?>" class="am-feature-image-two" alt="Session progress image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(!empty(pagesetting('section4_2nd_image'))): ?>
                                            <?php if(!empty(pagesetting('section4_2nd_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('section4_2nd_image')[0]['path']))); ?>" class="am-feature-image-one" alt="Start session image" />
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if(!empty(pagesetting('shape_img'))): ?>
        <?php if(!empty(pagesetting('shape_img')[0]['path'])): ?>
            <img class="am-img" src="<?php echo e(url(Storage::url(pagesetting('shape_img')[0]['path']))); ?>" alt="image-description">
        <?php endif; ?>
    <?php endif; ?>
</div>
<!-- Unique Features Section End --><?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/unique-features/view.blade.php ENDPATH**/ ?>