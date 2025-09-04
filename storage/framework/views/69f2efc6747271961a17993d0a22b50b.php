<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['currentBooking', 'id'=> 'session-detail']));

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

foreach (array_filter((['currentBooking', 'id'=> 'session-detail']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="modal fade am-session-detail-modal_two" id="<?php echo e($id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="am-session-detail">
            <div class="am-session-detail_sidebar">
                <div class="am-session-detail_content">
                    <span>
                        <i class="am-icon-book-1"></i>
                        <span><?php echo e($currentBooking?->slot?->subjectGroupSubjects?->group?->name); ?></span>
                    </span>
                    <div class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </div>
                    <h4><?php echo e($currentBooking?->slot?->subjectGroupSubjects?->subject?->name); ?></h4>
                </div>
                <ul class="am-session-duration">
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-blue">
                                <i class="am-icon-calender-minus"></i>
                            </em>
                            <span><?php echo e(__('general.date')); ?></span>
                        </div>
                        <strong class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-rescheduled' =>  auth()->user()->role == 'student' && $currentBooking?->status == 'rescheduled']); ?>"><?php echo e(parseToUserTz($currentBooking?->start_time)->format(setting('_general.date_format') ?? 'F j, Y')); ?></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-purple">
                                <i class="am-icon-time"></i>
                            </em>
                            <span><?php echo e(__('calendar.time')); ?></span>
                        </div>
                        <strong class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-rescheduled' => auth()->user()->role == 'student' && $currentBooking?->status == 'rescheduled']); ?>">
                            <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?>
                                <?php echo e(parseToUserTz($currentBooking?->start_time)->format('h:i a')); ?> -
                                <?php echo e(parseToUserTz($currentBooking?->end_time)->format('h:i a')); ?>

                            <?php else: ?>
                                <?php echo e(parseToUserTz($currentBooking?->start_time)->format('H:i')); ?> -
                                <?php echo e(parseToUserTz($currentBooking?->end_time)->format('H:i')); ?>

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
                            <?php echo e($currentBooking?->slot?->spaces > 1 ? __('calendar.group') : __('calendar.one')); ?>

                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-orange">
                                <i class="am-icon-user-group"></i>
                            </em>
                            <span><?php echo e(__('calendar.total_enrollment')); ?></span>
                        </div>
                        <strong><?php echo e(__('calendar.booked_students', ['count' => $currentBooking?->slot?->bookings_count])); ?></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-green">
                                <?php echo e(getCurrencySymbol()); ?>

                            </em>
                            <span><?php echo e(__('calendar.session_fee')); ?></span>
                        </div>
                        <strong> <?php echo e(formatAmount($currentBooking?->slot?->session_fee)); ?><em><?php echo e(__('calendar.person')); ?></em></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <figure>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($currentBooking?->tutor?->image) && Storage::disk(getStorageDisk())->exists($currentBooking?->tutor?->image)): ?>
                                    <img src="<?php echo e(resizedImage($currentBooking?->tutor?->image, 24, 24)); ?>" alt="<?php echo e($currentBooking?->tutor?->full_name); ?>">
                                <?php else: ?>
                                    <img src="<?php echo e(setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 24, 24)); ?>" alt="<?php echo e($currentBooking?->tutor?->full_name); ?>">
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </figure>
                            <span><em><?php echo e(__('calendar.session_tutor')); ?></em></span>
                        </div>
                        <strong>
                            <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?> <em><?php echo e(__('calendar.you')); ?></em> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php echo e($currentBooking?->tutor?->full_name); ?>

                        </strong>
                    </li>
                </ul>
                <!--[if BLOCK]><![endif]--><?php if($currentBooking?->status == 'active'): ?>
                   <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
                        <!--[if BLOCK]><![endif]--><?php if(!empty($currentBooking?->slot?->meta_data['meeting_link'])): ?>
                            <div class="am-session-btns" x-data="{ linkToCopy: '<?php echo e(route('session-detail', ['id' => encrypt($currentBooking?->slot?->id)])); ?>', linkCopied: false }">
                                <a href="<?php echo e($currentBooking?->slot?->meta_data['meeting_link'] ?? '#'); ?>" target="_blank" class="am-btn"><?php echo e(__('calendar.start_session_now')); ?></a>
                                <button class="am-white-btn" @click="
                                    navigator.clipboard.writeText(linkToCopy)
                                    .then(() => {
                                        linkCopied = true;
                                        setTimeout(() => linkCopied = false, 2000);
                                    })
                                ">
                                    <template x-if="!linkCopied">
                                        <div class="am-copy-link">
                                            <?php echo e(__('calendar.copy_session_link')); ?>

                                            <i class="am-icon-copy-01"></i>
                                        </div>
                                    </template>
                                    <template x-if="linkCopied">
                                        <span x-show="linkCopied" x-transition><?php echo e(__('calendar.link_copied')); ?></span>
                                    </template>
                                </button>
                            </div>
                            <div class="am-optioanl-or">
                                <span><?php echo e(__('general.or')); ?></span>
                            </div>
                            <div class="am-zoom-session" x-data="{ textToCopy: '<?php echo e($currentBooking?->slot?->meta_data['meeting_link'] ?? '#'); ?>', copied: false }">
                                <div class="am-zoom-session_title">
                                    <span>
                                        <img src="<?php echo e(asset('images/' . ($currentBooking?->slot?->meta_data['meeting_type'] ?? 'zoom' ) . '-icon.png')); ?>" alt="<?php echo e($currentBooking?->slot?->meta_data['meeting_type'] ?? 'Zoom'); ?>">
                                        <?php echo e(__('calendar.meeting_link')); ?>

                                    </span>
                                    <a href="#"><?php echo e($currentBooking?->slot?->meta_data['meeting_link'] ?? '#'); ?></a>
                                </div>
                                <button class="am-white-btn" @click="
                                    navigator.clipboard.writeText(textToCopy)
                                    .then(() => {
                                        copied = true;
                                        setTimeout(() => copied = false, 2000);
                                    })
                                ">
                                    <template x-if="!copied">
                                        <div class="am-copy-link">
                                            <?php echo e(__('calendar.copy_meeting_link')); ?>

                                            <i class="am-icon-copy-01"></i>
                                        </div>
                                    </template>
                                    <template x-if="copied">
                                        <span x-show="copied" x-transition><?php echo e(__('calendar.link_copied')); ?></span>
                                    </template>
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="am-session-detail_sidebar_footer" x-data="{ linkToCopy: '<?php echo e(route('session-detail', ['id' => encrypt($currentBooking?->slot?->id)])); ?>', linkCopied: false }">
                                <button class="am-white-btn" @click="
                                    navigator.clipboard.writeText(linkToCopy)
                                    .then(() => {
                                        linkCopied = true;
                                        setTimeout(() => linkCopied = false, 2000);
                                    })
                                ">
                                    <template x-if="!linkCopied">
                                        <div class="am-copy-link">
                                            <?php echo e(__('calendar.copy_session_link')); ?>

                                            <i class="am-icon-copy-01"></i>
                                        </div>
                                    </template>
                                    <template x-if="linkCopied">
                                        <span x-show="linkCopied" x-transition><?php echo e(__('calendar.link_copied')); ?></span>
                                    </template>
                                </button>
                                <p><?php echo e(__('calendar.generate_meeting_link_msg')); ?></p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(isCalendarConnected() && empty($currentBooking?->slot?->meta_data['event_id'])): ?>
                            <button class="am-btn am-sync_btn" wire:click="syncWithGoogleCalendar()" wire:loading.class="am-btn_disable">
                                <img src="<?php echo e(asset('images/calendar.png')); ?>">
                                <?php echo e(__('calendar.sync_google_calendar')); ?>

                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php elseif(auth()->user()->role == 'student'): ?>
                        <div class="am-session-detail_sidebar_footer">
                            <div class="am-session-start">
                                <!--[if BLOCK]><![endif]--><?php if(parseToUserTz($currentBooking->slot->start_time)->isFuture()): ?>
                                <div class="am-session-time">
                                    <em><i class="am-icon-megaphone-02"></i> </em>
                                    <span>
                                        <?php echo e(__('calendar.session_start_at')); ?>

                                    </span>
                                    <i>
                                        <?php echo e(timeLeft($currentBooking?->start_time)); ?>

                                    </i>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><?php if(!empty($currentBooking?->slot?->meta_data['meeting_link'])): ?>
                                <div class="am-sessionstart-btn">
                                    <a href="<?php echo e($currentBooking?->slot?->meta_data['meeting_link'] ?? '#'); ?>" class="am-btn" target="_blank">
                                        <?php echo e(__('calendar.join_session')); ?>

                                    </a>
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(empty($currentBooking?->slot?->meta_data['meeting_link'])): ?>
                            <p><?php echo e(__('calendar.missing_meeting_link')); ?></p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php if(isCalendarConnected() && empty($currentBooking?->meta_data['event_id'])): ?>
                            <button class="am-btn am-sync_btn" wire:click="syncWithGoogleCalendar()" wire:loading.class="am-btn_disable">
                                <img src="<?php echo e(asset('images/calendar.png')); ?>">
                                <?php echo e(__('calendar.sync_google_calendar')); ?>

                            </button>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php elseif(auth()->user()->role == 'student' && $currentBooking?->status == 'rescheduled'): ?>
                    <p><?php echo __('calendar.rescheduled_date_desc', ['date' => parseToUserTz($currentBooking?->slot?->start_time)->format(setting('_general.date_format') ?? 'F j, Y')]); ?></p>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="am-session-detail-modal_body">
                <figure>
                    <!--[if BLOCK]><![endif]--><?php if(!empty($currentBooking?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($currentBooking?->slot?->subjectGroupSubjects?->image)): ?>
                        <img src="<?php echo e(resizedImage($currentBooking?->slot?->subjectGroupSubjects?->image, 700, 360)); ?>" alt="<?php echo e($currentBooking?->slot?->subjectGroupSubjects?->subject?->name); ?>">
                    <?php else: ?>
                        <img src="<?php echo e(resizedImage('placeholder-land.png', 700, 360)); ?>" alt="<?php echo e($currentBooking?->slot?->subjectGroupSubjects?->subject?->name); ?>">
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </figure>
                <div class="am-session-content">
                    <?php echo $currentBooking?->slot?->description; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/components/booking-detail-modal.blade.php ENDPATH**/ ?>