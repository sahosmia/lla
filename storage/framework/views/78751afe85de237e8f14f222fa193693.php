<div class="am-banner-potential am-banner-content-six">
    <div class="am-banner-container">
        <?php if(!empty(pagesetting('first_heading'))
            || !empty(pagesetting('second_heading'))
            || !empty(pagesetting('paragraph'))
            || !empty(pagesetting('primary_btn_url'))
            || !empty(pagesetting('primary_btn_txt'))
            || !empty(pagesetting('secondary_btn_url'))
            || !empty(pagesetting('secondary_btn_txt'))): ?>
            <div class="am-banner-main">
                <div class="am-banner-tutor">
                    <?php if(!empty(pagesetting('first_heading')) || !empty(pagesetting('second_heading')) || !empty(pagesetting('paragraph'))): ?>
                        <?php if(!empty(pagesetting('first_heading'))): ?><h1 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"> <?php echo e(pagesetting('first_heading')); ?> </h1><?php endif; ?>
                        <?php if(!empty(pagesetting('second_heading'))): ?><h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400"><?php echo pagesetting('second_heading'); ?></h2><?php endif; ?>
                        <?php if(!empty(pagesetting('paragraph'))): ?><p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600"><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('primary_btn_txt')) || !empty(pagesetting('secondary_btn_txt'))): ?>
                        <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                            <?php if(!empty(pagesetting('primary_btn_txt'))): ?><a href="<?php echo e(pagesetting('primary_btn_url')); ?>" class="am-explore-btn"><?php echo e(pagesetting('primary_btn_txt')); ?></a><?php endif; ?>
                            <?php if(!empty(pagesetting('secondary_btn_txt'))): ?>
                                <a href="<?php echo e(pagesetting('secondary_btn_url')); ?> " class="am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content vbox-item" data-autoplay="true" data-vbtype="video" "="">
                                    <i class="am-icon-play-filled"></i>
                                    <?php echo e(pagesetting('secondary_btn_txt')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="am-reviews">
                        <?php if(!empty(pagesetting('image_repeater')) || !empty(pagesetting('user_rating_text'))): ?>
                            <div class="am-reviews_moreusers" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1000">
                                <?php if(!empty(pagesetting('image_repeater'))): ?>
                                    <ul>
                                        <?php $__currentLoopData = pagesetting('image_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!empty($option['user_review_img'])): ?>
                                                <?php if(!empty($option['user_review_img'][0]['path'])): ?><li><img src="<?php echo e(url(Storage::url($option['user_review_img'][0]['path']))); ?>" alt="Users image"></li><?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('user_rating_text'))): ?><span><?php echo e(pagesetting('user_rating_text')); ?></span><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('rating_repeater')) || !empty(pagesetting('rating')) || !empty(pagesetting('rating_text'))): ?>
                            <div class="am-reviews_ratings" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1200">
                                <?php if(!empty(pagesetting('rating_repeater')) || !empty(pagesetting('rating'))): ?>
                                    <div class="am-reviews_ratings_stars">
                                        <?php if(!empty(pagesetting('rating'))): ?><span><?php echo e(pagesetting('rating')); ?></span> <?php endif; ?>
                                            <?php $__currentLoopData = pagesetting('rating_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <i class="<?php echo $option['rating_icon']; ?>"></i>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('rating_text'))): ?><span><?php echo e(pagesetting('rating_text')); ?></span><?php endif; ?>
                            </div>

                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if(!empty(pagesetting('third_banner_image'))): ?>
                <div class="am-banner-bg">
                    <?php if(!empty(pagesetting('third_banner_image')[0]['path'])): ?><img src="<?php echo e(url(Storage::url(pagesetting('third_banner_image')[0]['path']))); ?>" alt="Background shape image" /><?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="am-banner-imgs">
        <figure>
            <?php if(!empty(pagesetting('banner_main_image'))): ?><img src="<?php echo e(url(Storage::url(pagesetting('banner_main_image')[0]['path']))); ?>" alt="Banner image" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="200"><?php endif; ?>
            <figcaption>
                <?php if(!empty(pagesetting('animated_first_image'))): ?><img class="am-img-1" src="<?php echo e(url(Storage::url(pagesetting('animated_first_image')[0]['path']))); ?>" alt="Rate your experience image" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="1600"><?php endif; ?>
                <?php if(!empty(pagesetting('animated_second_image'))): ?><img class="am-img-2" src="<?php echo e(url(Storage::url(pagesetting('animated_second_image')[0]['path']))); ?>" alt="Cursor image"><?php endif; ?>
            </figcaption>
        </figure>
    </div>
    <?php if(!empty(pagesetting('background_animated_first_image'))): ?><img class="am-bgimg-1" src="<?php echo e(url(Storage::url(pagesetting('background_animated_first_image')[0]['path']))); ?>" alt="Background shape image" /><?php endif; ?>
    <?php if(!empty(pagesetting('background_animated_second_image'))): ?><img class="am-bgimg-2" src="<?php echo e(url(Storage::url(pagesetting('background_animated_second_image')[0]['path']))); ?>" alt="Background shape image" /><?php endif; ?>
</div>

<?php if (! $__env->hasRenderedOnce('7dba0e34-40f1-4bb5-868d-1da7c481dcb9')): $__env->markAsRenderedOnce('7dba0e34-40f1-4bb5-868d-1da7c481dcb9');
$__env->startPush('styles'); ?>
<?php 
$isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
<?php if(!$isEdit): ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/aos.min.css']); ?>
<?php endif; ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('c3a7b8d8-f376-4691-a4c7-9b6107930692')): $__env->markAsRenderedOnce('c3a7b8d8-f376-4691-a4c7-9b6107930692');
$__env->startPush('scripts'); ?>
    <?php if(!$isEdit): ?>
        <script src="<?php echo e(asset('js/aos.min.js')); ?>"></script>
    <?php endif; ?>
    <script section='banner-v6'>
        AOS.init();
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/banner-v6/view.blade.php ENDPATH**/ ?>