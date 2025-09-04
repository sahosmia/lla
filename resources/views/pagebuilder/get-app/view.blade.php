
<div class="am-coming-section {{ pagesetting('select_verient') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-coming-soon_wrap">
                    <div class="am-coming-soon">
                        <div class="am-coming-soon_content">
                            @if(!empty(pagesetting('pre_heading')))
                                <span data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"
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
                            @if(!empty(pagesetting('heading')))<h3 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300">{!! pagesetting('heading') !!}</h3>@endif
                            @if(!empty(pagesetting('paragraph')))<p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">{!! pagesetting('paragraph') !!}</p>@endif
                            @if(!empty(pagesetting('app_store_image')) || !empty(pagesetting('google_image')))
                            <div class="am-coming-soon_btns" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500">
                                @if(!empty(pagesetting('app_store_image')[0]['path']))
                                    <a href=" @if(!empty(pagesetting('apple_store_url'))) {{ pagesetting('apple_store_url') }} @endif">
                                        <img src="{{url(Storage::url(pagesetting('app_store_image')[0]['path']))}}" alt="App store image">
                                    </a>
                                @endif
                                @if(!empty(pagesetting('google_image')[0]['path']))
                                    <a href=" @if(!empty(pagesetting('play_store_url'))) {{ pagesetting('play_store_url') }} @endif">
                                        <img src="{{url(Storage::url(pagesetting('google_image')[0]['path']))}}" alt="Google play store image">
                                    </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        @if(!empty(pagesetting('mobile_image')))
                            <figure data-aos="fade-left"  data-aos-duration="500" data-aos-easing="linear" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                @if(!empty(pagesetting('mobile_image')[0]['path']))
                                    <img src="{{url(Storage::url(pagesetting('mobile_image')[0]['path']))}}" alt="Mobile image">
                                @endif
                            </figure>
                        @endif
                        @if(!empty(pagesetting('shape_img_one')))
                            @if(!empty(pagesetting('shape_img_one')[0]['path']))
                                <img src="{{url(Storage::url(pagesetting('shape_img_one')[0]['path']))}}" class="am-img" alt="Background shape image">
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty(pagesetting('bg_image')))
        @if(!empty(pagesetting('bg_image')[0]['path']))
            <img src="{{url(Storage::url(pagesetting('bg_image')[0]['path']))}}" class="am-bgimg2" alt="Background shape image">
        @endif
    @endif
    @if(!empty(pagesetting('shape_img_one')))
        @if(!empty(pagesetting('shape_img_one')[0]['path']))
            <img src="{{url(Storage::url(pagesetting('shape_img_one')[0]['path']))}}" class="am-img" alt="Background shape image">
        @endif
    @endif
</div>