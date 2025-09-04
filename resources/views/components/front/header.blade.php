@props(['page'=> null])
@php
    $headerVariations = setting('_front_page_settings.header_variation_for_pages');
    $headerVariation  = '';
    if (!empty($headerVariations)) {
        foreach ($headerVariations as $key => $variation) {
           if($variation['page_id'] == $page?->id) {
                $headerVariation = $variation['header_variation'];
                break;
           }
        }
    }
@endphp

@if ($headerVariation == 'am-header_four')  
    <header class="am-header_four">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap am-header-bg">
                        <strong class="am-logo">
                            <x-application-logo />
                        </strong>
                        <nav class="am-navigation am-navigation-four navbar-expand-xxl">
                            
                            <div class="am-navbar-toggler">
                                <div  class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="Toggle navigation" role="button">
                                </div>
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox" class="toggler-menu">
                                    <span class="menu-bars" id="menu-bar1"></span>
                                    <span class="menu-bars" id="menu-bar2"></span>
                                    <span class="menu-bars" id="menu-bar3"></span>
                                </label>
                            </div>
                            <ul id="tenavbar" class="collapse navbar-collapse">
                                @if (!empty(getMenu('header')))
                                    @foreach (getMenu('header') as $item)
                                        <x-menu-item :menu="$item" />
                                    @endforeach
                                @endif
                            </ul>
                        </nav>
                        @auth
                            <x-frontend.user-menu />
                        @endauth
                        @guest
                            <div class="am-loginbtns">
                                <x-multi-currency />
                                <x-multi-lingual />
                                <a href="{{ route('login') }}" class="am-white-btn">{{ __('general.login') }}</a>
                                @if(setting('_lernen.allow_register') !== 'no')
                                    <a href="{{ route('register') }}" class="am-btn">{{ __('general.get_started') }}</a>
                                @endif
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>
@elseif ($headerVariation == 'am-header_seven')
    <header class="am-header-six">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap">
                        <strong class="am-logo">
                            <x-application-logo />
                        </strong>
                        <div class="am-loginbtns">
                            @guest
                                <a href="{{ route('login') }}" class="am-btn">{{ __('general.login') }}</a>
                            @endguest
                            <button type="button" class="navbar-toggler am-menubtn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">{{ __('general.menu') }} 
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                        <path d="M2.93359 14.0283H14.9336M8.26693 8.695H14.9336M2.93359 3.36166H14.9336" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </button>
                            @auth
                                <x-frontend.user-menu :multiLang="false" />
                            @endauth
                            <div class="am-sidebar-menu offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <strong class="am-logo">
                                        <a href="#">
                                            <img src="{{asset ('demo-content/logo-white.svg')}}" alt="">
                                        </a>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M6 18L18 6M6 6L18 18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav flex-grow-1">
                                        @if (!empty(getMenu('header')))
                                            @foreach (getMenu('header') as $item)
                                                <x-menu-item :menu="$item" :enableToggle="true" />
                                            @endforeach
                                        @endif
                                        @guest
                                            <x-multi-currency />
                                            <x-multi-lingual />
                                        @endguest
                                    </ul>
                                    @guest
                                        <div class="am-btns">
                                            <a href="{{ route('login') }}" class="am-btn am-joinnow-btn">{{ __('general.login') }}</a>
                                            @if(setting('_lernen.allow_register') !== 'no')
                                                <a href="{{ route('register') }}" class="am-btn">{{ __('general.get_started') }}</a>
                                            @endif
                                        </div>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
@else
    <header @class([
        'am-header_two', $headerVariation,
        'am-header-bg' => (empty($page) && !in_array(request()->route()->getName(), ['find-tutors','tutor-detail'])) || in_array($page?->slug, ['about-us', 'how-it-works', 'faq', 'terms-condition', 'privacy-policy'])
        ])>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="am-header_two_wrap">
                        <strong class="am-logo">
                            <x-application-logo />
                        </strong>
                        <nav class="am-navigation navbar-expand-xl">
                            <div class="am-navbar-toggler">
                                <div  class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#tenavbar" aria-expanded="false" aria-label="Toggle navigation" role="button">
                                </div>
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox" class="toggler-menu">
                                    <span class="menu-bars" id="menu-bar1"></span>
                                    <span class="menu-bars" id="menu-bar2"></span>
                                    <span class="menu-bars" id="menu-bar3"></span>
                                </label>
                            </div>
                            <ul id="tenavbar" class="collapse navbar-collapse">
                            @if (!empty(getMenu('header')))
                                @foreach (getMenu('header') as $item)
                                    <x-menu-item :menu="$item" />
                                @endforeach
                            @endif
                            </ul>
                        </nav>
                        @auth
                        <x-frontend.user-menu />
                        @endauth
                        @guest
                            <div class="am-loginbtns">
                                <x-multi-currency />
                                <x-multi-lingual />
                                <a href="{{ route('login') }}" class="am-btn">{{ __('general.login') }}</a>
                                @if(setting('_lernen.allow_register') !== 'no')
                                    <a href="{{ route('register') }}" class="am-white-btn">{{ __('general.get_started') }}</a>
                                @endif
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </header>
@endif