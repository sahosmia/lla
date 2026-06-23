

<div class="am-profile-setting">

    @if(request()->routeIs('tutor.profile.resume.*'))
        <livewire:components.tutor.profile.resume />
    @elseif(request()->routeIs('tutor.profile.identification'))
        <livewire:components.tutor.profile.identification />
    @elseif(request()->routeIs('tutor.profile.account-settings'))
        {{ $slot }}
    @else
        <livewire:components.tutor.profile.general />
    @endif
</div>
