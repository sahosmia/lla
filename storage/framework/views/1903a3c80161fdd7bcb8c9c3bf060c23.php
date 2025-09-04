<div class="am-userinfo_section"  wire:init="loadPage" x-data="{
    defaultTimeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    timezone: $wire.entangle('timezone'),
    }"
    x-init="if(!timezone) {
        $wire.set('timezone', defaultTimeZone, false);
    }">
    <!--[if BLOCK]><![endif]--><?php if(empty($pageLoaded)): ?>
        <div class="am-booking-skeleton">
            <?php echo $__env->make('skeletons.book-sessions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    <?php else: ?>
        <div class="d-none" wire:target="jumpToDate, nextBookings, previousBookings, timezone, filter" wire:loading.class.remove="d-none">
            <?php echo $__env->make('skeletons.book-sessions', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <div class="am-userinfo_content" wire:loading.class="d-none" wire:target="jumpToDate, nextBookings, previousBookings, timezone, filter">
            <?php
                $show_all = false;
                $showAll = array();
            ?>
            <div class="am-booksession-title">
                <h3><?php echo e(__('tutor.book_session')); ?></h3>   
                <button class="am-btn" wire:click='openModel' wire:loading.class="am-btn_disable" wire:target="openModel"><?php echo e(__('tutor.request_a_session')); ?></button>
            </div>
            <div class="am-booking-calander">
                <div class="am-booking-calander_header">
                    <div class="am-booking-dates-slot">
                        <div class="am-booking-calander-day">
                            <a href="javascript:void(0);" <?php if($isCurrent): ?> disabled <?php else: ?> wire:click="jumpToDate()" <?php endif; ?> >
                                <?php echo e(__('calendar.today')); ?>

                            </a>
                        </div>
                        <div wire:ignore class="am-booking-calander-date">
                            <input type="text" id="flat-picker"/>
                        </div>
                    </div>
                    <div class="am-booking-filter-slot">
                        <div class="flatpicker" x-init="$wire.dispatch('initSelect2', {target:'.am-customselect'})" wire:ignore>
                            <span class="am-select">
                                <select
                                    data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')"
                                    class="am-customselect"
                                    value="<?php echo e($timezone); ?>"
                                    data-searchable="true"
                                    id="timezone"
                                    data-live="true"
                                    data-wiremodel="timezone"
                                    data-placeholder="<?php echo e(__('settings.timezone_placeholder')); ?>"
                                >
                                    <option value=""></option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tz); ?>" x-bind:selected="timezone == '<?php echo e($tz); ?>'" ><?php echo e($tz); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <div class="am-tooltipicon am-custom-tooltip">
                                    <span class="am-tooltip-text">
                                        <span><?php echo e(__('tutor.tooltip_text')); ?></span>
                                    </span>
                                    <i class="am-icon-exclamation-01"></i>
                                </div>
                            </span>
                        </div>
                        <div class="am-booking-filter-wrapper">
                            <a class="am-booking-filter" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside">
                                <i class="am-icon-sliders-horiz-01"></i>
                            </a>
                            <form class="am-itemdropdown_list am-filter-list dropdown-menu" aria-labelledby="dropdownMenuLink"  x-on:submit.prevent
                                x-data="{
                                    selectedValues: [],
                                    init() {
                                        const selectElement = document.getElementById('filter_subject_group');
                                        const updateSelectedValues = () => {
                                            this.selectedValues = Array.from(selectElement.selectedOptions)
                                                .filter(option => option.value)
                                                .map(option => ({
                                                    value: option.value,
                                                    text: option.text,
                                                    price: option.getAttribute('data-price')
                                                })
                                            );
                                        };
                                        $(selectElement).select2().on('change', updateSelectedValues);
                                        updateSelectedValues();
                                    },
                                    removeValue(value) {
                                        const selectElement = document.getElementById('filter_subject_group');
                                        const optionToDeselect = Array.from(selectElement.options).find(option => option.value === value);
                                        if (optionToDeselect) {
                                            optionToDeselect.selected = false;
                                            $(selectElement).trigger('change');
                                        }
                                    },
                                    submitFilter() {
                                        let filters = {}
                                        const selectSbj = document.getElementById('filter_subject_group');
                                        const selectType = document.getElementById('type_fiter');
                                        filters.type = $(selectType).select2('val');
                                        filters.subject_group_ids = $(selectSbj).select2('val');
                                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('filter', filters);
                                    }
                                }"
                                >
                                <fieldset>
                                    <div class="form-group">
                                        <label><?php echo e(__('calendar.session_type_placeholder')); ?></label>
                                        <span class="am-select am-filter-select" wire:ignore>
                                            <select id="type_fiter" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-parent=".am-filter-list" class="am-customselect" data-searchable="false" data-wiremodel="filter.type">
                                                <option value="*"><?php echo e(__('calendar.show_all_type')); ?></option>
                                                <option value="one"><?php echo e(__('calendar.one')); ?></option>
                                                <option value="group"><?php echo e(__('calendar.group')); ?></option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo e(__('calendar.subject_placeholder')); ?></label>
                                        <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                            <select id="filter_subject_group" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-parent=".am-filter-list" class="am-customselect" data-class="subject-dropdown-select2" data-format="custom" data-searchable="true" data-wiremodel="filter.subject_group_ids" data-placeholder="<?php echo e(__('calendar.subject_placeholder')); ?>" multiple>
                                                <option label="<?php echo e(__('calendar.subject_placeholder')); ?>"></option>
                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($subjectGroups)): ?>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjectGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <optgroup label="<?php echo e($group['group_name']); ?>">
                                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $group['subjects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($subject['id']); ?>"
                                                                        data-price="<?php echo e(formatAmount($subject['hour_rate'])); ?>">
                                                                        <?php echo e($subject['subject_name']); ?>

                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                            </optgroup>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </span>
                                        <template x-if="selectedValues.length > 0">
                                            <ul class="am-subject-tag-list">
                                                <template x-for="(subject, index) in selectedValues">
                                                    <li>
                                                        <a href="javascript:void(0)" class="am-subject-tag" @click="removeValue(subject.value)">
                                                            <span x-text="`${subject.text} (${subject.price})`"></span>
                                                            <i class="am-icon-multiply-02"></i>
                                                        </a>
                                                    </li>
                                                </template>
                                            </ul>
                                        </template>
                                    </div>
                                    <div class="form-group">
                                        <button class="am-btn" @click="submitFilter()"><?php echo e(__('general.apply_filter')); ?></button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="am-booking-calander_body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="weeklytab">
                            <a class="tab-pane_leftarrow" href="javascript:void(0);" <?php if($disablePrevious): ?> disabled <?php else: ?> wire:click="previousBookings" <?php endif; ?>>
                                <i class="am-icon-chevron-left"></i>
                            </a>
                            <div class="am-booksession-details">
                                <table class="am-booking-weekly-clander">
                                    <thead>
                                        <tr>
                                            <!--[if BLOCK]><![endif]--><?php for($date = $currentDate->copy()->startOfWeek($startOfWeek); $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek))); $date->addDay()): ?>
                                                
                                                <th class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active' => $selectedDate === $date->toDateString()]); ?>">
                                                    <a href="javascript:void(0);" class="text-decoration-none" wire:click.prevent="showSlotsForDate('<?php echo e($date->toDateString()); ?>')">
                                                        <div class="am-booking-calander-title">
                                                            <strong><?php echo e($date->format('j M')); ?></strong>
                                                            <span><?php echo e($date->format('D')); ?></span>
                                                        </div>
                                                    </a>
                                                </th>
                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <!--[if BLOCK]><![endif]--><?php for($date = $currentDate->copy()->startOfWeek($startOfWeek); $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek))); $date->addDay()): ?>
                                                <?php
                                                    $active_date = $date->toDateString();
                                                    $slots = $availableSlots[$active_date] ?? [];
                                                ?>
                                                <td>
                                                    <div class="am-weekly-slots">
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($slots)): ?>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    $subject = $slot?->subjectGroupSubjects?->subject?->name;
                                                                    $group = $slot?->subjectGroupSubjects?->userSubjectGroup?->group?->name ?? '';
                                                                    $total_spaces = $slot->spaces ?? 0;
                                                                    $total_booked = $slot->total_booked ?? 0;
                                                                    $available_slot = $total_spaces - $total_booked;
                                                                    $show_all = $index > 3;
                                                                    $cartItemIds = array_column(array_column($cartItems?->toArray() ?? [], 'options'), 'slot_id');
                                                                    $tooltipClass   = Arr::random(['warning', 'pending', 'ready', 'success']);
                                                                    $discountedFee  = 0;
                                                                    if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal')){
                                                                        $coupon = $slot?->subjectGroupSubjects?->coupons?->first();
                                                                        if(!empty($coupon)){
                                                                            $discountedFee = getDiscountedTotal($slot->session_fee, $coupon->discount_type, $coupon->discount_value);
                                                                        }
                                                                    }
                                                                ?>
                                                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['d-none' => $index > 3, 'am-slot-selected' => in_array($slot->id, $cartItemIds), 'am-weekly-slots_card', 'am-slot-'.$tooltipClass]); ?>" id="sessionslot-<?php echo e($slot->id); ?>">
                                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($group)): ?>
                                                                        <h6>
                                                                            <?php echo e($group); ?>

                                                                            <!--[if BLOCK]><![endif]--><?php if(in_array($slot->id, $cartItemIds)): ?>
                                                                                <div class="am-closepopup" 
                                                                                        @click="$wire.dispatch('remove-cart', { params: { cartable_id: <?php echo \Illuminate\Support\Js::from($slot->bookings->first()?->id)->toHtml() ?>, cartable_type: 'App\\Models\\SlotBooking' } })">
                                                                                    <i class="am-icon-multiply-01"></i>
                                                                                </div>
                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </h6>
                                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                    <!--[if BLOCK]><![endif]--><?php if(!empty($subject)): ?><h5><?php echo $subject; ?></h5><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                    <div class="am-weekly-slots_info">
                                                                        <span>
                                                                            <i class="am-icon-time"></i>
                                                                            <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?>
                                                                                <em><?php echo e(parseToUserTz($slot->start_time, $timezone)->format('h:i a')); ?> -
                                                                                <?php echo e(parseToUserTz($slot->end_time, $timezone)->format('h:i a')); ?></em>
                                                                            <?php else: ?>
                                                                                <em><?php echo e(parseToUserTz($slot->start_time, $timezone)->format('H:i')); ?> -
                                                                                <?php echo e(parseToUserTz($slot->end_time, $timezone)->format('H:i')); ?></em>
                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                        </span>
                                                                        <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($slot?->subjectGroupSubjects?->coupons?->first())): ?>
                                                                            <span class="am-discounted-session">
                                                                                <i class="am-icon-shopping-basket-04"></i>
                                                                                <div class="am-discounted-price">
                                                                                    <strike>
                                                                                        <?php echo e(formatAmount($slot->session_fee)); ?>

                                                                                    </strike>
                                                                                    <?php echo e(formatAmount($discountedFee)); ?>

                                                                                    <em><?php echo e(__('tutor.per_session')); ?></em>
                                                                                </div>
                                                                            </span>
                                                                        <?php else: ?>
                                                                            <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                                                                <span>
                                                                                    <i class="am-icon-shopping-basket-04"></i>
                                                                                    <div class="am-nondiscounted-session">
                                                                                        <?php echo e(formatAmount($slot->session_fee)); ?>

                                                                                        <em><?php echo e(__('tutor.per_session')); ?></em>
                                                                                    </div>
                                                                                </span>
                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                        <!--[if BLOCK]><![endif]--><?php if($slot->spaces == '1' && !in_array($slot->id, $cartItemIds)): ?>
                                                                            <span><i class="am-icon-user-01"></i><?php echo e(__('calendar.private_session')); ?><span>
                                                                        <?php else: ?>
                                                                            <span><i class="am-icon-user-group"></i><?php echo e(__('calendar.no_slots_left', ['count' => $available_slot])); ?><span>
                                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <div class="am-bookingbtns">
                                                                        <!--[if BLOCK]><![endif]--><?php if(((Auth::check() && Auth()->user()->role == 'student') && !in_array($slot->id, $cartItemIds) && $available_slot > 0) && $slot->bookings->isEmpty() && $userId != Auth()->user()->id): ?>
                                                                            <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                                                                <button class="am-booksession" wire:loading.class="am-btn_disable" wire:target="bookSession(<?php echo e($slot->id); ?>)" wire:click.prevent="bookSession(<?php echo e($slot->id); ?>)" ><?php echo e(__('tutor.book_session_txt')); ?></button>
                                                                            <?php else: ?>
                                                                                <button  
                                                                                    class="am-booksession"
                                                                                    wire:click="getFreeSession(<?php echo e($slot->id); ?>)" 
                                                                                    type="button" 
                                                                                    wire:loading.delay.class="am-btn_disable" 
                                                                                    wire:target="getFreeSession(<?php echo e($slot->id); ?>)">
                                                                                    <?php echo e(__('tutor.get_session_txt')); ?>

                                                                                </button>
                                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                            <button class="am-viewdetail"  wire:loading.class="am-btn_disable" wire:target="showSlotDetail('<?php echo e($slot->id); ?>')" wire:click.prevent="showSlotDetail('<?php echo e($slot->id); ?>');"><?php echo e(__('tutor.view_detail')); ?></button>
                                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php else: ?>
                                                            <span class="am-emptyslot"><?php echo e(__('calendar.no_sessions')); ?></span>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </td>
                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="am-booking-weekly-clander am-booking-mobile">
                                <!--[if BLOCK]><![endif]--><?php for($date = $currentDate->copy()->startOfWeek($startOfWeek); $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek))); $date->addDay()): ?>
                                    <?php
                                        $active_date = $date->toDateString();
                                        $slots = $availableSlots[$active_date] ?? [];
                                        $showAll[$active_date] = false;
                                    ?>
                                    <td>
                                        <div class="am-weekly-slots <?php if($selectedDate === $date->toDateString()): ?> am-day-slots-show <?php endif; ?>">
                                            <!--[if BLOCK]><![endif]--><?php if(!empty($slots)): ?>

                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $slots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $subject = $slot?->subjectGroupSubjects?->subject?->name;
                                                        $group = $slot?->subjectGroupSubjects?->userSubjectGroup?->group?->name ?? '';
                                                        $total_spaces = $slot->spaces ?? 0;
                                                        $total_booked = $slot->total_booked ?? 0;
                                                        $available_slot = $total_spaces - $total_booked;
                                                        $showAll[$active_date] = $index > 4;
                                                        $cartItemIds = array_column(array_column($cartItems?->toArray() ?? [], 'options'), 'slot_id');
                                                        $tooltipClass   = Arr::random(['warning', 'pending', 'ready', 'success'])
                                                    ?>
                                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['d-none' => $index > 4, 'am-slot-selected' => in_array($slot->id, $cartItemIds), 'am-weekly-slots_card', 'am-slot-'.$tooltipClass]); ?>" id="sessionslot-<?php echo e($slot->id); ?>">
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($group)): ?>
                                                            <h6>
                                                                <?php echo e($group); ?>

                                                                <!--[if BLOCK]><![endif]--><?php if(in_array($slot->id, $cartItemIds)): ?>
                                                                    <div class="am-closepopup" 
                                                                        @click="$wire.dispatch('remove-cart', { params: { cartable_id: <?php echo \Illuminate\Support\Js::from($slot->bookings->first()?->id)->toHtml() ?>, cartable_type: 'App\\Models\\SlotBooking' } })">
                                                                        <i class="am-icon-multiply-02"></i>
                                                                    </div>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </h6>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <!--[if BLOCK]><![endif]--><?php if(!empty($subject)): ?><h5><?php echo e($subject); ?></h5><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        <div class="am-weekly-slots_info">
                                                            <span>
                                                                <i class="am-icon-time"></i>
                                                                <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?>
                                                                    <em><?php echo e(parseToUserTz($slot->start_time, $timezone)->format('h:i a')); ?> -
                                                                    <?php echo e(parseToUserTz($slot->end_time, $timezone)->format('h:i a')); ?></em>
                                                                <?php else: ?>
                                                                    <em><?php echo e(parseToUserTz($slot->start_time, $timezone)->format('H:i')); ?> -
                                                                    <?php echo e(parseToUserTz($slot->end_time, $timezone)->format('H:i')); ?></em>
                                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            </span>
                                                            <span><i class="am-icon-shopping-basket-04"></i><?php echo e(formatAmount($slot->session_fee)); ?><?php echo e(__('tutor.per_session')); ?></span>
                                                            <span><i class="am-icon-user-02"></i><?php echo e(__('calendar.no_slots_left', ['count' => $available_slot])); ?><span>
                                                        </div>
                                                        <div class="am-bookingbtns">
                                                            <!--[if BLOCK]><![endif]--><?php if((Auth::check() && Auth()->user()->role == 'student') && !in_array($slot->id, $cartItemIds) && $available_slot > 0): ?>
                                                                <button class="am-booksession" wire:loading.class="am-btn_disable" wire:target="bookSession(<?php echo e($slot->id); ?>)" wire:click.prevent="bookSession(<?php echo e($slot->id); ?>)" ><?php echo e(__('tutor.book_session_txt')); ?></button>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                            <button class="am-viewdetail"  wire:loading.class="am-btn_disable" wire:target="showSlotDetail('<?php echo e($slot->id); ?>')" wire:click.prevent="showSlotDetail('<?php echo e($slot->id); ?>');"><?php echo e(__('tutor.view_detail')); ?></button>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <?php else: ?>
                                                <span class="am-emptyslot"><?php echo e(__('calendar.no_sessions')); ?></span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </td>
                                    <!--[if BLOCK]><![endif]--><?php if($showAll[$active_date] && $selectedDate == $active_date): ?>
                                        <div class="am-view_schedule-wrap">
                                            <button class="am-white-btn am-view_schedule am-showmore"><?php echo e(__('tutor.view_full_schedules')); ?></button>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <a class="tab-pane_rightarrow" href="javascript:void(0);" wire:click="nextBookings">
                                <i class="am-icon-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($show_all): ?>
                        <div class="am-view_schedule-wrap am-showmore-btn">
                            <button class="am-white-btn am-view_schedule am-showmore"><?php echo e(__('tutor.view_full_schedules')); ?></button>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginal8368580ee911c2d8f24d65423c573661 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8368580ee911c2d8f24d65423c573661 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.slot-detail-modal','data' => ['cartItems' => $cartItems,'timezone' => $timezone,'currentSlot' => $currentSlot,'user' => $user,'wire:key' => ''.e(time()).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('slot-detail-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['cartItems' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cartItems),'timezone' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($timezone),'currentSlot' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentSlot),'user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($user),'wire:key' => ''.e(time()).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8368580ee911c2d8f24d65423c573661)): ?>
