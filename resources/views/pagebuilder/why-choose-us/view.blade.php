<div class="am-whychooseus">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-whychooseus-section">
                    @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                        <div class="am-section_title am-section_title_center {{ pagesetting('section_title_variation') }}">
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
                    @if(!empty(pagesetting('steps_repeater')))
                        <ul class="am-whychooseus-content">
                            @foreach(pagesetting('steps_repeater') as $option)
                                @if(!empty($option['image']) || !empty($option['data_heading']) || !empty($option['data_description'])) 
                                    <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="{{ $loop->iteration * 400 }}">
                                        @if(!empty($option['image'][0]['path']))<img src="{{url(Storage::url($option['image'][0]['path']))}}" alt="{!! $option['data_description'] !!} image">@endif
                                        @if(!empty($option['data_heading']))<h3>{!! $option['data_heading'] !!}</h3>@endif
                                        @if(!empty($option['data_description']))<p>{!! $option['data_description'] !!}</p>@endif
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty(pagesetting('btn_txt'))) 
                        <a class="am-getstarted-btn" href="@if(!empty(pagesetting('btn_url'))) {{ pagesetting('btn_url') }} @endif">
                            {{ pagesetting('btn_txt') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(!empty(pagesetting('bg_shape_img')))
        @if(!empty(pagesetting('bg_shape_img')[0]['path']))
            <img class="am-img" src="{{url(Storage::url(pagesetting('bg_shape_img')[0]['path']))}}" alt="image-description">
        @endif
    @endif
</div>
