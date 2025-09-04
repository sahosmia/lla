<div>
<!--[if BLOCK]><![endif]--><?php if($courses->isNotEmpty()): ?>
    <div class="am-testimonial-section">
        <div class="splide" id="courses-slider">
            <div class="splide__track">
                <ul class="splide__list">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <!--[if BLOCK]><![endif]--><?php if($sectionVerient == 'am-courses-block-two'): ?>
                            <li class="splide__slide">
                                <div class="cr-card">
                                    <figure class="cr-image-wrapper">
                                        <img height="200" width="360" src="<?php echo e(Storage::url($course?->thumbnail?->path)); ?>" alt="<?php echo e($course?->title); ?>" class="cr-background-image">
                                        <figcaption>
                                            <span><?php echo e($course?->category?->name); ?></span>
                                        </figcaption>
                                    </figure>
                                    <div class="cr-course-card">
                                        <div class="cr-course-header">
                                            <h2 class="cr-course-title">
                                                <a href="<?php echo e(route('courses.course-detail', ['slug' => $course?->slug])); ?>"><?php echo e(html_entity_decode($course?->title)); ?></a>
                                            </h2>
                                        </div>
                                        <div class="cr-instructor-details">
                                            <a href="<?php echo e(route('tutor-detail',['slug' => $course?->instructor?->profile?->slug])); ?>" target="_blank" class="cr-instructor-name">
                                                <img src="<?php echo e(Storage::url($course?->instructor?->profile?->image)); ?>" alt="<?php echo e($course?->instructor?->profile?->short_name); ?>" class="cr-instructor-avatar" />
                                                <?php echo e($course?->instructor?->profile?->full_name); ?>

                                            </a>
                                        </div>
                                        <div class="cr-card_footer">
                                            <div class="cr-course-features">
                                                <div class="cr-info-item">
                                                    <span><em><?php echo e($course?->curriculums?->count()); ?></em> <?php echo e(__('general.lessons')); ?></span>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-globe"></i>
                                                    <span><?php echo e($course?->language?->name); ?></span>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-time"></i>
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course?->content_length)): ?>
                                                        <!--[if BLOCK]><![endif]--><?php if($course?->content_length > 0): ?>
                                                            <em>
                                                                <?php echo e(getCourseDurationWithoutSecond($course?->content_length)); ?>

                                                            </em>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                            <div class="cr-price-wrap">
                                                <div class="cr-price-info">
                                                    <!--[if BLOCK]><![endif]--><?php if($course?->pricing?->price != $course?->pricing?->final_price): ?>
                                                        <span class="cr-original-price">
                                                            <?php echo formatAmount($course?->pricing?->price); ?>

                                                            <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                                <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                                <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                            </svg>
                                                        </span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <div class="cr-discounted-price">
                                                        <span class="cr-price-amount"><?php echo formatAmount($course?->pricing?->final_price, true); ?></span>
                                                    </div>
                                                </div> 
                                                <a href="<?php echo e(route('login')); ?>" class="am-btn"><?php echo e(__('general.enrole')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php elseif($sectionVerient == 'am-courses-block-three'): ?>
                            <li class="splide__slide">
                                <div class="cr-card">
                                    <figure class="cr-image-wrapper">
                                        <img height="200" width="360" src="<?php echo e(Storage::url($course?->thumbnail?->path)); ?>" alt="<?php echo e($course?->title); ?>" class="cr-background-image">
                                    </figure>
                                    <div class="cr-course-card">
                                        <img src="<?php echo e(Storage::url($course?->instructor?->profile?->image)); ?>" alt="<?php echo e($course?->instructor?->profile?->full_name); ?>" class="cr-instructor-avatar" />
                                        <div class="cr-user-detail">
                                            <a href="<?php echo e(route('tutor-detail',['slug' => $course?->instructor?->profile?->slug])); ?>" target="_blank">
                                                <h4><?php echo e($course?->instructor?->profile?->full_name); ?></h4>
                                            </a>
                                            <span><?php echo e(__('courses::courses.author')); ?></span>
                                            <div class="cr-price-info">
                                                <!--[if BLOCK]><![endif]--><?php if($course?->pricing?->price != $course?->pricing?->final_price): ?>
                                                    <span class="cr-original-price">
                                                        <?php echo formatAmount($course?->pricing?->price, true); ?>

                                                        <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                            <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                            <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                        </svg>
                                                    </span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <div class="cr-discounted-price">
                                                    <span class="cr-price-amount"><?php echo formatAmount($course?->pricing?->final_price, true); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cr-course-header">
                                            <h2 class="cr-course-title">
                                                <a href="<?php echo e(route('courses.course-detail', ['slug' => $course?->slug])); ?>"><?php echo e(html_entity_decode($course?->title)); ?></a>
                                            </h2>
                                            <div class="cr-course-category">
                                                <?php echo e(__('general.in')); ?> <a href="<?php echo e(route('courses.search-courses', ['searchCategories' => [0 => $course?->category?->id]])); ?>" class="cr-category-link"><?php echo e($course?->category?->name); ?></a>
                                            </div>
                                        </div>
                                        <div class="cr-card_footer">
                                            <div class="cr-course-features">
                                                <div class="cr-info-item">
                                                    <i class="am-icon-time"></i>
                                                    <span><?php echo e(__('courses::courses.duration')); ?></span>
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($course?->content_length)): ?>
                                                        <!--[if BLOCK]><![endif]--><?php if($course?->content_length > 0): ?>
                                                            <em>
                                                                <?php echo e(getCourseDurationWithoutSecond($course?->content_length)); ?>

                                                            </em>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-book-1"></i>
                                                    <span><?php echo e(__('general.lessons')); ?></span>
                                                    <em><?php echo e($course?->curriculums?->count()); ?></em>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-bar-chart-04"></i>
                                                    <span><?php echo e(__('courses::courses.level')); ?></span>
                                                    <em><?php echo e(__('courses::courses.'. $course->level)); ?></em>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-globe"></i>
                                                    <span><?php echo e(__('courses::courses.language')); ?></span>
                                                    <em><?php echo e($course?->language?->name); ?></em>
                                                </div>
                                            </div>
                                            <div class="cr-price-wrap">
                                                <a href="<?php echo e(route('login')); ?>" class="am-btn"><?php echo e(__('general.enrole')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class="splide__slide">
                                <div class="cr-card">
                                    <div class="cr-instructor-info">
                                        <div class="cr-instructor-details">
                                            <a href="<?php echo e(route('tutor-detail',['slug' => $course?->instructor?->profile?->slug])); ?>" target="_blank" class="cr-instructor-name">
                                                <img src="<?php echo e(Storage::url($course?->instructor?->profile?->image)); ?>" alt="<?php echo e($course?->instructor?->profile?->short_name); ?>" class="cr-instructor-avatar" />
                                                <?php echo e($course?->instructor?->profile?->short_name); ?>

                                            </a>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->guest()): ?>
                                            <button onclick="window.location.href='<?php echo e(route('login')); ?>'" class="cr-bookmark-button" aria-label="<?php echo e(__('courses::courses.like_this_course')); ?>">
                                                <i class="am-icon-heart-filled-1"></i>
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if(Auth::check() && Auth()->user()->role == 'student'): ?>
                                            <button wire:click="likeCourse(<?php echo e($course->id); ?>)" 
                                                class="<?php echo \Illuminate\Support\Arr::toCssClasses(['cr-bookmark-button','cr-likedcard' => auth()->check() && collect($course->like_user_ids)->contains(auth()->id())]); ?>" 
                                                aria-label="<?php echo e(__('courses::courses.like_this_course')); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="<?php echo e(auth()->check() && collect($course->like_user_ids)->contains(auth()->id()) ? '#F63C3C' : 'none'); ?>">
                                                    <g opacity="1">
                                                        <path opacity="1" d="M7.9987 14C8.66536 14 14.6654 10.6668 14.6654 6.00029C14.6654 3.66704 12.6654 2.02937 10.6654 2.00043C9.66537 1.98596 8.66536 2.33377 7.9987 3.33373C7.33203 2.33377 6.31473 2.00043 5.33203 2.00043C3.33203 2.00043 1.33203 3.66704 1.33203 6.00029C1.33203 10.6668 7.33204 14 7.9987 14Z" stroke="#F63C3C" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <figure class="cr-image-wrapper">
                                        <img height="200" width="360" src="<?php echo e(Storage::url($course?->thumbnail?->path)); ?>" alt="<?php echo e($course?->title); ?>" class="cr-background-image">
                                        <figcaption>
                                            <i class="am-icon-book-1"></i>
                                            <span><?php echo e($course?->curriculums?->count()); ?> <?php echo e(__('general.lessons')); ?></span>
                                        </figcaption>
                                    </figure>
                                    <div class="cr-course-card">
                                        <div class="cr-course-header">
                                            <div class="cr-course-category">
                                                <?php echo e(__('general.in')); ?> <a href="<?php echo e(route('courses.search-courses', ['searchCategories' => [0 => $course?->category?->id]])); ?>" class="cr-category-link"><?php echo e($course?->category?->name); ?></a>
                                            </div>
                                            <h2 class="cr-course-title">
                                                <a href="<?php echo e(route('courses.course-detail', ['slug' => $course->slug])); ?>"><?php echo e(html_entity_decode($course->title)); ?></a>
                                            </h2>
                                        </div>
                                        <div class="cr-course-features">
                                            <div class="cr-info-item">
                                                <i class="am-icon-bar-chart-04"></i>
                                                <span><?php echo e(__('courses::courses.level')); ?></span>
                                                <em><?php echo e(__('courses::courses.'. $course->level)); ?></em>
                                            </div>
                                            <div class="cr-info-item">
                                                <i class="am-icon-globe"></i>
                                                <span><?php echo e(__('courses::courses.language')); ?></span>
                                                <em><?php echo e($course?->language?->name); ?></em>
                                            </div>
                                            <div class="cr-info-item">
                                                <i class="am-icon-time"></i>
                                                <span><?php echo e(__('courses::courses.duration')); ?></span>
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($course?->content_length)): ?>
                                                    <!--[if BLOCK]><![endif]--><?php if($course?->content_length > 0): ?>
                                                        <em>
                                                            <?php echo e(getCourseDurationWithoutSecond($course?->content_length)); ?>

                                                        </em>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                        <div class="cr-card_footer">
                                            <div class="cr-price-info">
                                                <!--[if BLOCK]><![endif]--><?php if($course?->pricing?->price != $course?->pricing?->final_price): ?>
                                                    <span class="cr-original-price">
                                                        <?php echo formatAmount($course?->pricing?->price, true); ?>

                                                        <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                            <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                            <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                        </svg>
                                                    </span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <div class="cr-discounted-price">
                                                    <span class="cr-price-amount"><?php echo formatAmount($course?->pricing?->final_price, true); ?></span>
                                                </div>
                                            </div>
                                            <a href="<?php echo e(route('login')); ?>" class="am-btn"><?php echo e(__('general.enrole')); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php if (! $__env->hasRenderedOnce('209d9aea-e32d-4f8c-aa55-40a34eea29a0')): $__env->markAsRenderedOnce('209d9aea-e32d-4f8c-aa55-40a34eea29a0');
$__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/splide.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('#courses-slider')) {
                setTimeout(function() {
                    initCoursesSlider();
                }, 50);
            }
        });

        document.addEventListener('loadSectionJs', function (event) {
            if (event.detail.sectionId === 'courses') {
                if (document.querySelector('#courses-slider')) {
                    initCoursesSlider();
                }
            }
        });

        function initCoursesSlider() {
            new Splide('#courses-slider', {
                gap: '16px',
                perPage: 4,
                perMove: 1,
                focus: 1,
                pagination: true,
                type: 'loop',
                direction: document.documentElement.dir === 'rtl' ? 'rtl' : 'ltr', 
                breakpoints: {
                    1399: {
                        perPage: 3,
                    },
                    1024: {
                        perPage: 2,
                    },
                    768: {
                        perPage: 1,
                    },
                },
            }).mount();
        }
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/components/courses.blade.php ENDPATH**/ ?>