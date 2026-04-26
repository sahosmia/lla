<div class="am-event-registration-form p-4 border rounded shadow-sm bg-white">
    <h3 class="mb-4">Register for this Event</h3>
    <form wire:submit.prevent="register">
        <div class="form-group mb-3">
            <label class="am-label">Full Name</label>
            <input type="text" wire:model="name" class="form-control" placeholder="Enter your full name" @if(Auth::check()) readonly @endif>
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="form-group mb-3">
            <label class="am-label">Email Address</label>
            <input type="email" wire:model="email" class="form-control" placeholder="Enter your email" @if(Auth::check()) readonly @endif>
            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="form-group mb-3">
            <label class="am-label">Profession</label>
            <input type="text" wire:model="profession" class="form-control" placeholder="e.g. Software Engineer">
            @error('profession') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="form-group mb-3">
            <label class="am-label">Organization</label>
            <input type="text" wire:model="organization" class="form-control" placeholder="e.g. Prime Bank PLC">
            @error('organization') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            @if(Auth::check() && $event->users()->where('user_id', Auth::id())->exists())
                <button class="am-btn am-btn-success w-100" type="button" disabled>Already Registered</button>
            @else
                <button type="submit" class="am-btn w-100">
                    <span wire:loading.remove wire:target="register">Confirm Registration</span>
                    <span wire:loading wire:target="register" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </button>
            @endif
        </div>

        @guest
            <p class="mt-3 text-center small text-muted">
                Already have an account? <a href="{{ route('login') }}" class="am-link">Login</a>
            </p>
        @endguest
    </form>
</div>
