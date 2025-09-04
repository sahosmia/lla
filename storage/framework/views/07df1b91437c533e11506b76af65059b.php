<div class="am-profile-setting">
    <?php $__env->slot('title'); ?>
        <?php echo e(__('sidebar.bookings')); ?>

    <?php $__env->endSlot(); ?>
    <!--[if BLOCK]><![endif]--><?php if(auth()->user()->role == 'tutor'): ?>
        <?php echo $__env->make('livewire.pages.tutor.manage-sessions.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    <div wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter"
         class="am-booking-wrapper am-upcomming-booking <?php if(auth()->user()->role == 'student'): ?> am-student-booking <?php endif; ?>" x-data="{
            form:<?php if ((object) ('form') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'->value()); ?>')<?php echo e('form'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form'); ?>')<?php endif; ?>,
            charLeft:500,
            init(){
                this.updateCharLeft();
            },
            tutorInfo:{},
            updateCharLeft() {
                let maxLength = 500;
                if (this.form.comment.length > maxLength) {
                    this.form.comment = this.form.comment.substring(0, maxLength);
                }
                this.charLeft = maxLength - this.form.comment.length;
            }
        }">
        <div class="am-booking-calander am-booking-dailycalendar">
            <div class="am-booking-calander_header">
                <div class="am-booking-dates-slot">
                    <div class="am-booking-calander-day">
                        <a href="#" <?php if($disablePrevious): ?> disabled <?php else: ?> wire:click="previousBookings" <?php endif; ?>>
                            <i class="am-icon-chevron-left"></i>
                        </a>
                        <span <?php if($isCurrent): ?> disabled <?php else: ?> wire:click="jumpToDate()" <?php endif; ?>>
                            <?php echo e(__('calendar.current_'.$showBy)); ?>

                        </span>
                        <a href="#" wire:click="nextBookings">
                            <i class="am-icon-chevron-right"></i>
                        </a>
                    </div>
                    <div class="am-booking-calander-date flatpicker" wire:ignore>
                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'flat-picker']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'flat-picker']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                    </div>
                </div>
                <div class="am-booking-filters-wrapper">
                    <div class="am-inputicon">
                        <input type="text" wire:model.live.debounce.250ms="filter.keyword"
                            placeholder="<?php echo e(__('taxonomy.search_here')); ?>" class="form-control" />
                        <a href="#">
                            <i class="am-icon-search-02"></i>
                        </a>
                    </div>
                    <div class="am-booking-filter-wrapper">
                        <a class="am-booking-filter" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" data-bs-auto-close="outside">
                            <i class="am-icon-sliders-horiz-01"></i>
                        </a>
                        <form class="am-itemdropdown_list am-filter-list dropdown-menu"
                            aria-labelledby="dropdownMenuLink" x-on:submit.prevent x-data="{
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
                            }">
                            <fieldset>
                                <div class="form-group">
                                    <label><?php echo e(__('calendar.session_type_placeholder')); ?></label>
                                    <span class="am-select am-filter-select" wire:ignore>
                                        <select id="type_fiter" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-parent=".am-filter-list"
                                            class="am-select2" data-searchable="false" data-wiremodel="filter.type">
                                            <option value="*"><?php echo e(__('calendar.show_all_type')); ?></option>
                                            <option value="one"><?php echo e(__('calendar.one')); ?></option>
                                            <option value="group"><?php echo e(__('calendar.group')); ?></option>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label><?php echo e(__('calendar.subject_placeholder')); ?></label>
                                    <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                        <select id="filter_subject_group" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')"
                                            data-parent=".am-filter-list" class="am-select2"
                                            data-class="subject-dropdown-select2" data-format="custom"
                                            data-searchable="true" data-wiremodel="filter.subject_group_ids"
                                            data-placeholder="<?php echo e(__('calendar.subject_placeholder')); ?>" multiple>
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
                                </div>
                                <template x-if="selectedValues.length > 0">
                                    <ul class="am-subject-tag-list">
                                        <template x-for="(subject, index) in selectedValues">
                                            <li>
                                                <a href="javascript:void(0)" class="am-subject-tag"
                                                    @click="removeValue(subject.value)">
                                                    <span x-text="`${subject.text} (${subject.price})`"></span>
                                                    <i class="am-icon-multiply-02"></i>
                                                </a>
                                            </li>
                                        </template>
                                    </ul>
                                </template>
                                <button class="am-btn" @click="submitFilter()"><?php echo e(__('general.apply_filter')); ?></button>
                            </fieldset>
                        </form>
                    </div>
                    <ul class="am-session-slots am-session-slots-sm" role="tablist">
                        <li>
                            <button class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active'=> $showBy == 'daily']); ?>" <?php if($showBy != 'daily'): ?>
                                wire:click="switchShow('daily')" <?php endif; ?> aria-selected="true"
                                wire:loading.class="am-btn_disable"><?php echo e(__('calendar.daily')); ?></button>
                        </li>
                        <li>
                            <button class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active'=> $showBy == 'weekly']); ?>" <?php if($showBy != 'weekly'): ?>
                                wire:click="switchShow('weekly')" <?php endif; ?> aria-selected="false"
                                wire:loading.class="am-btn_disable"><?php echo e(__('calendar.weekly')); ?></button>
                        </li>
                        <li>
                            <button class="<?php echo \Illuminate\Support\Arr::toCssClasses(['active'=> $showBy == 'monthly']); ?>" <?php if($showBy != 'monthly'): ?>
                                wire:click="switchShow('monthly')" <?php endif; ?> aria-selected="false"
                                wire:loading.class="am-btn_disable"><?php echo e(__('calendar.monthly')); ?></button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="am-section-load" wire:loading.flex wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                <p><?php echo e(__('general.loading')); ?></p>
            </div>
            <div wire:loading.class="d-none" class="am-booking-calander_body" wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                <div class="tab-content">
                    <!--[if BLOCK]><![endif]--><?php if($showBy == 'daily'): ?>
                    <div class="tab-pane fade show active am-tableresponsive sticky-left-column" id="dailytab">
                        <table class="am-booking-clander-daily" cellspacing="0" id="dailytable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('calendar.time')); ?></th>
                                    <th><?php echo e(parseToUserTz($currentDate)->format('F j, Y \\G\\M\\T P')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $startTime = \Carbon\Carbon::createFromTime(0, 0, 0);
                                $endTime = \Carbon\Carbon::createFromTime(23, 59, 0);
                                ?>
                                <!--[if BLOCK]><![endif]--><?php while($startTime <= $endTime): ?> <tr>
                                    <!--[if BLOCK]><![endif]--><?php if(setting('_lernen.time_format') == '12'): ?>
                                        <td><?php echo e($startTime->format('h:i a')); ?></td>
                                    <?php else: ?>
                                        <td><?php echo e($startTime->format('H:i')); ?></td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if(isset($upcomingBookings[$startTime->format('h:i a')]) || isset($upcomingBookings[$startTime->format('H:i')])): ?>
                                    <td>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $upcomingBookings[$startTime->format('h:i a')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div
                                        <?php if(!empty(setting('_general.enable_rtl'))): ?>
                                            style="position: absolute; top: <?php echo e(calculatePercentageOfHour($booking->slot->start_time)); ?>px;right: <?php echo e($loop->index * 380); ?>px;"
                                        <?php else: ?>
                                            style="position: absolute; top: <?php echo e(calculatePercentageOfHour($booking->slot->start_time)); ?>px;left: <?php echo e($loop->index * 380); ?>px;"
                                        <?php endif; ?>
                                        >
                                            <?php if (isset($component)) { $__componentOriginala258dd8e6ebcc1b8aae716365ee1143d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.single-booking','data' => ['booking' => $booking,'disputeReason' => $disputeReason,'description' => $description,'selectedReason' => $selectedReason]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('single-booking'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['booking' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($booking),'disputeReason' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($disputeReason),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description),'selectedReason' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedReason)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d)): ?>
<?php $attributes = $__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d; ?>
<?php unset($__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala258dd8e6ebcc1b8aae716365ee1143d)): ?>
<?php $component = $__componentOriginala258dd8e6ebcc1b8aae716365ee1143d; ?>
<?php unset($__componentOriginala258dd8e6ebcc1b8aae716365ee1143d); ?>
<?php endif; ?>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <?php else: ?>
                                    <td></td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    $startTime->addHour();
                                    ?>
                                    <?php endwhile; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                    <?php elseif($showBy == 'weekly'): ?>
                    <div class="tab-pane fade show active" id="weeklytab">
                        <table class="am-booking-weekly-clander">
                            <thead>
                                <tr>
                                    <!--[if BLOCK]><![endif]--><?php for($date = $currentDate->copy()->startOfWeek($startOfWeek);
                                    $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek)));
                                    $date->addDay()): ?>
                                    <th>
                                        <div class="am-booking-calander-title">
                                            <strong><?php echo e($date->format('j F')); ?></strong>
                                            <span><?php echo e($date->format('D')); ?></span>
                                        </div>
                                    </th>
                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!--[if BLOCK]><![endif]--><?php for($date = $currentDate->copy()->startOfWeek($startOfWeek);
                                    $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek)));
                                    $date->addDay()): ?>
                                    <td>
                                        <div class="am-weekly-slots_wrap">
                                            <div class="am-weekly-slots">
                                                <!--[if BLOCK]><![endif]--><?php if(isset($upcomingBookings[$date->toDateString()])): ?>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $upcomingBookings[$date->toDateString()]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if (isset($component)) { $__componentOriginala258dd8e6ebcc1b8aae716365ee1143d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.single-booking','data' => ['booking' => $booking,'disputeReason' => $disputeReason,'description' => $description,'selectedReason' => $selectedReason]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('single-booking'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['booking' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($booking),'disputeReason' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($disputeReason),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description),'selectedReason' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedReason)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d)): ?>
<?php $attributes = $__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d; ?>
<?php unset($__attributesOriginala258dd8e6ebcc1b8aae716365ee1143d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala258dd8e6ebcc1b8aae716365ee1143d)): ?>
<?php $component = $__componentOriginala258dd8e6ebcc1b8aae716365ee1143d; ?>
<?php unset($__componentOriginala258dd8e6ebcc1b8aae716365ee1143d); ?>
<?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <?php else: ?>
                                                <span class="am-emptyslot"><?php echo e(__('calendar.no_sessions')); ?></span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </td>
                                    <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php elseif($showBy == 'monthly'): ?>
                    <div class="tab-pane fade show active" id="monthlytab">
                        <table class="am-monthly-session-table">
                            <thead>
                                <tr>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th><?php echo e($day['short_name']); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $startOfCalendar = $currentDate->copy()->firstOfMonth()->startOfWeek($startOfWeek);
                                $endOfCalendar =
                                $currentDate->copy()->lastOfMonth()->endOfWeek(getEndOfWeek($startOfWeek));
                                ?>
                                <!--[if BLOCK]><![endif]--><?php while($startOfCalendar <= $endOfCalendar): ?> <tr>
                                    <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 7; $i++): ?> <?php $totalBookings=0; ?> <td
                                        class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-outside-calendar'=> $startOfCalendar->format('m') !=
                                        $currentDate->format('m')]); ?>">
                                        <div class="am-monthly-session-title">
                                            <span class="<?php echo \Illuminate\Support\Arr::toCssClasses(['current-date'=> $startOfCalendar->isToday()]); ?>"><?php echo e(parseToUserTz($startOfCalendar)->format('j')); ?></span>
                                            <!--[if BLOCK]><![endif]--><?php if(isset($upcomingBookings[$startOfCalendar->toDateString()])): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $upcomingBookings[$startOfCalendar->toDateString()]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $totalBookings += 1;
                                            ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            <em> <?php echo e($totalBookings); ?> <?php echo e(__('calendar.sessions')); ?> </em>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if BLOCK]><![endif]--><?php if(isset($upcomingBookings[$startOfCalendar->toDateString()])): ?>
                                        <ul class="am-monthly-session-lsit">
                                            <?php $__currentLoopData = $upcomingBookings[$startOfCalendar->toDateString()]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $subject = $booking->slot->subjectGroupSubjects?->subject?->name;
                                            $tooltipClass = Arr::random(['warning', 'pending', 'ready', 'success'])
                                            ?>
                                            <li class="<?php echo \Illuminate\Support\Arr::toCssClasses([ "am-$tooltipClass-tooltip"=>
                                                parseToUserTz($booking->slot->end_time)->isFuture(),
                                                'am-blur-tooltip' => auth()->user()->role == 'student' &&
                                                ($booking->status == 'rescheduled' || $booking->status == 'disputed'),
                                                'am-tooltip',
                                                'am-addreview-tooltip' =>
                                                parseToUserTz($booking->slot->end_time)->isPast()
                                                ]); ?>" <?php if(parseToUserTz($booking->slot->end_time)->isFuture()): ?> wire:click="showBookingDetail(<?php echo e($booking->id); ?>)" <?php endif; ?>>
                                                <div class="am-titleblur">
                                                    <div class="am-session-monthly-tooltip">
                                                        <strong wire:loading.class="am-btn_disable"
                                                            ><?php echo e($subject); ?></strong>
                                                        <!--[if BLOCK]><![endif]--><?php if(parseToUserTz($booking->slot->end_time)->isFuture()): ?>
                                                        <span>
                                                            <span>
                                                                    <i class="am-icon-time"></i>
                                                                    <em>
                                                                        <?php echo e(parseToUserTz($booking->slot->start_time)->format('h:i
                                                                        a')); ?> -
                                                                        <?php echo e(parseToUserTz($booking->slot->end_time)->format('h:i a')); ?>

                                                                    </em>
                                                            </span>
                                                            <!--[if BLOCK]><![endif]--><?php if(parseToUserTz($booking->slot->end_time)->isFuture()): ?>
                                                                <i class="am-icon-arrow-right"></i>
                                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </span>
                                                        <?php elseif($booking->rating_exists): ?>
                                                        <span>
                                                            <em>
                                                                <?php echo e(__('calendar.review_submitted')); ?>

                                                            </em>
                                                            <i class="am-icon-check-circle06"></i>
                                                        </span>
                                                        <?php elseif($booking->status == 'completed'): ?>
                                                        <?php
                                                            $tutorInfo['name'] = $booking->tutor->full_name;
                                                            if (!empty($booking?->tutor?->image) &&
                                                                Storage::disk(getStorageDisk())->exists($booking?->tutor?->image)) {
                                                                $tutorInfo['image'] = resizedImage($booking?->tutor?->image, 36, 36);
                                                            } else {
                                                                $tutorInfo['image'] = setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 36, 36);
                                                            }
                                                        ?>
                                                            <a href="#"
                                                                @click=" tutorInfo = <?php echo \Illuminate\Support\Js::from($tutorInfo)->toHtml() ?>; form.bookingId = <?php echo \Illuminate\Support\Js::from($booking->id)->toHtml() ?>; $nextTick(() => $wire.dispatch('toggleModel', {id:'review-modal',action:'show'}) )">
                                                                <?php echo e(__('calendar.add_review')); ?> 
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="#" wire:click.prevent="showCompletePopup(<?php echo e(json_encode($booking)); ?>)">
                                                                <?php echo e(__('calendar.mark_as_completed')); ?>

                                                            </a>
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>
                                                <?php if(auth()->user()->role == 'student' && $booking->status ==
                                                'rescheduled'): ?>
                                                <div class="am-blur-content">
                                                    <a href="<?php echo e(route('student.reschedule-session', ['id' => $booking->id])); ?>"
                                                        wire:navigate.remove><?php echo e(__('calendar.tutor_rescheduled')); ?></a>
                                                </div>
                                                <?php elseif(auth()->user()->role == 'student' && $booking->status == 'disputed'): ?>
                                                    <div class="am-blur-content">
                                                        <a href="<?php echo e(route('student.manage-dispute', ['id' => $booking?->dispute?->uuid])); ?>"><?php echo e(__('calendar.dispute_session')); ?></a>  
                                                    </div>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </ul>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </td>
                                        <?php
                                        $startOfCalendar->addDay();
                                        ?>
                                        <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                        </tr>
                                        <?php endwhile; ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginal86cd4a276c2978c462f28bbb510e89a0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.no-record','data' => ['image' => asset('images/session.png'),'title' => __('calendar.no_sessions'),'description' => __('calendar.no_session_desc')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('no-record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['image' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(asset('images/session.png')),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.no_sessions')),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('calendar.no_session_desc'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $attributes = $__attributesOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__attributesOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0)): ?>
<?php $component = $__componentOriginal86cd4a276c2978c462f28bbb510e89a0; ?>
<?php unset($__componentOriginal86cd4a276c2978c462f28bbb510e89a0); ?>
<?php endif; ?>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
        <!-- session detail modal v2 -->
        <div class="modal fade am-review-popup" id="review-modal" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="am-review-detail">
                    <div class="am-review-session">
                        <h3><?php echo e(__('calendar.tell_us_experience')); ?></h3>
                        <div class="am-review-user">
                            <a href="#" class="am-review-user-detail">
                                <img :src="tutorInfo?.image" :alt="tutorInfo?.name">
                                <span x-text="tutorInfo?.name"></span>
                            </a>
                            <div class="am-stars-list_wrap">
                                <ul class="am-stars-list">
                                    <template x-for="(star, index) in 5">
                                        <li>
                                            <span :class="{
                                                'am-stars-items-fill': form.rating > index,
                                                'am-stars-items-empty': true
                                                }" @click="form.rating = index + 1">
                                                <i class="am-icon-star-fill"></i>
                                            </span>
                                        </li>
                                    </template>
                                </ul>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.rating']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.rating']); ?>
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
                        <div class="am-review-details <?php $__errorArgs = ['form.comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> am-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <textarea placeholder="<?php echo e(__('calendar.add_review')); ?>" x-model="form.comment"
                                x-on:input="updateCharLeft"></textarea>
                            <span x-text="charLeft + ' <?php echo e(__('general.char_left')); ?>'"></span>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.comment']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.comment']); ?>
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
                        <button class="am-btn" wire:click="submitReview" wire:loading.class="am-btn_disable"><?php echo e(__('calendar.submit_review')); ?></button>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_lernen.enabl_tips')) &&
                    (!empty(setting('_lernen.tip_section_title')) ||
                    !empty(setting('_lernen.tip_section_description')) ||
                    !empty(setting('_lernen.tip_bullets_repeater'))) ||
                    !empty(setting('_lernen.well_wishing_text'))
                    ): ?>
                    <div class="am-reviews-tips">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_lernen.tip_section_title'))): ?>
                        <div class="am-review-tips-heading">
                            <span>
                                <i class="am-icon-check-circle04"></i>
                            </span>
                            <h3><?php echo e(setting('_lernen.tip_section_title')); ?></h3>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_lernen.tip_section_description'))): ?>
                        <p class="am-review-description"><?php echo e(setting('_lernen.tip_section_description')); ?></p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_lernen.tip_bullets_repeater'))): ?>
                        <ul class="am-reviews-tips-list">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = setting('_lernen.tip_bullets_repeater'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span class="am-review-tip">
                                    <i class="am-icon-check-circle06"></i>
                                    <?php echo e($bullet['tip_bullets']); ?>

                                </span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </ul>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if(!empty(setting('_lernen.well_wishing_text'))): ?>
                        <span class="am-review-end"><?php echo e(setting('_lernen.well_wishing_text')); ?></span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
        <?php if (isset($component)) { $__componentOriginald3ddbb50354007a547c14bd23123e2ab = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald3ddbb50354007a547c14bd23123e2ab = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.completion','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('completion'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald3ddbb50354007a547c14bd23123e2ab)): ?>
<?php $attributes = $__attributesOriginald3ddbb50354007a547c14bd23123e2ab; ?>
<?php unset($__attributesOriginald3ddbb50354007a547c14bd23123e2ab); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald3ddbb50354007a547c14bd23123e2ab)): ?>
<?php $component = $__componentOriginald3ddbb50354007a547c14bd23123e2ab; ?>
<?php unset($__componentOriginald3ddbb50354007a547c14bd23123e2ab); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal9848963a7b8fd4bfd3d4937c45a7dfb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9848963a7b8fd4bfd3d4937c45a7dfb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dispute-reason-popup','data' => ['booking' => $userBooking,'disputeReason' => $disputeReason,'description' => $description,'selectedReason' => $selectedReason]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dispute-reason-popup'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['booking' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($userBooking),'disputeReason' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($disputeReason),'description' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($description),'selectedReason' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($selectedReason)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9848963a7b8fd4bfd3d4937c45a7dfb4)): ?>
<?php $attributes = $__attributesOriginal9848963a7b8fd4bfd3d4937c45a7dfb4; ?>
<?php unset($__attributesOriginal9848963a7b8fd4bfd3d4937c45a7dfb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9848963a7b8fd4bfd3d4937c45a7dfb4)): ?>
<?php $component = $__componentOriginal9848963a7b8fd4bfd3d4937c45a7dfb4; ?>
<?php unset($__componentOriginal9848963a7b8fd4bfd3d4937c45a7dfb4); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc3c8c472b571ebc244c7fd652e2df334 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc3c8c472b571ebc244c7fd652e2df334 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.booking-detail-modal','data' => ['currentBooking' => $currentBooking,'wire:key' => ''.e(time()).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('booking-detail-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['currentBooking' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentBooking),'wire:key' => ''.e(time()).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc3c8c472b571ebc244c7fd652e2df334)): ?>
<?php $attributes = $__attributesOriginalc3c8c472b571ebc244c7fd652e2df334; ?>
<?php unset($__attributesOriginalc3c8c472b571ebc244c7fd652e2df334); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3c8c472b571ebc244c7fd652e2df334)): ?>
<?php $component = $__componentOriginalc3c8c472b571ebc244c7fd652e2df334; ?>
<?php unset($__componentOriginalc3c8c472b571ebc244c7fd652e2df334); ?>
<?php endif; ?>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
<?php echo app('Illuminate\Foundation\Vite')([
    'public/css/flatpicker.css',
    'public/css/flatpicker-month-year-plugin.css'
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script defer src="<?php echo e(asset('js/flatpicker.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/weekSelect.min.js')); ?>"></script>
<script defer src="<?php echo e(asset('js/flatpicker-month-year-plugin.js')); ?>"></script>
<?php $__env->stopPush(); ?>

    <?php
        $__scriptKey = '735971364-0';
        ob_start();
    ?>
<script>
    let flatpickrInstance = null;
        initFlatPicker('<?php echo e($showBy); ?>', 'today');
        $wire.dispatch('initSelect2', {target:'.am-select2'})
        document.addEventListener('initCalendarJs', (event)=>{
            setTimeout(() => {
                initFlatPicker(event.detail.showBy, event.detail.currentDate, event.detail.range);
            }, 100);
        })
        function initFlatPicker(showBy, currentDate, range=[]) {
            if (flatpickrInstance) {
                flatpickrInstance.destroy();
            }
            let config = {
                defaultDate : currentDate,
                disableMobile: true,
                onChange : function(selectedDates, dateStr, instance) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('jumpToDate', dateStr);
                }
            }
            if('<?php echo e(auth()->user()->role); ?>' == 'tutor') {
                config = {...config, minDate: <?php echo \Illuminate\Support\Js::from(\Carbon\Carbon::now(getUserTimezone())->toDateString())->toHtml() ?>}
            }
            if(showBy == 'daily') {
                config = {
                    ...config,
                    altInput: true,
                    altFormat: "F j, Y",
                    dateFormat: "Y-m-d"
                };
            } else if (showBy == 'weekly') {
                config = {
                    ...config,
                    defaultDate: parseDateRange(currentDate),
                    minDate: <?php echo \Illuminate\Support\Js::from(\Carbon\Carbon::now(getUserTimezone())->toDateString())->toHtml() ?>,
                    plugins: [
                        new weekSelect({
                            weekStart: <?php echo \Illuminate\Support\Js::from($startOfWeek)->toHtml() ?>
                        })
                    ],
                    dateFormat: 'Y-m-d',
                    onReady: function(selectedDates, dateStr, instance) {
                        instance.input.value = currentDate
                    }
                };
            } else {
                config = {
                    ...config,
                        plugins: [
                            new monthSelectPlugin({
                                shorthand: true,
                                dateFormat: "F, Y",
                            })
                        ],
                };
            }
            flatpickrInstance = flatpickr($(`#flat-picker`), config);
            recalculateTdWidth();
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
        function recalculateTdWidth() {
            let table = document.getElementById("dailytable");
            if (table == null) {
                return;
            }
            let tds = table.querySelectorAll("tbody td:nth-child(2)");
            let th = table.querySelector("thead th:nth-child(2)");

            let maxWidth = 0;
            
            tds.forEach(td => {
                maxWidth = Math.max(maxWidth, td.scrollWidth);
            });
            console.log(maxWidth);
            th.style.minWidth = maxWidth + "px";
        }
        window.addEventListener("resize", recalculateTdWidth);
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/common/bookings/user-booking.blade.php ENDPATH**/ ?>