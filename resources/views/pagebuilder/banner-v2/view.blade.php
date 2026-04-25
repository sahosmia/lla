<div class="am-banner">
    <div class="am-banner_shapes">
        @if(!empty(pagesetting('shape_img_one')))
            @if(!empty(pagesetting('shape_img_one')[0]['path']))
                <img src="{{url(Storage::url(pagesetting('shape_img_one')[0]['path']))}}" class="am-img_one" alt="Background shape image">
            @endif
        @endif
        @if(!empty(pagesetting('shape_img_two')))
            @if(!empty(pagesetting('shape_img_two')[0]['path']))
                <img src="{{url(Storage::url(pagesetting('shape_img_two')[0]['path']))}}" class="am-img_two" alt="Background shape image">
            @endif
        @endif
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading_image'))
                    || !empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('all_tutor_btn_url')) 
                    || !empty(pagesetting('all_tutor_btn_txt')) 
                    || !empty(pagesetting('see_demo_btn_url')) 
                    || !empty(pagesetting('see_demo_btn_txt')) 
                    || !empty(pagesetting('image')))
                    <div class="am-banner_wrap">
                        <div class="am-banner_content">
                            @if(!empty(pagesetting('pre_heading_image')) || !empty(pagesetting('pre_heading'))) 
                                <div class="am-banner_tag">
                                    @if(!empty(pagesetting('pre_heading_image')))
                                        <figure>
                                            @if(!empty(pagesetting('pre_heading_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('pre_heading_image')[0]['path']))}}" alt="Heading image">
                                            @endif
                                        </figure>
                                    @endif
                                    @if(!empty(pagesetting('pre_heading')))
                                        <span 
                                            @if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'))
                                                style="
                                                    @if(!empty(pagesetting('pre_heading_text_color')))
                                                        color: {{ pagesetting('pre_heading_text_color') }};
                                                    @endif
                                                    @if(!empty(pagesetting('pre_heading_bg_color')))
                                                        background-color: {{ pagesetting('pre_heading_bg_color') }};
                                                    @endif
                                                "
                                            @endif>
                                            {{ pagesetting('pre_heading') }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            @if(!empty(pagesetting('heading')))<h1>{!! pagesetting('heading') !!}</h1>@endif
                            @if(!empty(pagesetting('paragraph')))<p>{!! pagesetting('paragraph') !!}</p>@endif
                            <div class="am-banner_btns">
                                @if(!empty(pagesetting('all_tutor_btn_txt')) || !empty(pagesetting('all_tutor_btn_url'))) 
                                    <a href="@if(!empty(pagesetting('all_tutor_btn_url'))) {{ pagesetting('all_tutor_btn_url') }} @endif" class="am-primary-btn">
                                        {{ pagesetting('all_tutor_btn_txt') }}
                                    </a>
                                @endif
                                @if(!empty(pagesetting('see_demo_btn_txt')) || !empty(pagesetting('see_demo_btn_url'))) 
                                    <a href="@if(!empty(pagesetting('see_demo_btn_url'))){{ pagesetting('see_demo_btn_url') }}@endif" class="am-primary-btn-white tu-themegallery tu-thumbnails_content" data-autoplay="true" data-vbtype="video">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.20214 2.97528C4.6106 2.00267 3.81483 1.51637 3.15921 1.57372C2.58762 1.62372 2.06503 1.91681 1.72431 2.37846C1.3335 2.90799 1.3335 3.84059 1.3335 5.70578V10.7439C1.3335 12.6091 1.3335 13.5417 1.72431 14.0713C2.06503 14.5329 2.58762 14.826 3.15921 14.876C3.81483 14.9333 4.6106 14.447 6.20213 13.4744L10.3243 10.9554C11.8016 10.0526 12.5402 9.60118 12.792 9.02006C13.0119 8.51272 13.0119 7.937 12.792 7.42966C12.5402 6.84855 11.8016 6.39715 10.3243 5.49436L6.20214 2.97528Z" fill="white"/>
                                        </svg>
                                        {{ pagesetting('see_demo_btn_txt') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        @if(!empty(pagesetting('image'))) 
                            <div class="am-banner_images">
                                <figure>
                                    @if(!empty(pagesetting('image')[0]['path']))
                                        <img src="{{url(Storage::url(pagesetting('image')[0]['path']))}}" alt="Banner image">
                                    @endif
                                </figure>
                            </div>
                        @endif
                    </div>
                @endif
                @if(!empty(pagesetting('banner_repeater')))
                    <ul class="am-banner_companies am-banner-image">
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
        </div>
    </div>
</div>

@pushOnce('styles')
    @vite(['public/css/venobox.min.css'])
@endPushOnce
@pushOnce('scripts')
<script defer src="{{ asset('js/venobox.min.js')}}"></script>
<script>
     document.addEventListener('DOMContentLoaded', function () {
        initVenobox()
     });
</script>
@endPushOnce