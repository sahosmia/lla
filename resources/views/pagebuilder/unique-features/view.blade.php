<!-- Unique Features Section Start -->
<div class="am-unique-features {{ pagesetting('select_verient') }}">
    <div class="container">
        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
            <div class="row">
                <div class="col-12">
                    <div class="am-section_title am-section_title_center {{ pagesetting('section_title_variation') }}">
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
                        @if(!empty(pagesetting('heading')))<h2>{!! pagesetting('heading') !!}</h2>@endif
                        @if(!empty(pagesetting('paragraph')))<p>{!! pagesetting('paragraph') !!}</p>@endif
                    </div>
                </div>
            </div>
        @endif
        @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) || !empty(pagesetting('section1_2nd_image'))
            || !empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) 
            || !empty(pagesetting('section2_3rd_image')) || !empty(pagesetting('section2_4th_image')) || !empty(pagesetting('section3_heading')) 
            || !empty(pagesetting('section3_image')) || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image'))
            || !empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image')))
            <div class="am-features-grid">
                @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) 
                    || !empty(pagesetting('section1_2nd_image')) || !empty(pagesetting('section2_heading')) 
                    || !empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) 
                    || !empty(pagesetting('section2_3rd_image')) || !empty(pagesetting('section2_4th_image')))
                    <div class="am-features-row">
                        @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_image')) || !empty(pagesetting('section1_2nd_image')))
                            <div class="am-feature-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                @if(!empty(pagesetting('section1_heading')))<h3>{{ pagesetting('section1_heading') }}</h3>@endif
                                @if (!empty(pagesetting('section1_image')))
                                    @if(!empty(pagesetting('section1_image')[0]['path']))
                                        <img src="{{url(Storage::url(pagesetting('section1_image')[0]['path']))}}" class="am-feature-image" alt="Schedule image" />
                                    @endif
                                @endif
                                @if (!empty(pagesetting('section1_2nd_image')))
                                    @if(!empty(pagesetting('section1_2nd_image')[0]['path']))
                                        <img src="{{url(Storage::url(pagesetting('section1_2nd_image')[0]['path']))}}" class="am-feature-icon" alt="Bell icon image" />
                                    @endif
                                @endif
                                @if(!empty(pagesetting('bg_shape_img')))
                                    @if(!empty(pagesetting('bg_shape_img')[0]['path']))
                                        <img class="am-img" src="{{url(Storage::url(pagesetting('bg_shape_img')[0]['path']))}}" alt="image-description">
                                    @endif
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_image')) 
                            || !empty(pagesetting('section2_2nd_image')) || !empty(pagesetting('section2_3rd_image')) 
                            || !empty(pagesetting('section2_4th_image')))
                            <div class="am-progress-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                @if(!empty(pagesetting('section2_image')) || !empty(pagesetting('section2_2nd_image')) || !empty(pagesetting('section2_3rd_image')))
                                    <div class="am-images-group">
                                        @if (!empty(pagesetting('section2_image')))
                                            @if(!empty(pagesetting('section2_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section2_image')[0]['path']))}}" class="am-progress-image1" alt="Background shape image" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section2_2nd_image')))
                                            @if(!empty(pagesetting('section2_2nd_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section2_2nd_image')[0]['path']))}}" class="am-progress-image2" alt="Subject statistics image" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section2_3rd_image')))
                                            @if(!empty(pagesetting('section2_3rd_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section2_3rd_image')[0]['path']))}}" class="am-progress-image3" alt="Order summary image" />
                                            @endif
                                        @endif
                                    </div>
                                @endif
                                @if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_4th_image')))
                                    @if(!empty(pagesetting('section2_heading')))<h3>{{ pagesetting('section2_heading') }}</h3>@endif
                                    @if (!empty(pagesetting('section2_4th_image')))
                                        @if(!empty(pagesetting('section2_4th_image')[0]['path']))
                                            <img src="{{url(Storage::url(pagesetting('section2_4th_image')[0]['path']))}}" class="am-progress-image4" alt="image description" />
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
                @if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_image')) 
                    || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image')) 
                    || !empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) 
                    || !empty(pagesetting('section4_2nd_image')))
                    <div class="am-features-row">
                        @if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_image')) 
                            || !empty(pagesetting('section3_2nd_image')) || !empty(pagesetting('section3_3rd_image')))
                            <div class="am-tutors-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                @if(!empty(pagesetting('section3_heading')))<h3>{{ pagesetting('section3_heading') }}</h3>@endif
                                @if(!empty(pagesetting('section3_image')) || !empty(pagesetting('section3_2nd_image')))
                                    <div class="am-tutor-img">
                                        @if (!empty(pagesetting('section3_image')))
                                            @if(!empty(pagesetting('section3_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section3_image')[0]['path']))}}" class="am-tutor-img-three" alt="Book image" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section3_2nd_image')))
                                            @if(!empty(pagesetting('section3_2nd_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section3_2nd_image')[0]['path']))}}" class="am-tutor-img-four" alt="User image" />
                                            @endif
                                        @endif
                                    </div>
                                @endif
                                @if (!empty(pagesetting('section3_3rd_image')))
                                    @if(!empty(pagesetting('section3_3rd_image')[0]['path']))
                                        <img src="{{url(Storage::url(pagesetting('section3_3rd_image')[0]['path']))}}" class="am-tutor-img-five" alt="Students image" />
                                    @endif
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('section4_heading')) || !empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image')))
                            <div class="am-personalize-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                @if(!empty(pagesetting('section4_heading')))<h3>{{ pagesetting('section4_heading') }}</h3>@endif
                                @if(!empty(pagesetting('section4_image')) || !empty(pagesetting('section4_2nd_image')))
                                    <div class="am-personalize-img">
                                        @if (!empty(pagesetting('section4_image')))
                                            @if(!empty(pagesetting('section4_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section4_image')[0]['path']))}}" class="am-feature-image-two" alt="Session progress image" />
                                            @endif
                                        @endif
                                        @if (!empty(pagesetting('section4_2nd_image')))
                                            @if(!empty(pagesetting('section4_2nd_image')[0]['path']))
                                                <img src="{{url(Storage::url(pagesetting('section4_2nd_image')[0]['path']))}}" class="am-feature-image-one" alt="Start session image" />
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>
    @if(!empty(pagesetting('shape_img')))
        @if(!empty(pagesetting('shape_img')[0]['path']))
            <img class="am-img" src="{{url(Storage::url(pagesetting('shape_img')[0]['path']))}}" alt="image-description">
        @endif
    @endif
</div>
<!-- Unique Features Section End -->