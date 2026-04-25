<div class="am-profile-setting am-managesessions_wrap">
    @slot('title')
        {{ __('calendar.title') }}
    @endslot
    @include('livewire.pages.tutor.manage-sessions.tabs')
    <div class="am-section-load" wire:loading.flex wire:target="updatedCurrentMonth,jumpToDate,updatedCurrentYear,previousMonthCalendar,nextMonthCalendar">
        <p>{{ __('general.loading') }}</p>
    </div>
    <div class="am-booking-wrapper">
        <div class="am-booking-calander">
            <div class="am-booking-calander_header">
                <h1>{{ __('calendar.title') }} </h1>
                <div>
                    <div class="am-booking-filters-wrapper">
                        <div class="am-booking-calander-day">
                            <i wire:click="previousMonthCalendar('{{ $currentDate }}')">
                                <i class="am-icon-chevron-left"></i>
                            </i>
                            <span @if(parseToUserTz($currentDate)->isToday()) disabled @else wire:click="jumpToDate()" @endif>
                                {{ __('calendar.today') }}
                            </span>
                            <i wire:click="nextMonthCalendar('{{ $currentDate }}')">
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
                                        @this.set('subjectGroupIds', $(selectElement).select2('val'));
                                    }
                                }"
                                >
                                <fieldset>
                                    <div class="form-group">
                                        <label>{{ __('calendar.subject_placeholder') }}</label>
                                        <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                            <select id="filter_subject_group" data-componentid="@this" class="am-select2" data-class="subject-dropdown-select2" data-format="custom" data-searchable="true" data-wiremodel="subjectGroupIds" data-placeholder="{{ __('calendar.subject_placeholder') }}" multiple>
                                                <option label="{{ __('calendar.subject_placeholder') }}"></option>
                                                @foreach ($subjectGroups as $sbjGroup)
                                                    @if ($sbjGroup->subjects->isEmpty())
                                                        @continue
                                                    @endif
                                                    <optgroup label="{{ $sbjGroup->group->name }}">
                                                        @if ($sbjGroup->subjects)
                                                            @foreach ($sbjGroup->subjects as $sbj)
                                                                <option value="{{ $sbj->pivot->id }}" data-price="{{ formatAmount($sbj->pivot->hour_rate) }}">{{ $sbj->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </optgroup>
                                                @endforeach
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
                                    <button class="am-btn" @click="submitFilter()">{{ __('general.apply_filter') }}</button>
                                </fieldset>
                            </form>
                        </div>

                        <button class="am-btn" x-on:click="$wire.dispatch('toggleModel', {id:'booking-modal',action:'show'})">
                            {{ __('calendar.add_new_session') }}
                            <i class="am-icon-plus-02"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="am-booking-calander_body">
                <table class="am-full-calander">
                    <thead>
                        <tr>
                            @foreach ($days as $day)
                                <th class="{{ (setting('_lernen.start_of_week') ?? \Carbon\Carbon::SUNDAY) == $day['week_day'] ? 'am-calendar_offday' : '' }}">{{ $day['short_name'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @while ($startOfCalendar <= $endOfCalendar)
                            <tr>
                                @for ($i = 0; $i < 7; $i++)
                                    <td>
                                        <a
                                            wire:key="{{ time() }}"
                                            @if(empty($availableSlots[parseToUserTz($startOfCalendar)->toDateString()]))
                                                href="#"
                                                x-on:click="$wire.dispatch('toggleModel', {id:'booking-modal',action:'show'})"
                                            @else
                                                href="{{ route('tutor.bookings.session-detail', ['date' => parseToUserTz($startOfCalendar)->toDateString()]) }}"
                                                wire:navigate.remove
                                            @endif
                                            @class([
                                                'am-full-calander-days',
                                                'am-active' => parseToUserTz($startOfCalendar)->isToday(),
                                                'am-outside-calendar' => parseToUserTz($startOfCalendar)->format('m') != parseToUserTz($currentDate)->format('m'),
                                                'am-empty-slots' => empty($availableSlots[$startOfCalendar->toDateString()])
                                            ])
                                        >
                                        @if(!empty($availableSlots[parseToUserTz($startOfCalendar)->toDateString()]))
                                            @php
                                                $availableSeats = $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots'] - $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['booked_slots'];
                                                $percentage = round(($availableSeats / $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots'] * 100), 2);
                                            @endphp
                                            <div class="am-slots-count">
                                                <em> <strong>{{ $availableSeats  }}</strong>/ {{ $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots'] }} {{ __('calendar.left') }}</em>
                                                <progress class="am-progress" value="{{ $percentage }}" max="100"></progress>
                                            </div>
                                            <span class="am-custom-tooltip">
                                                {{ parseToUserTz($startOfCalendar)->format('j') }}
                                                <div class="am-slots-count am-tooltip-text">
                                                    <em> <strong>{{ $availableSeats  }}</strong>/ {{ $availableSlots[parseToUserTz($startOfCalendar)->toDateString()]['all_slots'] }} {{ __('calendar.left') }}</em>
                                                    <progress class="am-progress" value="{{ $percentage }}" max="100"></progress>
                                                </div>
                                            </span>
                                        @else
                                            <span class="am-custom-tooltip">
                                                {{ parseToUserTz($startOfCalendar)->format('j') }}
                                            </span>
                                        @endif
                                        </a>
                                    </td>
                                    @php
                                        $startOfCalendar->addDay();
                                    @endphp
                                @endfor
                            </tr>
                        @endwhile
                    </tbody>
                </table>
            </div>
        </div>

        <!-- booking detail modal  -->
        <div class="modal am-modal am-session-modal fade" id="booking-modal" data-bs-backdrop="static" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="am-modal-header">
                        <h2>{{ __('calendar.add_session') }}</h2>
                        <span class="am-closepopup" data-bs-dismiss="modal" wire:loading.attr="disabled">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                    </div>
                    <div class="am-modal-body">
                        <form class="am-themeform am-session-form" wire:submit="addSession" autocomplete="off">
                            <fieldset  x-data="{
                                    days: @js($days).map(day => ({ ...day, selected: false })),
                                    selectedDays: @entangle('form.recurring_days'),
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
                                <div @class(['form-group form-group-half', 'am-invalid' => $errors->has('form.subject_group_id')])>
                                    <label class="am-label am-important">
                                        {{ __('calendar.select_subject') }}
                                    </label>
                                    <span class="am-select" wire:ignore>
                                        <select id="subject_group_id" data-componentid="@this" data-disable_onchange="true" data-live="true" class="am-select2" data-parent="#booking-modal" data-searchable="true" data-wiremodel="form.subject_group_id" data-placeholder="{{ __('calendar.subject_placeholder') }}">
                                            <option label="{{ __('calendar.subject_placeholder') }}"></option>
                                            @foreach ($subjectGroups as $sbjGroup)
                                                @if ($sbjGroup->subjects->isEmpty())
                                                    @continue
                                                @endif
                                                <optgroup label="{{ $sbjGroup->group->name }}">
                                                    @if ($sbjGroup->subjects)
                                                        @foreach ($sbjGroup->subjects as $sbj)
                                                            <option value="{{ $sbj->pivot->id }}">{{ $sbj->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </span>
                                    <x-input-error field_name="form.subject_group_id" />
                                </div>
                                <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.date_range')])>
                                    <label class="am-label am-important">{{ __('calendar.start_end_date') }}</label>
                                    <span class="am-select">
                                        <x-text-input wire:model="form.date_range" class="flat-date" placeholder="{{ __('calendar.start_end_date_placeholder') }}" 
                                                       data-min-date="today" data-modal="true" data-mode="range" data-format="Y-m-d" id="session-range" />
                                    </span>
                                    <x-input-error field_name="form.date_range" />
                                </div>
                                <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.end_time') || $errors->has('form.end_time')])>
                                    <label class="am-label am-important">{{ __('calendar.start_end_time') }}</label>
                                    <div class="am-dropdown am-startend-date" x-data="{
                                            start_time: @entangle('form.start_time'),
                                            end_time: @entangle('form.end_time'),
                                            sessionTime: '',
                                            updateValues() {
                                                this.start_time = $(this.$refs.select_start_hour).select2('val') + ':'+ $(this.$refs.select_start_min).select2('val')
                                                this.end_time   = $(this.$refs.select_end_hour).select2('val') + ':'+ $(this.$refs.select_end_min).select2('val')
                                                this.sessionTime = this.start_time != ':' && this.end_time != ':' ? this.start_time + ' to '+ this.end_time : ''
                                                $('.booking-time').dropdown('toggle');
                                            }
                                        }">
                                        <input type="text" id="session_time" x-model="sessionTime" data-bs-auto-close="outside" class="form-control am-input-field" placeholder="{{ __('calendar.time_placeholder') }}" data-bs-toggle="dropdown" readonly>
                                        <div class="dropdown-menu booking-time">
                                            <ul class="am-dropdownlist">
                                                <li>
                                                    <label class="am-label am-important">{{ __('calendar.start_time') }}</label>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_start_hour" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                                            <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                                            @for ($i=0; $i < 24; $i++)
                                                                <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_start_min" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                                            <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                                            @for ($i=0; $i < 60; $i++)
                                                                <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </span>
                                                </li>
                                                <li>
                                                    <label class="am-label am-important">{{ __('calendar.end_time') }}</label>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_end_hour" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.hour_placeholder') }}">
                                                            <option label="{{ __('calendar.hour_placeholder') }}"></option>
                                                            @for ($i=0; $i < 24; $i++)
                                                                <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </span>
                                                </li>
                                                <li>
                                                    <span class="am-select" wire:ignore>
                                                        <select x-ref="select_end_min" data-componentid="@this" class="am-select2" data-parent=".booking-time" data-searchable="true" data-placeholder="{{ __('calendar.minute_placeholder') }}">
                                                            <option label="{{ __('calendar.minute_placeholder') }}"></option>
                                                            @for ($i=0; $i < 60; $i++)
                                                                <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }}</option>
                                                            @endfor
                                                        </select>
                                                    </span>
                                                </li>
                                            </ul>
                                            <button type="button" x-on:click="updateValues()" class="am-btn">{{ __('calendar.add_time') }}</button>
                                        </div>
                                    </div>
                                    @if($errors->has('form.start_time'))
                                        <x-input-error field_name="form.start_time" />
                                    @else
                                        <x-input-error field_name="form.end_time" />
                                    @endif
                                </div>
                                <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.duration')])>
                                    <label class="am-label am-important">{{ __('calendar.session_duration') }}</label>
                                    <span class="am-select" wire:ignore>
                                        <select id="session_duration" data-componentid="@this" class="am-select2" data-parent="#booking-modal" data-searchable="true" data-wiremodel="form.duration" data-placeholder="{{ __('calendar.session_duration_placeholder') }}">
                                            <option value="">{{ __('calendar.session_duration_placeholder') }}</option>
                                            <option value="5">{{ __('calendar.minutes', ['min'=>5]) }}</option>
                                            <option value="10">{{ __('calendar.minutes', ['min'=>10]) }}</option>
                                            <option value="15">{{ __('calendar.minutes', ['min'=>15]) }}</option>
                                            <option value="20">{{ __('calendar.minutes', ['min'=>20]) }}</option>
                                            <option value="25">{{ __('calendar.minutes', ['min'=>25]) }}</option>
                                            <option value="30">{{ __('calendar.minutes', ['min'=>30]) }}</option>
                                            <option value="35">{{ __('calendar.minutes', ['min'=>35]) }}</option>
                                            <option value="40">{{ __('calendar.minutes', ['min'=>40]) }}</option>
                                            <option value="45">{{ __('calendar.minutes', ['min'=>45]) }}</option>
                                            <option value="50">{{ __('calendar.minutes', ['min'=>50]) }}</option>
                                            <option value="55">{{ __('calendar.minutes', ['min'=>55]) }}</option>
                                            <option value="60">{{ __('calendar.one_hour') }}</option>
                                            <option value="120">{{ __('calendar.hours', ['hour'=>2]) }}</option>
                                            <option value="180">{{ __('calendar.hours', ['hour'=>3]) }}</option>
                                            <option value="240">{{ __('calendar.hours', ['hour'=>4]) }}</option>
                                        </select>
                                    </span>
                                    <x-input-error field_name="form.duration" />
                                </div>
                                <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.break')])>
                                    <label class="am-label am-important">{{ __('calendar.break_time') }}</label>
                                    <span class="am-select" wire:ignore>
                                        <select id="session_break" data-componentid="@this" class="am-select2" data-parent="#booking-modal" data-searchable="true" data-wiremodel="form.break" data-placeholder="{{ __('calendar.break_time_placeholder') }}">
                                            <option label="{{ __('calendar.break_time_placeholder') }}"></option>
                                            <option value="0">{{ __('calendar.no_break') }}</option>
                                            <option value="5">{{ __('calendar.minutes', ['min'=>5]) }}</option>
                                            <option value="10">{{ __('calendar.minutes', ['min'=>10]) }}</option>
                                            <option value="15">{{ __('calendar.minutes', ['min'=>15]) }}</option>
                                            <option value="20">{{ __('calendar.minutes', ['min'=>20]) }}</option>
                                            <option value="25">{{ __('calendar.minutes', ['min'=>25]) }}</option>
                                            <option value="30">{{ __('calendar.minutes', ['min'=>30]) }}</option>
                                            <option value="35">{{ __('calendar.minutes', ['min'=>35]) }}</option>
                                            <option value="40">{{ __('calendar.minutes', ['min'=>40]) }}</option>
                                            <option value="45">{{ __('calendar.minutes', ['min'=>45]) }}</option>
                                            <option value="50">{{ __('calendar.minutes', ['min'=>50]) }}</option>
                                            <option value="55">{{ __('calendar.minutes', ['min'=>55]) }}</option>
                                            <option value="60">{{ __('calendar.one_hour') }}</option>
                                        </select>
                                    </span>
                                    <x-input-error field_name="form.break" />
                                </div>
                                <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.spaces')])>
                                    <label class="am-label">{{ __('calendar.session_seats') }}</label>
                                    <div class="am-session-field" x-data="{spaces:@entangle('form.spaces')}">
                                        <span class="am-decrement" @click="if(spaces > 1) {spaces --}">
                                            <i class="am-icon-minus-02"></i>
                                        </span>
                                        <input type="number" x-model="spaces" class="form-control am-input-field" placeholder="01">
                                        <span class="am-increment" @click="spaces++">
                                            <i class="am-icon-plus-02"></i>
                                        </span>
                                    </div>
                                    <x-input-error field_name="form.spaces" />
                                </div>
                                @if(\Nwidart\Modules\Facades\Module::has('upcertify') && \Nwidart\Modules\Facades\Module::isEnabled('upcertify'))
                                    <div @class(['am-certificate-template', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('form.template_id')])>
                                        <label class="am-label">
                                            {{ __('calendar.certificate_template') }}
                                            <a href="javascript:void(0);" class="am-custom-tooltip">
                                                <i class="am-icon-exclamation-01"></i>
                                                <span class="am-tooltip-text">
                                                    {{ __('calendar.certificate_info') }}
                                                </span>
                                            </a>
                                        </label>
                                        <span class="am-select" wire:ignore>
                                            <select data-componentid="@this" data-wiremodel="template_id" class="am-select2" data-parent=".am-certificate-template" data-searchable="true" data-placeholder="{{ __('calendar.certificate_template_placeholder') }}">
                                                <option label="{{ __('calendar.certificate_template_placeholder') }}"></option>
                                                @foreach ($templates as $template)
                                                    <option value="{{ $template->id }}">{{ $template->title }}</option>
                                                @endforeach
                                            </select>
                                        </span>
                                        <x-input-error field_name="form.template_id" />
                                    </div>
                                @endif

                                @if(isActiveModule('upcertify') && isActiveModule('quiz'))
                                    <div @class(['am-certificate-quiz', 'form-group', 'form-group-half', 'am-invalid' => $errors->has('assign_quiz_certificate')])>
                                        <label class="am-label">
                                            {{ __('calendar.assign_certificate') }}
                                            <a href="javascript:void(0);" class="am-custom-tooltip">
                                                <i class="am-icon-exclamation-01"></i>
                                                <span class="am-tooltip-text">
                                                    {{ __('calendar.assign_certificate_info') }}
                                                </span>
                                            </a>
                                        </label>
                                        <span class="am-select" wire:ignore>
                                            <select data-componentid="@this" data-wiremodel="assign_quiz_certificate" class="am-select2" data-parent=".am-certificate-quiz" data-searchable="true" data-placeholder="{{ __('calendar.certificate_template_placeholder') }}">
                                                <option label="{{ __('calendar.certificate_template_placeholder') }}"></option>
                                                    <option value="any">{{ __('calendar.any_quizzes') }}</option>
                                                    <option value="all">{{ __('calendar.all_quizzes') }}</option>
                                                    <option value="none">{{ __('calendar.no_quizzes') }}</option>
                                            </select>
                                        </span>
                                        <x-input-error field_name="assign_quiz_certificate" />
                                    </div>
                                @endif

                                @if(\Nwidart\Modules\Facades\Module::has('subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('subscriptions') && setting('_lernen.subscription_sessions_allowed') == 'tutor')
                                    <div class="form-group form-group-half">
                                        <div class="am-switchbtn-box">
                                            <label for="" class="am-label">{{ __('subscriptions::subscription.allowed_for_subscriptions') }}</label>
                                            <div class="am-switchbtn">
                                                <label for="allowed_for_subscriptions" class="cr-label">{{ __('subscriptions::subscription.disabled')  }}</label>
                                                <input type="checkbox" id="allowed_for_subscriptions" class="cr-toggle" wire:model="allowed_for_subscriptions" value="1">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (isPaidSystem())
                                    <div @class(['form-group', 'form-group-half', 'am-invalid' => $errors->has('form.session_fee')])>
                                        <label class="am-label am-important">{{ __('calendar.session_fee') }}</label>
                                        <div class="am-addfee">
                                            <input type="text" wire:model="form.session_fee" class="form-control am-input-field" placeholder="{{ __('calendar.session_fee_placeholder') }}" />
                                            <span class="am-addfee_icon">{{ getCurrencySymbol() }}</span>
                                        </div>
                                        <x-input-error field_name="form.session_fee" />
                                    </div>
                                @endif
                                <div class="form-group form-group-half">
                                    <label class="am-label">{{ __('calendar.recurring_booking') }}</label>
                                    <div class="am-select-days">
                                        <input type="text" class="form-control am-input-field" data-bs-auto-close="outside" placeholder="{{ __('calendar.select_from_list') }}" data-bs-toggle="dropdown">
                                        <div class="dropdown-menu">
                                            <div class="am-checkbox">
                                                <input type="checkbox" x-model="allSelected" id="select-all" name="days" @change="toggleAll($event.target.checked)">
                                                <label for="select-all">{{ __('calendar.select_all_days') }}</label>
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
                                <div @class(['form-group', 'am-invalid' => $errors->has('form.description')])>
                                    <div class="am-label-wrap">
                                        <label class="am-label am-important">{{ __('calendar.session_description') }}</label>
                                        @if(setting('_ai_writer_settings.enable_on_sessions_settings') == '1')
                                            <button type="button" class="am-ai-btn" data-bs-toggle="modal" data-bs-target="#aiModal" data-prompt-type="sessions" data-parent-model-id="booking-modal" data-target-selector="#session-desc" data-target-summernote="true">
                                                <img src="{{ asset('images/ai-icon.svg') }}" alt="AI">
                                                {{ __('general.write_with_ai') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="am-custom-editor" wire:ignore>
                                        <textarea id="session-desc" class="form-control" placeholder="{{ __('calendar.add_session_description') }}"></textarea>
                                        <span class="characters-count"></span>
                                    </div>
                                    <x-input-error field_name="form.description" />
                                </div>
                                <div class="form-group am-mt-10 am-form-btn-wrap">
                                    <button type="submit" class="am-btn" wire:loading.class="am-btn_disable">{{ __('general.save_update') }}</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    @vite([
        'public/css/flatpicker.css',
        'public/css/flatpicker-month-year-plugin.css',
        'public/summernote/summernote-lite.min.css'
    ])
@endpush
@push('scripts')
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>
@endpush

@script
    <script>
        let component = $wire;
        if(!component) {
            component = eval(@this);
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
                    @this.call('jumpToDate', dateStr);
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
            jQuery(this).parent('.am-switchbtn').find('.cr-label').text(jQuery(this).prop('checked') ? '{{ __('subscriptions::subscription.enabled') }}' : '{{ __('subscriptions::subscription.disabled') }}');
        });
    </script>
@endscript
