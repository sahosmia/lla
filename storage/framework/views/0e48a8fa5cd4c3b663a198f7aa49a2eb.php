<div class="am-userinfomore">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfomore_wrap">
                    <div class="nav nav-tabs am-userinfomore_tab" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-education-tab" data-bs-toggle="tab" data-bs-target="#nav-aducation" type="button" role="tab" aria-controls="nav-aducation" aria-selected="true"><?php echo e(__('tutor.education')); ?></button>
                        <button class="nav-link" id="nav-experience-tab" data-bs-toggle="tab" data-bs-target="#nav-experience" type="button" role="tab" aria-controls="nav-experience" aria-selected="false"><?php echo e(__('tutor.experience')); ?></button>
                        <button class="nav-link" id="nav-certification-tab" data-bs-toggle="tab" data-bs-target="#nav-certification" type="button" role="tab" aria-controls="nav-certification" aria-selected="false"><?php echo e(__('tutor.certification_awards')); ?></button>
                    </div>
                    <div class="tab-content am-userinfomore_content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-aducation" role="tabpanel" aria-labelledby="nav-education-tab">
                            <div class="am-userinfomore_title">
                                <h3><?php echo e(__('tutor.education')); ?></h3>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($educations->count() > 0): ?>
                                <div class="am-userinfomore_cards">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="am-userinfomore_card" wire:key="<?php echo e($key.'-'.time()); ?>" id="education-<?php echo e($key); ?>">
                                            <span>
                                                <?php echo e(date('Y', strtotime($education->start_date))); ?> - <?php echo e($education->ongoing ? __('general.current') : date('Y', strtotime($education->end_date))); ?>

                                            </span>
                                            <div class="am-userinfomore_card_info">
                                                <h4><?php echo e($education->course_title); ?></h4>
                                                <ul>
                                                    <li><i class="am-icon-book-1"></i><?php echo e($education->institute_name); ?></li>

                                                    <li><i class="am-icon-location"></i><?php echo e(ucfirst($education->city)); ?>, <?php echo e(ucfirst($education?->country?->name)); ?></li>
                                                </ul>
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($education->description)): ?>
                                                    <div class="am-toggle-text">
                                                        <div class="am-addmore">
                                                            <?php
                                                                $fullDescription  = strip_tags($education->description);
                                                                $shortDescription = Str::limit($fullDescription, 100, preserveWords: true);
                                                            ?>
                                                            <!--[if BLOCK]><![endif]--><?php if(Str::length($fullDescription) > 100): ?>
                                                                <div class="short-description">
                                                                    <?php echo $shortDescription; ?>

                                                                    <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_more')); ?></a>
                                                                </div>
                                                                <div class="full-description d-none">
                                                                    <?php echo $fullDescription; ?>

                                                                    <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_less')); ?></a>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="full-description">
                                                                    <?php echo $fullDescription; ?>

                                                                </div>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php else: ?>
                                <?php echo $__env->make('livewire.components.no-record', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        </div>
                        <div class="tab-pane fade" id="nav-experience" role="tabpanel" aria-labelledby="nav-experience-tab">
                            <div class="am-userinfomore_title">
                                <h3><?php echo e(__('tutor.experience')); ?></h3>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($experiences->count() > 0): ?>
                            <div class="am-userinfomore_cards">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $experiences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="am-userinfomore_card" wire:key="<?php echo e($key.'-'.time()); ?>" id="experience-<?php echo e($key); ?>">
                                        <span><?php echo e(date('Y', strtotime($experience->start_date))); ?> - <?php echo e($experience->is_current ? __('general.current') : date('Y', strtotime($experience->end_date))); ?></span>
                                        <div class="am-userinfomore_card_info">
                                            <h4><?php echo e($experience->title); ?></h4>
                                            <ul>
                                            <li><i class="am-icon-book-1"></i><?php echo e($experience->company); ?></li>
                                                <li><i class="am-icon-briefcase-02"></i> <?php echo e($employmentTypes[$experience->employment_type]); ?></li>
                                                <li>
                                                    <i class="am-icon-location"></i>
                                                    <!--[if BLOCK]><![endif]--><?php if($experience->location == 'onsite'): ?>
                                                        <?php echo e(ucfirst($experience?->country?->name)); ?>, <?php echo e(ucfirst($experience->city)); ?>

                                                    <?php else: ?>
                                                        <?php echo e(ucfirst($experience->location)); ?>

                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </li>
                                            </ul>
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($education->description)): ?>
                                                <div class="am-toggle-text">
                                                    <div class="am-addmore">
                                                        <?php
                                                            $fullDescription  = strip_tags($experience->description);
                                                            $shortDescription = Str::limit($fullDescription, 100, preserveWords: true);
                                                        ?>
                                                        <!--[if BLOCK]><![endif]--><?php if(Str::length($fullDescription) > 100): ?>
                                                            <div class="short-description">
                                                                <?php echo $shortDescription; ?>

                                                                <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_more')); ?></a>
                                                            </div>
                                                            <div class="full-description d-none">
                                                                <?php echo $fullDescription; ?>

                                                                <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_less')); ?></a>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="full-description">
                                                                <?php echo $fullDescription; ?>

                                                            </div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php else: ?>
                                <?php echo $__env->make('livewire.components.no-record', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="tab-pane fade" id="nav-certification" role="tabpanel" aria-labelledby="nav-certification-tab">
                            <div class="am-userinfomore_title">
                                <h3><?php echo e(__('tutor.certification_awards')); ?></h3>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if($certificates->count() > 0): ?>
                            <div class="am-userinfomore_cards">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="am-userinfomore_card" wire:key="<?php echo e($key.'-'.time()); ?>" id="certificate-<?php echo e($key); ?>">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($certificate->image)): ?>
                                        <figure class="am-userinfomore_card_img">
                                            <img src="<?php echo e(url(Storage::url($certificate->image))); ?>" alt="image">
                                        </figure>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="am-userinfomore_card_info">
                                        <h4><?php echo e($certificate->title); ?></h4>
                                        <ul>
                                            <li><i class="am-icon-book-1"></i><?php echo e($certificate->institute_name); ?></li>
                                            <li><i class="am-icon-calender-duration"></i><?php echo e(date('M d, Y', strtotime($certificate->issue_date))); ?></li>
                                        </ul>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($education->description)): ?>
                                            <div class="am-toggle-text">
                                                <div class="am-addmore">
                                                    <?php
                                                        $fullDescription  = strip_tags($certificate->description);
                                                        $shortDescription = Str::limit($fullDescription, 100, preserveWords: true);
                                                    ?>
                                                    <!--[if BLOCK]><![endif]--><?php if(Str::length($fullDescription) > 100): ?>
                                                        <div class="short-description">
                                                            <?php echo $shortDescription; ?>

                                                            <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_more')); ?></a>
                                                        </div>
                                                        <div class="full-description d-none">
                                                            <?php echo $fullDescription; ?>

                                                            <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_less')); ?></a>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="full-description">
                                                            <?php echo $fullDescription; ?>

                                                        </div>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php else: ?>
                            <?php echo $__env->make('livewire.components.no-record', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/components/tutor-resume.blade.php ENDPATH**/ ?>