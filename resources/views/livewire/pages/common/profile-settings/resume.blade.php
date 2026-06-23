<div class="am-profile-setting">
    @include('livewire.pages.common.profile-settings.tabs')
    <div class="am-userperinfo">
        <div class="am-resumebox">
            <div class="am-resumebox_tab">
                <div class="am-resumebox_tab_title">
                    <span>{{ __('profile.resume_highlights') }}</span>
                </div>
                <ul class="am-resumebox_tab_list">
                    @foreach ($routes as $item)
                    <li @class(["am-active"=> $activeRoute == $item['route']])>
                        <a href="{{ route($item['route']) }}" wire:navigate.remove>
                            {!! $item['icon'] !!}
                            <span>{{ $item['title'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @if(request()->routeIs('*.resume.experience'))
            <livewire:pages.common.profile-settings.resume.experience />
            @elseif(request()->routeIs('*.resume.certificate'))
            <livewire:pages.common.profile-settings.resume.certificate />
            @else
            <livewire:pages.common.profile-settings.resume.education />
            @endif
        </div>
    </div>
</div>
