<ul class="am-userperinfo_tab">
    <li @class(['am-active'=> $activeRoute == auth()->user()->role.'.profile.personal-details'])>
        <a href="{{ route(auth()->user()->role.'.profile.personal-details') }}" wire:navigate.remove>
            {{__('profile.personal_details') }}
        </a>
    </li>
    <li @class(['am-active'=> $activeRoute == auth()->user()->role.'.profile.account-settings'])>
        <a href="{{ route(auth()->user()->role.'.profile.account-settings') }}" wire:navigate.remove>
            {{__('profile.account_settings') }}
        </a>
    </li>
    @if(auth()->user()->role == 'tutor')
        <li @class(['am-active'=> in_array($activeRoute , [auth()->user()->role.'.profile.resume.education', auth()->user()->role.'.profile.resume.experience', auth()->user()->role.'.profile.resume.certificate'])])>
            <a href="{{ route('tutor.profile.resume.education') }}"
                wire:navigate.remove>{{ __('profile.resume_highlights') }}
            </a>
        </li>
    @endif
    
    @php
        $isIdentity = setting('_lernen.identity_verification_for_role') ?? "both";
    @endphp

    @if(auth()->user()->role == 'tutor' || $isIdentity == 'both')
        <li @class(['am-active'=> $activeRoute == auth()->user()->role.'.profile.identification'])>
            <a href="{{ route(auth()->user()->role.'.profile.identification') }}" wire:navigate.remove>
                {{ __('profile.identity_verification') }}
            </a>
        </li>
    @endif
</ul>