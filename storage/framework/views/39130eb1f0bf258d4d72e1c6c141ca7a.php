
<section class="am-marketplace"> 
    <?php if(!empty(pagesetting('shape_image'))): ?>
        <?php if(!empty(pagesetting('shape_image')[0]['path'])): ?>
            <img class="am-section-shape" src="<?php echo e(url(Storage::url(pagesetting('shape_image')[0]['path']))); ?>" alt="Background shape image">
        <?php endif; ?> 
    <?php endif; ?> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('icon'))
                    || !empty(pagesetting('list-data')) 
                    || !empty(pagesetting('start_journ_heading')) 
                    || !empty(pagesetting('start_journ_description')) 
                    || !empty(pagesetting('get_start_btn_text'))
                    || !empty(pagesetting('get_start_btn_url'))
                    || !empty(pagesetting('image'))): ?>
                    <div class="am-marketplace_content">
                        <?php if(!empty(pagesetting('pre_heading')) 
                            || !empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph')) 
                            || !empty(pagesetting('icon'))
    
                            || !empty(pagesetting('list-data')) 
                            || !empty(pagesetting('start_journ_heading')) 
                            || !empty(pagesetting('start_journ_description')) 
                            || !empty(pagesetting('get_start_btn_text'))
                            || !empty(pagesetting('get_start_btn_url'))): ?>
                            <div class="am-marketplace_content_list">
                                <?php if(!empty(pagesetting('icon'))): ?>
                                    <span>
                                        <i class="<?php echo pagesetting('icon'); ?>"></i>
                                    </span>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))): ?> 
                                    <div class="am-marketplace_content_list_info">
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
                                    </div>
                                <?php endif; ?> 
                                <?php if(!empty(pagesetting('list-data'))): ?>    
                                    <div class="am-marketplace_content_list_details">
                                        <?php if(!empty( pagesetting('list-data'))): ?>
                                            <ul>
                                                <?php $__currentLoopData = pagesetting('list-data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                <path d="M9 0L11.4308 6.56918L18 9L11.4308 11.4308L9 18L6.56918 11.4308L0 9L6.56918 6.56918L9 0Z" fill="white"/>
                                                            </svg>
                                                        </span>
                                                        <h6><?php echo $data['list_item']; ?></h6>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if(!empty(pagesetting('get_start_btn_text'))): ?> 
                                    <a href="<?php if(!empty(pagesetting('get_start_btn_url'))): ?> <?php echo e(pagesetting('get_start_btn_url')); ?> <?php endif; ?>" class="am-marketplace_content_list_btn am-btn">
                                        <?php echo e(pagesetting('get_start_btn_text')); ?>

                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('image'))): ?>
                            <div class="am-marketplace_content_video">
                                <?php if(!empty(pagesetting('image')[0]['path'])): ?>
                                    <img src="<?php echo e(url(Storage::url(pagesetting('image')[0]['path']))); ?>" alt="Marketplace image">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>  
                <?php endif; ?>
            </div>
        </div>
    </div>
</section><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/marketplace/view.blade.php ENDPATH**/ ?>