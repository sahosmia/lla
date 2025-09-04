<div class="am-banner-seven">
    <div class="am-banner-potential am-banner-content-seven">
        @if(!empty(pagesetting('bg_img')))
            <img class="am-banner-img" src="{{url(Storage::url(pagesetting('bg_img')[0]['path']))}}" alt="Banner image"> 
        @endif
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!empty(pagesetting('heading')) 
                        || !empty(pagesetting('paragraph')) 
                        || !empty(pagesetting('primary_btn_url')) 
                        || !empty(pagesetting('primary_btn_txt')) 
                        || !empty(pagesetting('secondary_btn_url')) 
                        || !empty(pagesetting('secondary_btn_txt'))
                        || !empty(pagesetting('banner_repeater')))
                        <div class="am-banner-main">
                            @if(!empty(pagesetting('heading')) 
                                || !empty(pagesetting('paragraph')) 
                                || !empty(pagesetting('primary_btn_url')) 
                                || !empty(pagesetting('primary_btn_txt')) 
                                || !empty(pagesetting('secondary_btn_url')) 
                                || !empty(pagesetting('secondary_btn_txt')))
                                <div class="am-banner-tutor">
                                    @if(!empty(pagesetting('heading')))<h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">{!! pagesetting('heading') !!}</h2>@endif
                                    @if(!empty(pagesetting('paragraph')))<p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">{!! pagesetting('paragraph') !!}</p>@endif
                                    @if(!empty(pagesetting('primary_btn_txt'))  || !empty(pagesetting('secondary_btn_txt')))
                                        <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                            @if(!empty(pagesetting('primary_btn_txt')))
                                                <a href="@if(!empty(pagesetting('primary_btn_url'))) {{ pagesetting('primary_btn_url') }} @endif" class="am-explore-btn"> 
                                                    {{ pagesetting('primary_btn_txt') }}
                                                </a>
                                            @endif
                                            @if(!empty(pagesetting('secondary_btn_txt')))
                                                <a href="@if(!empty(pagesetting('secondary_btn_url'))) {{ pagesetting('secondary_btn_url') }} @endif" class="am-btn am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content"  data-autoplay="true" data-vbtype="video">
                                                    <i class="am-icon-play-filled"></i>
                                                    {{ pagesetting('secondary_btn_txt') }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if(!empty(pagesetting('banner_repeater')))
                                <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                                    @foreach(pagesetting('banner_repeater') as $option)
                                        @if(!empty($option['banner_image']))
                                            @if(!empty($option['banner_image'][0]['path']))
                                                <li><figure><img src="{{url(Storage::url($option['banner_image'][0]['path']))}}" alt="Company logo"></figure></li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif
                </div>
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
@vite(['public/css/venobox.min.css'])
@endpushOnce
@pushOnce('scripts')
    <script defer src="{{ asset('js/venobox.min.js')}}"></script>
    @if(!$isEdit)
        <script src="{{ asset('js/aos.min.js') }}"></script>
    @endif
    <script section='banner-v7'>
        AOS.init();
    </script>
@endpushOnce
