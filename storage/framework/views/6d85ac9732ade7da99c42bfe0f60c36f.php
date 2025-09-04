<div class="cr-course-details-page">
    <div class="cr-course-content">
        <div class="cr-course-details-wrapper">
            <section class="cr-course-details-banner">
                <img src="<?php echo e(asset ('modules/courses/images/bg-shap.svg')); ?>" alt="Course preview image" class="cr-course-shap-image" />
                <img src="<?php echo e(asset ('modules/courses/images/bg-shap2.svg')); ?>" alt="Course preview image" class="cr-course-shap-image2" />
                <div class="cr-course-details-area">
                    <div class="cr-course-details-info">
                        <ol class="am-breadcrumb">
                            <li><a href="javascript:void(0);" navigate="true"><?php echo e(__('courses::courses.home')); ?></a></li>
                            <li><em>/</em></li>
                            <li><a href="javascript:void(0);" navigate="true"><?php echo e($course?->category?->name); ?></a></li>
                            <li><em>/</em></li>
                            <li class="active"><span><?php echo e($course?->subcategory?->name); ?></span></li>
                        </ol>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course?->title) || !empty($course?->subtitle)): ?>
                        <div class="am-searchhead_title">
                            <div class="cr-title-box">
                                <?php if(!empty($course?->title)): ?>
                                    <h2><?php echo e($course?->title); ?></h1>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if(!empty($course?->subtitle)): ?>
                                    <p><?php echo e($course?->subtitle); ?></p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="cr-course-meta">
                            <div class="cr-rating-container">
                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'cr-stars',
                                    'cr-' . floor($course->ratings_avg_rating) . 'star' => !empty($course->ratings_count)
                                ]); ?>">
                                    <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="am-icon-star-01"></i>
                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </span>
                                <span class="cr-rating-score"><?php echo e(number_format($course->ratings_avg_rating, 1)); ?></span>
                                <span class="cr-review-count">(<?php echo e($course->ratings_count); ?> <?php echo e(__('courses::courses.reviews')); ?>)</span>
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if(!empty($course->updated_at)): ?>
                                <div class="cr-last-updated">
                                    <span>
                                        <i class="am-icon-time"></i>
                                    </span>
                                    <span class="cr-update-date"><?php echo e(__('courses::courses.last_updated')); ?>: <?php echo e(\Carbon\Carbon::parse($course->updated_at)->format('M d, Y')); ?></span>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="cr-course-stats">
                            
                            <div class="cr-stat-item">
                                <div class="cr-stat-icon-wrapper">
                                    <i class="am-icon-bar-chart-04"></i>
                                </div>
                                <div class="cr-stat-content">
                                    <span class="cr-stat-label"><?php echo e(__('courses::courses.level')); ?></span>
                                    <span class="cr-stat-value"><?php echo e(__('courses::courses.'. $course?->level)); ?></span>
                                </div>
                            </div>
                            <div class="cr-stat-item">
                                <div class="cr-stat-icon-wrapper">
                                    <i class="am-icon-globe"></i>
                                </div>
                                <div class="cr-stat-content">
                                    <span class="cr-stat-label"><?php echo e(__('courses::courses.language')); ?></span>
                                    <span class="cr-stat-value"><?php echo e($course->language?->name); ?></span>
                                </div>
                            </div>
                            <div class="cr-stat-item">
                                <div class="cr-stat-icon-wrapper">
                                    <i class="am-icon-user-group"></i>
                                </div>
                                <div class="cr-stat-content">
                                    <span class="cr-stat-label"><?php echo e(__('courses::courses.enrolments')); ?></span>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course?->enrollments_count)): ?>
                                        <span class="cr-stat-value"><?php echo e(number_format($course?->enrollments_count ?? 0)); ?> <?php echo e($course?->enrollments_count == 1 ? __('courses::courses.student') : __('courses::courses.students')); ?></span>
                                    <?php else: ?>
                                        <span class="cr-stat-value"><?php echo e(__('courses::courses.no_enrolled_students')); ?></span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <div class="cr-stat-item">
                                <div class="cr-stat-icon-wrapper">
                                    <i class="am-icon-eye-open-01"></i>
                                </div>
                                <div class="cr-stat-content">
                                    <span class="cr-stat-label"><?php echo e(__('courses::courses.views')); ?></span>
                                    <span class="cr-stat-value"><?php echo e(number_format($course?->views_count ?? 0)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="cr-course-details-sections">
                <div class="am-aboutuser_section cr-detail-tabs">
                    <div class="cr-course-details-area">
                        <ul class="am-aboutuser_tab " x-data="{tab: 'overview'}">
                            <li x-bind:class="tab == 'overview' ? 'active' : ''">
                                <a href="#overview" @click="tab='overview'" class="am-tabitem"><?php echo e(__('courses::courses.overview')); ?></a>
                            </li>
                            <li x-bind:class="tab == 'objectives' ? 'active' : ''">
                                <a href="#objectives" @click="tab='objectives'" class="am-tabitem"><?php echo e(__('courses::courses.objectives')); ?></a>
                            </li>
                            <li x-bind:class="tab == 'course-curriculum' ? 'active' : ''">
                                <a @click="tab='course-curriculum'" href="#course-curriculum" class="am-tabitem"><?php echo e(__('courses::courses.course_curriculum')); ?></a>
                            </li>
                            <li x-bind:class="tab == 'prerequisites-&-faq' ? 'active' : ''">
                                <a @click="tab='prerequisites-&-faq'" href="#prerequisites-&-faq" class="am-tabitem"><?php echo e(__('courses::courses.prerequisites_and_faqs')); ?></a>
                            </li>
                            <li x-bind:class="tab == 'reviews' ? 'active' : ''">
                                <a @click="tab='reviews'" href="#reviews" class="am-tabitem"><?php echo e(__('courses::courses.reviews')); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cr-course-details-area">
                    <div class="cr-overview am-tutor-detail">
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->description)): ?>
                            <div class="cr-overview-course" id="overview">
                                <h3><?php echo e(__('courses::courses.about_this_course')); ?></h3>
                                <p>
                                    <!--[if BLOCK]><![endif]--><?php if($fullDescription): ?>
                                        <?php echo $course->description; ?>

                                    <?php else: ?>
                                        <?php echo Str::limit(strip_tags($course->description), 400, '...', preserveWords: true); ?>

                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </p>
                                <!--[if BLOCK]><![endif]--><?php if(strlen(strip_tags($course->description)) > 400): ?>
                                    <a href="javascript:void(0);" class="cr-show" wire:click.prevent="toggleDescription">
                                        <?php echo e($fullDescription ? __('courses::courses.show_less') : __('courses::courses.show_more')); ?>

                                    </a>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->learning_objectives)): ?>
                        <div class="cr-overview-course" id="objectives">
                            <h3><?php echo e(__('courses::courses.what_you_will_learn')); ?></h3>
                            <ul class="cr-learn-content">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $course->learning_objectives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <div class="cr-checked-contnet">
                                        <span>
                                            <i class="am-icon-check-circle03"></i>
                                        </span>
                                        <em>
                                            <?php echo $objective; ?>

                                        </em>
                                    </div>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </ul>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="cr-overview-course cr-overview-curriculm" id="course-curriculum">
                            <h3><?php echo e(__('courses::courses.course_curriculum')); ?></h3>
                            <div class="cr-curriculum-header">
                                <div class="cr-topics">
                                    <div class="cr-curriculum-stats">
                                        <em><?php echo e($course->sections_count); ?></em>
                                        <span><?php echo e($course->sections_count == 1 ? __('courses::courses.topic') : __('courses::courses.topics')); ?></span>
                                    </div>
                                    <span>
                                        <svg width="4" height="4" viewBox="0 0 4 4" fill="none">
                                        <circle cx="2" cy="2" r="2" fill="#585858"/>
                                        </svg>
                                    </span>
                                    <div class="cr-curriculum-stats">
                                        <em><?php echo e($course->curriculums_count); ?></em>
                                        <span><?php echo e($course->curriculums_count == 1 ? __('courses::courses.lesson') : __('courses::courses.lessons')); ?></span>
                                    </div>
                                    <span>
                                        <svg width="4" height="4" viewBox="0 0 4 4" fill="none">
                                            <circle cx="2" cy="2" r="2" fill="#585858"/>
                                        </svg>
                                    </span>
                                    <div class="cr-curriculum-stats">
                                        <em><?php echo e(getCourseDuration($course->content_length)); ?></em>
                                        <span><?php echo e(__('courses::courses.total_length')); ?> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="cr-curriculum-list">
                                <div class="cr-faq-accordion">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course->sections)): ?>
                                        <div class="cr-formarea accordion">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $course->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="accordion-item">
                                                    <input type="radio" <?php if($index == 0): ?> checked <?php endif; ?> name="curriculum-accordion" id="section-<?php echo e($section->id); ?>" class="accordion-checkbox">
                                                    <label for="section-<?php echo e($section->id); ?>" class="cr-course-item accordion-header">
                                                        <span class="accordion-icon">
                                                            <svg  width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                <path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </span>
                                                        <div class="cr-contentbox">
                                                            <span> <?php echo e($section->title); ?> </span>
                                                        </div>
                                                        <ul class="cr-courses-info">
                                                            <li>
                                                                <span>
                                                                    <strong><?php echo e(number_format( count($section->curriculums))); ?></strong>
                                                                    <?php echo e(count($section->curriculums) == 1 ? __('courses::courses.lecture') : __('courses::courses.lectures')); ?>

                                                                </span>
                                                            </li>
                                                            <li>
                                                                <span>
                                                                    <strong><?php echo e(getCourseDuration($section->curriculums->sum('content_length'))); ?></strong>
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </label>
                                                    <div class="accordion-content">
                                                        <p><?php echo strip_tags($section->description); ?></p>
                                                        <!--[if BLOCK]><![endif]--><?php if($section->curriculums->isNotEmpty()): ?>
                                                            <ul>
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $section->curriculums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curriculum): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li>
                                                                    <div class="cr-question">
                                                                        <div class="cr-frame">
                                                                            <div class="cr-div">
                                                                                <!--[if BLOCK]><![endif]--><?php if( in_array($curriculum->type, ['video', 'yt_link', 'vm_link'])): ?>
                                                                                    <svg width="15" height="16" viewBox="0 0 15 16" fill="none">
                                                                                        <g opacity="0.8">
                                                                                        <path d="M1.875 11.0711V4.92885C1.875 3.68539 1.875 3.06366 2.13554 2.71064C2.36269 2.40287 2.71108 2.20748 3.09214 2.17415C3.52922 2.13591 4.05974 2.46012 5.12076 3.10852L10.1463 6.17967C11.1311 6.78153 11.6236 7.08246 11.7914 7.46987C11.938 7.80809 11.938 8.19191 11.7914 8.53013C11.6236 8.91754 11.1311 9.21847 10.1463 9.82034L5.12076 12.8915C4.05974 13.5399 3.52922 13.8641 3.09214 13.8259C2.71108 13.7925 2.36269 13.5971 2.13554 13.2894C1.875 12.9363 1.875 12.3146 1.875 11.0711Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                        </g>
                                                                                    </svg> 
                                                                                <?php elseif($curriculum->type == 'article'): ?>
                                                                                    <i class="am-icon-file-06"></i>
                                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                                <div class="cr-frame-2">
                                                                                    <p class="cr-label"><?php echo e($curriculum->title); ?></p>
                                                                                    <!--[if BLOCK]><![endif]--><?php if(empty($curriculum->is_preview)): ?>
                                                                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none">
                                                                                            <g opacity="0.8">
                                                                                            <path d="M4.375 5.5V4.875C4.375 3.82559 4.375 3.30088 4.56702 2.89489C4.76486 2.4766 5.1016 2.13986 5.51989 1.94202C5.92588 1.75 6.45059 1.75 7.5 1.75V1.75C8.54941 1.75 9.07412 1.75 9.48011 1.94202C9.8984 2.13986 10.2351 2.4766 10.433 2.89489C10.625 3.30088 10.625 3.82559 10.625 4.875V5.5M7.5 9.25V10.5M6.14167 14.25H8.85833C10.3518 14.25 11.0985 14.25 11.669 13.9594C12.1707 13.7037 12.5787 13.2957 12.8344 12.794C13.125 12.2235 13.125 11.4768 13.125 9.98333V9.76667C13.125 8.27319 13.125 7.52646 12.8344 6.95603C12.5787 6.45426 12.1707 6.04631 11.669 5.79065C11.0985 5.5 10.3518 5.5 8.85833 5.5H6.14167C4.64819 5.5 3.90146 5.5 3.33103 5.79065C2.82926 6.04631 2.42131 6.45426 2.16565 6.95603C1.875 7.52646 1.875 8.27319 1.875 9.76667V9.98333C1.875 11.4768 1.875 12.2235 2.16565 12.794C2.42131 13.2957 2.82926 13.7037 3.33103 13.9594C3.90146 14.25 4.64819 14.25 6.14167 14.25Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                            </g>
                                                                                        </svg>
                                                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                                </div>
                                                                                <div class="cr-frame-wrapper">
                                                                                    <span>
                                                                                        <strong>
                                                                                            <?php echo e(getCourseDuration($curriculum->content_length)); ?>

                                                                                            <!--[if BLOCK]><![endif]--><?php if($curriculum->type == 'video'): ?>
                                                                                                <?php echo e(__('courses::courses.watch')); ?>

                                                                                            <?php elseif($curriculum->type == 'article'): ?>
                                                                                                <?php echo e(__('courses::courses.read')); ?>

                                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                                        </strong>

                                                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($curriculum->is_preview)): ?>
                                                                                            <span class="cr-label-preview" 
                                                                                            x-data="{
                                                                                                type: '<?php echo e($curriculum->type); ?>',
                                                                                                articleTitle: <?php echo \Illuminate\Support\Js::from($curriculum->title)->toHtml() ?>,
                                                                                                articleContent: <?php echo \Illuminate\Support\Js::from($curriculum->article_content)->toHtml() ?>,
                                                                                                videoUrl: <?php echo \Illuminate\Support\Js::from(getVideoUrl($curriculum))->toHtml() ?>, 
                                                                                                viewContent() {
                                                                                                    if (this.type === 'article') {
                                                                                                        document.getElementById('articleModalLabel').innerHTML = this.articleTitle;
                                                                                                        document.querySelector('.cr-article-content').innerHTML = this.articleContent;
                                                                                                        new bootstrap.Modal(document.getElementById('articleModal')).show();
                                                                                                    } else {
                                                                                                        openVideoModal(this.videoUrl, this.type);
                                                                                                        document.getElementById('videoModalLabel').innerHTML = this.articleTitle;
                                                                                                    } 
                                                                                                }
                                                                                            }" 
                                                                                            @click="viewContent()"><?php echo e(__('courses::courses.preview')); ?></span>
                                                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cr-div-wrapper">
                                                                            <p class="cr-p"><?php echo e(strip_tags($curriculum->description)); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </ul>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div> 
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->faqs) && $course->faqs->isNotEmpty()): ?>
                            <div class="cr-overview-course" id="prerequisites-&-faq">
                                <h3><?php echo e(__('courses::courses.faqs_title')); ?></h3>
                                <div class="cr-faq-accordion cr-detail-faq-accordion">
                                    <div class="accordion">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $course->faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="accordion-item">
                                                <input type="radio" <?php if($index == 0): ?> checked <?php endif; ?> name="accordion" id="faq-<?php echo e($faq->id); ?>" class="accordion-checkbox">
                                                <label for="faq-<?php echo e($faq->id); ?>" class="cr-course-item accordion-header">
                                                    <div class="cr-contentbox">
                                                        <span><?php echo e($faq->question); ?></span>
                                                    </div>
                                                    <span class="accordion-icon">
                                                        <svg  width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                            <path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </span>
                                                </label>
                                                <div class="accordion-content">
                                                    <p><?php echo $faq->answer; ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>   
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->prerequisites)): ?>
                            <div class="cr-overview-course" id="prerequisites-&-faq">
                                <h3><?php echo e(__('courses::courses.prerequisites_title')); ?></h3>
                                <div class="cr-prerequisites-frame">
                                <?php echo $course->prerequisites; ?>

                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->ratings) && $course?->ratings?->count() > 0): ?>
                            <div x-data="{
                                showMore : false,
                                totalRatings : <?php echo e($course->ratings?->count()); ?>,
                                showMoreRatings(){
                                    this.showMore = !this.showMore;
                                }
                            }" class="cr-overview-course cr-overview-rating" id="reviews">
                                <h3><?php echo e(__('courses::courses.reviews')); ?></h3>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $course->ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>$rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                    <div class="cr-review" <?php if($index >= 4): ?> x-show="showMore" <?php endif; ?>>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($rating->student?->profile?->image) && Storage::disk(getStorageDisk())->exists($rating->student?->profile?->image)): ?>
                                            <img src="<?php echo e(Storage::url($rating->student?->profile?->image)); ?>" alt="<?php echo e($rating->student?->profile?->full_name); ?>">
                                        <?php else: ?>
                                        <img src="<?php echo e(resizedImage('placeholder.png',42,42)); ?>" alt="<?php echo e($rating->student?->profile?->full_name); ?>" />
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="cr-review-content">
                                            <div class="cr-review-rating-main">
                                                <div class="cr-review-star">
                                                    <div class="cr-review-name">
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($rating->student?->profile?->full_name)): ?>
                                                            <h4><?php echo e($rating->student?->profile?->full_name); ?></h4>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($rating?->student?->address?->country?->short_code)): ?>
                                                        <div class="am-custom-tooltip">
                                                            <span class="am-tooltip-text">
                                                                <span><?php echo e(ucfirst($rating?->student?->address?->country?->name)); ?></span>
                                                            </span>
                                                            <span class="flag flag-<?php echo e(strtolower($rating?->student?->address?->country?->short_code)); ?>"></span>
                                                        </div>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($rating->created_at)): ?>
                                                        <span><?php echo e($rating->created_at->format('M d, Y')); ?></span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="cr-reviews-content">
                                                    <span class="cr-stars cr-<?php echo e(floor($rating->rating)); ?>star">
                                                        <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                                        <i class="am-icon-star-01"></i>
                                                        <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </span>
                                                    <div class="cr-review-rating">
                                                        <span><?php echo e($rating->rating); ?> <em>/5.0</em></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p><?php echo $rating->comment; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if($course->ratings?->count() > 4): ?>
                                    <a href="javascript:void(0);" @click="showMoreRatings()" class="cr-review-button" x-text="showMore ? '<?php echo e(__('courses::courses.show_less')); ?>' : '<?php echo e(__('courses::courses.show_more')); ?>'"></a>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <!-- === Sidebar Start === -->
                    <div class="cr-course-sidebar">
                        <div class="cr-course-card" x-data="{ showVideo: false }" x-init="setTimeout(() => showVideo = true, 500)">
                            <figure 
                                class="cr-image-wrapper" 
                                x-data="{ 
                                    isOpen: false, 
                                    videoUrl: '<?php echo e(url(Storage::url($course?->promotionalVideo?->path))); ?>',
                                    courseId: '<?php echo e($course->id); ?>',
                                    playVideo() {
                                        this.isOpen = true;
                                        this.$nextTick(() => {
                                            let video = document.getElementById(`course-${this.courseId}`);
                                            if (video) {
                                                video.load();
                                            }
                                        });
                                    }
                                }">
                                <template x-if="isOpen">
                                    <div class="cr-video-modal">
                                        <video :id="'course-'+courseId" onloadeddata="let player = videojs(this); player.removeClass('d-none'); setTimeout(() => player.play(), 100);" class="d-none video-js vjs-default-skin d-none-playBtn" width="100%" height="100%" controls>
                                            <source :src="videoUrl" type="video/mp4" x-ref="video" >
                                        </video>
                                    </div>
                                </template>
                                <template x-if="!isOpen">
                                    <img height="200" width="360" src="<?php echo e(!empty($course?->thumbnail?->path) ? url(Storage::url($course?->thumbnail?->path)) : asset('module/courses/images/course.png')); ?>" alt="<?php echo e($course?->title); ?>" class="cr-background-image" />
                                </template>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($course?->promotionalVideo?->path) && Storage::disk(getStorageDisk())->exists($course?->promotionalVideo?->path) ): ?>
                                    <template x-if="!isOpen">
                                        <figcaption>
                                            <button @click="playVideo()">
                                                <svg width="14" height="18" viewBox="0 0 14 18" fill="none">
                                                    <path d="M0.109375 12.9487V5.0514C0.109375 3.16703 0.109375 2.22484 0.503774 1.69381C0.847558 1.23093 1.37438 0.93894 1.94911 0.892737C2.60845 0.839731 3.40742 1.33909 5.00537 2.33781L11.3232 6.28644C12.7629 7.18627 13.4828 7.63619 13.7296 8.21222C13.9452 8.7153 13.9452 9.28476 13.7296 9.78785C13.4828 10.3639 12.7629 10.8138 11.3232 11.7136L5.00537 15.6623C3.40742 16.661 2.60845 17.1603 1.94911 17.1073C1.37438 17.0611 0.847558 16.7691 0.503774 16.3063C0.109375 15.7752 0.109375 14.833 0.109375 12.9487Z" fill="white"/>
                                                </svg>
                                            </button>
                                        </figcaption>
                                    </template>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </figure>
                            <div class="cr-course-details">
                                <!--[if BLOCK]><![endif]--><?php if(isPaidSystem() && !empty($course->pricing?->price) && !empty($course->pricing?->final_price) && $course->pricing?->price != 0.00 ): ?>
                                    <div class="cr-price-section">
                                        <div class="cr-price-wrapper">
                                            <div class="cr-price">
                                                <span class="cr-amount"><?php echo formatAmount($course->pricing?->final_price, true); ?></span>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($course->pricing?->price) && !empty($course->pricing?->discount)): ?>
                                                <span class="cr-discount">
                                                    <?php echo formatAmount($course->pricing?->price, true); ?>

                                                    <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                        <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"></rect>
                                                        <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"></rect>
                                                    </svg>
                                                </span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->pricing?->discount)): ?>
                                            <div class="cr-discount-label"><?php echo e($course->pricing?->discount); ?>% <?php echo e(__('courses::courses.off')); ?></div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <?php else: ?>
                                    <div class="cr-price-wrapper">
                                        <span class="cr-amount"><?php echo e(__('courses::courses.free')); ?></span>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="cr-course-includes">
                                    <h2 class="cr-includes-title"><?php echo e(__('courses::courses.course_includes')); ?>:</h2>
                                    <ul class="cr-includes-list">
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->sections_count)): ?>
                                            <li class="cr-includes-item">
                                                <i class="am-icon-list-02"></i>
                                                <div class="cr-includes-text">
                                                    <span class="cr-includes-value"><?php echo e($course->sections_count); ?></span>
                                                    <span class="cr-includes-label"><?php echo e($course->sections_count > 1 ? __('courses::courses.topics') : __('courses::courses.topic')); ?></span>
                                                </div>
                                            </li>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->curriculums_count)): ?>
                                            <li class="cr-includes-item">
                                                <i class="am-icon-book-1"></i>
                                                <div class="cr-includes-text">
                                                    <span class="cr-includes-value"><?php echo e($course->curriculums_count); ?></span>
                                                    <span class="cr-includes-label"><?php echo e($course->curriculums_count > 1 ? __('courses::courses.lessons') : __('courses::courses.lesson')); ?></span>
                                                </div>
                                            </li>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($totalArticles)): ?>
                                            <li class="cr-includes-item">
                                                <i class="am-icon-book"></i>
                                                <div class="cr-includes-text">
                                                    <span class="cr-includes-value"><?php echo e(number_format($totalArticles)); ?></span>
                                                    <span class="cr-includes-label"><?php echo e($totalArticles == 1 ? __('courses::courses.article') : __('courses::courses.articles')); ?></span>
                                                </div>
                                            </li>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($totalVideos)): ?>
                                            <li class="cr-includes-item">
                                                <i class="am-icon-play"></i>
                                                <div class="cr-includes-text">
                                                    <?php 
                                                        $total_duration = $course->curriculums->where('type', 'video')->sum('content_length');
                                                    ?>
                                                    <span class="cr-includes-value"><?php echo e(number_format($totalVideos)); ?></span>
                                                    <span class="cr-includes-label"><?php echo e($totalVideos == 1 ? __('courses::courses.video') : __('courses::courses.videos')); ?> of <?php echo e(getCourseDuration($total_duration)); ?></span>
                                                </div>
                                            </li>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </ul>
                                </div>
                            </div>
                            <div class="cr-action-buttons">
                                <!--[if BLOCK]><![endif]--><?php if($viewCourse): ?>
                                    <a href="<?php echo e(route('courses.course-taking', ['slug' => $course->slug, 'redirect' => 'course-detail'])); ?>" class="am-btn">
                                        <?php echo e(__('courses::courses.view_course')); ?>

                                    </a>
                                <?php elseif($isBuyable): ?>
                                    <!--[if BLOCK]><![endif]--><?php if($courseInCart): ?>
                                        <a href="<?php echo e(route('checkout')); ?>" class="am-btn">
                                            <?php echo e(__('general.proceed_order')); ?>

                                        </a>
                                    <?php else: ?>
                                        <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                            <button class="am-btn" wire:click="addToCart" wire:loading.attr="disabled" wire:loading.class="am-btn_disable" wire:target="addToCart">
                                                <?php echo e(__('courses::courses.add_to_cart')); ?>

                                            </button>
                                        <?php else: ?>
                                            <button class="am-btn" wire:click="enrollCourse" wire:loading.attr="disabled" wire:loading.class="am-btn_disable" wire:target="addToCart">
                                                <?php echo e(__('courses::courses.enroll_now')); ?>

                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor)): ?>
                            <div class="am-similar-user">
                                <div class="am-tutordetail_user" onclick="window.open(`<?php echo e(route('tutor-detail',['slug' => $course->instructor?->profile?->slug])); ?>`, '_blank')">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor->profile?->image)): ?>
                                        <figure class="am-tutorvone_img">
                                            <img src="<?php echo e(url(Storage::url($course->instructor->profile?->image))); ?>" alt="<?php echo e($course->instructor->profile?->short_name); ?>">
                                        </figure>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="am-tutordetail_user_name">
                                        <h3>
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor->profile?->full_name)): ?>  
                                                <a href="javascript:void(0);"><?php echo e($course->instructor->profile?->full_name); ?></a>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <div class="am-custom-tooltip">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor?->profile?->verified_at)): ?>
                                                <span class="am-tooltip-text">
                                                    <span><?php echo e(__('courses::courses.verified')); ?></span>
                                                </span>
                                                <i class="am-icon-user-check"></i>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor?->address?->country?->short_code)): ?>
                                                <div class="am-custom-tooltip">
                                                    <span class="am-tooltip-text">
                                                        <span><?php echo e(ucfirst($course->instructor?->address?->country?->name)); ?></span>
                                                    </span>
                                                    <span class="flag flag-<?php echo e(strtolower($course->instructor?->address?->country?->short_code)); ?>"></span>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </h3>
                                        <span><?php echo e($course->instructor?->profile?->tagline); ?></span>
                                    </div>
                                </div>
                                <ul class="am-tutorreviews-list">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($instructorAvgReviews) && !empty($instructorReviewsCount)): ?>
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <div class="am-tutorreview-item_icon">
                                                    <i class="am-icon-star-filled"></i>
                                                </div>
                                                    <span class="am-uniqespace"><?php echo e(number_format($instructorAvgReviews, 1)); ?> <em>/5.0 (<?php echo e($instructorReviewsCount. ' '. ($instructorReviewsCount > 1 ? __('courses::courses.reviews') : __('courses::courses.review'))); ?> )</em></span>
                                                </div>
                                            </li>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon">
                                                <i class="am-icon-user-group"></i>
                                            </div>
                                            <span><?php echo e(number_format($course->active_students_count)); ?>

                                                <em>
                                                    <?php echo e($course->active_students_count == 1 ? __('courses::courses.active_student') : __('courses::courses.active_students')); ?>

                                                </em>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"><g opacity="0.7"><path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7.18201 7.23984C7.18201 6.4545 8.04578 5.97564 8.71184 6.39173L11.5295 8.15195C12.1564 8.54359 12.1564 9.45654 11.5295 9.84817L8.71184 11.6084C8.04578 12.0245 7.18201 11.5456 7.18201 10.7603V7.23984Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></g></svg>
                                            </div>
                                            <span> <?php echo e(number_format( $this->instructorCoursesCount )); ?> <em><?php echo e($this->instructorCoursesCount == 1 ? __('courses::courses.course') : __('courses::courses.courses')); ?></em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon">
                                                <i class="am-icon-megaphone-01"></i>
                                            </div>
                                            <span><em><?php echo e(__('courses::courses.i_can_speak')); ?></em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor->languages)): ?>
                                        <div class="am-tutorreview-item">
                                            <div class="wa-tags-list">
                                                <ul x-data="{ open: false }">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor->profile?->native_language)): ?>
                                                        <li>
                                                            <span>
                                                                <?php echo e(ucfirst($course->instructor->profile->native_language)); ?>

                                                                <em><?php echo e(__('courses::courses.native')); ?></em>
                                                            </span>
                                                        </li>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $course->instructor->languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <!--[if BLOCK]><![endif]--><?php if($index < 2): ?>
                                                            <li><span><?php echo e(ucfirst($language->name)); ?></span></li>
                                                        <?php else: ?>
                                                            <li x-show="open"><span><?php echo e(ucfirst($language->name)); ?></span></li>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

                                                    <!--[if BLOCK]><![endif]--><?php if($course->instructor->languages->count() > 2): ?>
                                                        <li>
                                                            <a href="javascript:void(0);" @click="open = !open">
                                                                <span x-show="!open">
                                                                    +<?php echo e($course->instructor->languages->count() - 2); ?> <?php echo e(__('courses::courses.more')); ?>

                                                                </span>
                                                                <span x-show="open">
                                                                    <?php echo e(__('courses::courses.show_less')); ?>

                                                                </span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </ul>
                                            </div>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </li>
                                </ul>
                                <!--[if BLOCK]><![endif]--><?php if( !empty($course->instructor?->profile?->description)): ?>
                                    <p class="cr-instructor-bio">   
                                        <?php echo e(Str::words(strip_tags($course->instructor?->profile?->description), 50)); ?>

                                    </p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                               
                                <div class="cr-profile-footer">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course->instructor?->socialProfiles) && $course->instructor?->socialProfiles->isNotEmpty()): ?>
                                        <ul class="cr-social-icons">
                                            <?php
                                                $validProfiles = $course->instructor?->socialProfiles->filter(function($profile) {
                                                    return !empty($profile->url);
                                                })->take(4);
                                            ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $validProfiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialProfile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    <a href="<?php echo e($socialProfile->url); ?>" target="_blank">
                                                        <span class="am-tooltip-text">
                                                            <span><?php echo e($socialProfile->type); ?></span>
                                                        </span>
                                                        <!--[if BLOCK]><![endif]--><?php if($socialProfile->type == 'Pinterest'): ?>
                                                            <?php if (isset($component)) { $__componentOriginal1c576162d0d3368430660a5ad8a1b777 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c576162d0d3368430660a5ad8a1b777 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'courses::components.icons.pinterest','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('courses::icons.pinterest'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c576162d0d3368430660a5ad8a1b777)): ?>
<?php $attributes = $__attributesOriginal1c576162d0d3368430660a5ad8a1b777; ?>
<?php unset($__attributesOriginal1c576162d0d3368430660a5ad8a1b777); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c576162d0d3368430660a5ad8a1b777)): ?>
<?php $component = $__componentOriginal1c576162d0d3368430660a5ad8a1b777; ?>
<?php unset($__componentOriginal1c576162d0d3368430660a5ad8a1b777); ?>
<?php endif; ?>
                                                        <?php else: ?>
                                                            <i class="<?php echo e($socialIcons[$socialProfile->type]); ?>"></i>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </ul>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <a href="<?php echo e(route('tutor-detail', ['slug' => $course->instructor?->profile->slug])); ?>">
                                        <button class="cr-view-profile-btn"><?php echo e(__('courses::courses.view_profile')); ?></button>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="share-course-container">
                            <h2 class="share-text"><?php echo e(__('courses::courses.share_this_course')); ?></h2>
                            <div class="share-icons-container" x-data="{copied: false, textToCopy: '<?php echo e(route('courses.course-detail', ['slug' => $course->slug])); ?>'}">
                                <button class="share-icon cr-facebook" aria-label="Share on Facebook" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('courses.course-detail', ['slug' => $course->slug]))); ?>', '_blank', 'width=600,height=400')">
                                    <i class="am-icon-facebook-1"></i>
                                    <span class="am-tooltip-text">
                                        <span><?php echo e(__('courses::courses.facebook')); ?></span>
                                    </span>
                                </button>
                                <button class="share-icon cr-twitter" aria-label="Share on Twitter" onclick="window.open('https://twitter.com/intent/tweet?url=<?php echo e(urlencode(route('courses.course-detail', ['slug' => $course->slug]))); ?>&text=<?php echo e(urlencode($course->title)); ?>', '_blank', 'width=600,height=400')">
                                    <i class="am-icon-twitter-02"></i>
                                    <span class="am-tooltip-text">
                                        <span><?php echo e(__('courses::courses.twitter')); ?></span>
                                    </span>
                                </button>
                                <button class="share-icon cr-linkedin" aria-label="Share on LinkedIn" onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(urlencode(route('courses.course-detail', ['slug' => $course->slug]))); ?>&title=<?php echo e(urlencode($course->title)); ?>', '_blank', 'width=600,height=400')">
                                    <i class="am-icon-linkedin-02"></i>
                                    <span class="am-tooltip-text">
                                        <span><?php echo e(__('courses::courses.linkedin')); ?></span>
                                    </span>
                                </button>
                                <button class="share-icon cr-instagram" aria-label="Share via Instragram" onclick="window.open('https://www.instagram.com/sharer?url=<?php echo e(urlencode(route('courses.course-detail', ['slug' => $course->slug]))); ?>', '_blank', 'width=600,height=400')">
                                    <i class="am-icon-instagram"></i>
                                    <span class="am-tooltip-text">
                                        <span><?php echo e(__('courses::courses.instagram')); ?></span>
                                    </span>
                                </button>
                                <button 
                                    class="more-options" 
                                    aria-label="Copy Link" 
                                    @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true; setTimeout(() => copied = false, 2000) }).catch(() => {})"
                                >
                                <template x-if="copied">
                                    <span class="fw-bookmark fw-invite" x-show="copied" x-transition><?php echo e(__('general.copied')); ?></span>
                                </template>
                                    <i class="am-icon-copy-01"></i>
                                </button>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($course->tags)): ?>
                            <div class="tags-container">
                                <h2 class="tags-title"><?php echo e(__('courses::courses.tags')); ?></h2>
                                <div class="tags-list" role="list">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $course->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="tag" role="listitem" tabindex="0"><?php echo ucfirst($tag); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- Video.js Player Modal -->
    <div wire:ignore.self class="modal fade cr-promotional-video " id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2 id="videoModalLabel"><?php echo e(__('courses::courses.promotional_video')); ?></h2>
                    <span class="cr-close" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <div class="cr-offering-videojs"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Article Modal -->
    <div wire:ignore.self class="modal fade cr-article-modal" id="articleModal" tabindex="-1" aria-labelledby="articleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2 id="articleModalLabel"></h2>
                    <span class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <div class="cr-article-content"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('modules/courses/css/main.css')); ?>">
