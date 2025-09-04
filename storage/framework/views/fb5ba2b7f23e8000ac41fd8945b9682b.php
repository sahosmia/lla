<div class="am-profile-setting am-managesessions_wrap">
    <?php $__env->slot('title'); ?>
        <?php echo e(__('calendar.title')); ?>

    <?php $__env->endSlot(); ?>
    <?php echo $__env->make('livewire.pages.tutor.manage-sessions.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="am-section-load" wire:loading.flex wire:target="updatedCurrentMonth,jumpToDate,updatedCurrentYear,previousMonthCalendar,nextMonthCalendar">
        <p><?php echo e(__('general.loading')); ?></p>
    </div>
    <div class="am-booking-wrapper">
        <div class="am-booking-calander">
            <div class="am-booking-calander_header">
                <h1><?php echo e(__('calendar.title')); ?> </h1>
                <div>
                    <div class="am-booking-filters-wrapper">
                        <div class="am-booking-calander-day">
                            <i wire:click="previousMonthCalendar('<?php echo e($currentDate); ?>')">
                                <i class="am-icon-chevron-left"></i>
                            </i>
                            <span <?php if(parseToUserTz($currentDate)->isToday()): ?> disabled <?php else: ?> wire:click="jumpToDate()" <?php endif; ?>>
                                <?php echo e(__('calendar.today')); ?>

                            </span>
                            <i wire:click="nextMonthCalendar('<?php echo e($currentDate); ?>')">
                                <i class="am-icon-chevron-right"></i>
                            </i>
                        </div>
                        <div class="am-booking-calander-date flatpicker">
                            <input type="text" class="form-control" id="calendar-month-year">
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
                                        const selectElement = document.getElementById('filter_subject_group');
                                        window.Livewire.find('<?php echo e($_instance->getId()); ?>').set('subjectGroupIds', $(selectElement).select2('val'));
                                    }
                                }"
                                >
                                <fieldset>
                                    <div class="form-group">
                                        <label><?php echo e(__('calendar.subject_placeholder')); ?></label>
                                        <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                            <select id="filter_subject_group" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-class="subject-dropdown-select2" data-format="custom" data-searchable="true" data-wiremodel="subjectGroupIds" data-placeholder="<?php echo e(__('calendar.subject_placeholder')); ?>" multiple>
                                                <option label="<?php echo e(__('calendar.subject_placeholder')); ?>"></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjectGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sbjGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <!--[if BLOCK]><![endif]--><?php if($sbjGroup->subjects->isEmpty()): ?>
                                                        <?php continue; ?>
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    <optgroup label="<?php echo e($sbjGroup->group->name); ?>">
                                                        <!--[if BLOCK]><![endif]--><?php if($sbjGroup->subjects): ?>
                                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sbjGroup->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sbj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($sbj->pivot->id); ?>" data-price="<?php echo e(formatAmount($sbj->pivot->hour_rate)); ?>"><?php echo e($sbj->name); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                    </optgroup>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </span>
                                    </div>
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
                                    <button class="am-btn" @click="submitFilter()"><?php echo e(__('general.apply_filter')); ?></button>
                                </fieldset>
                            </form>
                        </div>

                        <button class="am-btn" x-on:click="$wire.dispatch('toggleModel', {id:'booking-modal',action:'show'})">
                            <?php echo e(__('calendar.add_new_session')); ?>

                            <i class="am-icon-plus-02"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="am-booking-calander_body">
                <table class="am-full-calander">
                    <thead>
                        <tr>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="<?php echo e((setting('_lernen.start_of_week') ?? \Carbon\Carbon::SUNDAY) == $day['week_day'] ? 'am-calendar_offday' : ''); ?>"><?php echo e($day['short_name']); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </tr>
                    </thead>
                    <tbody>
                        <!--[if BLOCK]><![endif]--><?php while($startOfCalendar <= $endOfCalendar): ?>
                            <tr>
                                <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 7; $i++): ?>
                                    <td>
                                        <a
                                            wire:key="<?php echo e(time()); ?>"
                                            <?php if(empty($availableSlots[parseToUserTz($startOfCalendar)->toDateString()])): ?>
                                                href="#"
                                                x-on:click="$wire.dispatch('toggleModel', {id:'booking-modal',action:'show'})"
                                            <?php else: ?>
                                                href="<?php echo e(route('tutor.bookings.session-detail', ['date' => parseToUserTz($startOfCalendar)->toDateString()])); ?>"
                                                wire:navigate.remove
                                            <?php endif; ?>
                                            class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                                'am-full-calander-days',
                                                'am-active' => parseToUserTz($startOfCalendar)->isToday(),
                                                'am-outside-calendar' => parseToUserTz($startOfCalendar)->format('m') != parseToUserTz($currentDate)->format('m'),
                                                'am-empty-slots' => empty($availableSlots[$startOfCalendar->toDateString()])
                                            ]); ?>"
                                        >
                                        <!--[if BLOCK]><![endif]--><?php if(!empty($availableSlots[parseToUserTz($startOfCalendar)->toDateString()])): ?>
                                            <?php
                                                $availableSeats = $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots'] - $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['booked_slots'];
                                                $percentage = round(($availableSeats / $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots'] * 100), 2);
                                            ?>
                                            <div class="am-slots-count">
                                                <em> <strong><?php echo e($availableSeats); ?></strong>/ <?php echo e($availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots']); ?> <?php echo e(__('calendar.left')); ?></em>
                                                <progress class="am-progress" value="<?php echo e($percentage); ?>" max="100"></progress>
                                            </div>
                                            <span class="am-custom-tooltip">
                                                <?php echo e(parseToUserTz($startOfCalendar)->format('j')); ?>

                                                <div class="am-slots-count am-tooltip-text">
                                                    <em> <strong><?php echo e($availableSeats); ?></strong>/ <?php echo e($availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots']); ?> <?php echo e(__('calendar.left')); ?></em>
                                                    <progress class="am-progress" value="<?php echo e($percentage); ?>" max="100"></progress>
                                                </div>
                                            </span>
                                        <?php else: ?>
                                            <span class="am-custom-tooltip">
                                                <?php echo e(parseToUserTz($startOfCalendar)->format('j')); ?>

                                            </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </a>
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
        </div>

        <!-- booking detail modal  -->
        <div class="modal am-modal am-session-modal fade" id="booking-modal" data-bs-backdrop="static" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2><?php echo e(__('calendar.add_session')); ?></h2>
                        <span class="am-closepopup" data-bs-dismiss="modal" wire:loading.attr="disabled">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform am-session-form" wire:submit="addSession" autocomplete="off">
                            <fieldset  x-data="{
                                    days: <?php echo \Illuminate\Support\Js::from($days)->toHtml() ?>.map(day => ({ ...day, selected: false })),
                                    selectedDays: <?php if ((object) ('form.recurring_days') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.recurring_days'->value()); ?>')<?php echo e('form.recurring_days'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.recurring_days'); ?>')<?php endif; ?>,
                                    allSelected:false,
                                    updateSelectedDays() {
                                        this.selectedDays = this.days.filter(day => day.selected).map(day => day.name);
                                        this.allSelected = this.days.every(day => day.selected);
                                    },
                                    toggleAll(selected) {
                                        this.days.forEach(day => day.selected = selected);
                                        this.updateSelectedDays();
                                    },
                                    removeDay(value) {
                                        this.days.find(day => day.name === value).selected = false;
                                        this.updateSelectedDays();
                                    }
                                    }">
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group form-group-half', 'am-invalid' => $errors->has('form.subject_group_id')]); ?>">
                                    <label class="am-label am-important">
                                        <?php echo e(__('calendar.select_subject')); ?>

                                    </label>
                                    <span class="am-select" wire:ignore>
                                        <select id="subject_group_id" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-disable_onchange="true" data-live="true" class="am-select2" data-parent="#booking-modal" data-searchable="true" data-wiremodel="form.subject_group_id" data-placeholder="<?php echo e(__('calendar.subject_placeholder')); ?>">
                                            <option label="<?php echo e(__('calendar.subject_placeholder')); ?>"></option>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjectGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sbjGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <!--[if BLOCK]><![endif]--><?php if($sbjGroup->subjects->isEmpty()): ?>
                                                    <?php continue; ?>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                <optgroup label="<?php echo e($sbjGroup->group->name); ?>">
                                                    <!--[if BLOCK]><![endif]--><?php if($sbjGroup->subjects): ?>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sbjGroup->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sbj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($sbj->pivot->id); ?>"><?php echo e($sbj->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                </optgroup>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </select>
                                    </span>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.subject_group_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.subject_group_id']); ?>
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
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.date_range')]); ?>">
                                    <label class="am-label am-important"><?php echo e(__('calendar.start_end_date')); ?></label>
                                    <span class="am-select">
                                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['wire:model' => 'form.date_range','class' => 'flat-date','placeholder' => ''.e(__('calendar.start_end_date_placeholder')).'','dataMinDate' => 'today','dataModal' => 'true','dataMode' => 'range','dataFormat' => 'Y-m-d','id' => 'session-range']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'form.date_range','class' => 'flat-date','placeholder' => ''.e(__('calendar.start_end_date_placeholder')).'','data-min-date' => 'today','data-modal' => 'true','data-mode' => 'range','data-format' => 'Y-m-d','id' => 'session-range']); ?>
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
                                    </span>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.date_range']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.date_range']); ?>
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
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.end_time') || $errors->has('form.end_time')]); ?>">
                                    <label class="am-label am-important"><?php echo e(__('calendar.start_end_time')); ?></label>
                                    <div class="am-dropdown am-startend-date" x-data="{
                                            start_time: <?php if ((object) ('form.start_time') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.start_time'->value()); ?>')<?php echo e('form.start_time'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.start_time'); ?>')<?php endif; ?>,
                                            end_time: <?php if ((object) ('form.end_time') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.end_time'->value()); ?>')<?php echo e('form.end_time'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.end_time'); ?>')<?php endif; ?>,
                                            sessionTime: '',
                                            updateValues() {
                                                this.start_time = $(this.$refs.select_start_hour).select2('val') + ':'+ $(this.$refs.select_start_min).select2('val')
                                                this.end_time   = $(this.$refs.select_end_hour).select2('val') + ':'+ $(this.$refs.select_end_min).select2('val')
                                                this.sessionTime = this.start_time != ':' && this.end_time != ':' ? this.start_time + ' to '+ this.end_time : ''
                                                $('.booking-time').dropdown('toggle');
                                            }
                                        }">
                                        <input type="text" id="session_time" x-model="sessionTime" data-bs-auto-close="outside" class="form-control am-input-field" placeholder="<?php echo e(__('calendar.time_placeholder')); ?>" data-bs-toggle="dropdown" readonly>
                                        <div class="dropdown-menu booking-time">
                                            <ul class="am-dropdownlist">
                                                <li>
                                                    <label class="am-label am-important"><?php echo e(__('calendar.start_time')); ?></label>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_start_hour" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                                            <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                                            <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 24; $i++): ?>
                                                                <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </select>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_start_min" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                                            <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                                            <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 60; $i++): ?>
                                                                <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </select>
                                                    </span>
                                                </li>
                                                <li>
                                                    <label class="am-label am-important"><?php echo e(__('calendar.end_time')); ?></label>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_end_hour" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.hour_placeholder')); ?>">
                                                            <option label="<?php echo e(__('calendar.hour_placeholder')); ?>"></option>
                                                            <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 24; $i++): ?>
                                                                <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </select>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_end_min" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="<?php echo e(__('calendar.minute_placeholder')); ?>">
                                                            <option label="<?php echo e(__('calendar.minute_placeholder')); ?>"></option>
                                                            <!--[if BLOCK]><![endif]--><?php for($i=0; $i < 60; $i++): ?>
                                                                <option value="<?php echo e(sprintf("%02d", $i)); ?>"><?php echo e(sprintf("%02d", $i)); ?></option>
                                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                                        </select>
                                                    </span>
                                                </li>
                                            </ul>
                                            <button type="button" x-on:click="updateValues()" class="am-btn"><?php echo e(__('calendar.add_time')); ?></button>
                                        </div>
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if($errors->has('form.start_time')): ?>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.start_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.start_time']); ?>
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
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.end_time']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.end_time']); ?>
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
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.duration')]); ?>">
                                    <label class="am-label am-important"><?php echo e(__('calendar.session_duration')); ?></label>
                                    <span class="am-select" wire:ignore>
                                        <select id="session_duration" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#booking-modal" data-searchable="true" data-wiremodel="form.duration" data-placeholder="<?php echo e(__('calendar.session_duration_placeholder')); ?>">
                                            <option value=""><?php echo e(__('calendar.session_duration_placeholder')); ?></option>
                                            <option value="5"><?php echo e(__('calendar.minutes', ['min'=>5])); ?></option>
                                            <option value="10"><?php echo e(__('calendar.minutes', ['min'=>10])); ?></option>
                                            <option value="15"><?php echo e(__('calendar.minutes', ['min'=>15])); ?></option>
                                            <option value="20"><?php echo e(__('calendar.minutes', ['min'=>20])); ?></option>
                                            <option value="25"><?php echo e(__('calendar.minutes', ['min'=>25])); ?></option>
                                            <option value="30"><?php echo e(__('calendar.minutes', ['min'=>30])); ?></option>
                                            <option value="35"><?php echo e(__('calendar.minutes', ['min'=>35])); ?></option>
                                            <option value="40"><?php echo e(__('calendar.minutes', ['min'=>40])); ?></option>
                                            <option value="45"><?php echo e(__('calendar.minutes', ['min'=>45])); ?></option>
                                            <option value="50"><?php echo e(__('calendar.minutes', ['min'=>50])); ?></option>
                                            <option value="55"><?php echo e(__('calendar.minutes', ['min'=>55])); ?></option>
                                            <option value="60"><?php echo e(__('calendar.one_hour')); ?></option>
                                            <option value="120"><?php echo e(__('calendar.hours', ['hour'=>2])); ?></option>
                                            <option value="180"><?php echo e(__('calendar.hours', ['hour'=>3])); ?></option>
                                            <option value="240"><?php echo e(__('calendar.hours', ['hour'=>4])); ?></option>
                                        </select>
                                    </span>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.duration']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.duration']); ?>
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
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.break')]); ?>">
                                    <label class="am-label am-important"><?php echo e(__('calendar.break_time')); ?></label>
                                    <span class="am-select" wire:ignore>
                                        <select id="session_break" data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" class="am-select2" data-parent="#booking-modal" data-searchable="true" data-wiremodel="form.break" data-placeholder="<?php echo e(__('calendar.break_time_placeholder')); ?>">
                                            <option label="<?php echo e(__('calendar.break_time_placeholder')); ?>"></option>
                                            <option value="0"><?php echo e(__('calendar.no_break')); ?></option>
                                            <option value="5"><?php echo e(__('calendar.minutes', ['min'=>5])); ?></option>
                                            <option value="10"><?php echo e(__('calendar.minutes', ['min'=>10])); ?></option>
                                            <option value="15"><?php echo e(__('calendar.minutes', ['min'=>15])); ?></option>
                                            <option value="20"><?php echo e(__('calendar.minutes', ['min'=>20])); ?></option>
                                            <option value="25"><?php echo e(__('calendar.minutes', ['min'=>25])); ?></option>
                                            <option value="30"><?php echo e(__('calendar.minutes', ['min'=>30])); ?></option>
                                            <option value="35"><?php echo e(__('calendar.minutes', ['min'=>35])); ?></option>
                                            <option value="40"><?php echo e(__('calendar.minutes', ['min'=>40])); ?></option>
                                            <option value="45"><?php echo e(__('calendar.minutes', ['min'=>45])); ?></option>
                                            <option value="50"><?php echo e(__('calendar.minutes', ['min'=>50])); ?></option>
                                            <option value="55"><?php echo e(__('calendar.minutes', ['min'=>55])); ?></option>
                                            <option value="60"><?php echo e(__('calendar.one_hour')); ?></option>
                                        </select>
                                    </span>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.break']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.break']); ?>
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
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.spaces')]); ?>">
                                    <label class="am-label"><?php echo e(__('calendar.session_seats')); ?></label>
                                    <div class="am-session-field" x-data="{spaces:<?php if ((object) ('form.spaces') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.spaces'->value()); ?>')<?php echo e('form.spaces'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('form.spaces'); ?>')<?php endif; ?>}">
                                        <span class="am-decrement" @click="if(spaces > 1) {spaces --}">
                                            <i class="am-icon-minus-02"></i>
                                        </span>
                                        <input type="number" x-model="spaces" class="form-control am-input-field" placeholder="01">
                                        <span class="am-increment" @click="spaces++">
                                            <i class="am-icon-plus-02"></i>
                                        </span>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.spaces']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.spaces']); ?>
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
                                <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify')): ?>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-certificate-template', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('form.template_id')]); ?>">
                                        <label class="am-label">
                                            <?php echo e(__('calendar.certificate_template')); ?>

                                            <a href="javascript:void(0);" class="am-custom-tooltip">
                                                <i class="am-icon-exclamation-01"></i>
                                                <span class="am-tooltip-text">
                                                    <?php echo e(__('calendar.certificate_info')); ?>

                                                </span>
                                            </a>
                                        </label>
                                        <span class="am-select" wire:ignore>
                                            <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-wiremodel="template_id" class="am-select2" data-parent=".am-certificate-template" data-searchable="true" data-placeholder="<?php echo e(__('calendar.certificate_template_placeholder')); ?>">
                                                <option label="<?php echo e(__('calendar.certificate_template_placeholder')); ?>"></option>
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($template->id); ?>"><?php echo e($template->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                            </select>
                                        </span>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.template_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.template_id']); ?>
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
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if(isActiveModule('upcertify') && isActiveModule('quiz')): ?>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['am-certificate-quiz', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('assign_quiz_certificate')]); ?>">
                                        <label class="am-label">
                                            <?php echo e(__('calendar.assign_certificate')); ?>

                                            <a href="javascript:void(0);" class="am-custom-tooltip">
                                                <i class="am-icon-exclamation-01"></i>
                                                <span class="am-tooltip-text">
                                                    <?php echo e(__('calendar.assign_certificate_info')); ?>

                                                </span>
                                            </a>
                                        </label>
                                        <span class="am-select" wire:ignore>
                                            <select data-componentid="window.Livewire.find('<?php echo e($_instance->getId()); ?>')" data-wiremodel="assign_quiz_certificate" class="am-select2" data-parent=".am-certificate-quiz" data-searchable="true" data-placeholder="<?php echo e(__('calendar.certificate_template_placeholder')); ?>">
                                                <option label="<?php echo e(__('calendar.certificate_template_placeholder')); ?>"></option>
                                                    <option value="any"><?php echo e(__('calendar.any_quizzes')); ?></option>
                                                    <option value="all"><?php echo e(__('calendar.all_quizzes')); ?></option>
                                                    <option value="none"><?php echo e(__('calendar.no_quizzes')); ?></option>
                                            </select>
                                        </span>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'assign_quiz_certificate']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'assign_quiz_certificate']); ?>
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
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                <!--[if BLOCK]><![endif]--><?php if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor'): ?>
                                    <div class="form-group form-group-half">
                                        <div class="am-switchbtn-box">
                                            <label for="" class="am-label"><?php echo e(__('subscriptions::subscription.allowed_for_subscriptions')); ?></label>
                                            <div class="am-switchbtn">
                                                <label for="allowed_for_subscriptions" class="cr-label"><?php echo e(__('subscriptions::subscription.disabled')); ?></label>
                                                <input type="checkbox" id="allowed_for_subscriptions" class="cr-toggle" wire:model="allowed_for_subscriptions" value="1">
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if(isPaidSystem()): ?>
                                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.session_fee')]); ?>">
                                        <label class="am-label am-important"><?php echo e(__('calendar.session_fee')); ?></label>
                                        <div class="am-addfee">
                                            <input type="text" wire:model="form.session_fee" class="form-control am-input-field" placeholder="<?php echo e(__('calendar.session_fee_placeholder')); ?>" />
                                            <span class="am-addfee_icon"><?php echo e(getCurrencySymbol()); ?></span>
                                        </div>
                                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.session_fee']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.session_fee']); ?>
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
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div class="form-group form-group-half">
                                    <label class="am-label"><?php echo e(__('calendar.recurring_booking')); ?></label>
                                    <div class="am-select-days">
                                        <input type="text" class="form-control am-input-field" data-bs-auto-close="outside" placeholder="<?php echo e(__('calendar.select_from_list')); ?>" data-bs-toggle="dropdown">
                                        <div class="dropdown-menu">
                                            <div class="am-checkbox">
                                                <input type="checkbox" x-model="allSelected" id="select-all" name="days" @change="toggleAll($event.target.checked)">
                                                <label for="select-all"><?php echo e(__('calendar.select_all_days')); ?></label>
                                            </div>
                                            <template x-for="day in days" :key="day.id">
                                                <div class="am-checkbox">
                                                    <input type="checkbox" :id="'day-' + day.id" :value="day.name" x-model="day.selected" @change="updateSelectedDays" />
                                                    <label :for="'day-' + day.id" x-text="day.name"></label>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group am-selected-days">
                                    <template x-if="selectedDays.length > 0">
                                        <ul class="am-subject-tag-list">
                                            <template x-for="day in selectedDays">
                                                <li>
                                                    <a href="javascript:void(0)" class="am-subject-tag"  @click="removeDay(day)">
                                                        <span x-text="day"></span>
                                                        <i class="am-icon-multiply-02"></i>
                                                    </a>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                </div>
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['form-group', 'am-invalid' => $errors->has('form.description')]); ?>">
                                    <div class="am-label-wrap">
                                        <label class="am-label am-important"><?php echo e(__('calendar.session_description')); ?></label>
                                        <!--[if BLOCK]><![endif]--><?php if(setting('_ai_writer_settings.enable_on_sessions_settings') == '1'): ?>
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="sessions" data-parent-model-id="booking-modal" data-target-selector="#session-desc" data-target-summernote="true">
                                                <img src="<?php echo e(asset('images/ai-icon.svg')); ?>" alt="AI">
                                                <?php echo e(__('general.write_with_ai')); ?>

                                            </button>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="session-desc" class="form-control" placeholder="<?php echo e(__('calendar.add_session_description')); ?>"></textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['fieldName' => 'form.description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field_name' => 'form.description']); ?>
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
                                <div class="form-group am-mt-10 am-form-btn-wrap">
                                    <button type="submit" class="am-btn" wire:loading.class="am-btn_disable"><?php echo e(__('general.save_update')); ?></button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
    <?php echo app('Illuminate\Foundation\Vite')([
        'public/css/flatpicker.css',
        'public/css/flatpicker-month-year-plugin.css',
        'public/summernote/summernote-lite.min.css'
    ]); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script defer src="<?php echo e(asset('js/flatpicker.js')); ?>"></script>
    <script defer src="<?php echo e(asset('js/flatpicker-month-year-plugin.js')); ?>"></script>
    <script defer src="<?php echo e(asset('summernote/summernote-lite.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

    <?php
        $__scriptKey = '1601455282-0';
        ob_start();
    ?>
    <script>
        let component = $wire;
        if(!component) {
            component = eval(window.Livewire.find('<?php echo e($_instance->getId()); ?>'));
        }
        document.addEventListener('initCalendarJs', (event)=>{
            initCalendarJs(event.detail.currentDate);
        })
        function initCalendarJs(defaultDate) {
            $("#calendar-month-year").flatpickr({
                defaultDate: defaultDate,
                disableMobile: true,
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true, //defaults to false
                        dateFormat: "F, Y", //defaults to "F Y"
                    })
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    window.Livewire.find('<?php echo e($_instance->getId()); ?>').call('jumpToDate', dateStr);
                }
            });
        }
        document.addEventListener('loadPageJs', (event)=>{
            setTimeout(() => {
                initializeDatePicker()
            }, 100);
        })
        $(document).on('show.bs.modal','#booking-modal', function () {
            setTimeout(() => {
                initializeDatePicker()
            }, 100);
            component.set('form', {
                'subject_group_id':null,
                'date_range':null,
                'start_time':null,
                'end_time':null,
                'duration':null,
                'break':null,
                'spaces':1,
                'recurring_days':[],
                'session_fee':0,
                'description':null,
            }, false);
            $("#subject_group_id,#session_duration,#session_break").val('').trigger('change.select2');
            $('#session_time').val('');
            $(document).find("#booking-modal .am-select-days input[type=checkbox]").prop('checked', false);
            clearFormErrors('#booking-modal');
            $('#session-desc').summernote(summernoteConfigs('#session-desc','.characters-count'));
            $('#session-desc').summernote('code','');
        })
        $('#session-desc').on('summernote.change', function(we, contents, $editable) {
            component.set("form.description",contents, false);
        });
        component.dispatch('initSelect2', {target:'.am-select2'})
        jQuery(document).on('change', '#allowed_for_subscriptions', function() {
            jQuery(this).parent('.am-switchbtn').find('.cr-label').text(jQuery(this).prop('checked') ? '<?php echo e(__('subscriptions::subscription.enabled')); ?>' : '<?php echo e(__('subscriptions::subscription.disabled')); ?>');
        });
    </script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH /home/clientagaintheme/lla.client.againtheme.com/resources/views/livewire/pages/tutor/manage-sessions/my-calendar.blade.php ENDPATH**/ ?>