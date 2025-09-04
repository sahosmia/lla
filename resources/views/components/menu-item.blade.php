@props(['menu', 'enableToggle' => false])
<li class="{{ !$menu->children->isEmpty() ? 'page-item-has-children' : '' }} {{ request()->url() == $menu->route && $menu->children->isEmpty() ? 'active' : '' }}">
    <a href="{{ !$menu->children->isEmpty() ? 'javascript:;' : (!empty($menu->route) ? url($menu->route) : url('/')) }}"
        @if($enableToggle && !$menu->children->isEmpty())  data-bs-toggle="collapse" data-bs-target="#{{ $menu->id }}" @endif>
        {!! ucfirst($menu->label) !!}
        @if( !$menu->children->isEmpty() )
            <i class="am-icon-chevron-down"></i>
        @endif
    </a>
    @if( !$menu->children->isEmpty() )
        <ul class="sub-menu {{ $enableToggle ? 'collapse' : '' }}" id="{{ $menu->id }}">
            @foreach( $menu->children as $child)
                <x-menu-item :menu="$child" />
            @endforeach
        </ul>
    @endif
</li>