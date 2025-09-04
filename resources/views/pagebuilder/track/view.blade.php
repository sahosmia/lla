<div class="am-tracklearning">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-tracklearning_wrap">
                    <div class="am-tracklearning_content">
                        <div class="am-section_title {{ pagesetting('section_title_variation') }}">
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
                        @if(!empty(pagesetting('steps_repeater')))
                            <ul>
                                @foreach(pagesetting('steps_repeater') as $option)
                                    <li>
                                        <div class="am-tracklearning_activities">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M7.75 0.5L9.77568 5.97432L15.25 8L9.77568 10.0257L7.75 15.5L5.72432 10.0257L0.25 8L5.72432 5.97432L7.75 0.5Z" fill="#3CCF3C"/>
                                            </svg>
                                            <div>
                                                @if(!empty($option['step_heading']))<h5>{!! $option['step_heading'] !!}</h5>@endif
                                                @if(!empty($option['step_paragraph']))<span>{!! $option['step_paragraph'] !!}</span>@endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        @if(!empty(pagesetting('get_started_btn_url')) 
                            || !empty(pagesetting('get_started_btn_txt'))
                            || !empty(pagesetting('explore_tutor_btn_url'))
                            || !empty(pagesetting('explore_tutor_btn_txt')))
                            <div class="am-tracklearning_btns">
                                @if(!empty(pagesetting('get_started_btn_txt')) || !empty(pagesetting('get_started_btn_url'))) 
                                    <a href="@if(!empty(pagesetting('get_started_btn_url'))) {{ pagesetting('get_started_btn_url') }} @endif" class="am-primary-btn">
                                        {{ pagesetting('get_started_btn_txt') }}
                                    </a>
                                @endif
                                @if(!empty(pagesetting('explore_tutor_btn_txt')) || !empty(pagesetting('explore_tutor_btn_url'))) 
                                    <a href="{{ setting('_lernen.allow_register') !== 'no' ? pagesetting('explore_tutor_btn_url') : '#' }}" class="am-primary-btn-white">
                                        {{ pagesetting('explore_tutor_btn_txt') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                    @if(!empty(pagesetting('subject_image')) 
                    || !empty(pagesetting('summary_image'))
                    || !empty(pagesetting('student_image'))
                    || !empty(pagesetting('calander_image')))
                        <div class="am-tracklearning_images">
                            @if(!empty(pagesetting('subject_image')[0]['path']))
                                <figure class="am-subject-img">
                                    <img src="{{url(Storage::url(pagesetting('subject_image')[0]['path']))}}" alt="Subject statistics image">
                                </figure>
                            @endif
                            @if(!empty(pagesetting('summary_image')[0]['path']))
                                <figure class="am-summary-img">
                                    <img src="{{url(Storage::url(pagesetting('summary_image')[0]['path']))}}" alt="Order summary image">
                                </figure>
                            @endif
                            @if(!empty(pagesetting('student_image')[0]['path']))
                                <figure class="am-student-img">
                                    <img src="{{url(Storage::url(pagesetting('student_image')[0]['path']))}}" alt="Student statistics image">
                                </figure>
                            @endif
                            @if(!empty(pagesetting('calander_image')[0]['path']))
                                <figure class="am-calander-logo">
                                    <img src="{{url(Storage::url(pagesetting('calander_image')[0]['path']))}}" alt="Calander image">
                                </figure>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(!empty(pagesetting('shape_img')))
        @if(!empty(pagesetting('shape_img')[0]['path']))
            <img src="{{url(Storage::url(pagesetting('shape_img')[0]['path']))}}" class="am-img" alt="Background shape image">
        @endif
    @endif
    <!-- <img class="am-img" src="../demo-content/home-v2/learning-bg.png" alt="image-description"> -->
</div>
