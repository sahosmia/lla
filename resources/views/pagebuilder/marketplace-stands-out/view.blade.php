<div class="am-whychooseus whychooseus-variation-two {{ pagesetting('select_verient') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('section1_heading')) 
                    || !empty(pagesetting('section1_paragraph')) 
                    || !empty(pagesetting('section1_video')) 
                    || !empty(pagesetting('section2_heading')) 
                    || !empty(pagesetting('section2_paragraph'))
                    || !empty(pagesetting('section2_image'))
                    || !empty(pagesetting('section3_image'))
                    || !empty(pagesetting('section3_heading'))
                    || !empty(pagesetting('section3_paragraph')))
                    <div class="am-whychooseus-section">
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                            <div class="am-section_title am-section_title_center {{ pagesetting('section_title_variation') }}">
                                @if(!empty(pagesetting('pre_heading')))
                                    <span class="am-tag"
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
                        @endif
                        @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_paragraph')) || !empty(pagesetting('section1_video'))
                            || !empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_paragraph')) || !empty(pagesetting('section2_image')) 
                            || !empty(pagesetting('section3_image')) || !empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_paragraph')))
                            <div class="am-cards-container">
                                @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_paragraph')) || !empty(pagesetting('section1_video')))
                                    <div class="am-column">
                                        @if(!empty(pagesetting('section1_heading')) || !empty(pagesetting('section1_paragraph')))
                                            <div class="am-card am-yellow-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="200">
                                                @if(!empty(pagesetting('section1_paragraph')))<p>{!! pagesetting('section1_paragraph') !!}</p>@endif
                                                @if(!empty(pagesetting('section1_heading')))<h2>{!! pagesetting('section1_heading') !!}</h2>@endif
                                                @if(!empty(pagesetting('bg_shape_img')))
                                                    @if(!empty(pagesetting('bg_shape_img')[0]['path']))
                                                        <img class="am-img" src="{{ url(Storage::url(pagesetting('bg_shape_img')[0]['path'])) }}" alt="image-description">
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                        @if(!empty(pagesetting('section1_video')))
                                            <div class="am-card am-card-video" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                                                <video class="video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                                    <source src="{{ url(Storage::url(pagesetting('section1_video')[0]['path'])) }}#t=0.1" type="video/mp4" >
                                                </video>
                                                <div class="am-card_status"><span>Online</span></div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_paragraph')) || !empty(pagesetting('section2_image')))
                                    <div class="am-column am-tall-card">
                                        <figure class="am-card am-card-image-container" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
                                            @if(!empty(pagesetting('section2_image')))<img src="{{url(Storage::url(pagesetting('section2_image')[0]['path']))}}" alt="Seamless learning image" /> @endif
                                            @if(!empty(pagesetting('section2_heading')) || !empty(pagesetting('section2_paragraph')))
                                                <figcaption>
                                                    @if(!empty(pagesetting('section2_heading')))<h2>{!! pagesetting('section2_heading') !!}</h2>@endif
                                                    @if(!empty(pagesetting('section2_paragraph')))<p>{!! pagesetting('section2_paragraph') !!}</p>@endif
                                                </figcaption>
                                            @endif
                                        </figure>
                                    </div>
                                @endif
                                @if(!empty(pagesetting('section3_image')) || !empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_paragraph')))
                                    <div class="am-column">
                                        @if(!empty(pagesetting('section3_image')))
                                            <div class="am-card am-card-image" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="600">
                                                <img class="card-image-thumbnail" src="{{url(Storage::url(pagesetting('section3_image')[0]['path']))}}" alt="Marketplace image" /> 
                                            </div>
                                        @endif
                                        @if(!empty(pagesetting('section3_heading')) || !empty(pagesetting('section3_paragraph')))
                                            <div class="am-card am-blue-card" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="1000">
                                                @if(!empty(pagesetting('section3_heading')))<h2>{!! pagesetting('section3_heading') !!}</h2>@endif
                                                @if(!empty(pagesetting('section3_paragraph')))<p>{!! pagesetting('section3_paragraph') !!}</p>@endif
                                                @if(!empty(pagesetting('bg_shape_img')))
                                                    @if(!empty(pagesetting('bg_shape_img')[0]['path']))
                                                        <img class="am-img" src="{{ url(Storage::url(pagesetting('bg_shape_img')[0]['path'])) }}" alt="image-description">
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
        </div>
    </div>
</div>

@pushOnce('styles')
    @vite(['public/css/videojs.css'])
    @vite(['public/css/venobox.min.css'])
@endpushOnce

@pushOnce('scripts')
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script src="{{ asset('js/venobox.min.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                jQuery('.video-js').each((index, item) => {
                    item.onloadeddata =  function(){
                        videojs(item);
                    }
                })
            }, 500);
        });
    </script>
@endpushOnce