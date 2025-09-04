<?php

use App\Http\Requests\Auth\SocialProfileRequest;
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
    public string $name = '';
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
        $this->isProfilePhoneMendatory = setting('_lernen.phone_number_on_signup') === 'yes' ? true : false;
        $this->tutor_name   = !empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor');
        $this->student_name = !empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student');
        $this->email = session('email', '');
        $this->name = session('name', '');
        $nameParts = explode(' ', $this->name, 2);
        $this->first_name = $nameParts[0] ?? '';
        $this->last_name = $nameParts[1] ?? '';
    }

    public function socialProfile(): void
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
        $user = Auth::getProvider()->retrieveByCredentials($this->only(['email']));

        if (empty($user)) {
            $this->redirect(route('login', absolute: false));
        }

        $validated = $this->validate((new SocialProfileRequest())->rules());

        $user = (new RegisterService)->completeSocialProfile($user, $validated);

        $user->status = 'active';
        $user->default_role = $validated['user_role'];
        $user->save();

        Auth::login($user);

        $redirect = $user->roles()?->first()?->name == 'tutor' ? 'tutor.dashboard' : 'student.bookings';

        $this->redirect(route($redirect, absolute: false));
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
                <h2>{{ __('auth.social_right_h2') }}</h2>
                <h3>{{ __('auth.social_right_h3') }}</h3>
            </div>
        </x-slot>
        <form wire:submit="socialProfile" class="am-themeform am-login-form am-signup-form">
            <fieldset>
                <div class="am-themeform__wrap">
                    <div class="form-group-wrap">
                        <div class="am-form-group-row">
                            <div class="form-group {{ $errors->get('email') ? 'am-invalid' : '' }}">
                            <x-input-label for="email" :value="__('auth.your_email_placeholder')" class="am-important" />
                            <x-text-input id="email" disabled wire:model="email" placeholder="{{ __('auth.email_placeholder') }}" type="email"  autofocus  />
                            <x-input-error field_name="email" />
                        </div>
                        </div>
                        <div class="am-form-group-row">
                            <div class="form-group-half {{ $errors->get('first_name') ? 'am-invalid' : '' }}">
                                <x-input-label for="first_name" :value="__('auth.first_name')" class="am-important" />
                                <x-text-input id="first_name" wire:model="first_name" placeholder="{{ __('auth.first_name') }}" type="text"  autofocus autocomplete="name" />
                                <x-input-error field_name="first_name" />
                            </div>
                            <div class="form-group-half {{ $errors->get('last_name') ? 'am-invalid' : '' }}">
                                <x-input-label for="last_name" :value="__('auth.last_name')" class="am-important" />
                                <x-text-input id="last_name" wire:model="last_name" placeholder="{{ __('auth.last_name') }}" type="text"  autofocus  />
                                <x-input-error field_name="last_name" />
                            </div>
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
                        <div class="form-group am-form-groupradio">
                            <x-input-label :value="__('auth.role')" class="am-important" />
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
                        <div class="form-group @error('terms') am-invalid @enderror am-terms-check">
                            <div class="am-checkbox am-signup-check">
                                <input wire:model="terms" type="checkbox" id="terms" name="terms">
                                <label for="terms"><span>{!! __('auth.register_terms') !!}</label>
                            </div>
                            <x-input-error :field_name="'terms'"></x-input-error>
                        </div>
                        <div class="form-group">
                            <x-primary-button wire:loading.class="am-btn_disable"><span>{{ __('auth.setup_account') }}</span><i class="icon icon-arrow-right"></i></x-primary-button>
                             <span class="am-already-account"> {{ __('auth.already_have_account') }} <a href="{{ route('login') }}">{{ __('auth.login') }}</a></span>
                        </div>
                    </div>
                </div>
        </form>
    </x-auth-card>
</div>
@push('scripts')

@endpush
