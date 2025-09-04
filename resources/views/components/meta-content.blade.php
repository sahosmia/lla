@props(['pageTitle'=>null, 'page'=>null, 'pageDescription'=>null, 'pageKeywords'=>null, 'metaImage'=>null])

@if(!empty($og_tags))
    @foreach($og_tags as $key => $value)
        @if(str_starts_with($key, 'twitter:'))
            <meta name="{{ $key }}" content="{{ $value }}">
        @else
            <meta property="{{ $key }}" content="{{ $value }}">
        @endif
    @endforeach
@endif

@php
    $siteTitle = setting('_general.site_name');
    $seoSettings = setting('_front_page_settings');
    $pageId = $page->id ?? null;
    $seoData = collect($seoSettings['seo_settings'] ?? [])->firstWhere('page_id', $pageId);
    $routeName = request()->routeIs('find-tutors') || request()->path() == 'search-courses' || request()->path() == 'blogs' ? request()->route()->getName() : null;
 
    $customSeoData = collect($seoSettings['seo_settings'] ?? [])->firstWhere('page_id', $routeName);
@endphp

@if( !empty($page->title) || !empty($seoData['seo_title']) || !empty($customSeoData['seo_title']) )
    @if(!empty($seoData['seo_title']))
        <title>{!! $seoData['seo_title'] !!}</title>
        <meta property="og:title" content="{!! $seoData['seo_title'] !!}">
        <meta property="twitter:title" content="{!! $seoData['seo_title'] !!}">
    @elseif(!empty($customSeoData['seo_title']))
        <title>{!! $customSeoData['seo_title'] !!}</title>
        <meta property="og:title" content="{!! $customSeoData['seo_title'] !!}">
        <meta property="twitter:title" content="{!! $customSeoData['seo_title'] !!}">
    @else
        <title>{!! $page->title !!}</title>
        <meta property="og:title" content="{!! $page->title !!}">
        <meta property="twitter:title" content="{!! $page->title !!}">
    @endif
@elseif( !empty($pageTitle) || !empty($seoData['seo_title']) || !empty($customSeoData['seo_title']) )
    @if(!empty($seoData['seo_title']))
        <title>{{ $siteTitle }} | {!! $seoData['seo_title'] !!}</title>
        <meta property="og:title" content="{!! $seoData['seo_title'] !!}">
        <meta property="twitter:title" content="{!! $seoData['seo_title'] !!}">
    @elseif(!empty($customSeoData['seo_title']))
        <title>{{ $siteTitle }} | {!! $customSeoData['seo_title'] !!}</title>
        <meta property="og:title" content="{!! $customSeoData['seo_title'] !!}">
        <meta property="twitter:title" content="{!! $customSeoData['seo_title'] !!}">
    @else
        <title>{{ $siteTitle }} | {!! $pageTitle !!}</title>
        <meta property="og:title" content="{!! $pageTitle !!}">
        <meta property="twitter:title" content="{!! $pageTitle !!}">
    @endif
@else
    <title>{{ $siteTitle }} | {{ __('tutor.tutors_tutors') }}</title>
    <meta property="og:title" content="{{ __('tutor.tutors_tutors') }}">
    <meta property="twitter:title" content="{{ __('tutor.tutors_tutors') }}">
@endif
@if( !empty($pageDescription) || !empty($seoData['seo_description']) || !empty($customSeoData['seo_description']) )
    @if(!empty($seoData['seo_description']))
        <meta name="description" content="{{ Str::limit(strip_tags($seoData['seo_description']), 160) }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($seoData['seo_description']), 160) }}">
        <meta property="twitter:description" content="{{ Str::limit(strip_tags($seoData['seo_description']), 160) }}">
    @elseif(!empty($customSeoData['seo_description']))
        <meta name="description" content="{{ Str::limit(strip_tags($customSeoData['seo_description']), 160) }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($customSeoData['seo_description']), 160) }}">
        <meta property="twitter:description" content="{{ Str::limit(strip_tags($customSeoData['seo_description']), 160) }}">
    @else
        <meta name="description" content="{{ Str::limit(strip_tags($pageDescription), 160) }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($pageDescription), 160) }}">
        <meta property="twitter:description" content="{{ Str::limit(strip_tags($pageDescription), 160) }}">
    @endif
@endif
@if( !empty($metaImage))
    <link rel="image_src" href="{{ asset($metaImage) }}" />
@endif
@if( !empty($pageKeywords) || !empty($seoData['seo_keywords']) || !empty($customSeoData['seo_keywords']) )
    @if(!empty($seoData['seo_keywords']))
        <meta name="keywords" content="{{ $seoData['seo_keywords'] }}" />
        <meta property="og:keywords" content="{{ $seoData['seo_keywords'] }}" />
        <meta property="twitter:keywords" content="{{ $seoData['seo_keywords'] }}" />
    @elseif(!empty($customSeoData['seo_keywords']))
        <meta name="keywords" content="{{ $customSeoData['seo_keywords'] }}" />
        <meta property="og:keywords" content="{{ $customSeoData['seo_keywords'] }}" />
        <meta property="twitter:keywords" content="{{ $customSeoData['seo_keywords'] }}" />
    @else
        <meta name="keywords" content="{{ $pageKeywords }}" />
        <meta property="og:keywords" content="{{ $pageKeywords }}" />
        <meta property="twitter:keywords" content="{{ $pageKeywords }}" />
    @endif
@endif
