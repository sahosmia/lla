
<div class="col-12 col-lg-8 col-xl-9" id="am-tutor_list" wire:init="loadPage" x-data="{
        message: <?php if ((object) ('message') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('message'->value()); ?>')<?php echo e('message'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('message'); ?>')<?php endif; ?>,
        recepientId: <?php if ((object) ('recepientId') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('recepientId'->value()); ?>')<?php echo e('recepientId'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('recepientId'); ?>')<?php endif; ?>,
        charLeft:500,
        init(){
            this.updateCharLeft();
        },
        tutorInfo:{},
        updateCharLeft() {
            let maxLength = 500;
            let messageLength = this.message ? this.message.length : 0;
            if (messageLength ?? 0 > maxLength) {
                this.message = this.message.substring(0, maxLength);
            }
            this.charLeft = maxLength - messageLength ?? 0;
        }
    }">
    <!--[if BLOCK]><![endif]--><?php if(empty($isLoadPage)): ?>
        <div>
            <?php echo $__env->make('skeletons.tutor-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php else: ?>
        <div class="d-none tutors-skeleton" wire:target="filters" wire:loading.class.remove="d-none">
            <?php echo $__env->make('skeletons.tutor-list', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div wire:loading.class="d-none" wire:target="filters" class="am-tutorlist">
            <!--[if BLOCK]><![endif]--><?php if($tutors->isNotEmpty()): ?>
                <div class="am-tutorsearch">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tutors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tutor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $tutorInfo['name'] = $tutor->profile->full_name;
                            $tutorInfo['id'] = $tutor?->id;
                            if (!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image)) {
                                $tutorInfo['image'] = resizedImage($tutor->profile->image, 36, 36);
                            } else {
                                $tutorInfo['image'] = setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 36, 36);
                            }
                        ?>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($tutor?->profile?->intro_video)): ?>
                            <div class="am-tutorsearch_card" id="profile-<?php echo e($tutor->id); ?>">
                                <div class="am-tutorsearch_video">
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($tutor->profile->intro_video)): ?>
                                        <video class="video-js" data-setup='{}' preload="auto" wire:key="profile-video-<?php echo e($tutor->id); ?>" id="profile-video-<?php echo e($tutor->id); ?>" width="320" height="240" controls >
                                            <source src="<?php echo e(url(Storage::url($tutor->profile->intro_video)).'?key=profile-video'. $tutor->id); ?>#t=0.1" wire:key="profile-video-src-<?php echo e($tutor->id); ?>" type="video/mp4" >
                                        </video>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="am-tutorsearch_btns">
                                        <a href="<?php echo e(route('tutor-detail',['slug' => $tutor->profile->slug]).'#availability'); ?>" class="am-white-btn"><?php echo e(__('tutor.book_session')); ?><i class="am-icon-calender-duration"></i></a>
                                        <!--[if BLOCK]><![endif]--><?php if(Auth::check() && $allowFavAction): ?>
                                            <a href="javascript:;" @click=" tutorInfo = <?php echo \Illuminate\Support\Js::from($tutorInfo)->toHtml() ?>;threadId=''; recepientId=<?php echo \Illuminate\Support\Js::from($tutor->id)->toHtml() ?>; $nextTick(() => $wire.dispatch('toggleModel', {id: 'message-model-'+<?php echo \Illuminate\Support\Js::from($tutor->id)->toHtml() ?>,action:'show'}) )" class="am-btn"><?php echo e(__('tutor.send_message')); ?><i class="am-icon-chat-03"></i></a>
                                            <a href="javascript:void(0);" id="toggleFavourite-<?php echo e($tutor->id); ?>" wire:click.prevent="toggleFavourite(<?php echo e($tutor->id); ?>)" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-likebtn', 'active' => in_array($tutor->id, $favouriteTutors)]); ?>"> <i class="am-icon-heart-01"></i></a>
                                        <?php else: ?>
                                            <a href="javascript:void(0);"
                                            @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `<?php echo e(Auth::check() ?  __('general.not_allowed') : __('general.login_error')); ?>` })" class="am-btn"><?php echo e(__('tutor.send_message')); ?><i class="am-icon-chat-03"></i></a>
                                            <a href="javascript:void(0);"
                                            @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `<?php echo e(Auth::check() ?  __('general.not_allowed') : __('general.login_error')); ?>` })" class="am-likebtn"><i class="am-icon-heart-01"></i></a>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                                <div class="am-tutorsearch_content">
                                    <div class="am-tutorsearch_head">
                                        <div class="am-tutorsearch_user">
                                            <figure class="am-tutorvone_img">
                                                <!--[if BLOCK]><![endif]--><?php if(!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image)): ?>
                                                    <img src="<?php echo e(resizedImage($tutor->profile->image, 100, 100)); ?>" class="am-user_image" alt="<?php echo e($tutor->profile->full_name); ?>" />
                                                <?php else: ?> 
                                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 100, 100)); ?>" alt="<?php echo e($tutor->profile->full_name); ?>" />
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-userstaus', 'am-userstaus_online' => $tutor->is_online]); ?>"></span>
                                            </figure>
                                            <div class="am-tutorsearch_user_name">
                                                <h3>
                                                    <a href="<?php echo e(route('tutor-detail',['slug' => $tutor->profile->slug])); ?>"><?php echo e($tutor->profile->full_name); ?></a>
                                                    <!--[if BLOCK]><![endif]--><?php if($tutor?->profile?->verified_at): ?>
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
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($tutor?->address?->country?->short_code)): ?>
                                                        <span class="flag flag-<?php echo e(strtolower($tutor?->address?->country?->short_code)); ?>"></span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </h3>
                                                <!--[if BLOCK]><![endif]--><?php if($tutor->profile->tagline): ?>
                                                    <span>
                                                        <?php echo $tutor->profile->tagline; ?>

                                                    </span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                            <div class="am-tutorsearch_fee">
                                                <span><?php echo e(__('tutor.session_fee')); ?></span>
                                                <strong><?php echo e(formatAmount($tutor->min_price)); ?><em>/<?php echo e(__('tutor.session')); ?></em></strong>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <ul class="am-tutorsearch_info">
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                                            <span><?php echo e(number_format($tutor->avg_rating, 1)); ?><em>/5.0 (<?php echo e($tutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $tutor->total_reviews] )); ?>)</em></span>
                                        </li>
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                            <span><?php echo e($tutor->active_students); ?> <em><?php echo e($tutor->active_students == '1' ? __('tutor.booked_session') : __('tutor.booked_sessions')); ?></em></span>
                                        </li>
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-menu-2"></i></div>
                                            <span><?php echo e($tutor->subjects->sum('sessions')); ?> <em><?php echo e($tutor->subjects->sum('sessions') == 1 ? __('tutor.session') : __('tutor.sessions')); ?></em></span>
                                        </li>
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-language-1"></i></div>
                                            <span> <?php echo e(__('tutor.language_know')); ?></span>
                                            <div class="wa-tags-list">
                                                <ul>
                                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tutor?->languages->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><span><?php echo e(ucfirst( $lan->name )); ?></span></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                </ul>
                                                <!--[if BLOCK]><![endif]--><?php if($tutor?->languages?->count() > 3): ?>
                                                <div class="am-more am-custom-tooltip">
                                                    <span class="am-tooltip-text">
                                                        <?php
                                                        $tutorLanguages = $tutor?->languages->slice(3,
                                                        $tutor?->languages?->count() - 1);
                                                        ?>
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($tutorLanguages)): ?>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tutorLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span><?php echo e(ucfirst( $lan->name )); ?></span>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </span>
                                                    +<?php echo e($tutor?->languages?->count() - 3); ?>

                                                </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </li>
                                    </ul>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($tutor->profile->description)): ?>
                                        <div class="am-toggle-text">
                                            <div class="am-addmore">
                                                <?php
                                                    $fullDescription  = strip_tags($tutor->profile->description);
                                                    $shortDescription = Str::limit($fullDescription, 220, preserveWords: true);
                                                ?>
                                                <!--[if BLOCK]><![endif]--><?php if(Str::length($fullDescription) > 220): ?>
                                                    <div class="short-description">
                                                        <?php echo $shortDescription; ?>

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
                        <?php else: ?>
                                <div class="am-tutorsearch_card am-tutorsearch_novideo" id="profile-<?php echo e($tutor->id); ?>">
                                    <div class="am-tutorsearch_content">
                                        <div class="am-tutorsearch_head">
                                            <div class="am-tutorsearch_user">
                                                <figure class="am-tutorvone_img">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image)): ?>
                                                        <img src="<?php echo e(resizedImage($tutor->profile->image, 50, 50)); ?>" class="am-user_image" alt="<?php echo e($tutor->profile->full_name); ?>" />
                                                    <?php else: ?> 
                                                        <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 50, 50)); ?>" alt="<?php echo e($tutor->profile->full_name); ?>" />
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-userstaus', 'am-userstaus_online' => $tutor->is_online]); ?>"></span>
                                                </figure>
                                                <div class="am-tutorsearch_user_name">
                                                    <h3>
                                                        <a href="<?php echo e(route('tutor-detail',['slug' => $tutor->profile->slug])); ?>"><?php echo e($tutor->profile->full_name); ?></a>
                                                        <!--[if BLOCK]><![endif]--><?php if($tutor?->profile?->verified_at): ?>
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
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($tutor?->address?->country?->short_code)): ?>
                                                            <span class="flag flag-<?php echo e(strtolower($tutor?->address?->country?->short_code)); ?>"></span>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </h3>
                                                    <!--[if BLOCK]><![endif]--><?php if($tutor->profile->tagline): ?>
                                                        <span>
                                                            <?php echo e($tutor->profile->tagline); ?>

                                                        </span>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                            <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                                <div class="am-tutorsearch_fee">
                                                    <span><?php echo e(__('tutor.session_fee')); ?></span>
                                                    <strong><?php echo e(formatAmount($tutor->min_price)); ?><em>/<?php echo e(__('tutor.session')); ?></em></strong>
                                                </div>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <ul class="am-tutorsearch_info">
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                                                <span><?php echo e(number_format($tutor->avg_rating, 1)); ?><em>/5.0 (<?php echo e($tutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $tutor->total_reviews] )); ?>)</em></span>
                                            </li>
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                                <span><?php echo e($tutor->active_students); ?> <em><?php echo e($tutor->active_students == '1' ? __('tutor.active_student') : __('tutor.active_students')); ?></em></span>
                                            </li>
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-menu-2"></i></div>
                                                <span><?php echo e($tutor->subjects->sum('sessions')); ?> <em><?php echo e($tutor->subjects->sum('sessions') == 1 ? __('tutor.session') : __('tutor.sessions')); ?></em></span>
                                            </li>
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-language-1"></i></div>
                                                <span> <?php echo e(__('tutor.language_know')); ?></span>
                                                <div class="wa-tags-list">
                                                    <ul>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tutor?->languages->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><span><?php echo e(ucfirst( $lan->name )); ?></span></li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </ul>
                                                    <!--[if BLOCK]><![endif]--><?php if($tutor?->languages?->count() > 3): ?>
                                                    <div class="am-more am-custom-tooltip">
                                                        <span class="am-tooltip-text">
                                                            <?php
                                                            $tutorLanguages = $tutor?->languages->slice(3,
                                                            $tutor?->languages?->count() - 1);
                                                            ?>
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($tutorLanguages)): ?>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $tutorLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <span><?php echo e(ucfirst( $lan->name )); ?></span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </span>
                                                        +<?php echo e($tutor?->languages?->count() - 3); ?>

                                                    </div>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </li>
                                        </ul>
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($tutor->profile->description)): ?>
                                            <div class="am-toggle-text">
                                                <div class="am-addmore">
                                                    <?php
                                                        $fullDescription  = strip_tags($tutor->profile->description);
                                                        $shortDescription = Str::limit($fullDescription, 220, preserveWords: true);
                                                    ?>
                                                    <!--[if BLOCK]><![endif]--><?php if(Str::length($fullDescription) > 220): ?>
                                                        <div class="short-description">
                                                            <?php echo $shortDescription; ?>

                                                        </div>
                                                    <?php else: ?>
                                                        <div class="full-description">
                                                            <?php echo $fullDescription; ?>

                                                        </div>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <div class="am-tutorsearch_btns">
                                                    <a href="<?php echo e(route('tutor-detail',['slug' => $tutor->profile->slug]).'#availability'); ?>" class="am-white-btn"><?php echo e(__('tutor.book_session')); ?><i class="am-icon-calender-duration"></i></a>
                                                    <!--[if BLOCK]><![endif]--><?php if(Auth::check() && $allowFavAction): ?>
                                                        <a href="javascript:;" @click=" tutorInfo = <?php echo \Illuminate\Support\Js::from($tutorInfo)->toHtml() ?>;threadId=''; recepientId=<?php echo \Illuminate\Support\Js::from($tutor->id)->toHtml() ?>; $nextTick(() => $wire.dispatch('toggleModel', {id: 'message-model-'+<?php echo \Illuminate\Support\Js::from($tutor->id)->toHtml() ?>,action:'show'}) )" class="am-btn"><?php echo e(__('tutor.send_message')); ?><i class="am-icon-chat-03"></i></a>
                                                        <a href="javascript:void(0);" id="toggleFavourite-<?php echo e($tutor->id); ?>" wire:click.prevent="toggleFavourite(<?php echo e($tutor->id); ?>)" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-likebtn', 'active' => in_array($tutor->id, $favouriteTutors)]); ?>"> <i class="am-icon-heart-01"></i></a>
                                                    <?php else: ?>
                                                        <a href="javascript:void(0);"
                                                        @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `<?php echo e(Auth::check() ?  __('general.not_allowed') : __('general.login_error')); ?>` })" class="am-btn"><?php echo e(__('tutor.send_message')); ?><i class="am-icon-chat-03"></i></a>
                                                        <a href="javascript:void(0);"
                                                        @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `<?php echo e(Auth::check() ?  __('general.not_allowed') : __('general.login_error')); ?>` })" class="am-likebtn"><i class="am-icon-heart-01"></i></a>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>

                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    <div class="am-pagination am-pagination_two">
                        <?php echo e($tutors->links('pagination.pagination', data:['scrollTo'=>false])); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="am-norecord-found">
                    <figure>
                        <img src="<?php echo e(asset('images/subjects.png')); ?>" alt="no record">
                    </figure>   
                    <strong><?php echo e(__('general.not_found')); ?>

                        <span><?php echo e(__('general.not_found_desc')); ?></span>
                    </strong>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <?php echo $__env->make('livewire.pages.tutor.action.message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('toggleFavIcon', (event) => {
                $(`#toggleFavourite-${event.detail.userId}`).toggleClass('active');
            })
            document.addEventListener('initVideoJs', (event) => {
                setTimeout(() => {
                    jQuery('.video-js').each((index, item) => {
                        item.onloadeddata =  function(){
                            videojs(item);
                        }
                    })
                }, event.detail.timeout ?? 500);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/livewire/components/search-tutor.blade.php ENDPATH**/ ?>