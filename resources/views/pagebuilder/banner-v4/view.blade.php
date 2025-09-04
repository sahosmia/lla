
<div class="am-banner-potential am-banner-content-four">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('primary_btn_url')) 
                    || !empty(pagesetting('primary_btn_txt')) 
                    || !empty(pagesetting('secondary_btn_url')) 
                    || !empty(pagesetting('secondary_btn_txt')))
                    <div class="am-banner-main">
                        <div class="am-banner-tutor">
                            @if(!empty(pagesetting('heading')))<h2 data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">{!! pagesetting('heading') !!}</h2>@endif
                            @if(!empty(pagesetting('paragraph')))<p data-aos="fade-up" data-aos-easing="ease" data-aos-delay="300"  data-aos-anchor-placement="bottom-bottom">{!! pagesetting('paragraph') !!}</p>@endif
                            @if(empty(pagesetting('primary_btn_url')) 
                                || !empty(pagesetting('primary_btn_txt')) 
                                || !empty(pagesetting('secondary_btn_url')) 
                                || !empty(pagesetting('secondary_btn_txt')))
                                <div class="am-explore-banner-button" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                    @if(!empty(pagesetting('primary_btn_txt'))) 
                                        <a href="@if(!empty(pagesetting('primary_btn_url'))) {{ pagesetting('primary_btn_url') }} @endif" class="am-explore-btn"> 
                                            {{ pagesetting('primary_btn_txt') }}
                                        </a>
                                    @endif
                                    @if(!empty(pagesetting('secondary_btn_txt'))) 
                                        <a href="@if(!empty(pagesetting('secondary_btn_url'))) {{ pagesetting('secondary_btn_url') }} @endif" class="am-explore-btn am-demo-btn tu-themegallery tu-thumbnails_content" data-autoplay="true" data-vbtype="video"">
                                            <i class="am-icon-play-filled"></i>
                                            {{ pagesetting('secondary_btn_txt') }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if(!empty(pagesetting('banner_repeater')))
                            <ul class="am-banner_companies am-banner-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="500">
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
    @if(!empty(pagesetting('bg_img_one')) || !empty(pagesetting('bg_img_two')) || !empty(pagesetting('bg_img_three')) || !empty(pagesetting('bg_img_four')))
        @if(!empty(pagesetting('bg_img_one')))
            <img class="am-bgimg1" src="{{url(Storage::url(pagesetting('bg_img_one')[0]['path']))}}" alt="Background shape image"> 
        @endif
        @if(!empty(pagesetting('bg_img_two')))
            <img class="am-bgimg2" src="{{url(Storage::url(pagesetting('bg_img_two')[0]['path']))}}" alt="Background shape image"> 
        @endif
        @if(!empty(pagesetting('bg_img_three')))
            <img class="am-bgimg3" src="{{url(Storage::url(pagesetting('bg_img_three')[0]['path']))}}" alt="Background shape image"> 
        @endif
        @if(!empty(pagesetting('bg_img_four')))
            <img class="am-bgimg4" src="{{url(Storage::url(pagesetting('bg_img_four')[0]['path']))}}" alt="Background shape image"> 
        @endif
    @endif
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
    @if(!$isEdit)
        <script src="{{ asset('js/aos.min.js') }}"></script>
    @endif
    <script defer src="{{ asset('js/venobox.min.js')}}"></script>
    <script section='banner-v4'>
        document.addEventListener('DOMContentLoaded', (event) => {
            initVenobox()
        });
        AOS.init();
    </script>
@endpushOnce
