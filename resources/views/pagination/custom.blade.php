@if ($paginator->hasPages())
    <div class="tk-pagiantion-holder">
        <div class="tk-pagination">
            <ul>
                @if ($paginator->onFirstPage())    
                    <li class="d-none">
                        <span class="icon-chevron-left"></span>
                    </li>
                @else
                    <li class="tk-prevpage">
                        <a href="javascript:;" wire:click="previousPage('page')">
                            <i class="icon-chevron-left"></i>
                        </a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                        <li class="{{ ($paginator->currentPage() == $page) ? ' active' : '' }}">
                            @if ($page == $paginator->currentPage())
                                <span wire:key="paginator-page-span-{{ $page }}" wire:click="gotoPage({{ $page }})">{{ $page }}</span>
                            @elseif ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                                <a href="javascript:;" wire:key="paginator-page-link-{{ $page }}" wire:click="gotoPage({{ $page }})">{{ $page }}</a>
                            @endif
                        </li>
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())    
                    <li class="tk-nextpage">
                        <a href="javascript:;" wire:click="nextPage('page')">
                            <i class="icon-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="d-none">
                        <span class="icon-chevron-right"></span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
