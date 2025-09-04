<section class="am-faqs_section"> 
    <div class="am-page-title-wrap">
        <div class="am-themetabwrap">
            <div class="container">
                <?php if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('tutor_btn_txt'))): ?>
                    <ul class="nav nav-pills am-faqs-tabs" id="pills-tab" role="tablist">
                        <?php if(!empty(pagesetting('student_btn_txt'))): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"> 
                                    <i class="am-icon-book-1"></i><?php echo e(pagesetting('student_btn_txt')); ?>

                                </button>
                            </li>
                        <?php endif; ?>
                        <?php if(!empty(pagesetting('tutor_btn_txt'))): ?>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> 
                                <i class="am-icon-user-check"></i><?php echo e(pagesetting('tutor_btn_txt')); ?>

                            </button>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="am-faqs_section_contant">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if(!empty(pagesetting('students_faqs_data')) || !empty(pagesetting('tutors_faqs_data'))): ?>
                        <div class="am-faq">
                            <div class="am-faq-page">
                                <?php if(empty(pagesetting('students_faqs_data')) || !empty(pagesetting('tutors_faqs_data'))): ?>
                                    <div class="am-faqs-tabs-detail">
                                        <?php if(!empty(pagesetting('students_faqs_data')) || !empty(pagesetting('tutors_faqs_data'))): ?>
                                            <div class="tab-content am-faqtab-content" id="pills-tabContent">
                                                <?php if(!empty(pagesetting('students_faqs_data'))): ?>    
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                            <?php $__currentLoopData = pagesetting('students_faqs_data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                               <?php if(!empty($faq['question']) || !empty($faq['answer'])): ?>
                                                                    <div class="accordion-item">
                                                                        <?php if(!empty($faq['question'])): ?>
                                                                            <h2 class="accordion-header" id="flush-headingOne<?php echo e($key); ?>">
                                                                                <span><i class="am-icon-file-02"></i></span>
                                                                                <button class="accordion-button collapsed <?php echo e($loop->first ? 'show' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?php echo e($key); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>" aria-controls="flush-collapseOne<?php echo e($key); ?>">
                                                                                    <?php echo $faq['question']; ?>

                                                                                </button>
                                                                            </h2>
                                                                        <?php endif; ?>
                                                                        <?php if(!empty($faq['answer'])): ?>
                                                                            <div id="flush-collapseOne<?php echo e($key); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>" aria-labelledby="flush-headingOne<?php echo e($key); ?>" data-bs-parent="#accordionFlushExample">
                                                                                <div class="accordion-body"><?php echo $faq['answer']; ?></div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>           
                                                               <?php endif; ?>   
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if(!empty(pagesetting('tutors_faqs_data'))): ?> 
                                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                        <div class="accordion accordion-flush" id="accordionFlushExamplev2">
                                                            <?php $__currentLoopData = pagesetting('tutors_faqs_data'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(!empty($faq['question']) || !empty($faq['answer'])): ?>
                                                                    <div class="accordion-item">
                                                                        <?php if(!empty($faq['question'])): ?>
                                                                            <h2 class="accordion-header" id="flush-headingOne<?php echo e($key); ?>">
                                                                                <span><i class="am-icon-file-02"></i></span>
                                                                                <button class="accordion-button collapsed <?php echo e($loop->first ? 'show' : ''); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne<?php echo e($key); ?>" aria-expanded="<?php echo e($loop->first ? 'true' : 'false'); ?>" aria-controls="flush-collapseOne">
                                                                                    <?php echo $faq['question']; ?>

                                                                                </button>
                                                                            </h2>
                                                                        <?php endif; ?>
                                                                        <?php if(!empty($faq['answer'])): ?>
                                                                            <div id="flush-collapseOne<?php echo e($key); ?>" class="accordion-collapse collapse <?php echo e($loop->first ? 'show' : ''); ?>" aria-labelledby="flush-headingOne<?php echo e($key); ?>" data-bs-parent="#accordionFlushExample">
                                                                                <div class="accordion-body"><?php echo $faq['answer']; ?></div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>     
                                                                <?php endif; ?>                    
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                                        </div>
                                                    </div>
                                                <?php endif; ?> 
                                            </div>       
                                        <?php endif; ?>                         
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>  
</section>

<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/pagebuilder/faqs/view.blade.php ENDPATH**/ ?>