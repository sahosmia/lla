<div class="am-event-list-page am-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-section_title am-section_title_center">
                    <h2>Upcoming Training and Events</h2>
                    <p>Enhance your skills with our professional training sessions and events.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            @foreach($events as $event)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="cr-card">
                        <figure class="cr-image-wrapper" style="margin: 0;">
                            <a href="{{ route('events.detail', $event->id) }}">
                                @if($event->banner_image)
                                    <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->title }}" class="cr-background-image" style="width: 100%; height: 200px; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">No Image</div>
                                @endif
                            </a>
                        </figure>
                        <div class="cr-course-card" style="padding: 20px; background: #fff; border: 1px solid #eee; border-top: 0;">
                            <h3 class="cr-course-title" style="font-size: 18px; margin-bottom: 10px; min-height: 54px;">
                                <a href="{{ route('events.detail', $event->id) }}">{{ $event->title }}</a>
                            </h3>
                            <div class="cr-course-features" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 15px;">
                                <div class="cr-info-item">
                                    <i class="am-icon-calender-duration"></i>
                                    <span>Date: {{ $event->date_time }}</span>
                                </div>
                                <div class="cr-info-item">
                                    <i class="am-icon-video-v2"></i>
                                    <span>Mode: {{ $event->mode }}</span>
                                </div>
                                <div class="cr-info-item">
                                    <i class="am-icon-user-v2"></i>
                                    <span>Trainer: {{ $event->trainer?->profile?->full_name ?? 'TBA' }}</span>
                                </div>
                            </div>
                            <div class="cr-card_footer" style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="{{ route('events.detail', $event->id) }}" class="am-btn">Register Now</a>
                                <a href="{{ route('events.detail', $event->id) }}" class="am-btn am-btn-outline">Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
