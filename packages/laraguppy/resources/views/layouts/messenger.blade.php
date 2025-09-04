<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('laraguppy::chatapp.app_title') }}{{ config('app.name') ? ' - ' . config('app.name') : '' }}</title>
        <link rel="shortcut icon" href="{{ asset('vendor/laraguppy/favicon.png') }}">
        @stack(config('laraguppy.style_stack'))
    </head>
    <body>
        <main>
            <div class="container">
                @yield(config('laraguppy.content_yeild'))
            </div>
        </main>
        @stack(config('laraguppy.script_stack'))
    </body>
</html>
