<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite([
    'public/css/bootstrap.min.css',
    'public/css/fonts.css',
    'public/css/icomoon/style.css',
    ])
    <x-favicon />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    @stack('styles')
    @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) )
        <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
    @endif
    @stack('scripts')
</head>

<body class="am-bodywrap">
    <x-front.header :page="null" />
    <main class="am-main am-404">
        <div class="tk-errorpage">
            <div class="tk-errorpage_content">
                <h1>@yield('code')</h1>
                <div class="tk-errorpage_title">
                    <h2>@yield('heading')</h2>
                    <p>@yield('message')</p>
                    <a href="{{ url('/') }}" class="am-btn">{{ __('general.go_to_home') }}</a>
                </div>
            </div>
        </div>
    </main>
    @livewireScripts()
    <script defer src="{{ asset('js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('js/main.js') }}"></script>
    <x-popups />
    <x-front.footer :page="null" />
</body>

</html>