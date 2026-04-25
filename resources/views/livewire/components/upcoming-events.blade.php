<div>
    @if($events->isNotEmpty())
        <div class="am-events-list row">
            @foreach($events as $event)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="cr-card">
                        <figure class="cr-image-wrapper" style="margin: 0;">
                            @if($event->banner_image)
                                <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->title }}" class="cr-background-image" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 200px; background: #eee; display: flex; align-items: center; justify-content: center;">No Image</div>
                            @endif
                        </figure>
                        <div class="cr-course-card" style="padding: 20px; background: #fff; border: 1px solid #eee; border-top: 0;">
                            <h3 class="cr-course-title" style="font-size: 18px; margin-bottom: 10px; min-height: 54px;">
                                {{ $event->title }}
                            </h3>
                            <div class="cr-course-features" style="display: flex; flex-direction: column; gap: 5px; margin-bottom: 15px;">
                                <div class="cr-info-item">
                                    <i class="am-icon-calender-duration"></i>
                                    <span>Date & Time: {{ $event->date_time }}</span>
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
                                @if(Auth::check() && $event->users()->where('user_id', Auth::id())->exists())
                                    <button class="am-btn am-btn-success" disabled>Registered</button>
                                @else
                                    <button wire:click="register({{ $event->id }})" class="am-btn">Register Now</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="am-no-record">
            <p>No upcoming events found.</p>
        </div>
    @endif
</div>
