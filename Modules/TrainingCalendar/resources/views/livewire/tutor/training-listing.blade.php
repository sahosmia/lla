<main class="am-main">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>{{ __('trainingcalendar::trainingcalendar.training_list') }}</h2>
            <a href="{{ route('trainingcalendar.tutor.create') }}" class="am-btn">{{ __('trainingcalendar::trainingcalendar.create_training') }}</a>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><input type="text" class="form-control" wire:model.live.debounce.400ms="keyword" placeholder="{{ __('general.search') }}"></div>
            <div class="col-md-3">
                <select class="form-control" wire:model.live="status">
                    <option value="">{{ __('trainingcalendar::trainingcalendar.status') }}</option>
                    <option value="draft">{{ __('trainingcalendar::trainingcalendar.draft') }}</option>
                    <option value="published">{{ __('trainingcalendar::trainingcalendar.published') }}</option>
                    <option value="cancelled">{{ __('trainingcalendar::trainingcalendar.cancelled') }}</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('trainingcalendar::trainingcalendar.title') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.price') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.registered_count') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.status') }}</th>
                        <th>{{ __('trainingcalendar::trainingcalendar.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trainings as $training)
                        <tr>
                            <td>{{ $training->title }}</td>
                            <td>{{ $training->event_datetime?->format('M d, Y h:i A') }}</td>
                            <td>{{ formatAmount($training->price) }}</td>
                            <td>{{ $training->paid_registrations_count }}</td>
                            <td>{{ ucfirst($training->status) }}</td>
                            <td>
                                <a href="{{ route('trainingcalendar.tutor.edit', $training->id) }}">{{ __('trainingcalendar::trainingcalendar.update') }}</a> |
                                <a href="{{ route('trainingcalendar.tutor.registrations', $training->id) }}">{{ __('trainingcalendar::trainingcalendar.view_registrations') }}</a> |
                                <a href="{{ route('trainingcalendar.tutor.send-notice', $training->id) }}">{{ __('trainingcalendar::trainingcalendar.send_notice') }}</a> |
                                <a href="javascript:void(0);" wire:click="deleteTraining({{ $training->id }})" wire:confirm="{{ __('trainingcalendar::trainingcalendar.confirm_delete') }}">{{ __('trainingcalendar::trainingcalendar.delete') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">{{ __('trainingcalendar::trainingcalendar.no_trainings') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $trainings->links('pagination.custom') }}
    </div>
</main>
