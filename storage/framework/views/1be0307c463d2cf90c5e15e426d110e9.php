<section class="am-banner_section"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
            <?php if(!empty(pagesetting('heading')) 
                || !empty(pagesetting('paragraph')) 
                || !empty(pagesetting('all_tutor_btn_url')) 
                || !empty(pagesetting('all_tutor_btn_txt')) 
                || !empty(pagesetting('brand_heading')) 
                || !empty(pagesetting('image'))
                || !empty(pagesetting('banner_image'))): ?>
                <div class="am-banner_wrap">
                    <?php if(!empty(pagesetting('heading')) 
                        || !empty(pagesetting('paragraph')) 
                        || !empty(pagesetting('all_tutor_btn_url')) 
                        || !empty(pagesetting('all_tutor_btn_txt')) 
                        || !empty(pagesetting('brand_heading')) 
                        || !empty(pagesetting('image'))): ?>
                        <div class="am-banner_content">
                            <?php if(!empty(pagesetting('heading'))): ?>
                                <h1 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"><?php echo pagesetting('heading'); ?></h1>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?>
                                <p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300"><?php echo pagesetting('paragraph'); ?></p>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('all_tutor_btn_txt'))): ?> 
                                <div class="am-banner_btns" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                    <a href="<?php if(!empty(pagesetting('all_tutor_btn_url'))): ?> <?php echo e(pagesetting('all_tutor_btn_url')); ?> <?php endif; ?>" class="am-primary-btn">
                                        <?php echo e(pagesetting('all_tutor_btn_txt')); ?>

                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('brand_heading')) || !empty(pagesetting('banner_repeater'))): ?>
                                <div class="am-banner_logo">
                                    <?php if(!empty(pagesetting('brand_heading'))): ?>
                                        <span data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500"><?php echo e(pagesetting('brand_heading')); ?> <em></em></span>
                                    <?php endif; ?>
                                    <?php if(!empty(pagesetting('banner_repeater'))): ?>
                                        <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                            <?php $__currentLoopData = pagesetting('banner_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(!empty($option['banner_image'][0]['path'])): ?>
                                                    <li><figure><img src="<?php echo e(url(Storage::url($option['banner_image'][0]['path']))); ?>" alt="Company logo"></figure></li>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div> 
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('image'))): ?>
                        <div class="am-banner_images">
                            <?php if(!empty(pagesetting('image')[0]['path'])): ?>
                                <figure>
                                    <img src="<?php echo e(url(Storage::url(pagesetting('image')[0]['path']))); ?>" alt="Banner image" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="600">
                                </figure>
                            <?php endif; ?>
                        </div>  
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php if (! $__env->hasRenderedOnce('47f16bcd-7459-4f68-94cd-212e3cbae3b8')): $__env->markAsRenderedOnce('47f16bcd-7459-4f68-94cd-212e3cbae3b8');
$__env->startPush('styles'); ?>
<?php 
$isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
<?php if(!$isEdit): ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/aos.min.css']); ?>
<?php endif; ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('ec4ae893-614c-47c7-b99b-4b05f86336c1')): $__env->markAsRenderedOnce('ec4ae893-614c-47c7-b99b-4b05f86336c1');
$__env->startPush('scripts'); ?>
    <?php if(!$isEdit): ?>
        <script src="<?php echo e(asset('js/aos.min.js')); ?>"></script>
    <?php endif; ?>
    <script section='banner-v9'>
        AOS.init();
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/banner-v9/view.blade.php ENDPATH**/ ?>