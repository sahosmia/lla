@if(!empty($booking))
    @php
        $subject = $booking->slot->subjectGroupSubjects?->subject?->name;
        $tooltipClass   = Arr::random(['warning', 'pending', 'ready', 'success'])
    @endphp
    <div @class([
        'am-reminder-tooltip',
        "am-$tooltipClass-tooltip" => parseToUserTz($booking->slot->end_time)->isFuture() || $booking->status == 'disputed' || $booking->status == 'rescheduled' ,
        'am-blur-tooltip' => auth()->user()->role == 'student' && ($booking->status == 'rescheduled' || $booking->status == 'disputed')
        ])>
        <div class="am-reminder-tooltip_title am-titleblur">
            <figure>
                @if (!empty($booking->slot->subjectGroupSubjects?->image) && Storage::disk(getStorageDisk())->exists($booking->slot->subjectGroupSubjects?->image))
                    <img src="{{ resizedImage($booking->slot->subjectGroupSubjects?->image, 40, 40) }}" alt="{{ $subject }}">
                @else 
                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40) }}" alt="{{ $subject }}">
                @endif
            </figure>
            <h2>
                {{ $subject }}
                @if(parseToUserTz($booking->slot->end_time)->isFuture())
                    <span>
                        <i class="am-icon-time"></i>
                        @if(setting('_lernen.time_format') == '12')
                            {{ parseToUserTz($booking->slot->start_time)->format('h:i a') }} -
                            {{ parseToUserTz($booking->slot->end_time)->format('h:i a') }}
                        @else
                            {{ parseToUserTz($booking->slot->start_time)->format('H:i') }} -
                            {{ parseToUserTz($booking->slot->end_time)->format('H:i') }}
                        @endif
                    </span>
                @elseif($booking->rating_exists)
                    <span class="am-reviewreqslot">
                        <i class="am-icon-check-circle06"></i> 
                        {{ __('calendar.review_submitted') }}
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
                @elseif(auth()->user()->role == 'student' && $booking->status == 'disputed')
                    <a href="{{ route('student.manage-dispute', ['id' => $booking?->dispute?->uuid]) }}">{{ __('calendar.dispute_session') }}</a>  
                @else
                    <a href="#" wire:click.prevent="showCompletePopup({{ json_encode($booking) }})">
                        {{ __('calendar.mark_as_completed') }}
                    </a>
                @endif
            </h2>
        </div>
        @if(auth()->user()->role == 'student' && $booking->status == 'rescheduled')
            <div class="am-blur-content">
                <a href="{{ route('student.reschedule-session', ['id' => $booking->id]) }}" wire:navigate.remove>{{ __('calendar.tutor_rescheduled') }}</a>
            </div>
        @elseif(auth()->user()->role == 'student' && $booking->status == 'disputed')
            <div class="am-blur-content">
                <a href="{{ route('student.manage-dispute', ['id' => $booking?->dispute?->uuid]) }}">{{ __('calendar.dispute_session') }}</a>   
            </div>
        @elseif(parseToUserTz($booking->slot->end_time)->isFuture())
            <div class="am-reminder-tooltip_body">
                <ul class="am-reminder-tooltip-content">
                    <li>
                        <span>{{ __('calendar.session_fee') }}</span>
                        <strong> {{ formatAmount($booking->slot->session_fee) }}</strong>
                    </li>
                    <li>
                        <span>{{ __('calendar.total_enrollment') }}</span>
                        @if ($booking->slot->total_booked > 0 && !empty($booking->slot->students))
                            <ul class="am-reminder-enrollment-list">
                                @foreach ($booking->slot->students as $student)
                                    <li>
                                        @if (!empty($student->image) && Storage::disk(getStorageDisk())->exists($student->image))
                                            <img src="{{ resizedImage($student->image, 40, 40) }}" alt="profile-img">
                                        @else 
                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40) }}" alt="profile-img">
                                        @endif
                                    </li>
                                @endforeach
                                <li>
                                    <span>{{ __('calendar.booked_students', ['count' => $booking->slot->bookings_count]) }}</span>
                                </li>
                            </ul>
                        @else
                            --
                        @endif
                    </li>
                    <li>
                        <span>{{ __('general.date') }}</span>
                        <strong>{{ parseToUserTz($booking->slot->start_time)->format(setting('_general.date_format') ?? 'F j, Y') }}</strong>
                    </li>
                    <li>
                        <span>{{ __('calendar.time') }}</span>
                        <strong>
                            @if(setting('_lernen.time_format') == '12')
                                {{ parseToUserTz($booking->slot->start_time)->format('h:i a') }} -
                                {{ parseToUserTz($booking->slot->end_time)->format('h:i a') }}
                            @else
                                {{ parseToUserTz($booking->slot->start_time)->format('H:i') }} -
                                {{ parseToUserTz($booking->slot->end_time)->format('H:i') }}
                            @endif
                        </strong>
                    </li>
                </ul>
                <div class="am-reminder-btn">
                    <button class="am-btn-light" wire:loading.class="am-btn_disable" wire:click="showBookingDetail({{ $booking->id }})">{{ __('calendar.view_full_details') }}</button>
                    @if(!empty($booking->slot->meta_data['meeting_link']))
                        <a href="{{ $booking->slot->meta_data['meeting_link'] ?? '#' }}" target="_blank" class="am-btn">
                            @if(auth()->user()->role == 'tutor'){{ __('calendar.start_session_now') }} @elseif(auth()->user()->role == 'student') {{ __('calendar.join_session') }} @endif
                        </a>
                    @endif
                </div>
            </div>
        @endif    
    </div> 
@endif
