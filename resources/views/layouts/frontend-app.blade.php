<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ) dir="rtl" @endif>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <x-meta-content :pageTitle="$pageTitle ?? null" :page="$page ?? null" :pageDescription="$pageDescription ?? null" :pageKeywords="$pageKeywords ?? null" :metaImage="$metaImage ?? null"/>
    
    @vite([
            'public/css/bootstrap.min.css',
            'public/css/fonts.css',
            'public/css/icomoon/style.css',
            'public/css/select2.min.css',
            'public/css/splide.min.css',
        ])
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
   
    <x-favicon />

    @stack('styles')
    @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) )
        <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
    @endif

    @if( !empty(setting('_scripts_styles.header_scripts')) )
        {!! setting('_scripts_styles.header_scripts') !!}
    @endif

    @if( !empty(setting('_scripts_styles.custom_styles')) )
        <style>{!! html_entity_decode(setting('_scripts_styles.custom_styles')) !!}</style>
    @endif
     
</head>

<body class="am-bodywrap @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) ) am-rtl @endif">
    <x-front.header :page="$page?? null"/>
    <main class="am-main">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    <x-popups />
    <x-front.footer :page="$page?? null" />
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
    @livewireScripts()
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script defer src="{{ asset('js/select2.min.js') }}"></script>
    <script defer src="{{ asset('js/splide.min.js') }}"></script>
    <script defer src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
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
   
    @if( !empty(setting('_scripts_styles.footer_scripts')) )
        {!! setting('_scripts_styles.footer_scripts') !!}
    @endif
    <x-gdpr />
</body>

</html>
