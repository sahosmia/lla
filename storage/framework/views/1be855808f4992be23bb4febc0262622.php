<section class="am-mission_section <?php echo e(pagesetting('style_variation')); ?>">
    <div class="container">
        <?php if(!empty(pagesetting('pre_heading')) 
            || !empty(pagesetting('heading')) 
            || !empty(pagesetting('paragraph')) 
            || !empty(pagesetting('list_data'))): ?>
            <div class="row">
                <?php if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('list_data'))): ?>
                    <div class="col-12 col-lg-6 order-2 order-lg-1">
                        <div class="am-content_box am-left-text <?php echo e(pagesetting('select_title_verient')); ?>">
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
                            <?php if(!empty(pagesetting('list_data'))): ?>
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
                            <?php if(!empty(pagesetting('button_enabled')) && pagesetting('button_enabled') == 'yes'): ?>
                                <?php if(!empty(pagesetting('button_text')) || !empty(pagesetting('button_url'))): ?>
                                    <div class="am-mission-button">
                                        <a href="<?php echo e(setting('_lernen.allow_register') !== 'no' ? pagesetting('button_url') : '#'); ?>" class="am-btn btn-primary"><?php echo pagesetting('button_text'); ?></a>
                                    </div>  
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty(pagesetting('mission_frame_image')) 
                    || !empty(pagesetting('user_one_image')) 
                    || !empty(pagesetting('handshake_image')) 
                    || !empty(pagesetting('user_two_image'))
                    || !empty(pagesetting('image_heading'))
                    || !empty(pagesetting('courses_text'))): ?>
                    <div class="col-12 col-lg-6 order-1 order-lg-2">
                        <div class="am-mission_iframe">
                            <?php if(!empty(pagesetting('mission_frame_image')) 
                                || !empty(pagesetting('user_one_image')) 
                                || !empty(pagesetting('handshake_image')) 
                                || !empty(pagesetting('user_two_image'))
                                || !empty(pagesetting('image_heading'))
                                || !empty(pagesetting('courses_text'))): ?>
                                <figure>
                                    <?php if(!empty(pagesetting('mission_frame_image'))): ?>
                                        <?php if(!empty(pagesetting('mission_frame_image')[0]['path'])): ?>
                                            <img src="<?php echo e(url(Storage::url(pagesetting('mission_frame_image')[0]['path']))); ?>" alt="Empowering learners image">
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if(!empty(pagesetting('user_one_image')) 
                                        || !empty(pagesetting('handshake_image')) 
                                        || !empty(pagesetting('user_two_image'))
                                        || !empty(pagesetting('image_heading'))
                                        || !empty(pagesetting('courses_text'))): ?>
                                        <figcaption>
                                            <?php if(!empty(pagesetting('user_one_image'))): ?>
                                                <?php if(!empty(pagesetting('user_one_image')[0]['path'])): ?>
                                                    <img src="<?php echo e(url(Storage::url(pagesetting('user_one_image')[0]['path']))); ?>" alt="User image">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('handshake_image'))): ?>
                                                <?php if(!empty(pagesetting('handshake_image')[0]['path'])): ?>
                                                    <img src="<?php echo e(url(Storage::url(pagesetting('handshake_image')[0]['path']))); ?>" class="am-mission-handshake-img" alt="Handshake image">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('user_two_image')) || !empty(pagesetting('image_heading'))): ?>
                                                <div class="am-mission_learning">
                                                    <div class="am-mission_platform">
                                                        <?php if(!empty(pagesetting('user_two_image'))): ?>
                                                            <figure>
                                                                <?php if(!empty(pagesetting('user_two_image')[0]['path'])): ?>
                                                                    <img src="<?php echo e(url(Storage::url(pagesetting('user_two_image')[0]['path']))); ?>" alt="User image">
                                                                <?php endif; ?>
                                                            </figure>
                                                        <?php endif; ?>
                                                        <?php if(!empty(pagesetting('image_heading'))): ?>
                                                            <span><?php echo pagesetting('image_heading'); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span>
                                                        <svg width="10" height="11" viewBox="0 0 10 11" fill="none">
                                                            <path d="M8.61738 4.74292C8.75098 4.83198 8.85118 4.94332 8.91799 5.07692C8.98479 5.21053 9.01819 5.35155 9.01819 5.5C9.01819 5.64845 8.98479 5.78947 8.91799 5.92308C8.85118 6.05668 8.75098 6.16802 8.61738 6.25708L1.35827 10.8664C1.28405 10.9109 1.20611 10.9443 1.12446 10.9666C1.04282 10.9889 0.964884 11 0.890659 11C0.653143 11 0.445315 10.9146 0.267178 10.7439C0.0890398 10.5732 -2.86102e-05 10.3617 -2.86102e-05 10.1093L-2.86102e-05 0.890688C-2.86102e-05 0.638327 0.0890398 0.426788 0.267178 0.256073C0.445315 0.0853577 0.653143 0 0.890659 0C0.964884 0 1.04282 0.0111341 1.12446 0.0334015C1.20611 0.0556679 1.28405 0.0890694 1.35827 0.133604L8.61738 4.74292Z" fill="white"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!empty(pagesetting('courses_text'))): ?>
                                                <div class="am-mission_courses">
                                                    <span><?php echo pagesetting('courses_text'); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </figcaption>
                                    <?php endif; ?>
                                </figure>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/mission/view.blade.php ENDPATH**/ ?>