<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);
        
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    @slot('title')
        {{ __('auth.reset_password') }}
    @endslot
    <x-auth-card>
        <x-slot name="logo">
            <strong>
                <x-application-logo :variation="'white'" />
            </strong>
        </x-slot>
        <x-slot name="formHeader">
            <strong class="am-mobile-logo">
                <x-application-logo />
            </strong>
            <div class="am-login-right_title">
                <h2>{{ __('auth.reset_password') }}</h2>
                <h3>{{ __('auth.reset_password_desc') }}</h3>
            </div>
        </x-slot>
        <form class="am-themeform am-login-form" wire:submit="resetPassword">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="form-group {{ $errors->get('email') ? 'am-invalid' : '' }}">
                            <x-input-label for="email" :value="__('general.email')" />
                            <x-text-input wire:model="email" placeholder="{{ __('auth.email_placeholder') }}" id="email" type="email" name="email" required autofocus autocomplete="username" />
                            <x-input-error field_name="email" />
                        </div>

                        <div class="form-group {{ $errors->get('password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password" :value="__('general.password')" />
                            <x-text-input wire:model="password" placeholder="{{ __('auth.password_placeholder') }}" id="password" type="password" name="password" required autocomplete="new-password" />
                            <x-input-error field_name="password" />
                        </div>

                        <div class="form-group {{ $errors->get('password_confirmation') ? 'am-invalid' : '' }}">
                            <x-input-label for="password_confirmation" :value="__('general.confirm_password')" />

                            <x-text-input wire:model="password_confirmation" id="password_confirmation"
                                        type="password" placeholder="{{ __('auth.confirm_password_placeholder') }}"
                                        name="password_confirmation" required autocomplete="new-password" />

                            <x-input-error field_name="password_confirmation" />
                        </div>

                        <div class="form-group">
                            <x-primary-button wire:loading.class="am-btn_disable">
                                {{ __('auth.reset_password') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </x-auth-card>
</div>
