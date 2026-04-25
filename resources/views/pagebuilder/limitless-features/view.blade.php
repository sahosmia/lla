<div class="am-limitless-features">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('btn_txt')) 
                    || !empty(pagesetting('btn_url')) 
                    || !empty(pagesetting('image')) 
                    || !empty(pagesetting('shape_image')) 
                    || !empty(pagesetting('second_shape_image'))
                    || !empty(pagesetting('left_shape_image')) 
                    || !empty(pagesetting('right_shape_image')))
                    <div class="am-limitless-features-box" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                        @if(!empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph')) 
                            || !empty(pagesetting('btn_txt')) 
                            || !empty(pagesetting('btn_url')))
                            <div class="am-limitless-features-content">
                                @if(!empty(pagesetting('heading')))<h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">{!! pagesetting('heading') !!}</h2>@endif
                                @if(!empty(pagesetting('paragraph')))<p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="700">{!! pagesetting('paragraph') !!}</p>@endif
                                @if(!empty(pagesetting('btn_txt')))
                                    <div data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                                        <a href="@if(!empty(pagesetting('btn_url'))) {{ pagesetting('btn_url') }} @endif" class="am-btn">{{ pagesetting('btn_txt') }}</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('image')))
                            <figure>
                                @if(!empty(pagesetting('image')[0]['path']))
                                    <img src="{{url(Storage::url(pagesetting('image')[0]['path']))}}" alt="Limitless features image" data-aos="fade-up-left" data-aos-easing="ease" data-aos-delay="1000">
                                @endif
                            </figure>
                        @endif
                        @if(!empty(pagesetting('shape_image')))
                            @if(!empty(pagesetting('shape_image')[0]['path']))
                                <img src="{{url(Storage::url(pagesetting('shape_image')[0]['path']))}}" class="am-limitless-features-img01" alt="Background shape image">
                            @endif
                        @endif
                        @if(!empty(pagesetting('second_shape_image')))
                            @if(!empty(pagesetting('second_shape_image')[0]['path']))
                                <img src="{{url(Storage::url(pagesetting('second_shape_image')[0]['path']))}}" class="am-limitless-features-img02" alt="Background shape image">
                            @endif
                        @endif
                        @if(!empty(pagesetting('left_shape_image')))
                            @if(!empty(pagesetting('left_shape_image')[0]['path']))
                                <img src="{{url(Storage::url(pagesetting('left_shape_image')[0]['path']))}}" class="am-limitless-features-img03" alt="Background shape image">
                            @endif
                        @endif
                        @if(!empty(pagesetting('right_shape_image')))
                            @if(!empty(pagesetting('right_shape_image')[0]['path']))
                                <img src="{{url(Storage::url(pagesetting('right_shape_image')[0]['path']))}}" class="am-limitless-features-img04" alt="Background shape image">
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
