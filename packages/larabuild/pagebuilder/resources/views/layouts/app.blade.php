<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Page Builder') . ' | '.$page->name }}</title>
    @if( config('pagebuilder.add_bootstrap') === 'yes' )
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/bootstrap.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/feather-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery-confirm.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/flatpickr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/jquery.colorpicker.bygiro.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/summernote-lite.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/optionbuilder/css/nouislider.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/pagebuilder/css/larabuild-pagebuilder.css')}}">
</head>

<body>
    @yield('builder-content')

    @if( config('pagebuilder.add_bootstrap') === 'yes' )
    <script defer src="{{ asset('vendor/optionbuilder/js/bootstrap.min.js') }}"></script>
    @endif

    <script src="{{ asset('vendor/optionbuilder/js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/select2.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/jquery-confirm.min.js')}}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/popper-core.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/tippy.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/flatpickr.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/jquery.colorpicker.bygiro.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/summernote-lite.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/nouislider.min.js') }}"></script>
    <script defer src="{{ asset('vendor/optionbuilder/js/optionbuilder.js') }}"></script>
    <script defer src="{{ asset('vendor/pagebuilder/js/Sortable.min.js') }}"></script>
    @stack(config('pagebuilder.site_script_var'))
    @stack('builder-js')
    @yield('builder-templates')
</body>

</html>