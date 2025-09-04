<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ) dir="rtl" @endif>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @php
            $siteTitle        = setting('_general.site_name');
        @endphp
        <title>{{ $siteTitle }} {!! request()->is('messenger') ? ' | Messages' : (!empty($title) ? ' | ' . $title : '') !!}</title>
        <x-favicon />
        @vite([
            'public/css/bootstrap.min.css',
            'public/css/fonts.css',
            'public/css/icomoon/style.css',
            'public/css/select2.min.css',
        ])
        <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
        @stack('styles')
        @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) )
            <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
        @endif
        @livewire('livewire-ui-spotlight')
        @livewireStyles()
    </head>
    <body class="font-sans antialiased @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ) am-rtl @endif"
        x-data="{ isDragging: false }"
        x-on:dragover.prevent="isDragging = true"
        x-on:drop="isDragging = false">
        <div class="am-dashboardwrap">
            <livewire:pages.common.navigation />
            <div class="am-mainwrap">
                <livewire:header.header />
                <!-- Page Content -->
                <main class="am-main">
                    <div class="am-dashboard_box">
                        <div class="am-dashboard_box_wrap">
                            @yield('content')
                            {{ $slot ?? '' }}
                             @if (
                                setting('_api.active_conference') == 'google_meet' && 
                                empty(isCalendarConnected(Auth::user())) && 
                                !request()->routeIs(auth()->user()->role. '.profile.account-settings')
                             )
                                <div class="am-connect_google_calendar">
                                    <div class="am-connect_google_calendar_title">
                                        <figure>
                                            <img src="{{ asset('images/calendar.png') }}" alt="Image">
                                        </figure>
                                        <h4>{{ __('passwords.connect_google_calendar') }}</h4>
                                        <i class="am-icon-multiply-02" @click="jQuery('.am-connect_google_calendar').remove()"></i>
                                    </div>
                                    <p> {{ __('calendar.'.auth()->user()->role.'_calendar_alert_msg') }}</p>
                                    <a href="{{ route(auth()->user()->role.'.profile.account-settings') }}" class="am-btn">{{ __('general.connect') }}</a>
                                </div>
                            @endif   
                        </div>
                    </div>
                </main>
            </div>
            @if(session('impersonated_name'))
                <div class="am-impersonation-bar">
                    <span>{{ __('general.impersonating') }} <strong>{{ session('impersonated_name') }}</strong></span>
                    <a href="{{ route('exit-impersonate') }}" class="am-btn">{{ __('general.exit') }}</a>
                </div>
            @endif
            @auth
                @if (
                    session('default_role_id'   . auth()->user()->id) && 
                    session('active_role_id'    . auth()->user()->id) && 
                    session('default_role_id'   . auth()->user()->id) != session('active_role_id' . auth()->user()->id)
                )
                    <div class="am-impersonation-bar" onclick="$(this).hide()">
                        <span>{!! __('app.switched_role_message', ['role' => Str::ucfirst(auth()->user()->role)]) !!}</span>
                        <a href="javascript:void(0);" class="am-btn">{{ __('general.close_btn') }}</a>
                    </div>
                @endif
            @endauth
        </div>
        <x-popups />
        @livewireScripts()
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script defer src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script defer src="{{ asset('js/select2.min.js') }}"></script>
        <script defer src="{{ asset('js/main.js') }}"></script>
        @stack('scripts')
        @if(showAIWriter())
            <x-open_ai />
        @endif
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                Livewire.on('remove-cart', (event) => {
                    const currentRoute = '{{ request()->route()->getName() }}';

                    const { index, cartable_id, cartable_type } = event.params;
                    if (currentRoute != 'tutor-detail') {
                        fetch('/remove-cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ index, cartable_id, cartable_type })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const event = new CustomEvent('cart-updated', {
                                detail: {
                                    cart_data: data.cart_data,
                                    total: data.total,
                                    subTotal: data.subTotal,
                                    discount: data.discount,
                                    toggle_cart: data.toggle_cart
                                }
                            });
                            window.dispatchEvent(event);
                        } else {
                            console.error('Failed to update cart:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                    }
                });
            });
        </script>
    </body>
</html>
