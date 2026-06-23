<main class="am-main">
    <div class="container">
        <h2>{{ $trainingId ? __('trainingcalendar::trainingcalendar.edit_training') : __('trainingcalendar::trainingcalendar.create_training') }}</h2>
        <form wire:submit.prevent="save" class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.title') }}</label>
                    <input type="text" class="form-control" wire:model="title">
                    @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.description') }}</label>
                    <textarea class="form-control" rows="5" wire:model="description"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>{{ __('trainingcalendar::trainingcalendar.price') }}</label>
                        <input type="number" step="0.01" min="0" class="form-control" wire:model="price">
                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>{{ __('trainingcalendar::trainingcalendar.max_seats') }}</label>
                        <input type="number" min="1" class="form-control" wire:model="max_seats">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>{{ __('trainingcalendar::trainingcalendar.type') }}</label>
                        <select class="form-control" wire:model.live="type">
                            <option value="online">{{ __('trainingcalendar::trainingcalendar.online') }}</option>
                            <option value="offline">{{ __('trainingcalendar::trainingcalendar.offline') }}</option>
                        </select>
                    </div>
                    @if($type === 'offline')
                        <div class="col-md-6 mb-3">
                            <label>{{ __('trainingcalendar::trainingcalendar.venue') }}</label>
                            <input type="text" class="form-control" wire:model="venue">
                            @error('venue') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>{{ __('trainingcalendar::trainingcalendar.registration_deadline') }}</label>
                        <input type="datetime-local" class="form-control" wire:model="registration_deadline">
                        @error('registration_deadline') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</label>
                        <input type="datetime-local" class="form-control" wire:model="event_datetime">
                        @error('event_datetime') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.status') }}</label>
                    <select class="form-control" wire:model="status">
                        <option value="draft">{{ __('trainingcalendar::trainingcalendar.draft') }}</option>
                        <option value="published">{{ __('trainingcalendar::trainingcalendar.published') }}</option>
                        <option value="cancelled">{{ __('trainingcalendar::trainingcalendar.cancelled') }}</option>
                    </select>
                </div>
                <button type="submit" class="am-btn">{{ __('trainingcalendar::trainingcalendar.save') }}</button>
            </div>
        </form>
    </div>
</main>
