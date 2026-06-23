<main class="am-main">
    <div class="container">
        <h2>{{ __('trainingcalendar::trainingcalendar.my_trainings') }}</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('trainingcalendar::trainingcalendar.training') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.type') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $registration->training?->title }}</td>
                            <td>{{ $registration->training?->event_datetime?->format('M d, Y h:i A') }}</td>
                            <td>{{ ucfirst($registration->training?->type) }}</td>
                            <td>
                                <a href="{{ route('trainingcalendar.student.training-detail', $registration->id) }}">{{ __('general.view') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">{{ __('trainingcalendar::trainingcalendar.no_registrations_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $registrations->links('pagination.custom') }}
    </div>
</main>
