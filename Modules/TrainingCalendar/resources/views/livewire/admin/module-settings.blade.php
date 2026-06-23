<main class="tb-main">
    <div class="container-fluid">
        <div class="tb-sectiontitle">
            <h5> {{__('trainingcalendar::trainingcalendar.module_settings')}}</h5>
        </div>
        <form wire:submit.prevent="save" class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.allow_free_training') }}</label>
                    <select class="form-control" wire:model="allow_free_training">
                        <option value="yes">{{ __('general.yes') }}</option>
                        <option value="no">{{ __('general.no') }}</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.enforce_registration_deadline') }}</label>
                    <select class="form-control" wire:model="enforce_registration_deadline">
                        <option value="yes">{{ __('general.yes') }}</option>
                        <option value="no">{{ __('general.no') }}</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.enable_seat_limit') }}</label>
                    <select class="form-control" wire:model="enable_seat_limit">
                        <option value="yes">{{ __('general.yes') }}</option>
                        <option value="no">{{ __('general.no') }}</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.default_max_seats') }}</label>
                    <input type="number" min="1" class="form-control" wire:model="default_max_seats">
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.require_login') }}</label>
                    <input type="text" class="form-control" value="{{ __('general.yes') }}" disabled>
                </div>
                <button type="submit" class="tb-btn">{{ __('trainingcalendar::trainingcalendar.save') }}</button>
            </div>
        </form>
    </div>
</main>
