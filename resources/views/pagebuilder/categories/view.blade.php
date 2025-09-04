<div class="am-categories {{ pagesetting('categories_verient') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                    <div class="am-section_title {{ pagesetting('section_title_variation') }}">
                        @if(!empty(pagesetting('pre_heading')))
                            <span class="am-tag" 
                                @if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'))
                                    style="
                                        @if(!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)')
                                            color: {{ pagesetting('pre_heading_text_color') }};
                                        @endif
                                        @if(!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')
                                            background-color: {{ pagesetting('pre_heading_bg_color') }};
                                        @endif
                                    "
                                @endif>
                                {{ pagesetting('pre_heading') }}
                            </span>
                        @endif
                        @if(!empty(pagesetting('heading')))<h2>{!! pagesetting('heading') !!}</h2>@endif
                        @if(!empty(pagesetting('paragraph')))<p>{!! pagesetting('paragraph') !!}</p>@endif
                    </div>
                @endif
                @if(!empty(pagesetting('categories_repeater'))
                    || !empty(pagesetting('all_category_heading')) 
                    || !empty(pagesetting('all_category_paragraph')) 
                    || !empty(pagesetting('view_category_btn_url')) 
                    || !empty(pagesetting('view_category_btn_txt')))
                     <ul class="am-card-container">
                        @foreach(pagesetting('categories_repeater') as $key =>  $option)
                            @if(!empty($option['category_image']) 
                                || !empty($option['category_heading']) 
                                || !empty($option['category_paragraph']) 
                                || !empty($option['explore_more_btn_url']) 
                                || !empty($option['explore_more_btn_txt']))
                                <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="{{ $loop->iteration * 200 }}">
                                    @if(pagesetting('categories_verient') == 'verient-two')
                                        <a class="am-card" href="@if(!empty($option['explore_more_btn_url'])) {{ $option['explore_more_btn_url'] }} @endif">
                                    @else
                                        <div class="am-card">
                                    @endif
                                        @if(pagesetting('categories_verient') == 'verient-two')
                                            @if(!empty($option['category_image']))
                                                <div class="am-icon am-web-dev">
                                                    @if(!empty($option['category_image'][0]['path']))
                                                        <img src="{{url(Storage::url($option['category_image'][0]['path']))}}" alt="Category image">
                                                    @endif
                                                </div>
                                            @endif
                                            @if(!empty($option['category_heading']))<h3 class="am-title">{!! $option['category_heading'] !!}</h3>@endif
                                        @else
                                            @if(!empty($option['category_image']))
                                                <div class="am-icon am-web-dev">
                                                    @if(!empty($option['category_image'][0]['path']))
                                                        <a href="@if(!empty($option['explore_more_btn_url'])) {{ $option['explore_more_btn_url'] }} @endif">
                                                            <img src="{{url(Storage::url($option['category_image'][0]['path']))}}" alt="Category image">
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                            @if(!empty($option['category_heading']))
                                                <a  href="@if(!empty($option['explore_more_btn_url'])) {{ $option['explore_more_btn_url'] }} @endif">
                                                    <h3 class="am-title">{!! $option['category_heading'] !!}</h3>
                                                </a>
                                            @endif
                                            @if(!empty($option['category_paragraph']))<p class="am-description">{!! $option['category_paragraph'] !!}</p>@endif
                                            @if(!empty($option['explore_more_btn_txt']))
                                                <a href="@if(!empty($option['explore_more_btn_url'])) {{ $option['explore_more_btn_url'] }} @endif" class="am-button am-explore-more">
                                                    {{ $option['explore_more_btn_txt'] }}
                                                    <i class="am-icon-arrow-right"></i>
                                                </a>
                                            @endif
                                        @endif
                                    @if(pagesetting('categories_verient') == 'verient-two')
                                        </a>
                                    @else
                                        </div>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                        @if(!empty(pagesetting('all_category_heading')) 
                            || !empty(pagesetting('all_category_paragraph')) 
                            || !empty(pagesetting('view_category_btn_url')) 
                            || !empty(pagesetting('view_category_btn_txt')))
                            <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="{{ (count(pagesetting('categories_repeater')) + 1) * 200 }}">
                                <div class="am-card am-highlighted">
                                    @if(!empty(pagesetting('all_category_heading')))<a href="@if(!empty(pagesetting('view_category_btn_url'))) {{ pagesetting('view_category_btn_url') }} @endif"><h3 class="am-title">{!! pagesetting('all_category_heading') !!}</h3></a>@endif
                                    @if(!empty(pagesetting('all_category_paragraph')))<p class="am-description">{!! pagesetting('all_category_paragraph') !!}</p>@endif
                                    @if(!empty(pagesetting('view_category_btn_txt')))
                                        <a href="@if(!empty(pagesetting('view_category_btn_url'))) {{ pagesetting('view_category_btn_url') }} @endif" class="am-btn">
                                            {{ pagesetting('view_category_btn_txt') }}
                                            <i class="am-icon-arrow-top-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>