<div class="am-banner-potential am-banner-content-three">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('all_tutor_btn_url')) 
                    || !empty(pagesetting('all_tutor_btn_txt')) 
                    || !empty(pagesetting('see_demo_btn_url')) 
                    || !empty(pagesetting('see_demo_btn_txt')) 
                    || !empty(pagesetting('left_image'))
                    || !empty(pagesetting('video'))
                    || !empty(pagesetting('wright_image'))
                    || !empty(pagesetting('allen_image'))): ?>
                    <div class="am-banner-main">
                        <div class="am-banner-content">
                            <div class="am-banner-tutor">
                                <?php if(!empty(pagesetting('pre_heading'))): ?>
                                    <span class="am-enhance" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"
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
                                <?php if(!empty(pagesetting('heading'))): ?><h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300" ><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                                <?php if(!empty(pagesetting('paragraph'))): ?><span data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400"><?php echo pagesetting('paragraph'); ?></span><?php endif; ?>
                                <?php if(!empty(pagesetting('all_tutor_btn_txt')) 
                                    || !empty(pagesetting('all_tutor_btn_url'))
                                    || !empty(pagesetting('see_demo_btn_txt')) 
                                    || !empty(pagesetting('see_demo_btn_url'))): ?>
                                    <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500">
                                        <?php if(!empty(pagesetting('all_tutor_btn_txt'))): ?> 
                                            <a href="<?php if(!empty(pagesetting('all_tutor_btn_url'))): ?> <?php echo e(pagesetting('all_tutor_btn_url')); ?> <?php endif; ?>" class="am-btn am-explore-btn"> 
                                                <?php echo e(pagesetting('all_tutor_btn_txt')); ?>

                                            </a>
                                        <?php endif; ?>
                                        <?php if(!empty(pagesetting('see_demo_btn_txt'))): ?> 
                                            <a href="<?php if(!empty(pagesetting('see_demo_btn_url'))): ?> <?php echo e(pagesetting('see_demo_btn_url')); ?> <?php endif; ?>" class="am-btn am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content"  data-autoplay="true" data-vbtype="video"><i class="am-icon-play-filled"></i> 
                                                <?php echo e(pagesetting('see_demo_btn_txt')); ?>

                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(!empty(pagesetting('banner_repeater'))): ?>
                            <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                <?php $__currentLoopData = pagesetting('banner_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(!empty($option['banner_image'])): ?>
                                        <?php if(!empty($option['banner_image'][0]['path'])): ?>
                                            <li><figure><img src="<?php echo e(url(Storage::url($option['banner_image'][0]['path']))); ?>" alt="Company logo"></figure></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('left_image'))
                            || !empty(pagesetting('video'))
                            || !empty(pagesetting('wright_image'))): ?>
                            <div class="am-banner-slide-img" data-aos="fade-up" data-aos-easing="linear" data-aos-delay="1200">
                                <figure>
                                    <?php if(!empty(pagesetting('video'))): ?>
                                        <div class="am-revolutionize_video am-shimmer">
                                            <?php if(!empty(pagesetting('video')[0]['path'])): ?>
                                                <video class="  video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                                    <source src="<?php echo e(url(Storage::url(pagesetting('video')[0]['path']))); ?>#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                                                </video>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(!empty(pagesetting('left_image')) || !empty(pagesetting('wright_image')) || !empty(pagesetting('allen_image'))): ?>
                                        <figcaption>
                                            <?php if(!empty(pagesetting('left_image'))): ?><img class="am-banner-img-one" src="<?php echo e(url(Storage::url(pagesetting('left_image')[0]['path']))); ?>" alt="First banner image" /> <?php endif; ?>
                                            <?php if(!empty(pagesetting('wright_image'))): ?><img class="am-banner-img-two" data-aos="fade-up" src="<?php echo e(url(Storage::url(pagesetting('wright_image')[0]['path']))); ?>" alt="Second banner image" /> <?php endif; ?>
                                            <?php if(!empty(pagesetting('allen_image'))): ?><img class="am-banner-img-three"  data-aos="fade-up" src="<?php echo e(url(Storage::url(pagesetting('allen_image')[0]['path']))); ?>" alt="Cursor image" /> <?php endif; ?>
                                        </figcaption>
                                    <?php endif; ?>
                                </figure>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('ad8c6c90-cf72-4934-a164-01c2e5d5a097')): $__env->markAsRenderedOnce('ad8c6c90-cf72-4934-a164-01c2e5d5a097');
$__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['public/css/videojs.css']); ?>
<?php 
$isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
<?php if(!$isEdit): ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/aos.min.css']); ?>
<?php endif; ?>
<?php echo app('Illuminate\Foundation\Vite')(['public/css/venobox.min.css']); ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('44283cce-3af2-4d0c-8b7d-48f599998b9d')): $__env->markAsRenderedOnce('44283cce-3af2-4d0c-8b7d-48f599998b9d');
$__env->startPush('scripts'); ?>
<?php if(!$isEdit): ?>
    <script src="<?php echo e(asset('js/aos.min.js')); ?>"></script>
<?php endif; ?>
    <script src="<?php echo e(asset('js/venobox.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/video.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                bannerV3VideoJs();
            }, 500);
        }); 

        document.addEventListener('loadSectionJs', (event) => {
            if(event.detail.sectionId === 'banner-v3'){
                bannerV3VideoJs();
            }
        }); 

        function bannerV3VideoJs(){
            if(typeof videojs !== 'undefined'){
                jQuery('.video-js').each((index, item) => {
                    item.onloadeddata =  function(){
                        videojs(item);
                    }
                })
            }
        }       

        if (typeof AOS !== 'undefined') {
            AOS.init();
        }
        
       
    </script>
<?php $__env->stopPush(); endif; ?>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/banner-v3/view.blade.php ENDPATH**/ ?>