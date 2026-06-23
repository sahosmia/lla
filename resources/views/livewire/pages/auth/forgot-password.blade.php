<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');
        $this->dispatch('showAlertMessage', type: 'success', message: __($status));
    }
};
?>

<div>
    @slot('title')
        {{ __('auth.forget_right_h2') }}
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
                <h2>{{ __('auth.forget_right_h2') }}</h2>
                <h3>{{ __('auth.forget_right_h3') }}</h3>
            </div>
        </x-slot>
        <form class="am-themeform am-login-form" wire:submit="sendPasswordResetLink">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="form-group {{ $errors->get('email') ? 'am-invalid' : '' }}">
                            <x-input-label for="email" :value="__('general.email')" />
                            <x-text-input wire:model="email" placeholder="{{ __('auth.email_placeholder') }}" id="email" type="email" name="email" required autofocus />
                            <x-input-error field_name="email" />
                        </div>

                        <div class="form-group">
                            <x-primary-button wire:loading.class="am-btn_disable">
                                {{ __('auth.email_reset_password_link') }}
                            </x-primary-button>
                        </div>
                        <div class="form-group text-center">
                            <span class="am-already-account m-0"><a href="{{ route('login') }}">{{ __('auth.back_to_sign_in') }}</a></span>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </x-auth-card>
</div>
