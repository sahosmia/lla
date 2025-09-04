<div class="am-banner-vfive">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading_image'))
                    || !empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('search_btn_txt')) 
                    || !empty(pagesetting('search_placeholder')) 
                    || !empty(pagesetting('banner_first_image')) 
                    || !empty(pagesetting('banner_second_image')) 
                    || !empty(pagesetting('banner_third_image')) 
                    || !empty(pagesetting('banner_fourth_image')) 
                    || !empty(pagesetting('banner_fifth_image'))): ?>
                    <div class="am-banner"  data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                        <div class="am-banner_wrap">
                            <?php if(!empty(pagesetting('pre_heading_image'))
                                || !empty(pagesetting('pre_heading')) 
                                || !empty(pagesetting('heading')) 
                                || !empty(pagesetting('paragraph')) 
                                || !empty(pagesetting('search_btn_txt')) 
                                || !empty(pagesetting('search_placeholder'))): ?>
                                <div class="am-banner-content">
                                    <?php if(!empty(pagesetting('pre_heading_image')) || !empty(pagesetting('pre_heading'))): ?> 
                                        <span class="am-banner_tag" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600"
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
                                            <?php if(!empty(pagesetting('pre_heading_image'))): ?>
                                                <figure>
                                                    <?php if(!empty(pagesetting('pre_heading_image')[0]['path'])): ?>
                                                        <img src="<?php echo e(url(Storage::url(pagesetting('pre_heading_image')[0]['path']))); ?>" alt="Heading image">
                                                    <?php endif; ?>
                                                </figure>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('pre_heading'))): ?> <?php echo e(pagesetting('pre_heading')); ?> <?php endif; ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if(!empty(pagesetting('heading'))): ?><h1 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="700"><?php echo pagesetting('heading'); ?></h1><?php endif; ?>
                                    <?php if(!empty(pagesetting('paragraph'))): ?><p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800"><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                                    <?php if(!empty(pagesetting('search_btn_txt')) || !empty(pagesetting('search_placeholder'))): ?> 
                                        <form action="<?php echo e(url('find-tutors')); ?>" method="GET" class="am-learning_search" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="900">
                                            <i class="am-icon-search-02"></i>
                                            <?php if(!empty(pagesetting('search_placeholder'))): ?>
                                                <div class="am-learning_search_input">
                                                    <input type="text" name="keyword" placeholder="<?php echo e(pagesetting('search_placeholder')); ?>">
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('search_btn_txt'))): ?>
                                                <button type="submit" class="am-learning_search_btn am-btn">
                                                    <?php echo e(pagesetting('search_btn_txt')); ?>    
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('banner_first_image')) 
                                || !empty(pagesetting('banner_second_image')) 
                                || !empty(pagesetting('banner_third_image')) 
                                || !empty(pagesetting('banner_fourth_image')) 
                                || !empty(pagesetting('banner_fifth_image'))): ?>
                                <div class="am-banner_images">
                                    <figure>
                                        <?php if(!empty(pagesetting('banner_first_image'))): ?>
                                            <?php if(!empty(pagesetting('banner_first_image')[0]['path'])): ?>
                                                <img src="<?php echo e(url(Storage::url(pagesetting('banner_first_image')[0]['path']))); ?>" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="600" alt="User image">
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <figcaption>
                                            <?php if(!empty(pagesetting('banner_second_image'))): ?>
                                                <?php if(!empty(pagesetting('banner_second_image')[0]['path'])): ?>
                                                    <img  class="am-image-one" src="<?php echo e(url(Storage::url(pagesetting('banner_second_image')[0]['path']))); ?>" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800" alt="Online user image">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('banner_third_image'))): ?>
                                                <?php if(!empty(pagesetting('banner_third_image')[0]['path'])): ?>
                                                    <img  class="am-image-two" src="<?php echo e(url(Storage::url(pagesetting('banner_third_image')[0]['path']))); ?>" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="900" alt="Users image">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('banner_fourth_image'))): ?>
                                                <?php if(!empty(pagesetting('banner_fourth_image')[0]['path'])): ?>
                                                    <img  class="am-image-three" src="<?php echo e(url(Storage::url(pagesetting('banner_fourth_image')[0]['path']))); ?>" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1000" alt="Cursor image">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('banner_fifth_image'))): ?>
                                                <?php if(!empty(pagesetting('banner_fifth_image')[0]['path'])): ?>
                                                    <img  class="am-image-four" src="<?php echo e(url(Storage::url(pagesetting('banner_fifth_image')[0]['path']))); ?>" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1100" alt="Rate experience image">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </figcaption>
                                    </figure>
                                    <?php if(!empty(pagesetting('bg_shape_img_one'))): ?>
                                        <?php if(!empty(pagesetting('bg_shape_img_one')[0]['path'])): ?>
                                            <img class="am-img_one" src="<?php echo e(url(Storage::url(pagesetting('bg_shape_img_one')[0]['path']))); ?>" alt="images-description">
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(!empty(pagesetting('bg_shape_img_two'))): ?>
                                        <?php if(!empty(pagesetting('bg_shape_img_two')[0]['path'])): ?>
                                            <img class="am-img_two" src="<?php echo e(url(Storage::url(pagesetting('bg_shape_img_two')[0]['path']))); ?>" alt="images-description">
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if(!empty(pagesetting('first_shape_img'))): ?>
                            <?php if(!empty(pagesetting('first_shape_img')[0]['path'])): ?>
                                <img class="am_img_one" src="<?php echo e(url(Storage::url(pagesetting('first_shape_img')[0]['path']))); ?>" alt="images-description">
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('second_shape_img'))): ?>
                            <?php if(!empty(pagesetting('second_shape_img')[0]['path'])): ?>
                                <img class="am_img_two" src="<?php echo e(url(Storage::url(pagesetting('second_shape_img')[0]['path']))); ?>" alt="images-description">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if (! $__env->hasRenderedOnce('84415cef-aa1b-43a0-8bf3-08f74352b04e')): $__env->markAsRenderedOnce('84415cef-aa1b-43a0-8bf3-08f74352b04e');
$__env->startPush('styles'); ?>
<?php 
$isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
<?php if(!$isEdit): ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/aos.min.css']); ?>
<?php endif; ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('a9b8fe8d-1183-4c86-af36-4b8b8ab3825c')): $__env->markAsRenderedOnce('a9b8fe8d-1183-4c86-af36-4b8b8ab3825c');
$__env->startPush('scripts'); ?>
    <?php if(!$isEdit): ?>
        <script src="<?php echo e(asset('js/aos.min.js')); ?>"></script>
    <?php endif; ?>
    <script section='banner-v5'>
        AOS.init();
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/banner-v5/view.blade.php ENDPATH**/ ?>