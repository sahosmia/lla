<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if( !empty(setting('_general.enable_rtl')) ) dir="rtl" @endif>
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
            'public/css/main.css',
        ])
        @stack('styles')
        @if( !empty(setting('_general.enable_rtl')) )
            <link rel="stylesheet" type="text/css" href="{{ asset('css/rtl.css') }}">
        @endif
    </head>
    <body class="am-bodywrap @if( !empty(setting('_general.enable_rtl')) ) am-rtl @endif">
        <main class="am-main">
            {{ $slot ?? '' }}
            @yield('content')
            @livewireScripts

            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script defer src="{{ asset('js/bootstrap.min.js') }}"></script>
            <script defer src="{{ asset('js/select2.min.js') }}"></script>
            <script defer src="{{ asset('js/main.js') }}"></script>
            @stack('scripts')
        </main>
    </body>
</html>
