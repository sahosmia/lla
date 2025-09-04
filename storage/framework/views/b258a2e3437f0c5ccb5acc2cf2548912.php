<div class="am-similar-tutor">
    <div class="container">
        <div class="row">
            <!--[if BLOCK]><![endif]--><?php if($similarTutors->isNotEmpty()): ?>
                <div class="col-12">
                    <div class="am-userinfomore_title">
                        <h3><?php echo e(__('tutor.similar_tutors')); ?></h3>
                    </div>
                    <ul class="am-similaruser-list">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $similarTutors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="am-similar-user">
                                <div class="am-tutordetail_user">
                                    <figure class="am-tutorvone_img">
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($item->profile?->image) && Storage::disk(getStorageDisk())->exists($item->profile?->image)): ?>
                                        <img src="<?php echo e(resizedImage($item->profile?->image,40,40)); ?>" alt="<?php echo e($item->profile?->image); ?>" />
                                        <?php else: ?> 
                                            <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40)); ?>" alt="<?php echo e($item->profile?->image); ?>" />
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </figure>
                                    <div class="am-tutordetail_user_name">
                                        <h3>
                                            <a href="<?php echo e(route('tutor-detail',['slug' => $item->profile->slug])); ?>"><?php echo e($item->profile->full_name); ?></a>
                                            <!--[if BLOCK]><![endif]--><?php if($item?->profile?->verified_at): ?>
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
                                            <!--[if BLOCK]><![endif]--><?php if($item?->address?->country?->short_code): ?>
                                                <span class="flag flag-<?php echo e(strtolower($item?->address?->country?->short_code)); ?>"></span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </h3>
                                        <span><?php echo e($item?->profile->tagline); ?></span>
                                    </div>
                                </div>
                                <ul class="am-tutorreviews-list">
                                    <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <span class="am-uniqespace am-currency_conversion"><?php echo formatAmount($item->min_price); ?><em><?php echo e(__('tutor.session_text')); ?></em></span>
                                            </div>
                                        </li>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon"><i class="am-icon-star-01"></i></div>
                                            <span class="am-uniqespace"><?php echo e(number_format($item->avg_rating, 1)); ?> <em>/5.0 (<?php echo e($item->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $item->total_reviews] )); ?>)</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon"><i class="am-icon-user-group"></i></div>
                                            <span><?php echo e($item->active_students); ?> <em><?php echo e($item->active_students == '1' ? __('tutor.active_student') : __('tutor.active_students', ['count' => $item->active_students ])); ?></em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon"><i class="am-icon-menu-2"></i></div>
                                            <?php
                                                $totalSessions = $item->subjects->flatMap(function ($subject) {
                                                    return $subject->slots;
                                                })->count();
                                            ?>
                                            <span> <?php echo e($totalSessions); ?> <em><?php echo e($totalSessions == 1 ? __('tutor.session') : __('tutor.sessions',)); ?></em></span>
                                        </div>
                                    </li>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($item?->languages)): ?>
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <div class="am-tutorreview-item_icon"><i class="am-icon-language-1"></i></div>
                                                <div class="wa-tags-list">
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($item?->languages)): ?>
                                                        <ul>
                                                            <!--[if BLOCK]><![endif]--><?php if(!empty($item->profile->native_language)): ?>
                                                                <li><span><?php echo e(ucfirst($item->profile->native_language)); ?></span></li>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $item?->languages->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li><span><?php echo e(ucfirst( $lan->name )); ?></span></li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </ul>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                                <!--[if BLOCK]><![endif]--><?php if($item?->languages?->count() > 3): ?>
                                                    <div class="am-more am-custom-tooltip">
                                                        <span class="am-tooltip-text">
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $item?->languages->slice(3, $item?->languages?->count() - 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <span><?php echo e(ucfirst( $lan->name )); ?></span>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        </span>
                                                        +<?php echo e($item?->languages?->count() - 3); ?>

                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </li>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </ul>
                                <div class="am-similaruser-btns">
                                    <div class="am-sendmessage-btn">
                                        <?php
                                        $isFavourite = in_array($item->id, $favouriteTutors);
                                    ?>
                                        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('pages.tutor.action.action', ['tutor' => $item,'isFavourite' => $isFavourite]);

$__html = app('livewire')->mount($__name, $__params, 'tutor-action-'.$item->id, $__slots ?? [], get_defined_vars());

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
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </ul>
                    <div class="am-similaruser-btn">
                        <a href="<?php echo e(url('find-tutors')); ?>">
                            <button class="am-white-btn"><?php echo e(__('tutor.view_all_tutors')); ?></button>
                        </a>
                    </div>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/components/similar-tutors.blade.php ENDPATH**/ ?>