<?php $attributes = $__attributesOriginal8368580ee911c2d8f24d65423c573661; ?>
<?php unset($__attributesOriginal8368580ee911c2d8f24d65423c573661); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8368580ee911c2d8f24d65423c573661)): ?>
<?php $component = $__componentOriginal8368580ee911c2d8f24d65423c573661; ?>
<?php unset($__componentOriginal8368580ee911c2d8f24d65423c573661); ?>
<?php endif; ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div wire:ignore.self class="modal fade am-requestsessionpopup" id="requestsession-popup" data-bs-backdrop="static" x-data="{requestSessionForm: <?php if ((object) ('requestSessionForm') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('requestSessionForm'->value()); ?>')<?php echo e('requestSessionForm'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('requestSessionForm'); ?>')<?php endif; ?>}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2><?php echo e(__('tutor.request_a_session')); ?></h2>
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <ul class="nav nav-pills am-booking-tabs" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" @click="requestSessionForm.type = 'private'" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"> 
                                <?php echo e(__('tutor.private_session')); ?>

                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" @click="requestSessionForm.type = 'group'" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> 
                                <?php echo e(__('tutor.group_session')); ?>

                            </button>
                        </li>
                    </ul>
                    <form class="am-themeform">
                        <fieldset>
                            <div class="form-group form-group-two-wrap">
                                <div <?php $__errorArgs = ['requestSessionForm.first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="am-invalid" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                    <label class="am-label am-important" for="name"><?php echo e(__('auth.first_name')); ?></label>
                                    <input type="text" x-model="requestSessionForm.first_name" class="form-control" placeholder="<?php echo e(__('auth.first_name')); ?>">
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'requestSessionForm.first_name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'requestSessionForm.first_name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                                <div <?php $__errorArgs = ['requestSessionForm.last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> class="am-invalid" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                    <label class="am-label am-important" for="email"><?php echo e(__('auth.last_name')); ?></label>
                                    <input type="text" x-model="requestSessionForm.last_name" class="form-control" placeholder="<?php echo e(__('auth.last_name')); ?>">
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'requestSessionForm.last_name']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'requestSessionForm.last_name']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group <?php $__errorArgs = ['requestSessionForm.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <label class="am-label am-important" for="email"><?php echo e(__('auth.email_placeholder')); ?></label>
                                <input type="text" x-model="requestSessionForm.email" class="form-control" placeholder="<?php echo e(__('auth.email_placeholder')); ?>">
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'requestSessionForm.email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'requestSessionForm.email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>
                            <div class="form-group <?php $__errorArgs = ['requestSessionForm.message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <label class="am-label am-important" for="email"><?php echo e(__('tutor.message')); ?></label>
                                <textarea name="message" x-model="requestSessionForm.message" placeholder="<?php echo e(__('tutor.message_placeholder')); ?>"></textarea>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'requestSessionForm.message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'requestSessionForm.message']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>
                        </fieldset>
                    </form>
                    <button class="am-btn" wire:click="sendRequestSession" wire:loading.class="am-btn_disable" wire:target="sendRequestSession"><?php echo e(__('tutor.send_request')); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/flatpicker-month-year-plugin.css',
    ]); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/flatpicker.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/weekSelect.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/flatpicker-month-year-plugin.js')); ?>"></script>
    <script>
        let dateInstance = null;
        document.addEventListener("DOMContentLoaded", (event) => {
            document.addEventListener('initCalendarJs', (event)=>{
                setTimeout(() => {
                    initFlatPicker( event.detail.currentDate,);
                }, 100);
            })

            function initFlatPicker(currentDate) {
                if (dateInstance) {
                    dateInstance.destroy();
                }
                let startOfWeek = <?php echo \Illuminate\Support\Js::from($startOfWeek)->toHtml() ?>;
                let config = {
                    defaultDate: parseDateRange(currentDate),
                    onChange : function(selectedDates, dateStr, instance) {
                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('jumpToDate', dateStr);
                    },
                    disableMobile: true,
                    minDate: <?php echo \Illuminate\Support\Js::from(\Carbon\Carbon::now($timezone))->toHtml() ?>,
                    plugins: [
                        new weekSelect({
                            weekStart: startOfWeek
                        })
                    ],
                    dateFormat: 'Y-m-d',
                    onReady: function(selectedDates, dateStr, instance) {
                        instance.input.value = currentDate
                    }
                };
                dateInstance = flatpickr($(`#flat-picker`), config);
            }

            function parseDateRange(dateRangeStr) {
                const [range, year] = dateRangeStr.split(' ');
                const [startStr, endStr] = range.split('-');

                const monthMap = {
                    January: 0, February: 1, March: 2, April: 3, May: 4, June: 5,
                    July: 6, August: 7, September: 8, October: 9, November: 10, December: 11
                };

                const parseDate = (str) => new Date(`${monthMap[str.split(' ')[0]]}/${str.split(' ')[1]}/${year}`);

                try {
                    const startDate = parseDate(startStr);
                    const endDate = parseDate(endStr);
                    if (isNaN(startDate) || isNaN(endDate)) throw new Error('Invalid date');
                    return { start: startDate.toISOString().split('T')[0], end: endDate.toISOString().split('T')[0] };
                } catch {
                    return null;
                }
            }

            jQuery(document).on('click','.am-view_schedule', function(){
                let _this = jQuery(this);
                if(_this.hasClass('am-showmore')){
                    _this.addClass('am-showless').removeClass('am-showmore');
                    jQuery('.am-weekly-slots').find('.d-none').addClass('am-showless').removeClass('d-none');
                    _this.text("<?php echo e(__('tutor.show_less')); ?>");
                } else {
                    _this.addClass('am-showmore')
                    jQuery('.am-weekly-slots').find('.am-showless').addClass('d-none').removeClass('am-showless');
                    _this.text("<?php echo e(__('tutor.view_full_schedules')); ?>");
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/components/tutor-sessions.blade.php ENDPATH**/ ?>