@unless($breadcrumbs->isEmpty())
    <ol class="am-breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)

            @if(!is_null($breadcrumb->url) && !$loop->last)
                <li><a href="{{ $breadcrumb->url }}" wire:navigate.remove>{{ $breadcrumb->title }}</a></li>
                <li>
                    <em>/</em>
                </li>
            @else
                <li class="active"><span>{{ $breadcrumb->title }}</span></li>
            @endif

        @endforeach
    </ol>
@endunless
