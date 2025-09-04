<div id="am-handpick-tutor" class="am-handpick-tutor splide">
    <div class="splide__track">
        <ul class="splide__list">
            <?php $__currentLoopData = $featuredTutors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleTutor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($singleTutor?->profile?->verified_at !== null): ?>
                    <li class="splide__slide">
                        <div class="am-tutor-feature">
                            <?php if(!empty($singleTutor?->profile?->intro_video) && Storage::disk(getStorageDisk())->exists($singleTutor?->profile?->intro_video)): ?>
                                <video class="video-js" src="<?php echo e(url(Storage::url($singleTutor?->profile?->intro_video))); ?>" controls></video>
                            <?php endif; ?> 
                            <div class="am-tutorsearch_user">
                                <figure class="am-tutorvone_img">
                                    <?php if($singleTutor?->profile?->image): ?>
                                        <img src="<?php echo e(url(Storage::url($singleTutor?->profile?->image))); ?>" alt="profile image">
                                    <?php else: ?>
                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34)); ?>" alt="profile image" />
                                    <?php endif; ?>
                                    <span class="am-userstaus am-userstaus_online"></span>
                                </figure>
                                <div class="am-tutorsearch_user_name">
                                    <h3>
                                        <a href="<?php echo e(route('tutor-detail',['slug' => $singleTutor?->profile?->slug])); ?>">
                                            <?php echo e($singleTutor?->profile?->first_name); ?> <?php echo e($singleTutor?->profile?->last_name); ?>

                                        </a>
                                        <?php if($singleTutor?->profile?->verified_at): ?>
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
                                        <?php endif; ?>
                                        <?php if($singleTutor?->address?->country?->short_code): ?>
                                            <span class="flag flag-<?php echo e(strtolower($singleTutor?->address?->country?->short_code)); ?>"></span>
                                        <?php endif; ?>
                                    </h3>
                                    <span>
                                        <?php $__currentLoopData = $singleTutor->educations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $singleEducation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($singleEducation?->course_title); ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </span>
                                </div>
                            </div>
                            <ul class="am-tutorsearch_info">
                                <?php if(isPaidSystem()): ?>
                                    <li>
                                        <span class="am-currency_conversion"><?php echo formatAmount($singleTutor->min_price); ?><em><?php echo e(__('app.hr')); ?></em></span>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                                    <span><?php echo e(number_format($singleTutor->avg_rating, 1)); ?><em>/5.0 (<?php echo e($singleTutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $singleTutor->total_reviews] )); ?>)</em></span>

                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                    <span><?php echo e($singleTutor->active_students); ?> <em><?php echo e(__('general.active_students')); ?></em></span>
                                </li>
                            </ul>
                            <a href="<?php echo e(route('tutor-detail', ['slug' => $singleTutor?->profile?->slug])); ?>" class="am-white-btn"><?php echo e(__('general.profile')); ?></a>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['public/css/flags.css']); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', (event)=>{
        initFeaturedTutorsSlider();
    });

    document.addEventListener('loadSectionJs', (event)=>{
        if(event.detail.sectionId === 'featured-tutors'){
            setTimeout(()=>{
                initFeaturedTutorsSlider();
            }, 500);
        }
    });

    function initFeaturedTutorsSlider(){
            new Splide('.am-handpick-tutor' , {
                autoWidth: true,
                    perMove: 1,
                pagination: false,
                breakpoints: {
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
<?php $__env->stopPush(); ?>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/featured-tutors.blade.php ENDPATH**/ ?>