<div class="am-profile-setting">
    @slot('title')
        {{ __('sidebar.bookings') }}
    @endslot
    @if(auth()->user()->role == 'tutor')
        @include('livewire.pages.tutor.manage-sessions.tabs')
    @endif
    <div wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter"
         class="am-booking-wrapper am-upcomming-booking @if(auth()->user()->role == 'student') am-student-booking @endif" x-data="{
            form:@entangle('form'),
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
                        <a href="#" @if($disablePrevious) disabled @else wire:click="previousBookings" @endif>
                            <i class="am-icon-chevron-left"></i>
                        </a>
                        <span @if($isCurrent) disabled @else wire:click="jumpToDate()" @endif>
                            {{ __('calendar.current_'.$showBy) }}
                        </span>
                        <a href="#" wire:click="nextBookings">
                            <i class="am-icon-chevron-right"></i>
                        </a>
                    </div>
                    <div class="am-booking-calander-date flatpicker" wire:ignore>
                        <x-text-input id="flat-picker" />
                    </div>
                </div>
                <div class="am-booking-filters-wrapper">
                    <div class="am-inputicon">
                        <input type="text" wire:model.live.debounce.250ms="filter.keyword"
                            placeholder="{{ __('taxonomy.search_here') }}" class="form-control" />
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
                                    @this.set('filter', filters);
                                }
                            }">
                            <fieldset>
                                <div class="form-group">
                                    <label>{{ __('calendar.session_type_placeholder') }}</label>
                                    <span class="am-select am-filter-select" wire:ignore>
                                        <select id="type_fiter" data-componentid="@this" data-parent=".am-filter-list"
                                            class="am-select2" data-searchable="false" data-wiremodel="filter.type">
                                            <option value="*">{{ __('calendar.show_all_type') }}</option>
                                            <option value="one">{{ __('calendar.one') }}</option>
                                            <option value="group">{{ __('calendar.group') }}</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('calendar.subject_placeholder') }}</label>
                                    <span class="am-select am-multiple-select am-filter-select" wire:ignore>
                                        <select id="filter_subject_group" data-componentid="@this"
                                            data-parent=".am-filter-list" class="am-select2"
                                            data-class="subject-dropdown-select2" data-format="custom"
                                            data-searchable="true" data-wiremodel="filter.subject_group_ids"
                                            data-placeholder="{{ __('calendar.subject_placeholder') }}" multiple>
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
                                <button class="am-btn" @click="submitFilter()">{{ __('general.apply_filter') }}</button>
                            </fieldset>
                        </form>
                    </div>
                    <ul class="am-session-slots am-session-slots-sm" role="tablist">
                        <li>
                            <button @class(['active'=> $showBy == 'daily']) @if($showBy != 'daily')
                                wire:click="switchShow('daily')" @endif aria-selected="true"
                                wire:loading.class="am-btn_disable">{{ __('calendar.daily') }}</button>
                        </li>
                        <li>
                            <button @class(['active'=> $showBy == 'weekly']) @if($showBy != 'weekly')
                                wire:click="switchShow('weekly')" @endif aria-selected="false"
                                wire:loading.class="am-btn_disable">{{ __('calendar.weekly') }}</button>
                        </li>
                        <li>
                            <button @class(['active'=> $showBy == 'monthly']) @if($showBy != 'monthly')
                                wire:click="switchShow('monthly')" @endif aria-selected="false"
                                wire:loading.class="am-btn_disable">{{ __('calendar.monthly') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="am-section-load" wire:loading.flex wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                <p>{{ __('general.loading') }}</p>
            </div>
            <div wire:loading.class="d-none" class="am-booking-calander_body" wire:target="switchShow,jumpToDate,nextBookings,previousBookings,filter">
                <div class="tab-content">
                    @if($showBy == 'daily')
                    <div class="tab-pane fade show active am-tableresponsive sticky-left-column" id="dailytab">
                        <table class="am-booking-clander-daily" cellspacing="0" id="dailytable">
                            <thead>
                                <tr>
                                    <th>{{ __('calendar.time') }}</th>
                                    <th>{{ parseToUserTz($currentDate)->format('F j, Y \\G\\M\\T P') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $startTime = \Carbon\Carbon::createFromTime(0, 0, 0);
                                $endTime = \Carbon\Carbon::createFromTime(23, 59, 0);
                                @endphp
                                @while ($startTime <= $endTime) <tr>
                                    @if(setting('_lernen.time_format') == '12')
                                        <td>{{ $startTime->format('h:i a') }}</td>
                                    @else
                                        <td>{{ $startTime->format('H:i') }}</td>
                                    @endif
                                    @if (isset($upcomingBookings[$startTime->format('h:i a')]) || isset($upcomingBookings[$startTime->format('H:i')]))
                                    <td>
                                        @foreach ($upcomingBookings[$startTime->format('h:i a')] as $subject => $booking)
                                        <div
                                        @if(!empty(setting('_general.enable_rtl')))
                                            style="position: absolute; top: {{ calculatePercentageOfHour($booking->slot->start_time) }}px;right: {{ $loop->index * 380 }}px;"
                                        @else
                                            style="position: absolute; top: {{ calculatePercentageOfHour($booking->slot->start_time) }}px;left: {{ $loop->index * 380 }}px;"
                                        @endif
                                        >
                                            <x-single-booking :booking="$booking" :disputeReason="$disputeReason" :description="$description" :selectedReason="$selectedReason"/>
                                        </div>
                                        @endforeach
                                    </td>
                                    @else
                                    <td></td>
                                    @endif
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @php
                                    $startTime->addHour();
                                    @endphp
                                    @endwhile
                            </tbody>
                        </table>
                    </div>
                    @elseif($showBy == 'weekly')
                    <div class="tab-pane fade show active" id="weeklytab">
                        <table class="am-booking-weekly-clander">
                            <thead>
                                <tr>
                                    @for ($date = $currentDate->copy()->startOfWeek($startOfWeek);
                                    $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek)));
                                    $date->addDay())
                                    <th>
                                        <div class="am-booking-calander-title">
                                            <strong>{{ $date->format('j F') }}</strong>
                                            <span>{{ $date->format('D') }}</span>
                                        </div>
                                    </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @for ($date = $currentDate->copy()->startOfWeek($startOfWeek);
                                    $date->lte($currentDate->copy()->endOfWeek(getEndOfWeek($startOfWeek)));
                                    $date->addDay())
                                    <td>
                                        <div class="am-weekly-slots_wrap">
                                            <div class="am-weekly-slots">
                                                @if (isset($upcomingBookings[$date->toDateString()]))
                                                @foreach ($upcomingBookings[$date->toDateString()] as $booking)
                                                <x-single-booking :booking="$booking" :disputeReason="$disputeReason" :description="$description" :selectedReason="$selectedReason"/>
                                                @endforeach
                                                @else
                                                <span class="am-emptyslot">{{ __('calendar.no_sessions') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @endfor
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @elseif($showBy == 'monthly')
                    <div class="tab-pane fade show active" id="monthlytab">
                        <table class="am-monthly-session-table">
                            <thead>
                                <tr>
                                    @foreach ($days as $day)
                                    <th>{{ $day['short_name'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $startOfCalendar = $currentDate->copy()->firstOfMonth()->startOfWeek($startOfWeek);
                                $endOfCalendar =
                                $currentDate->copy()->lastOfMonth()->endOfWeek(getEndOfWeek($startOfWeek));
                                @endphp
                                @while ($startOfCalendar <= $endOfCalendar) <tr>
                                    @for ($i = 0; $i < 7; $i++) @php $totalBookings=0; @endphp <td
                                        @class(['am-outside-calendar'=> $startOfCalendar->format('m') !=
                                        $currentDate->format('m')])>
                                        <div class="am-monthly-session-title">
                                            <span @class(['current-date'=> $startOfCalendar->isToday()])>{{
                                                parseToUserTz($startOfCalendar)->format('j') }}</span>
                                            @if (isset($upcomingBookings[$startOfCalendar->toDateString()]))
                                            @foreach ($upcomingBookings[$startOfCalendar->toDateString()] as $booking)
                                            @php
                                            $totalBookings += 1;
                                            @endphp
                                            @endforeach
                                            <em> {{ $totalBookings }} {{ __('calendar.sessions') }} </em>
                                            @endif
                                        </div>
                                        @if (isset($upcomingBookings[$startOfCalendar->toDateString()]))
                                        <ul class="am-monthly-session-lsit">
                                            @foreach ($upcomingBookings[$startOfCalendar->toDateString()] as $index => $booking)
                                            @php
                                            $subject = $booking->slot->subjectGroupSubjects?->subject?->name;
                                            $tooltipClass = Arr::random(['warning', 'pending', 'ready', 'success'])
                                            @endphp
                                            <li @class([ "am-$tooltipClass-tooltip"=>
                                                parseToUserTz($booking->slot->end_time)->isFuture(),
                                                'am-blur-tooltip' => auth()->user()->role == 'student' &&
                                                ($booking->status == 'rescheduled' || $booking->status == 'disputed'),
                                                'am-tooltip',
                                                'am-addreview-tooltip' =>
                                                parseToUserTz($booking->slot->end_time)->isPast()
                                                ]) @if(parseToUserTz($booking->slot->end_time)->isFuture()) wire:click="showBookingDetail({{ $booking->id }})" @endif>
                                                <div class="am-titleblur">
                                                    <div class="am-session-monthly-tooltip">
                                                        <strong wire:loading.class="am-btn_disable"
                                                            >{{
                                                            $subject }}</strong>
                                                        @if(parseToUserTz($booking->slot->end_time)->isFuture())
                                                        <span>
                                                            <span>
                                                                    <i class="am-icon-time"></i>
                                                                    <em>
                                                                        {{ parseToUserTz($booking->slot->start_time)->format('h:i
                                                                        a') }} -
                                                                        {{ parseToUserTz($booking->slot->end_time)->format('h:i a')
                                                                        }}
                                                                    </em>
                                                            </span>
                                                            @if (parseToUserTz($booking->slot->end_time)->isFuture())
                                                                <i class="am-icon-arrow-right"></i>
                                                            @endif
                                                        </span>
                                                        @elseif($booking->rating_exists)
                                                        <span>
                                                            <em>
                                                                {{ __('calendar.review_submitted') }}
                                                            </em>
                                                            <i class="am-icon-check-circle06"></i>
                                                        </span>
                                                        @elseif($booking->status == 'completed')
                                                        @php
                                                            $tutorInfo['name'] = $booking->tutor->full_name;
                                                            if (!empty($booking?->tutor?->image) &&
                                                                Storage::disk(getStorageDisk())->exists($booking?->tutor?->image)) {
                                                                $tutorInfo['image'] = resizedImage($booking?->tutor?->image, 36, 36);
                                                            } else {
                                                                $tutorInfo['image'] = setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 36, 36);
                                                            }
                                                        @endphp
                                                            <a href="#"
                                                                @click=" tutorInfo = @js($tutorInfo); form.bookingId = @js($booking->id); $nextTick(() => $wire.dispatch('toggleModel', {id:'review-modal',action:'show'}) )">
                                                                {{ __('calendar.add_review') }} 
                                                            </a>
                                                        @else
                                                            <a href="#" wire:click.prevent="showCompletePopup({{ json_encode($booking) }})">
                                                                {{ __('calendar.mark_as_completed') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if(auth()->user()->role == 'student' && $booking->status ==
                                                'rescheduled')
                                                <div class="am-blur-content">
                                                    <a href="{{ route('student.reschedule-session', ['id' => $booking->id]) }}"
                                                        wire:navigate.remove>{{ __('calendar.tutor_rescheduled') }}</a>
                                                </div>
                                                @elseif(auth()->user()->role == 'student' && $booking->status == 'disputed')
                                                    <div class="am-blur-content">
                                                        <a href="{{ route('student.manage-dispute', ['id' => $booking?->dispute?->uuid]) }}">{{ __('calendar.dispute_session') }}</a>  
                                                    </div>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
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
                    @else
                    <x-no-record :image="asset('images/session.png')" :title="__('calendar.no_sessions')"
                        :description="__('calendar.no_session_desc')" />
                    @endif
                </div>
            </div>
        </div>
        <!-- session detail modal v2 -->
        <div class="modal fade am-review-popup" id="review-modal" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="am-review-detail">
                    <div class="am-review-session">
                        <h3>{{ __('calendar.tell_us_experience') }}</h3>
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
                                <x-input-error field_name="form.rating" />
                            </div>
                        </div>
                        <div class="am-review-details @error('form.comment') am-invalid @enderror">
                            <textarea placeholder="{{ __('calendar.add_review') }}" x-model="form.comment"
                                x-on:input="updateCharLeft"></textarea>
                            <span x-text="charLeft + ' {{ __('general.char_left') }}'"></span>
                            <x-input-error field_name="form.comment" />
                        </div>
                        <button class="am-btn" wire:click="submitReview" wire:loading.class="am-btn_disable">{{
                            __('calendar.submit_review') }}</button>
                    </div>
                    @if (!empty(setting('_lernen.enabl_tips')) &&
                    (!empty(setting('_lernen.tip_section_title')) ||
                    !empty(setting('_lernen.tip_section_description')) ||
                    !empty(setting('_lernen.tip_bullets_repeater'))) ||
                    !empty(setting('_lernen.well_wishing_text'))
                    )
                    <div class="am-reviews-tips">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        @if (!empty(setting('_lernen.tip_section_title')))
                        <div class="am-review-tips-heading">
                            <span>
                                <i class="am-icon-check-circle04"></i>
                            </span>
                            <h3>{{ setting('_lernen.tip_section_title') }}</h3>
                        </div>
                        @endif
                        @if (!empty(setting('_lernen.tip_section_description')))
                        <p class="am-review-description">{{ setting('_lernen.tip_section_description') }}</p>
                        @endif
                        @if (!empty(setting('_lernen.tip_bullets_repeater')))
                        <ul class="am-reviews-tips-list">
                            @foreach (setting('_lernen.tip_bullets_repeater') as $bullet)
                            <li>
                                <span class="am-review-tip">
                                    <i class="am-icon-check-circle06"></i>
                                    {{ $bullet['tip_bullets'] }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        @if (!empty(setting('_lernen.well_wishing_text')))
                        <span class="am-review-end">{{ setting('_lernen.well_wishing_text') }}</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <x-completion/>
        <x-dispute-reason-popup :booking="$userBooking" :disputeReason="$disputeReason" :description="$description" :selectedReason="$selectedReason"/>
        <x-booking-detail-modal :currentBooking="$currentBooking" wire:key="{{ time() }}" />
    </div>
</div>
@push('styles')
@vite([
    'public/css/flatpicker.css',
    'public/css/flatpicker-month-year-plugin.css'
    ])
@endpush
@push('scripts')
<script defer src="{{ asset('js/flatpicker.js') }}"></script>
<script defer src="{{ asset('js/weekSelect.min.js') }}"></script>
<script defer src="{{ asset('js/flatpicker-month-year-plugin.js') }}"></script>
@endpush

@script
<script>
    let flatpickrInstance = null;
        initFlatPicker('{{ $showBy }}', 'today');
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
                    @this.call('jumpToDate', dateStr);
                }
            }
            if('{{ auth()->user()->role }}' == 'tutor') {
                config = {...config, minDate: @js(\Carbon\Carbon::now(getUserTimezone())->toDateString())}
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
                    minDate: @js(\Carbon\Carbon::now(getUserTimezone())->toDateString()),
                    plugins: [
                        new weekSelect({
                            weekStart: @js($startOfWeek)
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
@endscript
