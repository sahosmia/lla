<div class="uc-sidebar_wrap uc-template">
    <div class="uc-sidebar_inner">
        <div class="uc-sidebar_title">
            <h2>{{ __('upcertify::upcertify.templates') }}</h2>
            <a href="javascript:void(0);" class="uc-sidebar-hidebtn">
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
                            <input type="search" wire:model.live.debounce.500ms="search" class="uc-search-wildcard form-control" placeholder="Search" >
                            <i class="uc-search-icon"><x-upcertify::icons.search /></i>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="uc-sidebar uc-sidebar_templates">
            @if(!empty($loadingTemplates))
                <ul class="uc-template_list">
                    @for ($i = 0; $i < 12; $i++)
                        <li class="uc-skeleton">
                            <figure class="uc-template_item">
                            </figure>
                        </li>
                    @endfor
                </ul>
            @elseif($templates && $templates?->isNotEmpty())
                <ul class="uc-template_list">
                    @foreach ($templates as $template)
                        <li>
                            <figure class="uc-template_item">
                                <img src="{{ !empty($template->thumbnail_url) ? Storage::url($template->thumbnail_url) : asset('modules/upcertify/images/card-bg.webp') }}" alt="{{ $template->title }}">
                                <figcaption >
                                    <a href="javascript:void(0);" class="uc-usebtn uc-use-template" data-id="{{ $template->id }}">
                                        <i><x-upcertify::icons.template /></i>
                                        {{ __('upcertify::upcertify.use_template') }}
                                    </a>
                                </figcaption>
                            </figure>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-upcertify::no_record />
            @endif
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