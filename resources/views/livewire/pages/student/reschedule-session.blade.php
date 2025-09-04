<div class="am-reschudle-booking">
    <div class="am-reschudle-session">
        <div class="am-reschudle-header">
            <span>
                <i class="am-icon-megaphone-01"></i>
            </span>
            <h1>{{ __('calendar.booking_rescheduled_title') }}</h1>
        </div>
        <p>{!! __('calendar.booking_rescheduled_desc', ['tutor' => $booking->tutor->full_name]) !!}</p>
        <div class="am-reschudle-reason">
            <div class="am-user-detail">
                @if(!empty($booking?->tutor?->image) && Storage::disk(getStorageDisk())->exists($booking?->tutor?->image))
                    <img src="{{ resizedImage($booking?->tutor?->image, 30, 30) }}" alt="{{ $booking?->tutor?->full_name }}">
                @else
                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 30, 30) }}" alt="{{ $booking?->tutor?->full_name }}">
                @endif
                <div class="am-user-description">
                    <h3>{{ __('calendar.reschedule_reason') }}</h3>
                    <p>
                        {!! $booking->slot->meta_data['reason'] ?? '' !!}
                    </p>
                </div>
            </div>
        </div>
        <div class="am-reschudle-reason am-rescheduletimewrap">
            <h3>{{ __('calendar.rescheduled_session') }}</h3>
            <ul class="am-reschudle-list">
                <li>
                    <div class="am-reschudle-item am-rescheduletime">
                        <div class="am-session-reschudled">
                            <span>
                                <i class="am-icon-multiply-02"></i>
                            </span>
                            <strong>{{ __('calendar.previous_session_date_time') }}</strong>
                        </div>
                        <div class="am-session-time">
                            <strong>{{ parseToUserTz($booking->start_time)->format(setting('_general.date_format') ?? 'F j, Y') }}</strong>
                            <span>
                                @if(setting('_lernen.time_format') == '12')
                                {{ parseToUserTz($booking->start_time)->format('h:i a') }} -
                                    {{ parseToUserTz($booking->end_time)->format('h:i a') }}
                                @else
                                    {{ parseToUserTz($booking->start_time)->format('H:i') }} -
                                    {{ parseToUserTz($booking->end_time)->format('H:i') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="am-reschudle-item am-new-session">
                        <div class="am-session-reschudled">
                            <span>
                                <i class="am-icon-check-circle06"></i>
                            </span>
                            <strong>{{ __('calendar.rescheduled_session_date_time') }}</strong>
                        </div>
                        <div class="am-session-time">
                            <strong>{{ parseToUserTz($booking->slot->start_time)->format(setting('_general.date_format') ?? 'F j, Y') }}</strong>
                            <span>
                                @if(setting('_lernen.time_format') == '12')
                                {{ parseToUserTz($booking->slot->start_time)->format('h:i a') }} -
                                    {{ parseToUserTz($booking->slot->end_time)->format('h:i a') }}
                                @else
                                    {{ parseToUserTz($booking->slot->start_time)->format('H:i') }} -
                                    {{ parseToUserTz($booking->slot->end_time)->format('H:i') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="am-reschudle-confirm">
            <div class="am-reschudled-btns">
                <button class="am-btn" wire:click="confirmReschedule" wire:loading.class="am-btn_disable">{{ __('calendar.confirm_reschedule') }}</button>
                <button class="am-white-btn" @click="$wire.dispatch('showConfirm', { 
                    id : {{ $booking->id }},
                    action : 'refund-session',
                    icon: 'warning',
                    title: '{{ __('calendar.confirm_refund_title') }}',
                    content: '{{ __('calendar.confirm_refund_desc') }}',
                    btnOk_title: '{{ __('calendar.btn_confirm_refund') }}',
                    btnCancel_title: '{{ __('calendar.btn_cancel_refund') }}',
                 })">{{ __('calendar.confirm_refund') }}</button>
            </div>
            <button class="am-white-btn" data-bs-toggle="modal" data-bs-target="#session-detail">{{ __('calendar.view_session_details') }} 
                <i class="am-icon-arrow-06-1"></i>
            </button>
        </div>
        <div class="am-reschudle-reason">
            <p>{{ __('calendar.contact_via_email') }}<a href="mailto:{{ setting('_site.email') }}">{{ setting('_site.email') }}</a></p>
        </div>
    </div>
    <x-booking-detail-modal :currentBooking="$booking" wire:key="{{ time() }}" />
</div>