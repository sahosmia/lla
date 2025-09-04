<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="am-easysetup {{ pagesetting('style_variation') }}">
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
                    <div class="am-easysetup_list">
                        <ul>
                            @foreach(pagesetting('steps_repeater') as $option)
                                @if(!empty($option['step_image']) || !empty($option['scnd_step_image']) 
                                    || !empty($option['step_heading']) || !empty($option['step_paragraph']) 
                                    || !empty($option['learn_more_btn_url']) || !empty($option['learn_more_btn_txt']))
                                    <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="{{ $loop->iteration * 400 }}">
                                        <div class="am-easysetup_list_item @if(!empty($option['image_verient'])) {{ $option['image_verient'] }} @endif">
                                            @if(!empty($option['step_image'][0]['path']) || !empty($option['scnd_step_image'][0]['path']))
                                                <span class="am-setup-signup">
                                                    @if(!empty($option['step_image'][0]['path']))<img class="am-step-gif" src="{{url(Storage::url($option['step_image'][0]['path']))}}" alt="Easy steps image">@endif
                                                    @if(!empty($option['scnd_step_image'][0]['path']))<img class="am-step-img" src="{{url(Storage::url($option['scnd_step_image'][0]['path']))}}" alt="Easy steps image">@endif
                                                </span>
                                            @endif
                                            @if(!empty($option['step_heading']))<h4>{!! $option['step_heading'] !!}</h4>@endif
                                            @if(!empty($option['step_paragraph']))<p>{!! $option['step_paragraph'] !!}</p>@endif
                                            @if(!empty($option['learn_more_btn_txt']) || !empty($option['learn_more_btn_url']))
                                                @if (strpos($option['learn_more_btn_url'], '/register') !== false)
                                                    <a href="{{ setting('_lernen.allow_register') !== 'no' ? $option['learn_more_btn_url'] : '#' }}">
                                                        {{ $option['learn_more_btn_txt'] }}
                                                        <i class="am-icon-arrow-right"></i>
                                                    </a>
                                                @else
                                                    <a href="@if(!empty($option['learn_more_btn_url'])) {{ $option['learn_more_btn_url'] }} @endif">
                                                        {{ $option['learn_more_btn_txt'] }}
                                                        <i class="am-icon-arrow-right"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if(!empty(pagesetting('shape_image')))
        <img class="am-guide-pattranimg" src="{{url(Storage::url(pagesetting('shape_image')[0]['path']))}}" alt="Background shape image"> 
    @endif
</div>
