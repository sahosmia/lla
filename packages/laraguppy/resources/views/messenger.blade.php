@extends(!empty(config('laraguppy.layout')) ? config('laraguppy.layout') : 'laraguppy::layouts.messenger')

@push(config('laraguppy.style_stack'))
   
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/laraguppy/app.css') }}">
@endpush

@section(config('laraguppy.content_yeild'))
    <div id="chat-app" class="wpguppy-chat-app @if(config('laraguppy.enable_rtl') == 'yes' || !empty(setting('_general.enable_rtl'))) lg-rtl @endif"></div>
@endsection

@push(config('laraguppy.script_stack'))
    <script src="{{asset('vendor/laraguppy/jquery.min.js')}}"></script>
    <script>
        window.guppy_auth_token = {{ \Js::from($guppyAuthToken) }};
        window.pusherConfig     = {{ \Js::from($broadcastingSettings) }};
    </script>
   
   <script defer type="module" src="{{ asset('vendor/laraguppy/app.js') }}"></script>
  
@endpush
