<section class="am-feedback am-feedback-two {{ pagesetting('enable_slider') == 'no' ? 'am-feedback-three' : '' }} {{ pagesetting('verient') }}"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')) || !empty(pagesetting('feedback_repeater')))
                    <div class="am-feedback-two_wrap">
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
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
                                @if(!empty(pagesetting('heading'))) <h2>{!! pagesetting('heading') !!}</h2> @endif
                                @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
                            </div>
                        @endif
                        @if(pagesetting('enable_slider') == 'yes')
                        <div class="am-testimonial-section" data-aos="fade-up"  data-aos-duration="1000" data-aos-easing="ease">
                            <div class="splide" id="testimonial-slider">
                                <div class="splide__track">
                        @endif
                        @if(!empty(pagesetting('feedback_repeater'))) 
                            <ul class="am-feedback_content_list {{ pagesetting('enable_slider') == 'yes' ? 'splide__list' : '' }}">
                                @foreach(pagesetting('feedback_repeater') as $key => $option)
                                    <li class="{{ pagesetting('enable_slider') == 'yes' ? 'splide__slide' : '' }}" data-aos="fade-up" data-aos-duration="200" data-aos-easing="ease">
                                        @if(pagesetting('enable_slider') == 'yes')<div class="am-testimonial-card">@endif
                                        @if(!empty($option['feedback_paragraph']) 
                                            || !empty($option['tutor_rating']) 
                                            || !empty($option['tutor_image']) 
                                            || !empty($option['tutor_name']) 
                                            || !empty($option['tutor_tagline']) 
                                            || !empty($option['student_image']))
                                            <div class="am-feedback_content_list_info">
                                                @if(!empty($option['feedback_paragraph']))
                                                    <p>{!! $option['feedback_paragraph'] !!}</p>
                                                @endif
                                                @if(!empty($option['tutor_rating']))
                                                    <div class="am-feedback_content_list_stars">
                                                        @php
                                                            $rating = $option['tutor_rating']; 
                                                        @endphp
                                                        @if($rating)
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if($i <= $rating)
                                                                    <i class="am-icon-star-filled"></i>
                                                                @else
                                                                    <i class="am-icon-star-filled am-icon-start-empty"></i>
                                                                @endif
                                                            @endfor
                                                        @elseif(empty($rating))
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="am-icon-start-empty"></i>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                @endif
                                                @if(!empty($option['feedback_paragraph']) 
                                                    || !empty($option['tutor_image']) 
                                                    || !empty($option['tutor_name']) 
                                                    || !empty($option['tutor_tagline']) 
                                                    || !empty($option['student_image']))
                                                    <div class="am-feedback_content_list_info_prof"> 
                                                        @if(!empty($option['tutor_image']))
                                                            <figure>
                                                                @if(!empty($option['tutor_image'][0]['path']))
                                                                    <img src="{{url(Storage::url($option['tutor_image'][0]['path']))}}" alt="Profile image">
                                                                @endif
                                                            </figure>
                                                        @endif
                                                        <div>
                                                            @if(!empty($option['tutor_name'])) <h3>{!! $option['tutor_name'] !!}</h3> @endif
                                                            @if(!empty($option['tutor_tagline'])) <span>{!! $option['tutor_tagline'] !!}</span> @endif
                                                        </div>
                                                        @if(!empty($option['student_image']))
                                                            @if(!empty($option['student_image'][0]['path']))
                                                                <span class="am-rating-company">
                                                                    @if(!empty($option['student_image'][0]['path']))
                                                                        <img src="{{url(Storage::url($option['student_image'][0]['path']))}}" alt="Profile image">
                                                                    @endif      
                                                                </span>
                                                            @endif 
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="am-feedbackicon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <g opacity="0.2">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.2 3.25H5.16957H5.16955C4.6354 3.24999 4.18956 3.24998 3.82533 3.27974C3.44545 3.31078 3.08879 3.37789 2.75153 3.54973C2.23408 3.81339 1.81339 4.23408 1.54973 4.75153C1.37789 5.08879 1.31078 5.44545 1.27974 5.82533C1.24998 6.18956 1.24999 6.6354 1.25 7.16955V7.16957V7.2V8.8V8.83044V8.83045C1.24999 9.3646 1.24998 9.81044 1.27974 10.1747C1.31078 10.5546 1.37789 10.9112 1.54973 11.2485C1.81339 11.7659 2.23408 12.1866 2.75153 12.4503C3.08879 12.6221 3.44545 12.6892 3.82533 12.7203C4.18955 12.75 4.63538 12.75 5.16951 12.75H5.16955H5.2H6.8H6.83045H6.8305C7.36462 12.75 7.81045 12.75 8.17467 12.7203C8.55456 12.6892 8.91121 12.6221 9.24848 12.4503L9.25 12.4495V13.25C9.25 13.9999 9.24882 14.3148 9.21477 14.6072C9.07258 15.8284 8.50628 16.961 7.6146 17.8075C7.40111 18.0102 7.1499 18.2001 6.55 18.65L5.55 19.4C5.21863 19.6485 5.15147 20.1186 5.4 20.45C5.64853 20.7814 6.11863 20.8485 6.45 20.6L7.45 19.85L7.4915 19.8189L7.49152 19.8189C8.03778 19.4092 8.36303 19.1653 8.64735 18.8954C9.79379 17.807 10.5219 16.3508 10.7047 14.7807C10.75 14.3913 10.75 13.9847 10.75 13.3019V13.3019L10.75 13.25V8.8822V8.83045V8.8V8V7.2V7.16955V7.16951C10.75 6.63538 10.75 6.18955 10.7203 5.82533C10.6892 5.44545 10.6221 5.08879 10.4503 4.75153C10.1866 4.23408 9.76592 3.81339 9.24848 3.54973C8.91121 3.37789 8.55456 3.31078 8.17467 3.27974C7.81044 3.24998 7.3646 3.24999 6.83046 3.25H6.83044H6.8H5.2ZM17.2 3.25H17.1696H17.1695C16.6354 3.24999 16.1896 3.24998 15.8253 3.27974C15.4454 3.31078 15.0888 3.37789 14.7515 3.54973C14.2341 3.81339 13.8134 4.23408 13.5497 4.75153C13.3779 5.08879 13.3108 5.44545 13.2797 5.82533C13.25 6.18955 13.25 6.63538 13.25 7.16951V7.16955V7.2V8.8V8.83045V8.8305C13.25 9.36462 13.25 9.81045 13.2797 10.1747C13.3108 10.5546 13.3779 10.9112 13.5497 11.2485C13.8134 11.7659 14.2341 12.1866 14.7515 12.4503C15.0888 12.6221 15.4454 12.6892 15.8253 12.7203C16.1896 12.75 16.6354 12.75 17.1695 12.75H17.1695H17.2H18.8H18.8305H18.8305C19.3646 12.75 19.8105 12.75 20.1747 12.7203C20.5546 12.6892 20.9112 12.6221 21.2485 12.4503L21.25 12.4495V13.25C21.25 13.9999 21.2488 14.3148 21.2148 14.6072C21.0726 15.8284 20.5063 16.961 19.6146 17.8075C19.4011 18.0102 19.1499 18.2001 18.55 18.65L17.55 19.4C17.2186 19.6485 17.1515 20.1186 17.4 20.45C17.6485 20.7814 18.1186 20.8485 18.45 20.6L19.45 19.85L19.4915 19.8189L19.4915 19.8189C20.0378 19.4092 20.363 19.1653 20.6473 18.8954C21.7938 17.807 22.5219 16.3508 22.7047 14.7807C22.75 14.3912 22.75 13.9847 22.75 13.3019V13.25V8.88427V8.83045V8.8V8V7.2V7.16955C22.75 6.6354 22.75 6.18956 22.7203 5.82533C22.6892 5.44545 22.6221 5.08879 22.4503 4.75153C22.1866 4.23408 21.7659 3.81339 21.2485 3.54973C20.9112 3.37789 20.5546 3.31078 20.1747 3.27974C19.8104 3.24998 19.3646 3.24999 18.8305 3.25H18.8304H18.8H17.2Z" fill="black"/>
                                                        </g>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif
                                        @if(pagesetting('enable_slider') == 'yes')</div>@endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(pagesetting('enable_slider') == 'yes')
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('styles')
    @vite(['public/css/flags.css'])
@endpush

@pushOnce('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('#testimonial-slider')) {
                initClientsFeedbackSlider();
            }
        });

        document.addEventListener('loadSectionJs', function (event) {
            if (event.detail.sectionId === 'clients-feedback') {
                if (document.querySelector('#testimonial-slider')) {
                    initClientsFeedbackSlider();
                }
            }
        });

        function initClientsFeedbackSlider() {
            new Splide('#testimonial-slider', {
                gap: '20px',
                perPage: 3,
                perMove: 1,
                focus: 1,
                type: 'loop',
                direction: document.documentElement.dir === 'rtl' ? 'rtl' : 'ltr', 
                breakpoints: {
                    1024: {
                        perPage: 2,
                    },
                    768: {
                        perPage: 1,
                    },
                },
            }).mount();
        }
    </script>
@endPushOnce
