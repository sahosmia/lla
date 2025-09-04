<div class="am-banner">
    <div class="am-banner_shapes">
        <?php if(!empty(pagesetting('shape_img_one'))): ?>
            <?php if(!empty(pagesetting('shape_img_one')[0]['path'])): ?>
                <img src="<?php echo e(url(Storage::url(pagesetting('shape_img_one')[0]['path']))); ?>" class="am-img_one" alt="Background shape image">
            <?php endif; ?>
        <?php endif; ?>
        <?php if(!empty(pagesetting('shape_img_two'))): ?>
            <?php if(!empty(pagesetting('shape_img_two')[0]['path'])): ?>
                <img src="<?php echo e(url(Storage::url(pagesetting('shape_img_two')[0]['path']))); ?>" class="am-img_two" alt="Background shape image">
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading_image'))
                    || !empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('all_tutor_btn_url')) 
                    || !empty(pagesetting('all_tutor_btn_txt')) 
                    || !empty(pagesetting('see_demo_btn_url')) 
                    || !empty(pagesetting('see_demo_btn_txt')) 
                    || !empty(pagesetting('image'))): ?>
                    <div class="am-banner_wrap">
                        <div class="am-banner_content">
                            <?php if(!empty(pagesetting('pre_heading_image')) || !empty(pagesetting('pre_heading'))): ?> 
                                <div class="am-banner_tag">
                                    <?php if(!empty(pagesetting('pre_heading_image'))): ?>
                                        <figure>
                                            <?php if(!empty(pagesetting('pre_heading_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('pre_heading_image')[0]['path']))); ?>" alt="Heading image">
                                            <?php endif; ?>
                                        </figure>
                                    <?php endif; ?>
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
                                </div>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('heading'))): ?><h1><?php echo pagesetting('heading'); ?></h1><?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?><p><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                            <div class="am-banner_btns">
                                <?php if(!empty(pagesetting('all_tutor_btn_txt')) || !empty(pagesetting('all_tutor_btn_url'))): ?> 
                                    <a href="<?php if(!empty(pagesetting('all_tutor_btn_url'))): ?> <?php echo e(pagesetting('all_tutor_btn_url')); ?> <?php endif; ?>" class="am-primary-btn">
                                        <?php echo e(pagesetting('all_tutor_btn_txt')); ?>

                                    </a>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('see_demo_btn_txt')) || !empty(pagesetting('see_demo_btn_url'))): ?> 
                                    <a href="<?php if(!empty(pagesetting('see_demo_btn_url'))): ?><?php echo e(pagesetting('see_demo_btn_url')); ?><?php endif; ?>" class="am-primary-btn-white tu-themegallery tu-thumbnails_content" data-autoplay="true" data-vbtype="video">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.20214 2.97528C4.6106 2.00267 3.81483 1.51637 3.15921 1.57372C2.58762 1.62372 2.06503 1.91681 1.72431 2.37846C1.3335 2.90799 1.3335 3.84059 1.3335 5.70578V10.7439C1.3335 12.6091 1.3335 13.5417 1.72431 14.0713C2.06503 14.5329 2.58762 14.826 3.15921 14.876C3.81483 14.9333 4.6106 14.447 6.20213 13.4744L10.3243 10.9554C11.8016 10.0526 12.5402 9.60118 12.792 9.02006C13.0119 8.51272 13.0119 7.937 12.792 7.42966C12.5402 6.84855 11.8016 6.39715 10.3243 5.49436L6.20214 2.97528Z" fill="white"/>
                                        </svg>
                                        <?php echo e(pagesetting('see_demo_btn_txt')); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(!empty(pagesetting('image'))): ?> 
                            <div class="am-banner_images">
                                <figure>
                                    <?php if(!empty(pagesetting('image')[0]['path'])): ?>
                                        <img src="<?php echo e(url(Storage::url(pagesetting('image')[0]['path']))); ?>" alt="Banner image">
                                    <?php endif; ?>
                                </figure>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty(pagesetting('banner_repeater'))): ?>
                    <ul class="am-banner_companies am-banner-image">
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
        </div>
    </div>
</div>

<?php if (! $__env->hasRenderedOnce('e82ebffb-85ed-4258-a48e-9a048ff2d50b')): $__env->markAsRenderedOnce('e82ebffb-85ed-4258-a48e-9a048ff2d50b');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/venobox.min.css']); ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('32b69f55-8368-4c40-9e30-588582de0572')): $__env->markAsRenderedOnce('32b69f55-8368-4c40-9e30-588582de0572');
$__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('js/venobox.min.js')); ?>"></script>
<script>
     document.addEventListener('DOMContentLoaded', function () {
        initVenobox()
     });
</script>
<?php $__env->stopPush(); endif; ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/banner-v2/view.blade.php ENDPATH**/ ?>