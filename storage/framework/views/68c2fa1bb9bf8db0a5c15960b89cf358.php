
<section class="am-works"> 
    <div class="am-page-title-wrap">
        <div class="am-themetabwrap">
            <div class="container">
                <?php if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('tutor_btn_txt'))): ?>
                    <ul class="nav nav-pills am-faqs-tabs" id="pills-tab" role="tablist">
                        <?php if(!empty(pagesetting('student_btn_txt'))): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"> <i class="am-icon-book-1"></i><?php echo e(pagesetting('student_btn_txt')); ?></button>
                            </li>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('tutor_btn_txt'))): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> <i class="am-icon-user-check"></i><?php echo e(pagesetting('tutor_btn_txt')); ?></button>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="am-works_contant">
        <div class="container">
            <div class="row">
                <?php if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading'))       
                    || !empty(pagesetting('paragraph'))
                    || !empty(pagesetting('student_btn_txt'))
                    || !empty(pagesetting('tutor_btn_txt'))
                    || !empty(pagesetting('student_repeater'))
                    || !empty(pagesetting('tutor_repeater'))): ?>
                    <div class="am-faqs-tabs-detail am-how-it-works-detail">
                        <?php if(!empty(pagesetting('student_repeater')) || !empty(pagesetting('tutor_repeater'))): ?>
                            <div class="tab-content am-faqtab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <?php if(!empty(pagesetting('student_repeater'))): ?>
                                        <?php $__currentLoopData = pagesetting('student_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($loop->odd): ?>
                                                <div class="am-works_info">
                                                    <div>
                                                        <?php if(!empty($option['std_btn_icon'])): ?>
                                                            <span class="am-works_info_tag">
                                                                <i class="<?php echo $option['std_btn_icon']; ?>"></i>
                                                            </span>
                                                        <?php endif; ?>
                                                        <div class="am-works_info_description">
                                                            <?php if(!empty($option['student_sub_heading'])): ?> 
                                                                <?php if($option['student_sub_heading'] == 'Sign Up'): ?>
                                                                    <span><a href="<?php echo e(setting('_lernen.allow_register') !== 'no' ? 'register' : '#'); ?>"><?php echo e($option['student_sub_heading']); ?></a></span> 
                                                                <?php else: ?>
                                                                    <span><?php echo e($option['student_sub_heading']); ?></span> 
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php if(!empty($option['student_heading'])): ?> <h3><?php echo $option['student_heading']; ?></h3> <?php endif; ?>
                                                            <?php if(!empty($option['student_paragraph'])): ?> <?php echo $option['student_paragraph']; ?> <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <div class="am-works_info_user">
                                                        <?php if(!empty($option['student_image'])): ?>
                                                            <?php if(!empty($option['student_image'][0]['path'])): ?>
                                                                <figure><img src="<?php echo e(url(Storage::url($option['student_image'][0]['path']))); ?>" alt="Student image"></figure>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="am-works_info">
                                                    <div class="am-works_info_user">
                                                        <?php if(!empty($option['student_image'])): ?>
                                                            <?php if(!empty($option['student_image'][0]['path'])): ?>
                                                                <figure><img src="<?php echo e(url(Storage::url($option['student_image'][0]['path']))); ?>" alt="Tutor image"></figure>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <?php if(!empty($option['std_btn_icon'])): ?>
                                                            <span class="am-works_info_tag">
                                                                <i class="<?php echo $option['std_btn_icon']; ?>"></i>
                                                            </span>
                                                        <?php endif; ?>
                                                        <div class="am-works_info_description">
                                                            <?php if(!empty($option['student_sub_heading'])): ?> 
                                                                <?php if($option['student_sub_heading'] == 'Find a Tutor'): ?>
                                                                    <span><a href="find-tutors"><?php echo e($option['student_sub_heading']); ?></a></span> 
                                                                <?php else: ?>
                                                                    <span><?php echo e($option['student_sub_heading']); ?></span> 
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php if(!empty($option['student_heading'])): ?> <h3><?php echo $option['student_heading']; ?></h3> <?php endif; ?>
                                                            <?php if(!empty($option['student_paragraph'])): ?> <?php echo $option['student_paragraph']; ?> <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <?php if(!empty(pagesetting('tutor_repeater'))): ?>
                                        <?php $__currentLoopData = pagesetting('tutor_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($loop->odd): ?>
                                                <div class="am-works_info">
                                                    <div>
                                                        <?php if(!empty($option['tutor_btn_icon'])): ?>
                                                            <span class="am-works_info_tag">
                                                                <i class="<?php echo $option['tutor_btn_icon']; ?>"></i>
                                                            </span>
                                                        <?php endif; ?>
                                                        <div class="am-works_info_description">
                                                            <?php if(!empty($option['tutor_sub_heading'])): ?> 
                                                                <?php if($option['tutor_sub_heading'] == 'Sign Up'): ?>
                                                                    <span><a href="<?php echo e(setting('_lernen.allow_register') !== 'no' ? 'register' : '#'); ?>"><?php echo e($option['tutor_sub_heading']); ?></a></span> 
                                                                <?php else: ?>
                                                                    <span><?php echo e($option['tutor_sub_heading']); ?></span> 
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php if(!empty($option['tutor_heading'])): ?> <h3><?php echo $option['tutor_heading']; ?></h3> <?php endif; ?>
                                                            <?php if(!empty($option['tutor_paragraph'])): ?> <?php echo $option['tutor_paragraph']; ?> <?php endif; ?>                                              
                                                        </div>
                                                    </div>
                                                    <div class="am-works_info_user">
                                                        <?php if(!empty($option['tutor_image'])): ?>
                                                            <?php if(!empty($option['tutor_image'][0]['path'])): ?>
                                                                <figure><img src="<?php echo e(url(Storage::url($option['tutor_image'][0]['path']))); ?>" alt="Tutor image"></figure>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="am-works_info">
                                                    <div class="am-works_info_user">
                                                        <?php if(!empty($option['tutor_image'])): ?>
                                                            <?php if(!empty($option['tutor_image'][0]['path'])): ?>
                                                                <figure><img src="<?php echo e(url(Storage::url($option['tutor_image'][0]['path']))); ?>" alt="Tutor image"></figure>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <?php if(!empty($option['tutor_btn_icon'])): ?>
                                                            <span class="am-works_info_tag">
                                                                <i class="<?php echo $option['tutor_btn_icon']; ?>"></i>
                                                            </span>
                                                        <?php endif; ?>
                                                        <div class="am-works_info_description">
                                                            <?php if(!empty($option['tutor_sub_heading'])): ?> 
                                                                <?php if($option['tutor_sub_heading'] == 'Set Availability'): ?>
                                                                    <span><a href="login"><?php echo e($option['tutor_sub_heading']); ?></a></span> 
                                                                <?php else: ?>
                                                                    <span><?php echo e($option['tutor_sub_heading']); ?></span> 
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <?php if(!empty($option['tutor_heading'])): ?> <h3><?php echo $option['tutor_heading']; ?></h3> <?php endif; ?>
                                                            <?php if(!empty($option['tutor_paragraph'])): ?> <?php echo $option['tutor_paragraph']; ?> <?php endif; ?>   
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>  
                        <?php endif; ?>                              
                    </div>    
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/how-it-works/view.blade.php ENDPATH**/ ?>