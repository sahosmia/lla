<section class="am-learning"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('search_placeholder')) 
                    || !empty(pagesetting('search_btn_txt')) 
                    || !empty(pagesetting('video')) 
                    || !empty(pagesetting('image_heading')) 
                    || !empty(pagesetting('image_paragraph')) 
                    || !empty(pagesetting('tutors_image')) 
                    || !empty(pagesetting('student_image')))
                    <div class="am-learning_content">
                        @if(!empty(pagesetting('pre_heading')) 
                            || !empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph')) 
                            || !empty(pagesetting('search_placeholder')) 
                            || !empty(pagesetting('search_btn_txt')))
                            <div class="am-learning_details">
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
                                        <svg xmlns:xlink="http://www.w3.org/1999/xlink" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                            <rect x="0.466797" width="18" height="18" fill="url(#pattern0_3685_950)"/>
                                            <defs>
                                                <pattern id="pattern0_3685_950" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_3685_950" transform="scale(0.0138889)"/>
                                                </pattern>
                                                <image id="image0_3685_950" width="72" height="72" xlink:href="data:image/png;base64,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"/>
                                            </defs>
                                        </svg>
                                        {{ pagesetting('pre_heading') }}
                                    </span>
                                @endif
                                @if(!empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                                    <div class="am-learning_title">
                                        @if(!empty(pagesetting('heading')))
                                            <h3>{!! pagesetting('heading') !!}</h3>
                                        @endif
                                        @if(!empty(pagesetting('paragraph')))
                                            <p>{!! pagesetting('paragraph') !!}</p>
                                        @endif
                                    </div>
                                @endif
                                <form action="{{ url('find-tutors') }}" method="GET" class="am-learning_search">
                                    <div class="am-learning_search_input">
                                        <input type="text" name="keyword" placeholder="{{ pagesetting('search_placeholder') }}">
                                    </div>
                                    <button type="submit" class="am-learning_search_btn am-btn"><i class="am-icon-search-02"></i></button>
                                </form>
                            </div>
                        @endif
                        @if(!empty(pagesetting('video'))
                            || !empty(pagesetting('image_heading')) 
                            || !empty(pagesetting('image_paragraph')) 
                            || !empty(pagesetting('tutors_image')) 
                            || !empty(pagesetting('student_image')))
                            <div class="am-learning_video">
                                @if(!empty(pagesetting('video')))
                                    <div class="am-learning_video_info">
                                        @if(!empty(pagesetting('video')[0]['path']))
                                            <video class="video-js" data-setup='{}' preload="auto" id="auth-video" width="416" height="284" controls >
                                                <source src="{{ url(Storage::url(pagesetting('video')[0]['path'])) }}" type="video/mp4" >
                                            </video>   
                                        @endif
                                    </div>
                                @endif
                                @if(!empty(pagesetting('image_heading')) || !empty(pagesetting('image_paragraph')))
                                    <div class="am-learning_video_tag">
                                        <div class="am-learning_video_tag_talent">
                                            <div>
                                                @if(!empty(pagesetting('image_heading')))
                                                    <svg class="am-text-svg" viewBox="0 0 100 100">
                                                        <path id="circlePath" d="M 10, 50 a 40,40 0 1,1 80,0 40,40 0 1,1 -80,0"></path>
                                                        <text>
                                                            <textPath href="#circlePath">
                                                            {{pagesetting('image_heading')}}
                                                            </textPath>
                                                        </text>
                                                    </svg>
                                                @endif
                                                <span>
                                                    <svg width="93" height="92" viewBox="0 0 93 92" fill="none">
                                                        <g filter="url(#filter0_d_3553_56658)">
                                                            <path d="M46.4955 26.0208L51.2261 38.8052L64.0104 43.5358L51.2261 48.2664L46.4955 61.0508L41.7648 48.2664L28.9805 43.5358L41.7648 38.8052L46.4955 26.0208Z" fill="#F55C2B"/>
                                                        </g>
                                                        <defs>
                                                            <filter id="filter0_d_3553_56658" x="0.956495" y="0.33217" width="91.0782" height="91.0779" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                                            <feOffset dy="2.33533"/>
                                                            <feGaussianBlur stdDeviation="14.012"/>
                                                            <feComposite in2="hardAlpha" operator="out"/>
                                                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3553_56658"/>
                                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3553_56658" result="shape"/>
                                                            </filter>
                                                        </defs>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        @if(!empty(pagesetting('image_paragraph')))
                                            <p>{{ pagesetting('image_paragraph') }}</p>
                                        @endif
                                    </div>
                                @endif
                                @if(!empty(pagesetting('tutors_image')))
                                    <figure class="am-learning_video_tutors-img">
                                        @if(!empty(pagesetting('tutors_image')[0]['path']))
                                            <img src="{{url(Storage::url(pagesetting('tutors_image')[0]['path']))}}" alt="Registered Tutors with profile pictures">
                                        @endif
                                    </figure>
                                @endif
                                @if(!empty(pagesetting('student_image')))
                                    <figure class="am-learning_video_talents-img">
                                        @if(!empty(pagesetting('student_image')[0]['path']))
                                            <img src="{{url(Storage::url(pagesetting('student_image')[0]['path']))}}" alt="Profile card">
                                        @endif
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
@vite(['public/css/videojs.css'])
@endpushOnce
@pushOnce('scripts')
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                bannerVideoJs();
            }, 500);
        });

        document.addEventListener('loadSectionJs', (event) => {
            if(event.detail.sectionId === 'banner'){
                bannerVideoJs();
            }
        });

        function bannerVideoJs(){
            if(typeof videojs !== 'undefined'){
                jQuery('.video-js').each((index, item) => {
                    item.onloadeddata =  function(){
                        videojs(item);
                    }
                })
            }
        }
    </script>
@endpushOnce
