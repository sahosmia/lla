<section class="am-steps"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('steps_data')) 
                    || !empty(pagesetting('start_journ_icon')) 
                    || !empty(pagesetting('start_journ_heading')) 
                    || !empty(pagesetting('start_journ_description')) 
                    || !empty(pagesetting('get_start_btn_text'))
                    || !empty(pagesetting('get_start_btn_url')))
                    <div class="am-steps_content">
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                            <div class="am-steps_content_unlock">
                                @if(!empty(pagesetting('pre_heading')))
                                    <span
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
                                @if(!empty(pagesetting('heading'))) <h3>{!! pagesetting('heading') !!}</h3> @endif
                                @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('steps_data')) 
                            || !empty(pagesetting('start_journ_icon')) 
                            || !empty(pagesetting('start_journ_heading')) 
                            || !empty(pagesetting('start_journ_description')) 
                            || !empty(pagesetting('get_start_btn_text')) 
                            || !empty(pagesetting('get_start_btn_url')))
                            <div class="am-steps_content_start">
                                @if(!empty(pagesetting('steps_data')))
                                    @foreach(pagesetting('steps_data') as $option)
                                        @if(!empty($option['sub_heading']) 
                                            || !empty($option['step_image']) 
                                            || !empty($option['step_heading'])
                                            || !empty($option['step_paragraph']) 
                                            || !empty($option['btn_text']) 
                                            || !empty($option['btn_url']))
                                            <div>
                                                <div class="am-steps_content_start_info">
                                                    @if(!empty($option['sub_heading'])) <span>{{ $option['sub_heading'] }}</span> @endif
                                                    @if(!empty($option['step_image']))
                                                        <figure>
                                                            @if(!empty($option['step_image'][0]['path']))
                                                                <img src="{{url(Storage::url($option['step_image'][0]['path']))}}" alt="{{ $option['step_heading'] }} image">
                                                            @endif
                                                        </figure>
                                                    @endif
                                                    @if(!empty($option['step_heading']) || !empty($option['step_paragraph']))
                                                        <div class="am-steps_content_start_info_redirect">
                                                            @if(!empty($option['step_heading'])) <h3>{{ $option['step_heading'] }}</h3> @endif
                                                            @if(!empty($option['step_paragraph'])) <p>{!! $option['step_paragraph'] !!}</p> @endif
                                                        </div>
                                                    @endif
                                                    @if(!empty($option['btn_text']) || !empty($option['btn_url'])) 
                                                        @if ($option['btn_url'] == 'register')
                                                            <a href="{{ setting('_lernen.allow_register') !== 'no' ? $option['btn_url'] : '#' }}">{{ $option['btn_text'] }}</a> 
                                                        @else
                                                            <a href="@if(!empty($option['btn_url'])) {{ $option['btn_url'] }} @endif">{{ $option['btn_text'] }}</a> 
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endif 
                                    @endforeach
                                @endif
                                @if(!empty(pagesetting('start_journ_icon')) 
                                    || !empty(pagesetting('start_journ_heading')) 
                                    || !empty(pagesetting('start_journ_description')) 
                                    || !empty(pagesetting('get_start_btn_text')) 
                                    || !empty(pagesetting('get_start_btn_url')))
                                    <div>
                                        <div class="am-steps_content_start_info journey">
                                            @if(!empty(pagesetting('start_journ_icon')))
                                                <span>
                                                    <i class="{!! pagesetting('start_journ_icon') !!}"></i>
                                                </span>
                                            @endif
                                            @if(!empty(pagesetting('start_journ_heading')) || !empty(pagesetting('start_journ_description'))) 
                                                <div class="am-steps_content_start_info_redirect">
                                                    @if(!empty(pagesetting('start_journ_heading'))) <h3>{{ pagesetting('start_journ_heading') }}</h3> @endif 
                                                    @if(!empty(pagesetting('start_journ_description'))) <p>{{ pagesetting('start_journ_description') }}</p> @endif 
                                                </div>
                                            @endif
                                            @if(!empty(pagesetting('get_start_btn_text')) || !empty(pagesetting('get_start_btn_url'))) 
                                                <a href="@if(!empty(pagesetting('get_start_btn_url'))) {{ pagesetting('get_start_btn_url') }} @endif" class="am-btn">{{ pagesetting('get_start_btn_text') }}
                                                    <i class="am-icon-arrow-right"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
