

@extends($extends)

@push(config('upcertify.style_stack'))

    @if($load_livewire_styles)
        @livewireStyles
    @endif

    <link rel="stylesheet" href="{{ asset('modules/upcertify/css//icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/main.css') }}">
    @if( !empty(setting('_general.enable_rtl')) || !empty(session()->get('rtl')) )
        <link rel="stylesheet" href="{{ asset('modules/upcertify/css/rtl.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/jquery.colorpicker.bygiro.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/smart-guides.css') }}">
@endpush

@section(config('upcertify.content_yeild'))
    @livewire("upcertify::$component", $props ?? [])
@endsection

@push(config('upcertify.script_stack'))

    @if($load_livewire_scripts)
        @livewireScripts
    @endif
    
    @if($load_jquery)
        <script defer src="{{ asset('modules/upcertify/js/jquery.min.js') }}"></script>
    @endif

    <script src="{{ asset('modules/upcertify/js/html2canvas.min.js') }}"></script>
    <script defer src="{{ asset('modules/upcertify/js/jquery-ui.min.js') }}"></script>
    <script defer src="{{ asset('modules/upcertify/js/jquery.ui.rotatable.min.js') }}"></script>
    <script defer src="{{ asset('modules/upcertify/js/jquery.colorpicker.bygiro.js') }}"></script>
    <script defer src="{{ asset('modules/upcertify/js/jquery.draggable.smartguides.js') }}"></script>
    <script defer src="{{ asset('modules/upcertify/js/smart-guides.js') }}"></script>
    <script defer src="{{ asset('modules/upcertify/js/main.js') }}"></script>    
@endpush
