<div>
    <!--[if BLOCK]><![endif]--><?php if($slider == false): ?>
        <ul class="am-experience-tutor-list">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $experiencedTutors->take($selectTutor); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleTutor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="<?php echo e($loop->iteration * 200); ?>">
                <div class="am-experience-tutor-card">
                    <div class="am-experience-tutor-img">
                        <!--[if BLOCK]><![endif]--><?php if($sectionVerient == 'am-tutors-varient-two'): ?>
                            <!--[if BLOCK]><![endif]--><?php if($singleTutor->profile->image): ?>
                                <img src="<?php echo e(url(Storage::url($singleTutor->profile->image))); ?>" alt="Profile image">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php else: ?>
                            <!--[if BLOCK]><![endif]--><?php if($singleTutor->profile->image): ?>
                                <img src="<?php echo e(url(Storage::url($singleTutor->profile->image))); ?>" alt="Profile image">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if(auth()->guard()->guest()): ?>
                                <span>
                                    <i class="am-icon-heart-01" onclick="window.location.href='<?php echo e(route('login')); ?>'"></i>
                                </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if(Auth::check() && Auth()->user()->role == 'student'): ?>
                                <span class="<?php echo e(in_array($singleTutor->profile->id, $favouriteTutors) ? 'active' : ''); ?>">
                                    <i class="am-icon-heart-01" wire:click="favouriteTutor(<?php echo e($singleTutor->profile->id); ?>)"></i>
                                </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($sectionVerient == 'am-tutors-varient-two'): ?>
                        <div class="am-experience-tutor-info"> 
                            <div class="am-experience-tutor-name">
                                <div class="am-tutorsearch_user_name">
                                    <h3>
                                        <a href="<?php echo e(route('tutor-detail',['slug' => $singleTutor->profile->slug])); ?>">
                                            <?php echo e($singleTutor->profile->first_name); ?> <?php echo e($singleTutor->profile->last_name); ?>

                                        </a>
                                    </h3>
                                    <!--[if BLOCK]><![endif]--><?php if($singleTutor->profile->tagline): ?>
                                        <p><?php echo e($singleTutor->profile->tagline); ?></p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <a class="am-primary-btn" href="<?php echo e(route('tutor-detail', ['slug' => $singleTutor->profile->slug])); ?>">
                                        <?php echo e(__('general.profile')); ?>

                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="am-experience-tutor-info">
                            <div class="am-experience-tutor-name">
                                <div class="am-tutorsearch_user_name">
                                    <h3>
                                        <a href="<?php echo e(route('tutor-detail',['slug' => $singleTutor->profile->slug])); ?>">
                                            <?php echo e($singleTutor->profile->first_name); ?> <?php echo e($singleTutor->profile->last_name); ?>

                                        </a>
                                        <!--[if BLOCK]><![endif]--><?php if($singleTutor->profile->verified_at): ?>
                                            <?php if (isset($component)) { $__componentOriginald80d9d1155ea0a0af59d2dc6ae0f154e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald80d9d1155ea0a0af59d2dc6ae0f154e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.frontend.verified-tooltip','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('frontend.verified-tooltip'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald80d9d1155ea0a0af59d2dc6ae0f154e)): ?>
<?php $attributes = $__attributesOriginald80d9d1155ea0a0af59d2dc6ae0f154e; ?>
<?php unset($__attributesOriginald80d9d1155ea0a0af59d2dc6ae0f154e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald80d9d1155ea0a0af59d2dc6ae0f154e)): ?>
<?php $component = $__componentOriginald80d9d1155ea0a0af59d2dc6ae0f154e; ?>
<?php unset($__componentOriginald80d9d1155ea0a0af59d2dc6ae0f154e); ?>
<?php endif; ?>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($singleTutor->address?->country?->short_code)): ?>
                                            <span class="flag flag-<?php echo e(strtolower($singleTutor->address?->country?->short_code)); ?>"></span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </h3>
                                </div>
                            </div>
                            <ul class="am-tutorsearch_info">
                                <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                    <li>
                                        <span class="am-currency_conversion"><?php echo formatAmount($singleTutor->min_price); ?><em><?php echo e(__('app.hr')); ?></em></span>
                                    </li>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-star-filled"></i></div>
                                    <span><?php echo e(number_format($singleTutor->avg_rating, 1)); ?><em>/5.0 (<?php echo e($singleTutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $singleTutor->total_reviews] )); ?>)</em></span>
                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                    <span><?php echo e($singleTutor->active_students); ?> <em><?php echo e(__('general.active_students')); ?></em></span>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </ul>
    <?php else: ?>
        <div class="am-featured-mentors-slider splide featured-slider" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
            <div class="splide__track">
                <ul class="splide__list">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $experiencedTutors->take($selectTutor); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleTutor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="splide__slide">
                            <div class="am-experience-tutor-card">
                                <!--[if BLOCK]><![endif]--><?php if($singleTutor->profile->image): ?>
                                    <figure class="am-experience-tutor-img">
                                        <img src="<?php echo e(url(Storage::url($singleTutor->profile->image))); ?>" alt="Profile image" class="user-avatar" />
                                    </figure>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="am-experience-tutor-info">
                                    <div class="am-experience-tutor-name">
                                        <div class="am-tutorsearch_user_name">
                                            <h3>
                                                <a href="<?php echo e(route('tutor-detail',['slug' => $singleTutor->profile->slug])); ?>">
                                                    <?php echo e($singleTutor->profile->first_name); ?> <?php echo e($singleTutor->profile->last_name); ?>

                                                </a>
                                            </h3>
                                            <!--[if BLOCK]><![endif]--><?php if($singleTutor->profile->tagline): ?>
                                                <p><?php echo e($singleTutor->profile->tagline); ?></p>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <a class="am-primary-btn" href="<?php echo e(route('tutor-detail', ['slug' => $singleTutor->profile->slug])); ?>">
                                                <?php echo e(__('general.profile')); ?>

                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ul>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/flags.css']); ?>
<?php $__env->stopPush(); ?>

<?php if (! $__env->hasRenderedOnce('bd94a5e8-3c47-4e97-85d7-f2e260998e5f')): $__env->markAsRenderedOnce('bd94a5e8-3c47-4e97-85d7-f2e260998e5f');
$__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/splide.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initFeaturedMentorsSlider();
        });

        document.addEventListener('loadSectionJs', (event)=>{
            if(event.detail.sectionId === 'featured-mentors'){
                initFeaturedMentorsSlider();
            }
        });

        function initFeaturedMentorsSlider(){
            if (typeof Splide !== 'undefined') {
                const sliders = document.querySelectorAll('.featured-slider');
                sliders.forEach(slider => {
                new Splide(slider, {
                    gap: 24,
                    perPage: 4,
                    perMove: 1,
                    focus  : 1,
                    type: 'loop',
                    direction: document.documentElement.dir === 'rtl' ? 'rtl' : 'ltr',
                    pagination: false,
                    breakpoints: {
                        1024: {
                            perPage: 3,
                        },
                        768: {
                            perPage: 2,
                        },
                        576: {
                            perPage: 1,
                        },
                    },
                    }).mount();
                });
            }
        }
    </script>
<?php $__env->stopPush(); endif; ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/experienced-tutors.blade.php ENDPATH**/ ?>