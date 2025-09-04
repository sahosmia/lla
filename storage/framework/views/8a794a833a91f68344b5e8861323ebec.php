
<section class="am-vision-section">
    <div class="container-fluaid">
        <?php if(!empty(pagesetting('video'))
            || !empty(pagesetting('pre_heading')) 
            || !empty(pagesetting('heading')) 
            || !empty(pagesetting('paragraph')) 
            || !empty(pagesetting('list_data'))
            || !empty(pagesetting('discover_more_btn_text'))
            || !empty(pagesetting('discover_more_btn_url'))): ?>
            <div class="row">
                <?php if(!empty(pagesetting('video'))): ?>
                    <div class="col-12 col-lg-6">
                        <?php if(!empty(pagesetting('video')[0]['path'])): ?>
                            <video class="video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                <source src="<?php echo e(url(Storage::url(pagesetting('video')[0]['path']))); ?>#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('list_data'))
                    || !empty(pagesetting('discover_more_btn_text'))
                    || !empty(pagesetting('discover_more_btn_url'))): ?>
                    <div class="col-12 col-lg-6">
                        <div class="am-tutor-vision">
                            <div class="am-content_box am-left-text">
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
                                <?php if(!empty(pagesetting('heading'))): ?> <h3><?php echo pagesetting('heading'); ?></h3> <?php endif; ?>
                                <?php if(!empty(pagesetting('paragraph'))): ?> <p><?php echo pagesetting('paragraph'); ?></p> <?php endif; ?>
                                <?php if(!empty( pagesetting('list_data'))): ?>
                                    <ul>
                                        <?php $__currentLoopData = pagesetting('list_data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(!empty($data['item_heading']) || !empty($data['list_item'])): ?> 
                                                <li>
                                                    <span>
                                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none">
                                                            <path d="M7.5 0.5L9.52568 5.97432L15 8L9.52568 10.0257L7.5 15.5L5.47432 10.0257L0 8L5.47432 5.97432L7.5 0.5Z" fill="#F55C2B"/>
                                                        </svg>
                                                    </span>
                                                    <?php if(!empty($data['item_heading']) || !empty($data['list_item'])): ?> 
                                                        <div class="am-content_list">
                                                            <h6><?php echo $data['item_heading']; ?></h6>
                                                            <p><?php echo $data['list_item']; ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('discover_more_btn_text')) || !empty(pagesetting('discover_more_btn_url'))): ?>
                                    <a href="<?php echo e(setting('_lernen.allow_register') !== 'no' ? pagesetting('discover_more_btn_url') : '#'); ?>" class="am-marketplace_content_list_btn am-btn">
                                        <?php echo e(pagesetting('discover_more_btn_text')); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php if (! $__env->hasRenderedOnce('c992ee06-6dab-4e2a-93f8-1ca8e6c0e7b4')): $__env->markAsRenderedOnce('c992ee06-6dab-4e2a-93f8-1ca8e6c0e7b4');
$__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/videojs.css']); ?>
<?php $__env->stopPush(); endif; ?>
<?php if (! $__env->hasRenderedOnce('8a541635-0c6e-41b3-87ff-c3eb17bfaaa9')): $__env->markAsRenderedOnce('8a541635-0c6e-41b3-87ff-c3eb17bfaaa9');
$__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/video.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                visionVideoJs();
            }, 500);
        }); 

        document.addEventListener('loadSectionJs', (event) => {
            if(event.detail.sectionId === 'vision'){
                visionVideoJs();
            }
        }); 

        function visionVideoJs(){
            if(typeof videojs !== 'undefined'){
                jQuery('.video-js').each((index, item) => {
                    item.onloadeddata =  function(){
                        videojs(item);
                    }
                })
            }
        }       
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/vision/view.blade.php ENDPATH**/ ?>