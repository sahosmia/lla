@extends(config('pagebuilder.site_layout'),['page' => $page, 'edit' => false ])

@section(config('pagebuilder.site_section'))
<div class="page-{{ $page->slug == "/" ? "home-page" : $page->slug }}">
    {!! $pageSections !!}
</div>
@endsection
