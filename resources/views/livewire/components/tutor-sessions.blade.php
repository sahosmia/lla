
<div class="am-userinfo_section"  wire:init="loadPage" x-data="{
    defaultTimeZone: Intl.DateTimeFormat().resolvedOptions().timeZone,
    timezone: $wire.entangle('timezone'),
    }"
    x-init="if(!timezone) {
        $wire.set('timezone', defaultTimeZone, false);
    }">
    @if(empty($pageLoaded))
        <div class="am-booking-skeleton">
            @include('skeletons.book-sessions')
        </div>
    @else
        <div class="d-none" wire:target="jumpToDate, nextBookings, previousBookings, timezone, filter" wire:loading.class.remove="d-none">
            @include('skeletons.book-sessions')
        </div>
        <div class="am-userinfo_content" wire:loading.class="d-none" wire:target="jumpToDate, nextBookings, previousBookings, timezone, filter">
            @php
                $show_all = false;
                $showAll = array();
            @endphp
            <div class="am-booksession-title">
                <h3>{{ __('tutor.book_session') }}</h3>   
                <button class="am-btn" wire:click='openModel' wire:loading.class="am-btn_disable" wire:target="openModel">{{ __('tutor.request_a_session') }}</button>
            </div>
            <div class="am-booking-calander">
                <div class="am-booking-calander_header">
                    <div class="am-booking-dates-slot">
                        <div class="am-booking-calander-day">
                            <a href="javascript:void(0);" @if($isCurrent) disabled @else wire:click="jumpToDate()" @endif >
                                {{ __('calendar.today') }}
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
                                    data-componentid="@this"
                                    class="am-customselect"
                                    value="{{$timezone}}"
                                    data-searchable="true"
                                    id="timezone"
                                    data-live="true"
                                    data-wiremodel="timezone"
                                    data-placeholder="{{ __('settings.timezone_placeholder') }}"
                                >
                                    <option value=""></option>
                                    @foreach (timezone_identifiers_list() as $tz)
                                        <option value="{{ $tz }}" x-bind:selected="timezone == '{{ $tz }}'" >{{ $tz }}</option>
                                    @endforeach
                                </select>
                                <div class="am-tooltipicon am-custom-tooltip">
                                    <span class="am-tooltip-text">
                                        <span>{{ __('tutor.tooltip_text') }}</span>
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
                                        @this.set('filter', filters);
                                    }
                                }"
                                >
                                <fieldset>
                                    <div class="form-group">
                                        <label>{{ __('calendar.session_type_placeholder') }}</label>
                                        <span class="am-select am-filter-select" wire:ignore>
                                            <select id="type_fiter" data-componentid="@this" data-parent=".am-filter-list" class="am-customselect" data-searchable="false" data-wiremodel="filter.type">
                                                <option value="*">{{ __('calendar.show_all_type') }}</option>
                                                <option value="one">{{ __('calendar.one') }}</option>
                                                <option value="group">{{ __('calendar.group') }}</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('calendar.subject_placeholder') }}</label>
                                        <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                            <select id="filter_subject_group" data-componentid="@this" data-parent=".am-filter-list" class="am-customselect" data-class="subject-dropdown-select2" data-format="custom" data-searchable="true" data-wiremodel="filter.subject_group_ids" data-placeholder="{{ __('calendar.subject_placeholder') }}" multiple>
                                                <option label="{{ __('calendar.subject_placeholder') }}"></option>
                                                    @if(!empty($subjectGroups))
                                                        @foreach ($subjectGroups as $group)
                                                            <optgroup label="{{ $group['group_name'] }}">
                                                                @foreach ($group['subjects'] as $subject)
                                                                    <option value="{{ $subject['id'] }}"
                                                                        data-price="{{ formatAmount($subject['hour_rate']) }}">
                                                                        {{ $subject['subject_name'] }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    @endif
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
                                        <button class="am-btn" @click="submitFilter()">{{ __('general.apply_filter') }}</button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="am-booking-calander_body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="weeklytab">
                            <a class="tab-pane_leftarrow" href="javascript:void(0);" @if($disablePrevious) disabled @else wire:click="previousBookings" @endif>
                                <i class="am-icon-chevron-left"></i>
                            </a>
                            <div class="am-booksession-details">
                                <table class="am-booking-weekly-clander">
                                    <thead>
                                        <tr>
                                            @for ($date = $currentDate->copy()->startOfWeek($startOfWeek); $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek))); $date->addDay())
                                                {{-- <th @class(['active' => $date->isToday()])> --}}
                                                <th @class(['active' => $selectedDate === $date->toDateString()])>
                                                    <a href="javascript:void(0);" class="text-decoration-none" wire:click.prevent="showSlotsForDate('{{ $date->toDateString() }}')">
                                                        <div class="am-booking-calander-title">
                                                            <strong>{{ $date->format('j M') }}</strong>
                                                            <span>{{ $date->format('D') }}</span>
                                                        </div>
                                                    </a>
                                                </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @for ($date = $currentDate->copy()->startOfWeek($startOfWeek); $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek))); $date->addDay())
                                                @php
                                                    $active_date = $date->toDateString();
                                                    $slots = $availableSlots[$active_date] ?? [];
                                                @endphp
                                                <td>
                                                    <div class="am-weekly-slots">
                                                        @if(!empty($slots))
                                                            @foreach ($slots as $index => $slot)
                                                                @php
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
                                                                @endphp
                                                                <div @class(['d-none' => $index > 3, 'am-slot-selected' => in_array($slot->id, $cartItemIds), 'am-weekly-slots_card', 'am-slot-'.$tooltipClass]) id="sessionslot-{{ $slot->id}}">
                                                                    @if(!empty($group))
                                                                        <h6>
                                                                            {{ $group }}
                                                                            @if(in_array($slot->id, $cartItemIds))
                                                                                <div class="am-closepopup" 
                                                                                        @click="$wire.dispatch('remove-cart', { params: { cartable_id: @js($slot->bookings->first()?->id), cartable_type: 'App\\Models\\SlotBooking' } })">
                                                                                    <i class="am-icon-multiply-01"></i>
                                                                                </div>
                                                                            @endif
                                                                        </h6>
                                                                    @endif
                                                                    @if(!empty($subject))<h5>{!! $subject !!}</h5>@endif
                                                                    <div class="am-weekly-slots_info">
                                                                        <span>
                                                                            <i class="am-icon-time"></i>
                                                                            @if(setting('_lernen.time_format') == '12')
                                                                                <em>{{ parseToUserTz($slot->start_time, $timezone)->format('h:i a') }} -
                                                                                {{ parseToUserTz($slot->end_time, $timezone)->format('h:i a') }}</em>
                                                                            @else
                                                                                <em>{{ parseToUserTz($slot->start_time, $timezone)->format('H:i') }} -
                                                                                {{ parseToUserTz($slot->end_time, $timezone)->format('H:i') }}</em>
                                                                            @endif
                                                                        </span>
                                                                        @if (\Nwidart\Modules\Facades\Module::has('kupondeal') && \Nwidart\Modules\Facades\Module::isEnabled('kupondeal') && !empty($slot?->subjectGroupSubjects?->coupons?->first()))
                                                                            <span class="am-discounted-session">
                                                                                <i class="am-icon-shopping-basket-04"></i>
                                                                                <div class="am-discounted-price">
                                                                                    <strike>
                                                                                        {{ formatAmount($slot->session_fee) }}
                                                                                    </strike>
                                                                                    {{ formatAmount($discountedFee) }}
                                                                                    <em>{{ __('tutor.per_session') }}</em>
                                                                                </div>
                                                                            </span>
                                                                        @else
                                                                            @if(isPaidSystem())
                                                                                <span>
                                                                                    <i class="am-icon-shopping-basket-04"></i>
                                                                                    <div class="am-nondiscounted-session">
                                                                                        {{ formatAmount($slot->session_fee) }}
                                                                                        <em>{{ __('tutor.per_session') }}</em>
                                                                                    </div>
                                                                                </span>
                                                                            @endif
                                                                        @endif
                                                                        @if($slot->spaces == '1' && !in_array($slot->id, $cartItemIds))
                                                                            <span><i class="am-icon-user-01"></i>{{ __('calendar.private_session')  }}<span>
                                                                        @else
                                                                            <span><i class="am-icon-user-group"></i>{{ __('calendar.no_slots_left', ['count' => $available_slot])  }}<span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="am-bookingbtns">
                                                                        @if(((Auth::check() && Auth()->user()->role == 'student') && !in_array($slot->id, $cartItemIds) && $available_slot > 0) && $slot->bookings->isEmpty() && $userId != Auth()->user()->id)
                                                                            @if(isPaidSystem())
                                                                                <button class="am-booksession" wire:loading.class="am-btn_disable" wire:target="bookSession({{ $slot->id }})" wire:click.prevent="bookSession({{ $slot->id }})" >{{ __('tutor.book_session_txt') }}</button>
                                                                            @else
                                                                                <button  
                                                                                    class="am-booksession"
                                                                                    wire:click="getFreeSession({{ $slot->id }})" 
                                                                                    type="button" 
                                                                                    wire:loading.delay.class="am-btn_disable" 
                                                                                    wire:target="getFreeSession({{ $slot->id }})">
                                                                                    {{ __('tutor.get_session_txt') }}
                                                                                </button>
                                                                            @endif
                                                                            <button class="am-viewdetail"  wire:loading.class="am-btn_disable" wire:target="showSlotDetail('{{ $slot->id }}')" wire:click.prevent="showSlotDetail('{{ $slot->id }}');">{{ __('tutor.view_detail') }}</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            <span class="am-emptyslot">{{ __('calendar.no_sessions') }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            @endfor
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="am-booking-weekly-clander am-booking-mobile">
                                @for ($date = $currentDate->copy()->startOfWeek($startOfWeek); $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek))); $date->addDay())
                                    @php
                                        $active_date = $date->toDateString();
                                        $slots = $availableSlots[$active_date] ?? [];
                                        $showAll[$active_date] = false;
                                    @endphp
                                    <td>
                                        <div class="am-weekly-slots @if($selectedDate === $date->toDateString()) am-day-slots-show @endif">
                                            @if(!empty($slots))

                                                @foreach ($slots as $index => $slot)
                                                    @php
                                                        $subject = $slot?->subjectGroupSubjects?->subject?->name;
                                                        $group = $slot?->subjectGroupSubjects?->userSubjectGroup?->group?->name ?? '';
                                                        $total_spaces = $slot->spaces ?? 0;
                                                        $total_booked = $slot->total_booked ?? 0;
                                                        $available_slot = $total_spaces - $total_booked;
                                                        $showAll[$active_date] = $index > 4;
                                                        $cartItemIds = array_column(array_column($cartItems?->toArray() ?? [], 'options'), 'slot_id');
                                                        $tooltipClass   = Arr::random(['warning', 'pending', 'ready', 'success'])
                                                    @endphp
                                                    <div @class(['d-none' => $index > 4, 'am-slot-selected' => in_array($slot->id, $cartItemIds), 'am-weekly-slots_card', 'am-slot-'.$tooltipClass]) id="sessionslot-{{ $slot->id}}">
                                                        @if(!empty($group))
                                                            <h6>
                                                                {{ $group }}
                                                                @if(in_array($slot->id, $cartItemIds))
                                                                    <div class="am-closepopup" 
                                                                        @click="$wire.dispatch('remove-cart', { params: { cartable_id: @js($slot->bookings->first()?->id), cartable_type: 'App\\Models\\SlotBooking' } })">
                                                                        <i class="am-icon-multiply-02"></i>
                                                                    </div>
                                                                @endif
                                                            </h6>
                                                        @endif
                                                        @if(!empty($subject))<h5>{{ $subject }}</h5>@endif
                                                        <div class="am-weekly-slots_info">
                                                            <span>
                                                                <i class="am-icon-time"></i>
                                                                @if(setting('_lernen.time_format') == '12')
                                                                    <em>{{ parseToUserTz($slot->start_time, $timezone)->format('h:i a') }} -
                                                                    {{ parseToUserTz($slot->end_time, $timezone)->format('h:i a') }}</em>
                                                                @else
                                                                    <em>{{ parseToUserTz($slot->start_time, $timezone)->format('H:i') }} -
                                                                    {{ parseToUserTz($slot->end_time, $timezone)->format('H:i') }}</em>
                                                                @endif
                                                            </span>
                                                            <span><i class="am-icon-shopping-basket-04"></i>{{ formatAmount($slot->session_fee) }}{{ __('tutor.per_session') }}</span>
                                                            <span><i class="am-icon-user-02"></i>{{ __('calendar.no_slots_left', ['count' => $available_slot])  }}<span>
                                                        </div>
                                                        <div class="am-bookingbtns">
                                                            @if((Auth::check() && Auth()->user()->role == 'student') && !in_array($slot->id, $cartItemIds) && $available_slot > 0)
                                                                <button class="am-booksession" wire:loading.class="am-btn_disable" wire:target="bookSession({{ $slot->id }})" wire:click.prevent="bookSession({{ $slot->id }})" >{{ __('tutor.book_session_txt') }}</button>
                                                            @endif
                                                            <button class="am-viewdetail"  wire:loading.class="am-btn_disable" wire:target="showSlotDetail('{{ $slot->id }}')" wire:click.prevent="showSlotDetail('{{ $slot->id }}');">{{ __('tutor.view_detail') }}</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="am-emptyslot">{{ __('calendar.no_sessions') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    @if($showAll[$active_date] && $selectedDate == $active_date)
                                        <div class="am-view_schedule-wrap">
                                            <button class="am-white-btn am-view_schedule am-showmore">{{ __('tutor.view_full_schedules')}}</button>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                            <a class="tab-pane_rightarrow" href="javascript:void(0);" wire:click="nextBookings">
                                <i class="am-icon-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    @if($show_all)
                        <div class="am-view_schedule-wrap am-showmore-btn">
                            <button class="am-white-btn am-view_schedule am-showmore">{{ __('tutor.view_full_schedules')}}</button>
                        </div>
                    @endif
            </div>
        </div>
        <x-slot-detail-modal :cartItems="$cartItems" :timezone="$timezone" :currentSlot="$currentSlot" :user="$user" wire:key="{{ time() }}" />
    @endif
    <div wire:ignore.self class="modal fade am-requestsessionpopup" id="requestsession-popup" data-bs-backdrop="static" x-data="{requestSessionForm: @entangle('requestSessionForm')}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2>{{ __('tutor.request_a_session') }}</h2>
                    <span data-bs-dismiss="modal" class="am-closepopup">
                        <i class="am-icon-multiply-01"></i>
                    </span>
                </div>
                <div class="am-modal-body">
                    <ul class="nav nav-pills am-booking-tabs" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" @click="requestSessionForm.type = 'private'" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"> 
                                {{ __('tutor.private_session') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" @click="requestSessionForm.type = 'group'" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> 
                                {{ __('tutor.group_session') }}
                            </button>
                        </li>
                    </ul>
                    <form class="am-themeform">
                        <fieldset>
                            <div class="form-group form-group-two-wrap">
                                <div @error('requestSessionForm.first_name') class="am-invalid" @enderror>
                                    <label class="am-label am-important" for="name">{{ __('auth.first_name') }}</label>
                                    <input type="text" x-model="requestSessionForm.first_name" class="form-control" placeholder="{{ __('auth.first_name') }}">
                                    <x-input-error field_name="requestSessionForm.first_name" />
                                </div>
                                <div @error('requestSessionForm.last_name') class="am-invalid" @enderror>
                                    <label class="am-label am-important" for="email">{{ __('auth.last_name') }}</label>
                                    <input type="text" x-model="requestSessionForm.last_name" class="form-control" placeholder="{{ __('auth.last_name') }}">
                                    <x-input-error field_name="requestSessionForm.last_name" />
                                </div>
                            </div>
                            <div class="form-group @error('requestSessionForm.email') am-invalid @enderror">
                                <label class="am-label am-important" for="email">{{ __('auth.email_placeholder') }}</label>
                                <input type="text" x-model="requestSessionForm.email" class="form-control" placeholder="{{ __('auth.email_placeholder') }}">
                                <x-input-error field_name="requestSessionForm.email" />
                            </div>
                            <div class="form-group @error('requestSessionForm.message') am-invalid @enderror">
                                <label class="am-label am-important" for="email">{{ __('tutor.message') }}</label>
                                <textarea name="message" x-model="requestSessionForm.message" placeholder="{{ __('tutor.message_placeholder') }}"></textarea>
                                <x-input-error field_name="requestSessionForm.message" />
                            </div>
                        </fieldset>
                    </form>
                    <button class="am-btn" wire:click="sendRequestSession" wire:loading.class="am-btn_disable" wire:target="sendRequestSession">{{ __('tutor.send_request') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    @vite([
        'public/css/flatpicker-month-year-plugin.css',
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('js/flatpicker.js') }}"></script>
    <script defer src="{{ asset('js/weekSelect.min.js') }}"></script>
    <script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
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
                let startOfWeek = @js($startOfWeek);
                let config = {
                    defaultDate: parseDateRange(currentDate),
                    onChange : function(selectedDates, dateStr, instance) {
                        @this.call('jumpToDate', dateStr);
                    },
                    disableMobile: true,
                    minDate: @js(\Carbon\Carbon::now($timezone)),
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
                    _this.text("{{ __('tutor.show_less') }}");
                } else {
                    _this.addClass('am-showmore')
                    jQuery('.am-weekly-slots').find('.am-showless').addClass('d-none').removeClass('am-showless');
                    _this.text("{{ __('tutor.view_full_schedules') }}");
                }
            });
        });
    </script>
@endpush
