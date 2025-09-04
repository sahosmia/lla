@extends('upcertify::layouts.app')

@push(config('upcertify.style_stack'))
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/fonts.css') }}">
    @if(!empty($body['fontFamilies']))
        @php
            $fontSet = $body['fontFamilies'];
            $families = collect($fontSet)->map(function($font) {
                return "family=" . urlencode($font) . ":ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900";
            })->join('&');
            $linkHref = "https://fonts.googleapis.com/css2?{$families}&display=swap";
        @endphp
        <link id="uc-custom-fonts" type="text/css" rel="stylesheet" href="{{ $linkHref }}">
    @endif
@endpush

@section(config('upcertify.content_yeild'))
    <div class="uc-certificateprint uc-download">
        <x-upcertify::body :body="$body" :isPreview="true" />
    </div>
@endsection

