<?php

use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Services\RegisterService;
use App\Livewire\Forms\Auth\RegisterUserForm;

new #[Layout('layouts.guest')] class extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $user_role    = 'tutor';
    public string $terms        = '';
    public string $phone_number = '';
    public bool $isProfilePhoneMendatory = true;
    public $tutor_name = '';
    public $student_name = '';

    /**
     * Handle an incoming registration request.
     */

    public function mount(): void
    {
        if(setting('_lernen.allow_register') === 'no') {
            abort(404);
        } 
        if(setting('_lernen.restricting_tutor_account_creation') === 'yes'){
            $this->user_role = 'student';
        }
        $this->tutor_name   = !empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor');
        $this->student_name = !empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student');
        $this->isProfilePhoneMendatory = setting('_lernen.phone_number_on_signup') === 'yes' ? true : false;
    }

    public function register(): void
    {
        $response = isDemoSite();
        if ($response) {
            $this->dispatch(
                'showAlertMessage',
                type: 'error',
                title: __('general.demosite_res_title'),
                message: __('general.demosite_res_txt')
            );
            return;
        }
        
        $validated = $this->validate((new RegisterUserRequest())->rules());
        $user = (new RegisterService)->registerUser($validated);
        Auth::login($user);
        $this->redirect(route('tutor.profile.personal-details', absolute: false), navigate: true);
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
    @slot('title')
        {{ __('auth.join') }}
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
                <h2>{{ __('auth.register_right_h2') }}</h2>
                <h3>{{ __('auth.register_right_h3') }}</h3>
            </div>
        </x-slot>
        <form wire:submit="register" class="am-themeform am-login-form am-signup-form">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="am-form-group-row">
                            <div class="form-group-half {{ $errors->get('first_name') ? 'am-invalid' : '' }}">
                                <x-input-label for="first_name" :value="__('auth.first_name')" />
                                <x-text-input id="first_name" wire:model="first_name" placeholder="{{ __('auth.first_name') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="first_name" />
                            </div>
                            <div class="form-group-half {{ $errors->get('last_name') ? 'am-invalid' : '' }}">
                                <x-input-label for="last_name" :value="__('auth.last_name')" />
                                <x-text-input id="last_name" wire:model="last_name" placeholder="{{ __('auth.last_name') }}" type="text"  autofocus  />
                                <x-input-error field_name="last_name" />
                            </div>
                        </div>
                        <div class="form-group {{ $errors->get('email') ? 'am-invalid' : '' }}">
                            <x-input-label for="email" :value="__('auth.email_placeholder')" />
                            <x-text-input id="email" wire:model="email" placeholder="{{ __('auth.email_placeholder') }}" type="email"  autofocus  />
                            <x-input-error field_name="email" />
                        </div>
                        @if($isProfilePhoneMendatory)
                        <div class="form-group @error('phone_number') am-invalid @enderror">
                            <x-input-label for="phone_number" :value="__('general.phone_number')" class="am-important" />
                            <div class="form-control_wrap">
                                <x-text-input wire:model="phone_number" id="phone_number" placeholder="{{ __('general.enter_phone_number') }}" name="phone_number" type="text" class="block w-full mt-1"  autocomplete="phone_number" />
                                <x-input-error field_name="phone_number" />
                            </div>
                        </div>
                        @endif
                        <div class="form-group {{ $errors->get('password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password" :value="__('auth.password_placeholder')" />
                            <div class="am-passwordfield">
                                <x-text-input id="password" wire:model="password" placeholder="{{ __('auth.password_placeholder') }}" type="password"  autofocus  />
                                <i class="am-icon-eye-close-01" id="togglePassword"></i>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->get('password') ? 'am-invalid' : '' }}">
                            <x-input-label for="password_confirmation" :value="__('auth.confirm_password_placeholder')" />
                            <div class="am-passwordfield">
                                <x-text-input id="password_confirmation" wire:model="password_confirmation" placeholder="{{ __('auth.confirm_password_placeholder') }}" type="password"  autofocus  />
                                <i class="am-icon-eye-close-01" id="toggleConfirmPassword"></i>
                            </div>
                            <x-input-error field_name="password" />
                        </div>
                        @if(setting('_lernen.restricting_tutor_account_creation') === 'no')
                            <div class="form-group am-form-groupradio">
                                <x-input-label :value="__('auth.role')" />
                                <div class="am-selectrole">
                                    <div class="am-radio">
                                        <input wire:model="user_role" id="tutor" value="tutor" type="radio" autofocus name="user_role">
                                        <x-input-label for="tutor" :value="$tutor_name" />
                                    </div>
                                    <div class="am-radio">
                                        <input wire:model="user_role" id="student" value="student" type="radio" autofocus name="user_role">
                                        <x-input-label for="student" :value="$student_name" />
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group @error('terms') am-invalid @enderror am-terms-check">
                            <div class="am-checkbox am-signup-check">
                                <input wire:model="terms" type="checkbox" id="terms" name="terms">
                                <label for="terms"><span>{!! __('auth.register_terms') !!}</label>
                            </div>
                            <x-input-error :field_name="'terms'"></x-input-error>
                        </div>
                        <div class="form-group">
                            <x-primary-button wire:target="register" wire:loading.class="am-btn_disable"><span>{{ __('auth.register') }}</span><i class="icon icon-arrow-right"></i></x-primary-button>
                             <span class="am-already-account"> {{ __('auth.already_have_account') }} <a href="{{ route('login') }}">{{ __('auth.login') }}</a></span>
                        </div>
                    </div>
                </div>
        </form>
        @if (!empty(setting('_api.enable_social_login')) && ((!empty(setting('_api.social_google_client_id')) && !empty(setting('_api.social_google_client_secret')))))
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
        function togglePasswordVisibility(toggleButton, passwordField) {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            toggleButton.classList.toggle('am-icon-eye-close-01', type === 'password');
            toggleButton.classList.toggle('am-icon-eye-open-01', type !== 'password');
        }
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPasswordField = document.getElementById('password_confirmation');

        togglePassword.addEventListener('click', function () {
            togglePasswordVisibility(togglePassword, passwordField);
        });

        toggleConfirmPassword.addEventListener('click', function () {
            togglePasswordVisibility(toggleConfirmPassword, confirmPasswordField);
        });
    });
</script>
@endpush
