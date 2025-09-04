<div class="am-revolutionize">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-revolutionize_wrap">
                    <?php if(!empty(pagesetting('video'))): ?>
                        <div class="am-revolutionize_video">
                            <?php if(!empty(pagesetting('video')[0]['path'])): ?>
                                <video class="video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                    <source src="<?php echo e(url(Storage::url(pagesetting('video')[0]['path']))); ?>#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                                </video>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="am-revolutionize_content">
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
                                <?php if(!empty(pagesetting('heading'))): ?><h2><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                                <?php if(!empty(pagesetting('paragraph'))): ?><?php echo pagesetting('paragraph'); ?><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('revolutionize_repeater'))): ?>
                            <div class="am-revolutionize_achivments">
                                <?php $__currentLoopData = pagesetting('revolutionize_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="am-revolutionize_achivments_content">
                                        <?php if(!empty($option['revolu_image'][0]['path'])): ?>
                                            <figure><img src="<?php echo e(url(Storage::url($option['revolu_image'][0]['path']))); ?>" alt="Revolutionize image"></figure>
                                        <?php endif; ?>
                                        <?php if(!empty($option['revolu_heading'])): ?><h4><?php echo $option['revolu_heading']; ?></h4><?php endif; ?>
                                        <?php if(!empty($option['revolu_paragraph'])): ?><p><?php echo $option['revolu_paragraph']; ?></p><?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty(pagesetting('bg_image'))): ?>
        <?php if(!empty(pagesetting('bg_image')[0]['path'])): ?>
            <img src="<?php echo e(url(Storage::url(pagesetting('bg_image')[0]['path']))); ?>" alt="Background shape image">
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php if (! $__env->hasRenderedOnce('dcaf4e2e-c3af-46c0-bdf4-67acb4899f25')): $__env->markAsRenderedOnce('dcaf4e2e-c3af-46c0-bdf4-67acb4899f25');
$__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')(['public/css/videojs.css']); ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('4b443b52-2785-45e6-83c7-e878f45f83f8')): $__env->markAsRenderedOnce('4b443b52-2785-45e6-83c7-e878f45f83f8');
$__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/video.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                revolutionizeVideoJs();
            }, 500);
        });

        document.addEventListener('loadSectionJs', (event) => {
            if(event.detail.sectionId === 'revolutionize'){
                revolutionizeVideoJs();
            }
        });
 
        function revolutionizeVideoJs(){
            if(typeof videojs !== 'undefined'){
                jQuery('.video-js').each((index, item) => {
                    item.onloadeddata =  function(){
                        videojs(item);
                    }
                })
            }
        }
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/pagebuilder/revolutionize/view.blade.php ENDPATH**/ ?>