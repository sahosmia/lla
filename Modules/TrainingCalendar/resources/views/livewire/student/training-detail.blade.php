<main class="am-main">
    <div class="container">
        <h2>{{ $registration->training?->title }}</h2>
        <div class="row">
            <div class="col-lg-8">
                <h4>{{ __('trainingcalendar::trainingcalendar.event_details') }}</h4>
                <ul class="list-unstyled">
                    <li><strong>{{ __('trainingcalendar::trainingcalendar.type') }}:</strong> {{ ucfirst($registration->training?->type) }}</li>
                    @if($registration->training?->type === 'offline')
                        <li><strong>{{ __('trainingcalendar::trainingcalendar.venue') }}:</strong> {{ $registration->training?->venue }}</li>
                    @endif
                    <li><strong>{{ __('trainingcalendar::trainingcalendar.event_datetime') }}:</strong> {{ $registration->training?->event_datetime?->format('M d, Y h:i A') }}</li>
                    <li><strong>{{ __('trainingcalendar::trainingcalendar.profession') }}:</strong> {{ $registration->profession }}</li>
                </ul>

                <h4 class="mt-4">{{ __('trainingcalendar::trainingcalendar.notices') }}</h4>
                @forelse($registration->training?->notices ?? [] as $notice)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>{{ $notice->subject }}</h6>
                            <p>{!! nl2br(e($notice->message)) !!}</p>
                            @if($notice->zoom_link)<p><strong>{{ __('trainingcalendar::trainingcalendar.zoom_link') }}:</strong> <a href="{{ $notice->zoom_link }}" target="_blank">{{ $notice->zoom_link }}</a></p>@endif
                            @if($notice->meet_link)<p><strong>{{ __('trainingcalendar::trainingcalendar.meet_link') }}:</strong> <a href="{{ $notice->meet_link }}" target="_blank">{{ $notice->meet_link }}</a></p>@endif
                            @if($notice->location)<p><strong>{{ __('trainingcalendar::trainingcalendar.location') }}:</strong> {{ $notice->location }}</p>@endif
                            <small>{{ $notice->sent_at?->format('M d, Y h:i A') }}</small>
                        </div>
                    </div>
                @empty
                    <p>{{ __('trainingcalendar::trainingcalendar.no_registrations_found') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</main>
