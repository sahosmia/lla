<?php $__env->startSection('content'); ?>
<div class="am-search-detail-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="am-breadcrumb">
                    <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('sidebar.home')); ?></a></li>
                    <li><em>/</em></li>
                    <li><a href="<?php echo e(route('find-tutors')); ?>"><?php echo e(__('sidebar.find_tutor')); ?></a></li>
                    <li><em>/</em></li>
                    <li class="active"><span><?php echo e($tutor?->profile?->full_name); ?></span></li>
                </ol>
                <div class="am-searchdetail">
                    <div class="am-search-userdetail">
                        <div class="am-tutordetail_head">
                            <div class="am-tutordetail_user">
                                <figure class="am-tutorvone_img">
                                    <?php if(!empty($tutor?->profile?->image) &&
                                    Storage::disk(getStorageDisk())->exists($tutor?->profile?->image)): ?>
                                        <img src="<?php echo e(resizedImage($tutor?->profile?->image,80,80)); ?>" alt="<?php echo e($tutor?->profile?->full_name); ?>" />
                                    <?php else: ?> 
                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 80, 80)); ?>" alt="<?php echo e($tutor->profile?->full_name); ?>" />
                                    <?php endif; ?>
                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-userstaus','am-userstaus_online'=> $tutor?->is_online]); ?>"></span>
                                </figure>
                                <div class="am-tutordetail_user_name">
                                    <h3>
                                        <?php echo e($tutor?->profile?->full_name); ?>

                                        <?php if($tutor?->profile?->verified_at): ?>
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
                                        <?php if($tutor?->address?->country?->short_code): ?>
                                        <span
                                            class="flag flag-<?php echo e(strtolower($tutor?->address?->country?->short_code)); ?>"></span>
                                        <?php endif; ?>
                                    </h3>
                                    <?php if(!empty($tutor?->profile?->tagline)): ?>
                                        <span><?php echo $tutor?->profile?->tagline; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if(!empty($tutor?->profile?->intro_video) && isPaidSystem()): ?>
                                <div class="am-tutordetail_fee">
                                    <strong> <?php echo formatAmountV2($tutor?->min_price); ?><em><?php echo e(__('tutor.per_session')); ?></em></strong>
                                    <span><?php echo e(__('tutor.starting_from')); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="am-tutordetail-reviews">
                            <div class="am-tutordetail-reviews_wrap">
                                <ul class="am-tutorreviews-list">
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-star-01"></i>
                                            <span class="am-uniqespace"><?php echo e(number_format($tutor?->avg_rating, 1)); ?><em>/5.0 (<?php echo e($tutor?->total_reviews == 1 ? __('general.review_count') :
                                                    __('general.reviews_count', ['count' => $tutor?->total_reviews] )); ?>)</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-user-group"></i>
                                            <span><?php echo e($tutor?->active_students); ?> <em>
                                            <?php echo e($tutor?->active_students == '1' ? __('tutor.booked_session') :
                                            __('tutor.booked_sessions')); ?></em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-menu-2"></i>
                                            <span><?php echo e($tutor?->subjects->sum('sessions')); ?> <em><?php echo e($tutor?->subjects->sum('sessions') == 1 ? __('tutor.session') : __('tutor.sessions')); ?></em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-watch-1"></i>
                                            <span><?php echo e(__('tutor.time', ['time' => rand(2, 5)])); ?> <em><?php echo e(__('tutor.response_time')); ?></em></span>
                                        </div>
                                    </li>
                                    <?php if(hasSocialProfiles($tutor?->socialProfiles)): ?>
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                    <path d="M12.8337 6.99935C12.8337 10.221 10.222 12.8327 7.00033 12.8327M12.8337 6.99935C12.8337 3.77769 10.222 1.16602 7.00033 1.16602M12.8337 6.99935C12.8337 5.71069 10.222 4.66602 7.00033 4.66602C3.77866 4.66602 1.16699 5.71069 1.16699 6.99935M12.8337 6.99935C12.8337 8.28801 10.222 9.33268 7.00033 9.33268C3.77866 9.33268 1.16699 8.28801 1.16699 6.99935M7.00033 12.8327C3.77866 12.8327 1.16699 10.221 1.16699 6.99935M7.00033 12.8327C8.28899 12.8327 9.33366 10.221 9.33366 6.99935C9.33366 3.77769 8.28899 1.16602 7.00033 1.16602M7.00033 12.8327C5.71166 12.8327 4.66699 10.221 4.66699 6.99935C4.66699 3.77769 5.71166 1.16602 7.00033 1.16602M1.16699 6.99935C1.16699 3.77769 3.77866 1.16602 7.00033 1.16602" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <span><em><?php echo e(__('tutor.social_profiles')); ?></em></span>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <?php if(hasSocialProfiles($tutor?->socialProfiles)): ?>
                                    <ul class="am-tutorsocial-list">
                                        <?php $__currentLoopData = setting('_social.platforms'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(hasSocialProfile($tutor?->socialProfiles, $platform)): ?>
                                                <li>
                                                    <a href="<?php echo e(getSocialProfileUrl($tutor?->socialProfiles, $platform)); ?>" target="_blank">
                                                        <img src="<?php echo e(asset('demo-content/social-icons/'. Str::slug($platform). '.svg')); ?>" alt="<?php echo e($platform); ?>" />
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <ul class="am-tutorskills-list">
                                <?php if($tutor?->subjects->isNotEmpty()): ?>
                                    <li>
                                        <div class="am-tutorskills-item">
                                            <i class="am-icon-book-1"></i>
                                            <span><?php echo e(__('tutor.i_can_teach')); ?></span>
                                        </div>
                                        <ul x-data="{ open: false }">
                                        
                                                <?php $__currentLoopData = $tutor?->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($index < 2): ?> 
                                                        <li><span><?php echo $sub->subject?->name; ?></span></li>
                                                    <?php else: ?>
                                                        <li x-show="open"><span><?php echo $sub->subject?->name; ?></span></li>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                            <?php if($tutor?->subjects->count() > 2): ?>
                                                <li>
                                                    <a href="javascript:void(0);" @click="open = !open">
                                                        <span x-show="!open"><?php echo e(__('tutor.more_item', ['count' =>
                                                            $tutor?->subjects->count() - 2])); ?></span>
                                                        <span x-show="open"><?php echo e(__('tutor.show_less')); ?></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <div class="am-tutorskills-item">
                                        <i class="am-icon-megaphone-01"></i>
                                        <span><?php echo e(__('tutor.i_can_speak')); ?></span>
                                    </div>
                                    <div class="wa-tags-list">
                                        <p><?php echo e(ucfirst($tutor?->profile?->native_language)); ?><span><?php echo e(__('tutor.native')); ?></span></p>
                                        <ul>
                                            <?php $__currentLoopData = $tutor?->languages->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><span><?php echo e(ucfirst( $lan->name )); ?></span></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php if($tutor?->languages?->count() > 3): ?>
                                        <div class="am-more am-custom-tooltip">
                                            <span class="am-tooltip-text">
                                                <?php
                                                $tutorLanguages = $tutor?->languages->slice(3,
                                                $tutor?->languages?->count() - 1);
                                                ?>
                                                <?php if(!empty($tutorLanguages)): ?>
                                                <?php $__currentLoopData = $tutorLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span><?php echo e(ucfirst( $lan->name )); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </span>
                                            +<?php echo e($tutor?->languages?->count() - 3); ?>

                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li>
                                    <?php if(\Nwidart\Modules\Facades\Module::has('starup') && \Nwidart\Modules\Facades\Module::isEnabled('starup')): ?>
                                        <div class="am-tutorskills-item">
                                            <i class="am-icon-shield-check"></i>
                                            <span><?php echo e(__('tutor.achievements')); ?></span>
                                        </div>
                                        <?php if($tutor?->badges?->count() > 0): ?>
                                        <div class="am-tutordetail_user_badge am-user_badge">
                                            <?php $__currentLoopData = $tutor?->badges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="am-custom-tooltip">
                                                    <span class="am-tooltip-text">
                                                        <span><?php echo e($badge?->name); ?></span>
                                                    </span>
                                                    <figure class="am-shimmer">
                                                    <?php if(!empty($badge?->image) &&
                                                        Storage::disk(getStorageDisk())->exists($badge?->image)): ?>
                                                        <img src="<?php echo e(resizedImage($badge?->image,80,80)); ?>" alt="<?php echo e($badge?->name); ?>" />
                                                    <?php else: ?> 
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 80, 80)); ?>" alt="<?php echo e($tutor->profile?->full_name); ?>" />
                                                    <?php endif; ?>
                                                    </figure>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <?php if(!empty($tutor?->profile?->intro_video)): ?>
                            <div class="am-tutordetail-btns">
                                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.tutor.action.action', ['tutor' => $tutor,'isFavourite' => $isFavourite,'navigate' => false]);

