
<section class="am-works"> 
    @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
        <div class="am-page-title-wrap">
            <div class="am-content_box">
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
                @if(!empty(pagesetting('heading'))) <h3>{!! pagesetting('heading') !!}</h3> @endif
                @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
            </div>
        </div>
    @endif

    @if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('student_btn_url')) || !empty(pagesetting('tutor_btn_url')) || !empty(pagesetting('tutor_btn_txt')))
        <div class="am-joincommunity_btn">
            @if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('student_btn_url')))
                <a href="{{ setting('_lernen.allow_register') !== 'no' ? pagesetting('student_btn_url') : '#' }}" class="am-btn">
                    {{ pagesetting('student_btn_txt') }}
                </a>
            @endif
            @if(!empty(pagesetting('tutor_btn_url')) || !empty(pagesetting('tutor_btn_txt')))
                <a href="{{ setting('_lernen.allow_register') !== 'no' ? pagesetting('tutor_btn_url') : '#' }}" class="am-white-btn">
                    {{ pagesetting('tutor_btn_txt') }}
                </a>
            @endif
        </div>
    @endif
</section>
