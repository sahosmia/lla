<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['currentSlot', 'cartItems' => [], 'id'=> 'slot-detail', 'user' => null, 'timezone' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['currentSlot', 'cartItems' => [], 'id'=> 'slot-detail', 'user' => null, 'timezone' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="modal fade am-session-detail-modal_two" id="<?php echo e($id); ?>" aria-hidden="true">
    <?php
        $cartItemIds = array_column(array_column($cartItems?->toArray() ?? [], 'options'), 'slot_id');
    ?>
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="am-session-detail">
            <div class="am-session-detail_sidebar">
                <div class="am-session-detail_content">
                    <span>
                        <i class="am-icon-book-1"></i>
                        <span><?php echo e($currentSlot?->subjectGroupSubjects?->userSubjectGroup?->group?->name); ?></span>
                    </span>
                    <i class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </i>
                    <h4><?php echo e($currentSlot?->subjectGroupSubjects?->subject?->name); ?></h4>
                </div>
                <ul class="am-session-duration">
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-blue">
                                <i class="am-icon-calender-minus"></i>
                            </em>
                            <span><?php echo e(__('general.date')); ?></span>
                        </div>
                        <strong><?php echo e(parseToUserTz($currentSlot?->start_time)->format(setting('_general.date_format') ?? 'F j, Y')); ?></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-purple">
                                <i class="am-icon-time"></i>
                            </em>
                            <span><?php echo e(__('calendar.time')); ?></span>
                        </div>
                        <strong>
                            <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?>
                                <?php echo e(parseToUserTz($currentSlot?->start_time, $timezone)->format('h:i a')); ?> -
                                <?php echo e(parseToUserTz($currentSlot?->end_time, $timezone)->format('h:i a')); ?>

                            <?php else: ?>
                                <?php echo e(parseToUserTz($currentSlot?->start_time, $timezone)->format('H:i')); ?> -
                                <?php echo e(parseToUserTz($currentSlot?->end_time, $timezone)->format('H:i')); ?>

                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-red">
                                <i class="am-icon-layer-01"></i>
                            </em>
                            <span><?php echo e(__('calendar.type')); ?></span>
                        </div>
                        <strong>
                            <?php echo e($currentSlot?->spaces > 1 ? __('calendar.group') : __('calendar.one')); ?>

                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-orange">
                                <i class="am-icon-user-group"></i>
                            </em>
                            <span><?php echo e(__('calendar.total_enrollment')); ?></span>
                        </div>
                        <strong><?php echo e(__('calendar.booked_students', ['count' => $currentSlot?->bookings_count ?? 0])); ?></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-green">
                                <?php echo e(getCurrencySymbol()); ?>

                            </em>
                            <span><?php echo e(__('calendar.session_fee')); ?></span>
                        </div>
                        <strong> <?php echo e(formatAmount($currentSlot?->session_fee)); ?><em><?php echo e(__('calendar.person')); ?></em></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <figure>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($user?->profile->image) && Storage::disk(getStorageDisk())->exists($user?->profile?->image)): ?>
                                    <img src="<?php echo e(resizedImage($user?->profile?->image, 24, 24)); ?>" alt="<?php echo e($user?->profile?->full_name); ?>">
                                <?php else: ?> 
                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 24, 24)); ?>" alt="<?php echo e($user?->profile?->full_name); ?>">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </figure>
                            <span><em><?php echo e(__('calendar.session_tutor')); ?></em></span>
                        </div>
                        <strong>
                            <?php echo e($user->profile?->full_name); ?>

                        </strong>
                    </li>
                </ul>
                <!--[if BLOCK]><![endif]--><?php if(auth()->check() && auth()->user()->role == 'student'): ?>
                <div class="am-session-detail_sidebar_footer">
                    <!--[if BLOCK]><![endif]--><?php if( !in_array($currentSlot?->id, $cartItemIds)): ?>
                        <div class="am-sessionstart-btn">
                            <!--[if BLOCK]><![endif]--><?php if(!isPaidSystem()): ?>
                            <button class="am-btn" wire:click="getFreeSession(<?php echo e($currentSlot?->id); ?>)">
                                <?php echo e(__('tutor.get_session_txt')); ?>

                            </button>
                            <?php else: ?>
                            <button class="am-btn" wire:click.prevent="bookSession(<?php echo e($currentSlot?->id); ?>)">
                                <?php echo e(__('calendar.book_session')); ?>

                            </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="am-session-detail-modal_body">
                <!--[if BLOCK]><![endif]--><?php if(!empty($currentSlot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($currentSlot?->subjectGroupSubjects?->image)): ?>
                <figure>
                    <img src="<?php echo e(resizedImage($currentSlot?->subjectGroupSubjects?->image, 700, 360)); ?>" alt="<?php echo e($currentSlot?->subjectGroupSubjects?->subject?->name); ?>">
                </figure>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div class="am-session-content">
                    <?php echo $currentSlot?->description; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\Sahos\Laravel\lla\resources\views/components/slot-detail-modal.blade.php ENDPATH**/ ?>