$__html = app('livewire')->mount($__name, $__params, $tutor->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($tutor?->profile?->intro_video)): ?>
                        <div class="am-detailuser_video am-detailuser_video_main">
                            <video class="video-js" data-setup='{}' preload="auto" wire:key="profile-video-<?php echo e($tutor->id); ?>"
                                id="profile-video-<?php echo e($tutor->id); ?>" width="320" height="240" controls>
                                <source
                                    src="<?php echo e(url(Storage::url($tutor?->profile?->intro_video)).'?key=short-video'); ?>#t=0.1"
                                    wire:key="profile-video-src-<?php echo e($tutor->id); ?>" type="video/mp4">
                            </video>
                        </div>
                    <?php else: ?>
                        <div class="am-detailuser_novideo">
                            <?php if(isPaidSystem()): ?>
                                <div class="am-tutordetail_fee">
                                    <strong> <?php echo formatAmountV2($tutor?->min_price); ?><em><?php echo e(__('tutor.per_session')); ?></em></strong>
                                    <span><?php echo e(__('tutor.starting_from')); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.tutor.action.action', ['tutor' => $tutor,'isFavourite' => $isFavourite,'navigate' => false]);

$__html = app('livewire')->mount($__name, $__params, $tutor->id, $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="am-aboutuser_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="am-aboutuser_tab" x-data="{tab: 'about'}">
                    <li x-bind:class="tab == 'about' ? 'active' : ''">
                        <a href="#" @click="tab='about'" class="am-tabitem"><?php echo e(__('tutor.introduction')); ?></a>
                    </li>
                    <li x-bind:class="tab == 'availability' ? 'active' : ''">
                        <a href="#availability" @click="tab='availability'" class="am-tabitem"><?php echo e(__('tutor.availability')); ?></a>
                    </li>
                    <?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && $courses->isNotEmpty()): ?>
                        <li x-bind:class="tab == 'courses' ? 'active' : ''">
                            <a @click="tab='courses'" href="#courses" class="am-tabitem"><?php echo e(__('courses::courses.courses')); ?></a>
                        </li>
                    <?php endif; ?>
                    <li x-bind:class="tab == 'highlights' ? 'active' : ''">
                        <a @click="tab='highlights'" href="#resume-highlights" class="am-tabitem"><?php echo e(__('tutor.resume_highlights')); ?></a>
                    </li>
                    <li x-bind:class="tab == 'reviews' ? 'active' : ''">
                        <a @click="tab='reviews'" href="#reviews" class="am-tabitem"><?php echo e(__('tutor.reviews')); ?> <span><?php echo e($tutor?->total_reviews); ?></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="am-userinfo_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfo_content">
                    <h3><?php echo e(__('tutor.about_me')); ?></h3>
                    <div class="am-toggle-text">
                        <div class="am-addmore">
                            <?php
                                $fullDescription  = $tutor?->profile?->description;
                                $shortDescription = Str::limit(strip_tags($fullDescription), 460, preserveWords: true);
                            ?>
                            <?php if(Str::length(strip_tags($fullDescription)) > 460): ?>
                                <p class="short-description">
                                    <?php echo $shortDescription; ?>

                                    <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_more')); ?></a>
                                </p>
                                <div class="full-description d-none">
                                    <?php echo $fullDescription; ?>

                                    <a href="javascript:void(0);" class="toggle-description"><?php echo e(__('general.show_less')); ?></a>
                                </div>
                            <?php else: ?>
                                <div class="full-description">
                                    <?php echo $fullDescription; ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-tutor-detail">
    <div class="am-booking_section" id="availability">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.tutor-sessions', ['user' => $tutor]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2357725293-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
        <div class="am-howtobook">
            <?php if(!empty(setting('_lernen.enable_booking_tips')) && (
            !empty(setting('_lernen.tips_for_booking_image')) ||
            !empty(setting('_lernen.tips_for_booking_heading')) ||
            !empty(setting('_lernen.tips_for_booking_bullets')) ||
            !empty(setting('_lernen.tips_for_booking_sub_heading')) ||
            !empty(setting('_lernen.tips_for_booking_sub_heading'))
            )): ?>
            <a href="javascript:void(0);">
                <i class="am-icon-exclamation-01"></i>
                <!-- <span><?php echo e(__('general.how_it_work')); ?></span> -->
            </a>
            <div class="am-howtobook_popup">
                <?php if(!empty(setting('_lernen.tips_for_booking_image')[0]['path'])): ?>
                <figure class="am-howtobook_img">
                    <img src="<?php echo e(url(Storage::url(setting('_lernen.tips_for_booking_image')[0]['path']))); ?>"
                        alt="img description">
                    <a href="javascript:void(0);" class="am-howtobook_close">
                        <i class="am-icon-multiply-02"></i>
                    </a>
                </figure>
                <?php endif; ?>
                <div class="am-howtobook_content">
                    <div class="am-howtobook_info">
                        <?php if(!empty(setting('_lernen.tips_for_booking_heading'))): ?>
                        <h3><?php echo e(setting('_lernen.tips_for_booking_heading')); ?></h3>
                        <?php endif; ?>
                        <?php if(!empty(setting('_lernen.tips_for_booking_bullets'))): ?>
                        <ol>
                            <?php $__currentLoopData = setting('_lernen.tips_for_booking_bullets'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span><?php echo $bullet['tips_for_booking_bullet']; ?></span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                        <?php endif; ?>
                    </div>
                    <div class="am-howtobook_info">
                        <?php if(!empty(setting('_lernen.tips_for_booking_sub_heading'))): ?>
                        <h3><?php echo e(setting('_lernen.tips_for_booking_sub_heading')); ?></h3>
                        <?php endif; ?>
                        <?php if(!empty(setting('_lernen.tips_for_booking_sub_bullets'))): ?>
                        <ol>
                            <?php $__currentLoopData = setting('_lernen.tips_for_booking_sub_bullets'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span><?php echo addBaseUrl($sub_bullet['tips_for_booking_sub_bullet']); ?></span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ol>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && $courses->isNotEmpty()): ?>
        <div wire:ignore class="am-booking_section am-featured-courses" id="courses">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1><?php echo e(__('courses::courses.featured_courses')); ?></h1>
                        <?php if($courses->isNotEmpty()): ?>
                        <div id="am-handpick-tutor" class="am-handpick-tutor <?php if( $courses->count() > 3 ): ?> splide <?php endif; ?>">
                            <div class="splide__track">
                                <ul class="splide__list">
                                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="splide__slide">
                                                <div class="cr-card">
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
                                                                <video 
                                                                    :id="'course-'+courseId"
                                                                    onloadeddata="
                                                                        let player = videojs(this); 
                                                                        player.removeClass('d-none'); 
                                                                        setTimeout(() => player.play(), 100);
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
                                                                        " class="d-none video-js vjs-default-skin d-none-playBtn" width="100%" height="100%" controls>
                                                                    <source :src="videoUrl" type="video/mp4" x-ref="video" >
                                                                </video>
                                                            </div>
                                                        </template>
                                                        <template x-if="!isOpen">
                                                            <img height="200" width="360" src="<?php echo e(!empty($course->thumbnail->path) ? url(Storage::url($course->thumbnail->path)) : asset('vendor/courses/images/course.png')); ?>" alt="<?php echo e($course->title); ?>" class="cr-background-image" />
                                                        </template>
                                                        <?php if(!empty($course?->promotionalVideo?->path) && Storage::disk(getStorageDisk())->exists($course?->promotionalVideo?->path) ): ?>
                                                            <template x-if="!isOpen">
                                                                <figcaption>
                                                                    <?php if(!empty($course->pricing?->discount)): ?>
                                                                        <span><?php echo e($course->pricing?->discount); ?>%<?php echo e(__('courses::courses.off')); ?></span>
                                                                    <?php endif; ?>
        
                                                                    <button @click="playVideo()">
                                                                        <svg width="14" height="18" viewBox="0 0 14 18" fill="none">
                                                                            <path d="M0.109375 12.9487V5.0514C0.109375 3.16703 0.109375 2.22484 0.503774 1.69381C0.847558 1.23093 1.37438 0.93894 1.94911 0.892737C2.60845 0.839731 3.40742 1.33909 5.00537 2.33781L11.3232 6.28644C12.7629 7.18627 13.4828 7.63619 13.7296 8.21222C13.9452 8.7153 13.9452 9.28476 13.7296 9.78785C13.4828 10.3639 12.7629 10.8138 11.3232 11.7136L5.00537 15.6623C3.40742 16.661 2.60845 17.1603 1.94911 17.1073C1.37438 17.0611 0.847558 16.7691 0.503774 16.3063C0.109375 15.7752 0.109375 14.833 0.109375 12.9487Z" fill="white"/>
                                                                        </svg>
                                                                    </button>
                                                                </figcaption>
                                                            </template>
                                                        <?php endif; ?>
                                                    </figure>
                                                    <div class="cr-course-card">
                                                        <div class="cr-course-header">
                                                            <div class="cr-instructor-info">
                                                                <div class="cr-instructor-details">
                                                                    <a href="<?php echo e(route('tutor-detail',['slug' => $course->instructor?->profile?->slug])); ?>" target="_blank" class="cr-instructor-name">
                                                                        <img src="<?php echo e(Storage::url($course->instructor?->profile?->image)); ?>" alt="<?php echo e($course->instructor?->profile?->short_name); ?>" class="cr-instructor-avatar" />
                                                                        <?php echo e($course->instructor?->profile?->short_name); ?>

                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <h2 class="cr-course-title">
                                                                <a href="<?php echo e(route('courses.course-detail', ['slug' => $course->slug])); ?>"><?php echo e(html_entity_decode($course->title)); ?></a>
                                                            </h2>
                                                            <div class="cr-course-category">
                                                                <a href="<?php echo e(route('courses.search-courses', ['searchCategories' => [0 => $course->category?->id]])); ?>" class="cr-category-link"><?php echo e($course->category->name); ?></a>
                                                            </div>
                                                        </div>
                                                        <div class="cr-course-features">
                                                            <div class="cr-filter-option">
                                                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['cr-stars', 'cr-1star' => !empty($course->ratings_avg_rating)]); ?>">
                                                                    <i class="am-icon-star-01"></i>
                                                                </span>
                                                                <span class="cr-rating-score"><?php echo e(number_format($course->ratings_avg_rating, 1)); ?></span>
                                                                <span class="cr-review-count">(<?php echo e($course->ratings_count == 1 ? __('courses::courses.single_reviews') : __('courses::courses.reviews_count', ['count' => $course->ratings_count])); ?>)</span>
                                                            </div>
                                                            <div class="cr-course-info">
                                                                <div class="cr-info-item">
                                                                    <i class="am-icon-bar-chart-04"></i>
                                                                    <span><?php echo e(__('courses::courses.'. $course->level)); ?></span>
                                                                </div>
                                                                <div class="cr-info-item">
                                                                    <i class="am-icon-dribbble-01"></i>
                                                                    <span><?php echo e($course->language->name); ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="cr-lesson-count">
                                                                <i class="am-icon-book-1"></i>
                                                                <span><?php echo e($course->curriculums_count); ?> <?php echo e(__('courses::courses.lessons')); ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="cr-price-container">
                                                            <div class="cr-price-info">
                                                                <?php if(!empty($course->pricing?->price) && !empty($course->pricing?->final_price) && $course->pricing?->price != 0.00 ): ?>
                                                                    
                                                                    <?php if($course->pricing?->price != $course->pricing?->final_price): ?>
                                                                        <span class="cr-original-price">
                                                                            <?php echo e(formatAmount($course->pricing?->price)); ?>

                                                                            <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                                                <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                                                <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                                            </svg>
                                                                        </span>
                                                                    <?php endif; ?>
                                                                    <div class="cr-discounted-price">
                                                                        <span class="cr-price-amount"><?php echo formatAmount($course->pricing?->final_price, true); ?></span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="cr-discounted-price">
                                                                        <span class="cr-price-amount"><?php echo e(__('courses::courses.free')); ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if(!empty($course->content_length)): ?>
                                                                <div class="cr-duration-info">
                                                                    <i class="am-icon-time"></i>
                                                                    <?php if($course->content_length > 0): ?>
                                                                        <span>
                                                                            <?php echo e(getCourseDuration($course->content_length)); ?>

                                                                        </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                        <div class="am-featured-courses-btn">
                            <a href="<?php echo e(route('courses.search-courses', ['tutor_id' => $tutor->id])); ?>" class="am-btn"><?php echo e(__('courses::courses.view_all')); ?></a>
                        </div>
                        <?php else: ?>
                            <?php echo $__env->make('livewire.components.no-record', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div id="resume-highlights">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.tutor-resume', ['lazy' => true,'user' => $tutor]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2357725293-1', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
    <div id="reviews">
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.students-reviews', ['user' => $tutor,'lazy' => true]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2357725293-2', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
    </div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('components.similar-tutors', ['user' => $tutor,'lazy' => true]);

$__html = app('livewire')->mount($__name, $__params, 'lw-2357725293-3', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/flatpicker.css',
        'public/css/videojs.css',
        'public/css/flags.css'
    ]); ?>
    <?php if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses')): ?>
        <link rel="stylesheet" href="<?php echo e(asset('modules/courses/css/main.css')); ?>">
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/video.min.js')); ?>"></script>
<script>

    function initFeaturedTutorsSlider(){
        new Splide('.am-handpick-tutor' , {
            autoWidth: true,
            perMove: 1,
            perPage: 3,
            pagination: false,
            width: 1236,
            arrows: 'slider',
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

    document.addEventListener("DOMContentLoaded", (event) => {
        <?php if(count($courses) > 3): ?>    
            initFeaturedTutorsSlider();
        <?php endif; ?>
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top    >= 0 &&
                rect.left   >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right  <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        jQuery(document).on('click', '.am-howtobook > a', function() {
            const popup = jQuery('.am-howtobook_popup');
            popup.slideToggle('slow').toggleClass('active');
        });

        jQuery(document).on('click', '.am-howtobook_close', function() {
            const popup = jQuery('.am-howtobook_popup');
            popup.slideUp('slow').removeClass('active');
        });

        $(document).on('click','.toggle-description', function() {
            var parentContainer = $(this).closest('.am-addmore');

            parentContainer.find('.short-description').toggleClass('d-none');
            parentContainer.find('.full-description').toggleClass('d-none');
            if (parentContainer.find('.short-description').hasClass('d-none')) {
                $(this).text('<?php echo e(__('general.show_more')); ?>');
            } else {
                $(this).text('<?php echo e(__('general.show_less')); ?>');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.frontend-app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Sahos\Laravel\lla\resources\views/frontend/tutor-detail.blade.php ENDPATH**/ ?>