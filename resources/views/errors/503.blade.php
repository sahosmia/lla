<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{  setting('_general.site_name') }}</title>
        <x-favicon />
        <link rel="stylesheet" href="{{ asset('css/maintenance.css') }}">
    </head>
<body>

    @if (
        !empty(setting('_maintenance.maintenance_logo')[0]['path']) || 
        !empty(setting('_maintenance.maintenance_title')) || 
        !empty(setting('_maintenance.maintenance_description')) || 
        !empty(setting('_maintenance.maintenance_email'))
    )
    
    <div class="ln-container">
        <div class="ln-wrapper">
            <div class="ln-content">
                @if (!empty(setting('_maintenance.maintenance_logo')[0]['path']))
                    <strong><img src="{{ url(Storage::url(setting('_maintenance.maintenance_logo')[0]['path'])) }}" alt="logo"></strong>
                @endif
                @if (!empty(setting('_maintenance.maintenance_title')))
                    <h3>{{ setting('_maintenance.maintenance_title') }}</h3>
                @endif
                @if (!empty(setting('_maintenance.maintenance_description')))
                    <p>{{ setting('_maintenance.maintenance_description') }}</p>
                @endif
                @if (!empty(setting('_maintenance.maintenance_email')))
                    <span>{{ __('general.please_contact_us_at') }}: <a href="mailto:{{ setting('_maintenance.maintenance_email') }}">{{ setting('_maintenance.maintenance_email') }}</a></span>
                @endif
            </div>
        </div>
    </div>
    @else
        <h1>{{ __('general.we_are_under_maintenance') }}</h1>
    @endif
    
</body>
</html>