<div class="am-banner-seven">
    <div class="am-banner-potential am-banner-content-seven">
        <?php if(!empty(pagesetting('bg_img'))): ?>
            <img class="am-banner-img" src="<?php echo e(url(Storage::url(pagesetting('bg_img')[0]['path']))); ?>" alt="Banner image"> 
        <?php endif; ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if(!empty(pagesetting('heading')) 
                        || !empty(pagesetting('paragraph')) 
                        || !empty(pagesetting('primary_btn_url')) 
                        || !empty(pagesetting('primary_btn_txt')) 
                        || !empty(pagesetting('secondary_btn_url')) 
                        || !empty(pagesetting('secondary_btn_txt'))
                        || !empty(pagesetting('banner_repeater'))): ?>
                        <div class="am-banner-main">
                            <?php if(!empty(pagesetting('heading')) 
                                || !empty(pagesetting('paragraph')) 
                                || !empty(pagesetting('primary_btn_url')) 
                                || !empty(pagesetting('primary_btn_txt')) 
                                || !empty(pagesetting('secondary_btn_url')) 
                                || !empty(pagesetting('secondary_btn_txt'))): ?>
                                <div class="am-banner-tutor">
                                    <?php if(!empty(pagesetting('heading'))): ?><h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                                    <?php if(!empty(pagesetting('paragraph'))): ?><p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400"><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                                    <?php if(!empty(pagesetting('primary_btn_txt'))  || !empty(pagesetting('secondary_btn_txt'))): ?>
                                        <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                            <?php if(!empty(pagesetting('primary_btn_txt'))): ?>
                                                <a href="<?php if(!empty(pagesetting('primary_btn_url'))): ?> <?php echo e(pagesetting('primary_btn_url')); ?> <?php endif; ?>" class="am-explore-btn"> 
                                                    <?php echo e(pagesetting('primary_btn_txt')); ?>

                                                </a>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('secondary_btn_txt'))): ?>
                                                <a href="<?php if(!empty(pagesetting('secondary_btn_url'))): ?> <?php echo e(pagesetting('secondary_btn_url')); ?> <?php endif; ?>" class="am-btn am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content"  data-autoplay="true" data-vbtype="video">
                                                    <i class="am-icon-play-filled"></i>
                                                    <?php echo e(pagesetting('secondary_btn_txt')); ?>

                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('banner_repeater'))): ?>
                                <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                                    <?php $__currentLoopData = pagesetting('banner_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($option['banner_image'])): ?>
                                            <?php if(!empty($option['banner_image'][0]['path'])): ?>
                                                <li><figure><img src="<?php echo e(url(Storage::url($option['banner_image'][0]['path']))); ?>" alt="Company logo"></figure></li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('9d39720c-7426-47d8-a888-22af81b4799f')): $__env->markAsRenderedOnce('9d39720c-7426-47d8-a888-22af81b4799f');
$__env->startPush('styles'); ?>
<?php 
    $isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
<?php if(!$isEdit): ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/aos.min.css']); ?>
<?php endif; ?>
<?php echo app('Illuminate\Foundation\Vite')(['public/css/venobox.min.css']); ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('39272a1d-fd55-40d3-8be4-aceb450e24ca')): $__env->markAsRenderedOnce('39272a1d-fd55-40d3-8be4-aceb450e24ca');
$__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/venobox.min.js')); ?>"></script>
    <?php if(!$isEdit): ?>
        <script src="<?php echo e(asset('js/aos.min.js')); ?>"></script>
    <?php endif; ?>
    <script section='banner-v7'>
        AOS.init();
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/banner-v7/view.blade.php ENDPATH**/ ?>