<div class="am-faqs-three <?php echo e(pagesetting('select_verient')); ?>">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(!empty(pagesetting('sub-heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph'))
                    || !empty(pagesetting('btn_txt')) 
                    || !empty(pagesetting('faqs_data'))): ?>
                    <div class="am-faqs-three_content">
                        <?php if(!empty(pagesetting('sub-heading')) 
                            || !empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph'))
                            || !empty(pagesetting('btn_txt'))): ?>
                            <div class="am-faqs-three_title">
                                <div class="am-section_title <?php echo e(pagesetting('section_title_variation')); ?>">
                                    <?php if(!empty(pagesetting('sub-heading'))): ?>
                                        <span
                                            <?php if((!empty(pagesetting('sub_heading_text_color')) && pagesetting('sub_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('sub_heading_bg_color')) && pagesetting('sub_heading_bg_color') !== 'rgba(0,0,0,0)')): ?>
                                                style="
                                                    <?php if(!empty(pagesetting('sub_heading_text_color')) && pagesetting('sub_heading_text_color') !== 'rgba(0,0,0,0)'): ?>
                                                        color: <?php echo e(pagesetting('sub_heading_text_color')); ?>;
                                                    <?php endif; ?>
                                                    <?php if(!empty(pagesetting('sub_heading_bg_color')) && pagesetting('sub_heading_bg_color') !== 'rgba(0,0,0,0)'): ?>
                                                        background-color: <?php echo e(pagesetting('sub_heading_bg_color')); ?>;
                                                    <?php endif; ?>
                                                "
                                            <?php endif; ?>>
                                            <?php echo e(pagesetting('sub-heading')); ?>

                                        </span>
                                    <?php endif; ?>
                                    <?php if(!empty(pagesetting('heading'))): ?><h2><?php echo pagesetting('heading'); ?></h2><?php endif; ?>
                                    <?php if(!empty(pagesetting('paragraph'))): ?><p><?php echo pagesetting('paragraph'); ?></p><?php endif; ?>
                                    <?php if(!empty(pagesetting('btn_txt'))): ?> <a href="<?php if(!empty(pagesetting('btn_url'))): ?> <?php echo e(pagesetting('btn_url')); ?> <?php endif; ?>" class="am-btn"><?php echo e(pagesetting('btn_txt')); ?></a><?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('faqs_data'))): ?>
                            <div class="am-faqs-three_accordions" >
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <?php $__currentLoopData = pagesetting('faqs_data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="accordion-item"  data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                            <?php if(!empty($faq['question'])): ?>
                                                <h2 class="accordion-header" id="am-faqs<?php echo e($key); ?>">
                                                    <button class="accordion-button collapsed <?php echo e($loop->first ? 'show' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#am-faq-target<?php echo e($key); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>" aria-controls="am-faq-target<?php echo e($key); ?>">
                                                        <?php echo $faq['question']; ?>

                                                        <i class="am-icon-minus-02 minus"></i>
                                                        <i class="am-icon-plus-02 plus"></i>
                                                    </button>
                                                </h2>
                                            <?php endif; ?>
                                            <?php if(!empty($faq['answer'])): ?>
                                                <div id="am-faq-target<?php echo e($key); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?> " aria-labelledby="am-faqs<?php echo e($key); ?>" data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        <?php echo $faq['answer']; ?>

                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 </div> <?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/faqs-without-btn/view.blade.php ENDPATH**/ ?>