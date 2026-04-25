<div class="am-events-list row">
    @foreach($events as $event)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="am-event-card">
                <figure class="am-event-banner">
                    @if(!empty($event->banner_image))
                        <img src="{{ url(Storage::url($event->banner_image)) }}" alt="{{ $event->title }}">
                    @else
                        <img src="{{ asset('demo-content/placeholders/placeholder-image.jpg') }}" alt="{{ $event->title }}">
                    @endif
                    @if(!empty($event->mode))
                        <span class="am-event-mode">{{ $event->mode }}</span>
                    @endif
                </figure>
                <div class="am-event-content">
                    @if(!empty($event->title))
                        <h3>{{ $event->title }}</h3>
                    @endif
                    <ul class="am-event-details">
                        @if(!empty($event->date_time))
                            <li>
                                <i class="am-icon-calender-duration"></i>
                                <span>{{ $event->date_time }}</span>
                            </li>
                        @endif
                        @if(!empty($event->trainer_name))
                            <li>
                                <i class="am-icon-user-check"></i>
                                <span>{{ $event->trainer_name }}</span>
                            </li>
                        @endif
                    </ul>
                    @if(!empty($event->registration_link))
                        <button wire:click="register({{ $event->id }})" class="am-btn am-event-btn">
                            {{ __('Register Now') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
