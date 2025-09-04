@if(!empty($page->settings['grids']))
@foreach ($page->settings['grids'] as $grid)
@php $columns = getColumnInfo($grid['grid']); @endphp
<!-- Section start -->
@php
setGridId($grid['grid_id']);
$css = getCss();
if(!empty(getBgOverlay()))
$css = 'position:relative;'.$css;
@endphp
<section class="pb-themesection {{ getClasses() }}" {!!getCustomAttributes() !!} {!! !empty($css)? 'style="' .$css.'"':'' !!}>
    {!! getBgOverlay() !!}
    <div {!! getContainerStyles() !!}>
        <div class="row">
            @if(!empty($grid['data']))
            @foreach ($grid['data'] as $column => $components)
            <div class="{{ $columns[$column] }}">
                @foreach ($components as $component)
                @php setSectionId($component['id']);@endphp
                @if(view()->exists('pagebuilder.' . $component['section_id'] . '.view'))
                {!! view('pagebuilder.' . $component['section_id']. '.view')->render() !!}
                @endif
                @endforeach
            </div>

            @endforeach
            @endif
        </div>
    </div>
</section>
<!-- Section end -->
@endforeach
@endif