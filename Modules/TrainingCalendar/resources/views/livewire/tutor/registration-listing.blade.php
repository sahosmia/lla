<main class="am-main">
    <div class="container">
        <h2>{{ __('trainingcalendar::trainingcalendar.registrations') }} - {{ $training->title }}</h2>
        <div class="mb-3">
            <a href="{{ route('trainingcalendar.tutor.send-notice', $training->id) }}" class="am-btn">{{ __('trainingcalendar::trainingcalendar.send_notice') }}</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('trainingcalendar::trainingcalendar.name') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.email') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.phone') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.profession') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.payment_status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                        <tr>
                            <td>{{ $registration->name }}</td>
                            <td>{{ $registration->email }}</td>
                            <td>{{ $registration->phone }}</td>
                            <td>{{ $registration->profession }}</td>
                            <td>{{ ucfirst($registration->payment_status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">{{ __('trainingcalendar::trainingcalendar.no_registrations_found') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $registrations->links('pagination.custom') }}
    </div>
</main>
