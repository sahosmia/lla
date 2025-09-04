@extends('vendor.installer.layouts.master')

@section('title', trans('installer_messages.seeders.title'))
@section('style')
    <link href="{{ asset('installer/froiden-helper/helper.css') }}" rel="stylesheet"/>
@endsection
@section('container')
    <div class="am-installer-popup" id="env-form">
        <p class="paragraph" style="text-align: center;">{!! trans('installer_messages.seeders.import_text') !!}</p>
        <ul class="list">
            @foreach($seederGroups as $seeder => $classes)
                <li class="list__item {{ ($seederStatus[$seeder]['status'] ?? '') == 'completed' ? 'success' : 'error' }}">
                    <span>{{ __('installer_messages.seeders.'.$seeder.'_title') }}</span>
                    <p>{{ __('installer_messages.seeders.'.$seeder.'_desc') }} </p>
                    <em>{{ $seeder == 'migrate' ? __('installer_messages.seeders.migrate_tooltip_text') : __('installer_messages.seeders.tooltip_text')  }}</em>
                </li>
            @endforeach
        </ul>
    
        @if ( !empty($allDone) && empty($nextSeeder) )
            <div class="buttons">
                <a class="button" href="{{ route('LaravelInstaller::final') }}">
                    {{ trans('installer_messages.next') }}
                </a>
            </div>
        @else
            <div class="buttons">
                <a class="button" href="{{ route('LaravelInstaller::import', ['type' => $nextSeeder]) }}" onclick="return blockUI(this)">
                    {{ trans('installer_messages.next') }}
                </a>
            </div>
        @endif
    </div>
@stop
@section('scripts')
    <script src="{{ asset('installer/js/jQuery-2.2.0.min.js') }}"></script>
    <script src="{{ asset('installer/froiden-helper/helper.js')}}"></script>
    <script>
    function blockUI(button) {
        $(button).attr("disabled", true);
        $.easyBlockUI($(button).closest('#env-form'));
    }
    </script>
@endsection
