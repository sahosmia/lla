@props(['currentBooking', 'id'=> 'session-detail'])
<div class="modal fade am-session-detail-modal_two" id="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="am-session-detail">
            <div class="am-session-detail_sidebar">
                <div class="am-session-detail_content">
                    <span>
                        <i class="am-icon-book-1"></i>
                        <span>{{ $currentBooking?->slot?->subjectGroupSubjects?->group?->name }}</span>
                    </span>
                    <div class="am-closepopup" data-bs-dismiss="modal">
                        <i class="am-icon-multiply-01"></i>
                    </div>
                    <h4>{{ $currentBooking?->slot?->subjectGroupSubjects?->subject?->name }}</h4>
                </div>
                <ul class="am-session-duration">
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-blue">
                                <i class="am-icon-calender-minus"></i>
                            </em>
                            <span>{{ __('general.date') }}</span>
                        </div>
                        <strong @class(['am-rescheduled' =>  auth()->user()->role == 'student' && $currentBooking?->status == 'rescheduled'])>{{ parseToUserTz($currentBooking?->start_time)->format(setting('_general.date_format') ?? 'F j, Y') }}</strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-purple">
                                <i class="am-icon-time"></i>
                            </em>
                            <span>{{ __('calendar.time') }}</span>
                        </div>
                        <strong @class(['am-rescheduled' => auth()->user()->role == 'student' && $currentBooking?->status == 'rescheduled'])>
                            @if(setting('_lernen.time_format') == '12')
                                {{ parseToUserTz($currentBooking?->start_time)->format('h:i a') }} -
                                {{ parseToUserTz($currentBooking?->end_time)->format('h:i a') }}
                            @else
                                {{ parseToUserTz($currentBooking?->start_time)->format('H:i') }} -
                                {{ parseToUserTz($currentBooking?->end_time)->format('H:i') }}
                            @endif
                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-red">
                                <i class="am-icon-layer-01"></i>
                            </em>
                            <span>{{ __('calendar.type') }}</span>
                        </div>
                        <strong>
                            {{ $currentBooking?->slot?->spaces > 1 ? __('calendar.group') : __('calendar.one') }}
                        </strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-orange">
                                <i class="am-icon-user-group"></i>
                            </em>
                            <span>{{ __('calendar.total_enrollment') }}</span>
                        </div>
                        <strong>{{ __('calendar.booked_students', ['count' => $currentBooking?->slot?->bookings_count]) }}</strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <em class="am-light-green">
                                {{ getCurrencySymbol() }}
                            </em>
                            <span>{{ __('calendar.session_fee') }}</span>
                        </div>
                        <strong> {{ formatAmount($currentBooking?->slot?->session_fee) }}<em>{{ __('calendar.person') }}</em></strong>
                    </li>
                    <li>
                        <div class="am-session-duration_title">
                            <figure>
                                @if(!empty($currentBooking?->tutor?->image) && Storage::disk(getStorageDisk())->exists($currentBooking?->tutor?->image))
                                    <img src="{{ resizedImage($currentBooking?->tutor?->image, 24, 24) }}" alt="{{ $currentBooking?->tutor?->full_name }}">
                                @else
                                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 24, 24) }}" alt="{{ $currentBooking?->tutor?->full_name }}">
                                @endif
                            </figure>
                            <span><em>{{ __('calendar.session_tutor') }}</em></span>
                        </div>
                        <strong>
                            @if(auth()->user()->role == 'tutor') <em>{{ __('calendar.you') }}</em> @endif
                            {{ $currentBooking?->tutor?->full_name }}
                        </strong>
                    </li>
                </ul>
                @if($currentBooking?->status == 'active')
                   @if(auth()->user()->role == 'tutor')
                        @if(!empty($currentBooking?->slot?->meta_data['meeting_link']))
                            <div class="am-session-btns" x-data="{ linkToCopy: '{{ route('session-detail', ['id' => encrypt($currentBooking?->slot?->id)]) }}', linkCopied: false }">
                                <a href="{{ $currentBooking?->slot?->meta_data['meeting_link'] ?? '#' }}" target="_blank" class="am-btn">{{ __('calendar.start_session_now') }}</a>
                                <button class="am-white-btn" @click="
                                    navigator.clipboard.writeText(linkToCopy)
                                    .then(() => {
                                        linkCopied = true;
                                        setTimeout(() => linkCopied = false, 2000);
                                    })
                                ">
                                    <template x-if="!linkCopied">
                                        <div class="am-copy-link">
                                            {{ __('calendar.copy_session_link') }}
                                            <i class="am-icon-copy-01"></i>
                                        </div>
                                    </template>
                                    <template x-if="linkCopied">
                                        <span x-show="linkCopied" x-transition>{{ __('calendar.link_copied') }}</span>
                                    </template>
                                </button>
                            </div>
                            <div class="am-optioanl-or">
                                <span>{{ __('general.or') }}</span>
                            </div>
                            <div class="am-zoom-session" x-data="{ textToCopy: '{{ $currentBooking?->slot?->meta_data['meeting_link'] ?? '#' }}', copied: false }">
                                <div class="am-zoom-session_title">
                                    <span>
                                        <img src="{{asset('images/' . ($currentBooking?->slot?->meta_data['meeting_type'] ?? 'zoom' ) . '-icon.png')}}" alt="{{ $currentBooking?->slot?->meta_data['meeting_type'] ?? 'Zoom' }}">
                                        {{ __('calendar.meeting_link') }}
                                    </span>
                                    <a href="#">{{ $currentBooking?->slot?->meta_data['meeting_link'] ?? '#' }}</a>
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
                                            {{ __('calendar.copy_meeting_link') }}
                                            <i class="am-icon-copy-01"></i>
                                        </div>
                                    </template>
                                    <template x-if="copied">
                                        <span x-show="copied" x-transition>{{ __('calendar.link_copied') }}</span>
                                    </template>
                                </button>
                            </div>
                        @else
                            <div class="am-session-detail_sidebar_footer" x-data="{ linkToCopy: '{{ route('session-detail', ['id' => encrypt($currentBooking?->slot?->id)]) }}', linkCopied: false }">
                                <button class="am-white-btn" @click="
                                    navigator.clipboard.writeText(linkToCopy)
                                    .then(() => {
                                        linkCopied = true;
                                        setTimeout(() => linkCopied = false, 2000);
                                    })
                                ">
                                    <template x-if="!linkCopied">
                                        <div class="am-copy-link">
                                            {{ __('calendar.copy_session_link') }}
                                            <i class="am-icon-copy-01"></i>
                                        </div>
                                    </template>
                                    <template x-if="linkCopied">
                                        <span x-show="linkCopied" x-transition>{{ __('calendar.link_copied') }}</span>
                                    </template>
                                </button>
                                <p>{{ __('calendar.generate_meeting_link_msg') }}</p>
                            </div>
                        @endif
                        @if(isCalendarConnected() && empty($currentBooking?->slot?->meta_data['event_id']))
                            <button class="am-btn am-sync_btn" wire:click="syncWithGoogleCalendar()" wire:loading.class="am-btn_disable">
                                <img src="{{ asset('images/calendar.png') }}">
                                {{ __('calendar.sync_google_calendar') }}
                            </button>
                        @endif
                    @elseif(auth()->user()->role == 'student')
                        <div class="am-session-detail_sidebar_footer">
                            <div class="am-session-start">
                                @if(parseToUserTz($currentBooking->slot->start_time)->isFuture())
                                <div class="am-session-time">
                                    <em><i class="am-icon-megaphone-02"></i> </em>
                                    <span>
                                        {{ __('calendar.session_start_at') }}
                                    </span>
                                    <i>
                                        {{ timeLeft($currentBooking?->start_time) }}
                                    </i>
                                </div>
                            @endif
                            @if(!empty($currentBooking?->slot?->meta_data['meeting_link']))
                                <div class="am-sessionstart-btn">
                                    <a href="{{ $currentBooking?->slot?->meta_data['meeting_link'] ?? '#' }}" class="am-btn" target="_blank">
                                        {{ __('calendar.join_session') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        @if(empty($currentBooking?->slot?->meta_data['meeting_link']))
                            <p>{{ __('calendar.missing_meeting_link') }}</p>
                        @endif
                        @if(isCalendarConnected() && empty($currentBooking?->meta_data['event_id']))
                            <button class="am-btn am-sync_btn" wire:click="syncWithGoogleCalendar()" wire:loading.class="am-btn_disable">
                                <img src="{{ asset('images/calendar.png') }}">
                                {{ __('calendar.sync_google_calendar') }}
                            </button>
                        @endif
                    </div>
                    @endif
                @elseif(auth()->user()->role == 'student' && $currentBooking?->status == 'rescheduled')
                    <p>{!! __('calendar.rescheduled_date_desc', ['date' => parseToUserTz($currentBooking?->slot?->start_time)->format(setting('_general.date_format') ?? 'F j, Y')]) !!}</p>
                @endif
            </div>
            <div class="am-session-detail-modal_body">
                <figure>
                    @if(!empty($currentBooking?->slot?->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($currentBooking?->slot?->subjectGroupSubjects?->image))
                        <img src="{{ resizedImage($currentBooking?->slot?->subjectGroupSubjects?->image, 700, 360) }}" alt="{{ $currentBooking?->slot?->subjectGroupSubjects?->subject?->name }}">
                    @else
                        <img src="{{ resizedImage('placeholder-land.png', 700, 360) }}" alt="{{ $currentBooking?->slot?->subjectGroupSubjects?->subject?->name }}">
                    @endif
                </figure>
                <div class="am-session-content">
                    {!! $currentBooking?->slot?->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
