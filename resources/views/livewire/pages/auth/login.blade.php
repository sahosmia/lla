<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    public string $id = '';
    public function mount() {
        $this->id = request()->query('id') ?? '';
    }
    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        if(isActiveModule('ipmanager')){
            if(isBlockedIP($this->form->email)){
                $this->dispatch('showAlertMessage', type: 'error', title: __('ipmanager::ipmanager.error_title') , message: __('ipmanager::ipmanager.access_denied'));
                return;
            }
        }

        $this->form->authenticate();
        Session::regenerate();


        $this->dispatch('showAlertMessage', type: 'success', title: __('general.success_title') , message: __('general.login_success'));
        usleep(500);
        if($this->id != '' && auth()->user()->role == 'student'){
            $this->redirect(route('session-detail', encrypt($this->id)));
        }else {
            $this->redirect(auth()->user()->redirect_after_login);
        }
    }

    public function redirectGoogle() 
    {
        $response = isDemoSite();
        if( $response ){
            $this->dispatch('showAlertMessage', type: 'error', title:  __('general.demosite_res_title') , message: __('general.demosite_res_txt'));
            return;
        }
        return $this->redirect(route('social.redirect', ['provider' => 'google']));
    }

}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    @slot('title')
        {{ __('auth.login') }}
    @endslot
    <!-- Search Header Start -->
    <x-auth-card>
        <x-slot name="logo">
            <strong>
                <x-application-logo :variation="'white'" />
            </strong>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-slot name="formHeader">
            <strong class="am-mobile-logo">
                <x-application-logo />
            </strong>
            <div class="am-login-right_title">
                <h2>{{ __('auth.login_right_h2') }}</h2>
                <h3>{{ __('auth.login_right_h3') }}</h3>
            </div>
        </x-slot>
        <form wire:submit.prevent="login" class="am-themeform am-login-form" x-data="{form:@entangle('form')}">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="form-group {{ $errors->get('form.email') ? 'am-invalid' : '' }}">
                            <x-input-label class="am-important" for="username" :value="__('auth.email_placeholder')" />
                            <x-text-input x-model="form.email" id="username" wire:model="form.email" placeholder="{{ __('auth.email_placeholder') }}" type="text"  autofocus  />
                            <x-input-error field_name="form.email" />
                        </div>
                        <div class="form-group pb-2 {{ $errors->get('form.password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password" class="am-important" :value="__('auth.password_placeholder')" />
                            <div class="am-passwordfield">
                                <x-text-input x-model="form.password" id="password" wire:model="form.password" placeholder="{{ __('auth.password_placeholder') }}" type="password" autofocus />
                                <i class="am-icon-eye-close-01" id="togglePassword"></i>
                            </div>
                            <x-input-error field_name="form.password" />
                        </div>
                        <div class="form-group am-lost-password">
                            <div class="am-checkbox">
                                <input id="remember_me" type="checkbox" x-model="form.remember" name="remember">
                                <label for="remember_me">
                                    <span>{{ __('auth.remember_me') }}</span>
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}">{{ __('auth.lost_password') }}</a>
                        </div>
                        <div class="form-group">
                            <x-primary-button wire:loading.class="am-btn_disable" wire:target="login"><span>{{ __('auth.login_btn') }}</span><i class="icon icon-arrow-right"></i></x-primary-button>
                        </div>
                        @if(isDemoSite())
                            <div class="form-group">
                                @php
                                    $tutor_name   = !empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor');
                                    $student_name = !empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student');
                                @endphp
                                <div class="am-login-options">
                                    <em>{{ __('auth.login_as') }}</em>
                                    <button type="button" class="am-btn" x-data @click="form.email = 'anthony@amentotech.com'; form.password = 'google'">
                                        {{$tutor_name}}
                                    </button>

                                    <button type="button" class="am-btn" x-data @click="form.email = 'student@amentotech.com'; form.password = 'google'">
                                        {{ $student_name }}
                                    </button>

                                    <button type="button" class="am-btn" x-data @click="form.email = 'admin@amentotech.com'; form.password = 'google'">
                                        {{ __('auth.admin') }}
                                    </button>
                                    @if(setting('_lernen.allow_register') !== 'no')
                                        <span class="am-already-account">
                                            {{ __('auth.dont_account_join') }}
                                            <a href="{{ route('register') }}">{{ __('auth.join') }}</a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            @if(setting('_lernen.allow_register') !== 'no')
                                <span class="am-already-account">
                                    {{ __('auth.dont_account_join') }}
                                    <a href="{{ route('register') }}">{{ __('auth.join') }}</a>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            </fieldset>
        </form>

        @if (isGoogleSociaLoginEnabled() && setting('_lernen.allow_register') !== 'no' )    
            <div class="am-signinoption">
                <span class="am-signinoption_br"><em>{{ __('auth.or') }}</em></span>
                <a href="#" wire:click.prevent="redirectGoogle" wire:target="redirectGoogle" wire:loading.class="am-btn_disable" class="am-signinoption_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none">
                        <path d="M19.3 10.708C19.3 10.058 19.2417 9.43301 19.1333 8.83301H10.5V12.3788H15.4333C15.2208 13.5247 14.575 14.4955 13.6042 15.1455V17.4455H16.5667C18.3 15.8497 19.3 13.4997 19.3 10.708Z" fill="#4285F4"/>
                        <path d="M10.5003 19.6662C12.9753 19.6662 15.0503 18.8454 16.5669 17.4454L13.6044 15.1454C12.7836 15.6954 11.7336 16.0204 10.5003 16.0204C8.11276 16.0204 6.09193 14.4079 5.37109 12.2412H2.30859V14.6162C3.81693 17.612 6.91693 19.6662 10.5003 19.6662Z" fill="#34A853"/>
                        <path d="M5.37148 12.2411C5.18815 11.6911 5.08399 11.1036 5.08399 10.4995C5.08399 9.89531 5.18815 9.30781 5.37148 8.75781V6.38281H2.30899C1.66732 7.66019 1.33342 9.06999 1.33399 10.4995C1.33399 11.9786 1.68815 13.3786 2.30899 14.6161L5.37148 12.2411Z" fill="#FBBC05"/>
                        <path d="M10.5003 4.97884C11.8461 4.97884 13.0544 5.44134 14.0044 6.34967L16.6336 3.72051C15.0461 2.24134 12.9711 1.33301 10.5003 1.33301C6.91693 1.33301 3.81693 3.38717 2.30859 6.38301L5.37109 8.75801C6.09193 6.59134 8.11276 4.97884 10.5003 4.97884Z" fill="#EA4335"/>
                    </svg>
                    {{ __('auth.sign_in_with_google') }}
                </a>
            </div>
        @endif
    </x-auth-card>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');

        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            if (type === 'password') {
                togglePassword.classList.remove('am-icon-eye-open-01');
                togglePassword.classList.add('am-icon-eye-close-01');
            } else {
                togglePassword.classList.remove('am-icon-eye-close-01');
                togglePassword.classList.add('am-icon-eye-open-01');
            }
        });
    });
</script>
@endpush
