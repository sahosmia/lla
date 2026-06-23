<main class="am-main">
    <div class="container">
        <h2>{{ __('trainingcalendar::trainingcalendar.send_notice') }} - {{ $training->title }}</h2>
        <form wire:submit.prevent="send" class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.subject') }}</label>
                    <input type="text" class="form-control" wire:model="subject">
                    @error('subject') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.message') }}</label>
                    <textarea class="form-control" rows="5" wire:model="message"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.zoom_link') }}</label>
                    <input type="url" class="form-control" wire:model="zoom_link">
                    @error('zoom_link') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.meet_link') }}</label>
                    <input type="url" class="form-control" wire:model="meet_link">
                    @error('meet_link') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group mb-3">
                    <label>{{ __('trainingcalendar::trainingcalendar.location') }}</label>
                    <input type="text" class="form-control" wire:model="location">
                </div>
                <button type="submit" class="am-btn">{{ __('trainingcalendar::trainingcalendar.send_email') }}</button>
            </div>
        </form>
    </div>
</main>