<?php echo app('Illuminate\Foundation\Vite')([
    'public/css/videojs.css',
    'public/css/flags.css',
]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/video.min.js')); ?>"></script>

<script type="text/javascript" data-navigate-once>

     function openVideoModal(videoPath, type) {
        var videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
        let player = null;
        let id = 'ar-video_' + Math.random().toString(36).substring(2, 15);
      
        const container = document.querySelector('.cr-offering-videojs');

        container.innerHTML = type === 'yt_link' || type === 'vm_link' 
        ? `<iframe id="${id}" class="cr-promotional-video" width="100%" height="400" src="${videoPath}" frameborder="0" allowfullscreen></iframe>`
        : `<video id="${id}" class="video-js vjs-default-skin d-none cr-promotional-video" width="100%" height="400" controls></video>`;

        if (type !== 'yt_link' && type !== 'vm_link') {
            setTimeout(() => {
                player = videojs(id);
                player.src({ type: 'video/mp4', src: videoPath });
                player.ready(function () {
                    player.play();
                    player.removeClass('d-none');
                });
            }, 100);
        }
        videoModal.show();
    };
    function initializeVideoPlayer(videoElement, courseId) {
        alert(videoElement);
        if (!videoElement.player) {
            let player = videojs(videoElement);
            videoElement.player = player;
            
            player.on('loadstart', function() {
                player.addClass('vjs-waiting');
                $(`#cr-card-skeleton-${courseId}`).remove();
                player.removeClass('d-none');
            });
            
            player.on('loadeddata', function() {
                player.removeClass('vjs-waiting');
                player.removeClass('d-none');
                $(`#cr-card-skeleton-${courseId}`)?.remove();
            });
            
            player.on('playing', function() {
                let players = document.querySelectorAll('.video-js');
                let current = document.getElementById(this.id());
                players.forEach((element) => {
                    if(current != element){
                        let otherPlayer = videojs(element);
                        if (!otherPlayer.paused()) {
                            otherPlayer.pause();
                        }
                    }
                });
            });
        }
    }
</script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/Modules/Courses/resources/views/livewire/course/course-detail.blade.php ENDPATH**/ ?>