<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\RegisterService;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    protected $registerService;

    public function boot(){
        $this->registerService = new RegisterService();
    }

    public function mount(){
        if (Auth::user()->hasVerifiedEmail()) {
            return $this->redirectIntended(default: auth()->user()->redirect_after_login, navigate: true);
        }
    }

    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: auth()->user()->redirect_after_login, navigate: true);

            return;
        }

        $this->registerService->sendEmailVerificationNotification(Auth::user());

        $this->dispatch('showAlertMessage', type: 'success', message: __('auth.verify_email_link'));
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div>
    @slot('title')
        {{ __('auth.verify_email') }}
    @endslot
    <x-auth-card>
        <x-slot name="logo">
            <strong>
                <x-application-logo :variation="'white'" />
            </strong>
        </x-slot>
        <x-slot name="figure">
            @php
                $src = !empty(setting('site.auth_bg')) ? resizedImage(setting('site.auth_bg')[0]['path'], 500, 320) : asset('images/login/img-01.png');
            @endphp
            <x-figure :src="$src"/>
        </x-slot>

        <x-slot name="formHeader">
            <strong class="am-mobile-logo">
                <x-application-logo />
            </strong>
            <div class="am-login-right_title">
                <h2>{{ __('auth.verify_title') }}</h2>
                <p class="am-description">{{ __('auth.verify_email_msg') }}</p>
                <p class="am-description">{{ __('auth.verify_email_msg2') }}</p>
            </div>
        </x-slot>

        <div class="am-login-right_btns">
            <x-primary-button wire:click="sendVerification" wire:loading.class="am-btn_disable">
                {{ __('auth.resend_verification_email') }}
            </x-primary-button>

            <button wire:click="logout" wire:loading.class="am-btn_disable" type="submit" class="am-white-btn">
                {{ __('auth.log_out') }}
            </button>
        </div>
    </x-auth-card>
</div>
