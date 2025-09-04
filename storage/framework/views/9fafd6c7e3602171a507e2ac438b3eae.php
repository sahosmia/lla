<div class="am-guidesteps">
    <?php if(!empty(pagesetting('pre_heading')) 
        || !empty(pagesetting('heading')) 
        || !empty(pagesetting('paragraph')) 
        || !empty(pagesetting('steps_data')) 
        || !empty(pagesetting('primary_btn_url')) 
        || !empty(pagesetting('primary_btn_text')) 
        || !empty(pagesetting('secondary_btn_url')) 
        || !empty(pagesetting('secondary_btn_text'))
        || !empty(pagesetting('first_shape_image'))
        || !empty(pagesetting('second_shape_image'))): ?>
        <div class="am-guidesteps_contentwrap">
            <?php if(!empty(pagesetting('pre_heading')) 
                || !empty(pagesetting('heading')) 
                || !empty(pagesetting('paragraph')) 
                || !empty(pagesetting('steps_data')) 
                || !empty(pagesetting('primary_btn_url')) 
                || !empty(pagesetting('primary_btn_text')) 
                || !empty(pagesetting('secondary_btn_url')) 
                || !empty(pagesetting('secondary_btn_text'))): ?>
                <div class="am-guidesteps_content">
                    <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?>
                        <div class="am-section_title <?php echo e(pagesetting('section_title_variation')); ?>">
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
                            <?php if(!empty(pagesetting('heading'))): ?> <h2><?php echo pagesetting('heading'); ?></h2> <?php endif; ?>
                            <?php if(!empty(pagesetting('paragraph'))): ?> <p><?php echo pagesetting('paragraph'); ?></p> <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('steps_data'))): ?>
                        <ul class="am-guidesteps_list">
                            <?php $__currentLoopData = pagesetting('steps_data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($option['step_heading']) || !empty($option['step_paragraph']) || !empty($option['step_icon'])): ?>
                                    <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="<?php echo e($loop->index * 200); ?>">
                                        <div class="am-guidesteps_list_item">
                                            <?php if(!empty($option['step_icon'])): ?><span><i class="<?php echo $option['step_icon']; ?>"></i></span><?php endif; ?>
                                            <?php if(!empty($option['step_heading']) || !empty($option['step_paragraph'])): ?>
                                                <div class="am-guidesteps_list_info">
                                                    <?php if(!empty($option['step_heading'])): ?> <h5><?php echo $option['step_heading']; ?></h5> <?php endif; ?>
                                                    <?php if(!empty($option['step_paragraph'])): ?> <p><?php echo $option['step_paragraph']; ?></p> <?php endif; ?>
                                                </div>
                                            <?php endif; ?>   
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                    <?php if(!empty(pagesetting('primary_btn_url')) || !empty(pagesetting('primary_btn_text')) 
                        || !empty(pagesetting('secondary_btn_url')) || !empty(pagesetting('secondary_btn_text'))): ?>
                        <div class="am-guidesteps_btns" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                            <?php if(!empty(pagesetting('primary_btn_text'))): ?>
                                <a href="<?php if(!empty(pagesetting('primary_btn_url'))): ?> <?php echo e(pagesetting('primary_btn_url')); ?> <?php endif; ?>" class="am-explore-btn">
                                    <?php echo e(pagesetting('primary_btn_text')); ?>

                                </a>
                            <?php endif; ?>
                            <?php if(!empty(pagesetting('secondary_btn_text'))): ?>
                                <a href="<?php if(!empty(pagesetting('secondary_btn_url'))): ?> <?php echo e(pagesetting('secondary_btn_url')); ?> <?php endif; ?>" class="am-demo-btn tu-themegallery tu-thumbnails_content vbox-item" data-autoplay="true" data-vbtype="video" "="">
                                    <i class="am-icon-play-filled"></i> 
                                    <?php echo e(pagesetting('secondary_btn_text')); ?>

                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if(!empty(pagesetting('first_shape_image')) || !empty(pagesetting('second_shape_image'))): ?>
                <?php if(!empty(pagesetting('first_shape_image')[0]['path'])): ?>
                    <img class="am-stepbgimg-1" src="<?php echo e(url(Storage::url(pagesetting('first_shape_image')[0]['path']))); ?>" alt="Background shape image">
                <?php endif; ?>
                <?php if(!empty(pagesetting('second_shape_image')[0]['path'])): ?>
                    <img class="am-stepbgimg-2" src="<?php echo e(url(Storage::url(pagesetting('second_shape_image')[0]['path']))); ?>" alt="Background shape image">
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if(!empty(pagesetting('main_image'))): ?>
        <div class="am-guidesteps_bookingsection" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="200">
            <figure>
                <img src="<?php echo e(url(Storage::url(pagesetting('main_image')[0]['path']))); ?>" alt="Guide steps image">
            </figure>
        </div>
    <?php endif; ?>
</div>

<?php if (! $__env->hasRenderedOnce('46d5d76f-e7e9-4da3-afee-f10e99b04b6f')): $__env->markAsRenderedOnce('46d5d76f-e7e9-4da3-afee-f10e99b04b6f');
$__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['public/css/venobox.min.css']); ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('967cc626-c361-4ce7-be83-de603de686e4')): $__env->markAsRenderedOnce('967cc626-c361-4ce7-be83-de603de686e4');
$__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/venobox.min.js')); ?>"></script>
    <script section='guide-steps'>
        document.addEventListener('DOMContentLoaded', (event) => {
            initVenobox()
        });
    </script>
<?php $__env->stopPush(); endif; ?>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/guide-steps/view.blade.php ENDPATH**/ ?>