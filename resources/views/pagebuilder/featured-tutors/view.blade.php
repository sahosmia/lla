<section class="am-marketplace am-marketplace-slider">
    @if(!empty(pagesetting('shape_image')))
        @if(!empty(pagesetting('shape_image')[0]['path']))
            <img class="am-section-shape" src="{{url(Storage::url(pagesetting('shape_image')[0]['path']))}}" alt="image"> 
        @endif 
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')) || !empty(pagesetting('view_tutor_btn_text')) || !empty(pagesetting('view_tutor_btn_url')))
                    <div class="am-explore-tutor">
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                            <div class="am-steps_content_unlock">
                                @if(!empty(pagesetting('pre_heading'))) <span
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
                                </span> @endif 
                                @if(!empty(pagesetting('heading'))) <h3>{!! pagesetting('heading') !!}</h3> @endif
                                @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('view_tutor_btn_text'))) 
                            <a class="am-btn" href="@if(!empty(pagesetting('view_tutor_btn_url'))) {{ pagesetting('view_tutor_btn_url') }} @endif">
                                {{ pagesetting('view_tutor_btn_text') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-featured-tutors  /> 
</section>