<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('courses::courses.classroom_training_application') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent="submit">
                <div class="form-group">
                    <label for="name">{{ __('courses::courses.name') }}</label>
                    <input type="text" class="form-control" id="name" wire:model="name">
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="address">{{ __('courses::courses.address') }}</label>
                    <textarea class="form-control" id="address" wire:model="address"></textarea>
                    @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="phone">{{ __('courses::courses.phone') }}</label>
                    <input type="text" class="form-control" id="phone" wire:model="phone">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="profession">{{ __('courses::courses.profession') }}</label>
                    <input type="text" class="form-control" id="profession" wire:model="profession">
                    @error('profession') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="organization">{{ __('courses::courses.organization') }}</label>
                    <input type="text" class="form-control" id="organization" wire:model="organization">
                    @error('organization') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="reason">{{ __('courses::courses.reason_for_taking_course') }}</label>
                    <textarea class="form-control" id="reason" wire:model="reason"></textarea>
                    @error('reason') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="am-btn">{{ __('courses::courses.submit_application') }}</button>
            </form>
        </div>
    </div>
</div>