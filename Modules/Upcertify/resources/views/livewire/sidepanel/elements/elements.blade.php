<div class="uc-sidebar_wrap">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2>{{ __('upcertify::upcertify.elements') }}</h2>
            <a href="#" class="uc-sidebar-hidebtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 16 16" fill="none">
                    <g>
                        <path d="M4 12L12 4M4 4L12 12" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
            </a>
        </div>
        <div class="uc-sidebar-element">
            <form class="uc-themeform uc-sidebar_form">
                <fieldset>
                    <div class="form-group">
                        <div class="form-group-wrap">
                            <label for="title" class="uc-important">Title</label>
                            <input type="search" wire:model.live.debounce.500ms="searchTemplates" class="uc-search-wildcard form-control" placeholder="Search" >
                            <i class="uc-search-icon"><x-upcertify::icons.search /></i>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="uc-sidebar uc-sidebar_elements">
            <div class="uc-element-instructor">
                @foreach ($wildcards as $wildcard)
                    <div class="uc-element-drag" data-name="{{ $wildcard }}">
                        <i class="uc-element-drag_icon"><x-upcertify::icons.sorting /></i>
                        <i class="uc-element-drag_user">
                        @if (View::exists("upcertify::components.icons.$wildcard"))
                            @include("upcertify::components.icons.$wildcard")
                        @endif
                        </i>
                        <span>{{ __("upcertify::upcertify.".$wildcard) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="uc-no-found" style="display: none;" data-name="{{ $wildcard }}">
                <x-upcertify::no_record />
            </div>
        </div>
    </div>
    <div class="uc-sidebar_toggler">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M14 6L8 12L14 18" stroke="white" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    </div>
</div>