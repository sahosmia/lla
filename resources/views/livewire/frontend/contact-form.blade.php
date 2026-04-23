<div>
    @if ($successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="am-contact-form">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group am-form-group">
                    <label>{{ __('Full Name') }}</label>
                    <input type="text" wire:model="fullname" class="form-control" placeholder="{{ __('Enter your full name') }}">
                    @error('fullname') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group am-form-group">
                    <label>{{ __('Organization / University') }}</label>
                    <input type="text" wire:model="organization" class="form-control" placeholder="{{ __('Enter your organization or university') }}">
                    @error('organization') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group am-form-group">
                    <label>{{ __('Designation') }}</label>
                    <input type="text" wire:model="designation" class="form-control" placeholder="{{ __('Enter your designation') }}">
                    @error('designation') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group am-form-group">
                    <label>{{ __('Email Address') }}</label>
                    <input type="email" wire:model="email" class="form-control" placeholder="{{ __('Enter your email address') }}">
                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group am-form-group">
                    <label>{{ __('Contact Number') }}</label>
                    <input type="text" wire:model="phone" class="form-control" placeholder="{{ __('Enter your contact number') }}">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-group am-form-group">
                    <label>{{ __('Type of Inquiry') }}</label>
                    <select wire:model="type" class="form-control">
                        <option value="">{{ __('Select Inquiry Type') }}</option>
                        <option value="Training">{{ __('Training') }}</option>
                        <option value="Corporate">{{ __('Corporate') }}</option>
                        <option value="University">{{ __('University') }}</option>
                        <option value="Other">{{ __('Other') }}</option>
                    </select>
                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group am-form-group">
                    <label>{{ __('Message') }}</label>
                    <textarea wire:model="message" class="form-control" rows="5" placeholder="{{ __('Enter your message') }}"></textarea>
                    @error('message') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="am-btn" wire:loading.attr="disabled">
                    {{ __('general.submit_btn') }}
                    <span wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </form>
</div>
