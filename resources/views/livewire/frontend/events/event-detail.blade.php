<div class="am-event-detail-page am-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="am-event-content">
                    @if($event->banner_image)
                        <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-4" style="width: 100%; max-height: 400px; object-fit: cover;">
                    @endif
                    <h1>{{ $event->title }}</h1>
                    <div class="am-event-meta mt-3 mb-4 d-flex gap-4">
                        <span><i class="am-icon-calender-duration"></i> {{ $event->date_time }}</span>
                        <span><i class="am-icon-video-v2"></i> {{ $event->mode }}</span>
                    </div>
                    <hr>
                    <div class="am-event-description mt-4">
                        <h3>About this Event</h3>
                        <p>This is a professional training session titled "{{ $event->title }}".</p>
                        <!-- Add more description if available in database later -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="am-event-sidebar mb-4 p-4 border rounded shadow-sm bg-white">
                    <h4>Event Details</h4>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-3">
                            <strong>Trainer:</strong><br>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                @if($event->trainer?->profile?->image)
                                    <img src="{{ Storage::url($event->trainer->profile->image) }}" width="40" height="40" class="rounded-circle" alt="">
                                @endif
                                <div>
                                    <span>{{ $event->trainer?->profile?->full_name ?? 'TBA' }}</span><br>
                                    <small class="text-muted">{{ $event->trainer?->profile?->tagline }}</small>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <strong>Mode:</strong><br>
                            <span>{{ $event->mode }}</span>
                        </li>
                        <li class="mb-3">
                            <strong>Date:</strong><br>
                            <span>{{ $event->date_time }}</span>
                        </li>
                        <li class="mb-3">
                            <strong>Price:</strong><br>
                            <span>{{ $event->price > 0 ? formatAmount($event->price) : 'Free' }}</span>
                        </li>
                        @if($event->registration_deadline)
                            <li class="mb-3">
                                <strong>Registration Deadline:</strong><br>
                                <span class="{{ $event->registration_deadline->isPast() ? 'text-danger' : '' }}">
                                    {{ $event->registration_deadline->format('l, d F Y H:i') }}
                                </span>
                            </li>
                        @endif
                        @if($event->mode === 'Physical')
                            <li class="mb-3">
                                <strong>Venue:</strong><br>
                                <span>{{ $event->venue_address }}, {{ $event->venue_city }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
                <livewire:frontend.events.event-registration :event="$event" />
            </div>
        </div>
    </div>
</div>
