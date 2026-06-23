<div class="am-banner-potential am-banner-content-six">
    <div class="am-banner-container">
        @if(!empty(pagesetting('first_heading'))
            || !empty(pagesetting('second_heading'))
            || !empty(pagesetting('paragraph'))
            || !empty(pagesetting('primary_btn_url'))
            || !empty(pagesetting('primary_btn_txt'))
            || !empty(pagesetting('secondary_btn_url'))
            || !empty(pagesetting('secondary_btn_txt')))
            <div class="am-banner-main">
                <div class="am-banner-tutor">
                    @if(!empty(pagesetting('first_heading')) || !empty(pagesetting('second_heading')) || !empty(pagesetting('paragraph')))
                        @if(!empty(pagesetting('first_heading')))<h1 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200"> {{ pagesetting('first_heading') }} </h1>@endif
                        @if(!empty(pagesetting('second_heading')))<h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">{!! pagesetting('second_heading') !!}</h2>@endif
                        @if(!empty(pagesetting('paragraph')))<p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">{!! pagesetting('paragraph') !!}</p>@endif
                    @endif
                    @if(!empty(pagesetting('primary_btn_txt')) || !empty(pagesetting('secondary_btn_txt')))
                        <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                            @if(!empty(pagesetting('primary_btn_txt')))<a href="{{ pagesetting('primary_btn_url') }}" class="am-explore-btn">{{ pagesetting('primary_btn_txt') }}</a>@endif
                            @if(!empty(pagesetting('secondary_btn_txt')))
                                <a href="{{ pagesetting('secondary_btn_url') }} " class="am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content vbox-item" data-autoplay="true" data-vbtype="video" "="">
                                    <i class="am-icon-play-filled"></i>
                                    {{ pagesetting('secondary_btn_txt') }}
                                </a>
                            @endif
                        </div>
                    @endif
                    <div class="am-reviews">
                        @if(!empty(pagesetting('image_repeater')) || !empty(pagesetting('user_rating_text')))
                            <div class="am-reviews_moreusers" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1000">
                                @if(!empty(pagesetting('image_repeater')))
                                    <ul>
                                        @foreach(pagesetting('image_repeater') as $option)
                                            @if(!empty($option['user_review_img']))
                                                @if(!empty($option['user_review_img'][0]['path']))<li><img src="{{ url(Storage::url($option['user_review_img'][0]['path'])) }}" alt="Users image"></li>@endif
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                @if(!empty(pagesetting('user_rating_text')))<span>{{ pagesetting('user_rating_text') }}</span>@endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('rating_repeater')) || !empty(pagesetting('rating')) || !empty(pagesetting('rating_text')))
                            <div class="am-reviews_ratings" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1200">
                                @if(!empty(pagesetting('rating_repeater')) || !empty(pagesetting('rating')))
                                    <div class="am-reviews_ratings_stars">
                                        @if(!empty(pagesetting('rating')))<span>{{ pagesetting('rating') }}</span> @endif
                                            @foreach(pagesetting('rating_repeater') as $option)
                                                <i class="{!! $option['rating_icon'] !!}"></i>
                                            @endforeach
                                    </div>
                                @endif
                                @if(!empty(pagesetting('rating_text')))<span>{{ pagesetting('rating_text') }}</span>@endif
                            </div>

                            
                        @endif
                    </div>
                </div>
            </div>
            @if(!empty(pagesetting('third_banner_image')))
                <div class="am-banner-bg">
                    @if(!empty(pagesetting('third_banner_image')[0]['path']))<img src="{{url(Storage::url(pagesetting('third_banner_image')[0]['path']))}}" alt="Background shape image" />@endif
                </div>
            @endif
        @endif
    </div>
    <div class="am-banner-imgs">
        <figure>
            @if(!empty(pagesetting('banner_main_image')))<img src="{{ url(Storage::url(pagesetting('banner_main_image')[0]['path'])) }}" alt="Banner image" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="200">@endif
            <figcaption>
                @if(!empty(pagesetting('animated_first_image')))<img class="am-img-1" src="{{ url(Storage::url(pagesetting('animated_first_image')[0]['path'])) }}" alt="Rate your experience image" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="1600">@endif
                @if(!empty(pagesetting('animated_second_image')))<img class="am-img-2" src="{{ url(Storage::url(pagesetting('animated_second_image')[0]['path'])) }}" alt="Cursor image">@endif
            </figcaption>
        </figure>
    </div>
    @if(!empty(pagesetting('background_animated_first_image')))<img class="am-bgimg-1" src="{{url(Storage::url(pagesetting('background_animated_first_image')[0]['path']))}}" alt="Background shape image" />@endif
    @if(!empty(pagesetting('background_animated_second_image')))<img class="am-bgimg-2" src="{{url(Storage::url(pagesetting('background_animated_second_image')[0]['path']))}}" alt="Background shape image" />@endif
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
    <script section='banner-v6'>
        AOS.init();
    </script>
@endpushOnce