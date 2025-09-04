<section class="am-banner_section"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
            @if(!empty(pagesetting('heading')) 
                || !empty(pagesetting('paragraph')) 
                || !empty(pagesetting('all_tutor_btn_url')) 
                || !empty(pagesetting('all_tutor_btn_txt')) 
                || !empty(pagesetting('brand_heading')) 
                || !empty(pagesetting('image'))
                || !empty(pagesetting('banner_image')))
                <div class="am-banner_wrap">
                    @if(!empty(pagesetting('heading')) 
                        || !empty(pagesetting('paragraph')) 
                        || !empty(pagesetting('all_tutor_btn_url')) 
                        || !empty(pagesetting('all_tutor_btn_txt')) 
                        || !empty(pagesetting('brand_heading')) 
                        || !empty(pagesetting('image')))
                        <div class="am-banner_content">
                            @if(!empty(pagesetting('heading')))
                                <h1 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">{!! pagesetting('heading') !!}</h1>
                            @endif
                            @if(!empty(pagesetting('paragraph')))
                                <p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300">{!! pagesetting('paragraph') !!}</p>
                            @endif
                            @if(!empty(pagesetting('all_tutor_btn_txt'))) 
                                <div class="am-banner_btns" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                    <a href="@if(!empty(pagesetting('all_tutor_btn_url'))) {{ pagesetting('all_tutor_btn_url') }} @endif" class="am-primary-btn">
                                        {{ pagesetting('all_tutor_btn_txt') }}
                                    </a>
                                </div>
                            @endif
                            @if(!empty(pagesetting('brand_heading')) || !empty(pagesetting('banner_repeater')))
                                <div class="am-banner_logo">
                                    @if(!empty(pagesetting('brand_heading')))
                                        <span data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500">{{ pagesetting('brand_heading') }} <em></em></span>
                                    @endif
                                    @if(!empty(pagesetting('banner_repeater')))
                                        <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                            @foreach(pagesetting('banner_repeater') as $option)
                                                @if(!empty($option['banner_image'][0]['path']))
                                                    <li><figure><img src="{{url(Storage::url($option['banner_image'][0]['path']))}}" alt="Company logo"></figure></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endif
                        </div> 
                    @endif
                    @if(!empty(pagesetting('image')))
                        <div class="am-banner_images">
                            @if(!empty(pagesetting('image')[0]['path']))
                                <figure>
                                    <img src="{{url(Storage::url(pagesetting('image')[0]['path']))}}" alt="Banner image" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="600">
                                </figure>
                            @endif
                        </div>  
                    @endif
                </div>
            @endif
            </div>
        </div>
    </div>
</section>

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
    <script section='banner-v9'>
        AOS.init();
    </script>
@endpushOnce