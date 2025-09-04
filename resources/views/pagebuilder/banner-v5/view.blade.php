<div class="am-banner-vfive">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading_image'))
                    || !empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('search_btn_txt')) 
                    || !empty(pagesetting('search_placeholder')) 
                    || !empty(pagesetting('banner_first_image')) 
                    || !empty(pagesetting('banner_second_image')) 
                    || !empty(pagesetting('banner_third_image')) 
                    || !empty(pagesetting('banner_fourth_image')) 
                    || !empty(pagesetting('banner_fifth_image')))
                    <div class="am-banner"  data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                        <div class="am-banner_wrap">
                            @if(!empty(pagesetting('pre_heading_image'))
                                || !empty(pagesetting('pre_heading')) 
                                || !empty(pagesetting('heading')) 
                                || !empty(pagesetting('paragraph')) 
                                || !empty(pagesetting('search_btn_txt')) 
                                || !empty(pagesetting('search_placeholder')))
                                <div class="am-banner-content">
                                    @if(!empty(pagesetting('pre_heading_image')) || !empty(pagesetting('pre_heading'))) 
                                        <span class="am-banner_tag" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600"
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
                                            @if(!empty(pagesetting('pre_heading_image')))
                                                <figure>
                                                    @if(!empty(pagesetting('pre_heading_image')[0]['path']))
                                                        <img src="{{url(Storage::url(pagesetting('pre_heading_image')[0]['path']))}}" alt="Heading image">
                                                    @endif
                                                </figure>
                                            @endif
                                            @if(!empty(pagesetting('pre_heading'))) {{ pagesetting('pre_heading') }} @endif
                                        </span>
                                    @endif
                                    @if(!empty(pagesetting('heading')))<h1 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="700">{!! pagesetting('heading') !!}</h1>@endif
                                    @if(!empty(pagesetting('paragraph')))<p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">{!! pagesetting('paragraph') !!}</p>@endif
                                    @if(!empty(pagesetting('search_btn_txt')) || !empty(pagesetting('search_placeholder'))) 
                                        <form action="{{ url('find-tutors') }}" method="GET" class="am-learning_search" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="900">
                                            <i class="am-icon-search-02"></i>
                                            @if(!empty(pagesetting('search_placeholder')))
                                                <div class="am-learning_search_input">
                                                    <input type="text" name="keyword" placeholder="{{ pagesetting('search_placeholder') }}">
                                                </div>
                                            @endif
                                            @if(!empty(pagesetting('search_btn_txt')))
                                                <button type="submit" class="am-learning_search_btn am-btn">
                                                    {{ pagesetting('search_btn_txt') }}    
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                            @endif
                            @if(!empty(pagesetting('banner_first_image')) 
                                || !empty(pagesetting('banner_second_image')) 
                                || !empty(pagesetting('banner_third_image')) 
                                || !empty(pagesetting('banner_fourth_image')) 
                                || !empty(pagesetting('banner_fifth_image')))
                                <div class="am-banner_images">
                                    <figure>
                                        @if(!empty(pagesetting('banner_first_image')))
                                            @if(!empty(pagesetting('banner_first_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('banner_first_image')[0]['path']))}}" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="600" alt="User image">
                                            @endif
                                        @endif
                                        <figcaption>
                                            @if(!empty(pagesetting('banner_second_image')))
                                                @if(!empty(pagesetting('banner_second_image')[0]['path']))
                                                    <img  class="am-image-one" src="{{url(Storage::url(pagesetting('banner_second_image')[0]['path']))}}" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800" alt="Online user image">
                                                @endif
                                            @endif
                                            @if(!empty(pagesetting('banner_third_image')))
                                                @if(!empty(pagesetting('banner_third_image')[0]['path']))
                                                    <img  class="am-image-two" src="{{url(Storage::url(pagesetting('banner_third_image')[0]['path']))}}" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="900" alt="Users image">
                                                @endif
                                            @endif
                                            @if(!empty(pagesetting('banner_fourth_image')))
                                                @if(!empty(pagesetting('banner_fourth_image')[0]['path']))
                                                    <img  class="am-image-three" src="{{url(Storage::url(pagesetting('banner_fourth_image')[0]['path']))}}" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1000" alt="Cursor image">
                                                @endif
                                            @endif
                                            @if(!empty(pagesetting('banner_fifth_image')))
                                                @if(!empty(pagesetting('banner_fifth_image')[0]['path']))
                                                    <img  class="am-image-four" src="{{url(Storage::url(pagesetting('banner_fifth_image')[0]['path']))}}" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1100" alt="Rate experience image">
                                                @endif
                                            @endif
                                        </figcaption>
                                    </figure>
                                    @if(!empty(pagesetting('bg_shape_img_one')))
                                        @if(!empty(pagesetting('bg_shape_img_one')[0]['path']))
                                            <img class="am-img_one" src="{{url(Storage::url(pagesetting('bg_shape_img_one')[0]['path']))}}" alt="images-description">
                                        @endif
                                    @endif
                                    @if(!empty(pagesetting('bg_shape_img_two')))
                                        @if(!empty(pagesetting('bg_shape_img_two')[0]['path']))
                                            <img class="am-img_two" src="{{url(Storage::url(pagesetting('bg_shape_img_two')[0]['path']))}}" alt="images-description">
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if(!empty(pagesetting('first_shape_img')))
                            @if(!empty(pagesetting('first_shape_img')[0]['path']))
                                <img class="am_img_one" src="{{url(Storage::url(pagesetting('first_shape_img')[0]['path']))}}" alt="images-description">
                            @endif
                        @endif
                        @if(!empty(pagesetting('second_shape_img')))
                            @if(!empty(pagesetting('second_shape_img')[0]['path']))
                                <img class="am_img_two" src="{{url(Storage::url(pagesetting('second_shape_img')[0]['path']))}}" alt="images-description">
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@pushOnce('styles')
<?php 
$isEdit = str_contains(request()->path(), 'pages') && str_contains(request()->path(), 'iframe');
?>
@if(!$isEdit)
    @vite(['public/css/aos.min.css'])
@endif
@endpushOnce
@pushOnce('scripts')
    @if(!$isEdit)
        <script src="{{ asset('js/aos.min.js') }}"></script>
    @endif
    <script section='banner-v5'>
        AOS.init();
    </script>
@endpushOnce