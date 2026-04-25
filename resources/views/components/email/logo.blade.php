@php
    $logo = setting('_email.email_logo');
    $logoImg = !empty($logo[0]['path']) ? url(Storage::url($logo[0]['path'])) : asset('/demo-content/logo.webp');
@endphp
<img src="{{ $logoImg }}" alt="{{ setting('_site.name') ?? config('app.name', __('general.app_name')) }}" {{ $attributes }}>
