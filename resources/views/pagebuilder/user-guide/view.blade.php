<section class="am-steps"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('left_image')) || !empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                    <div class="am-works_info am-home-support-section">
                        @if(!empty(pagesetting('left_image')))
                            <div class="am-works_info_user">
                                @if(!empty(pagesetting('left_image')[0]['path']))
                                    <figure><img src="{{url(Storage::url(pagesetting('left_image')[0]['path']))}}" alt="Comprehensive support image"></figure>
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                            <div class="am-home-support">                           
                                <div class="am-works_info_description">
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
                                    @if(!empty(pagesetting('paragraph'))) {!! pagesetting('paragraph') !!} @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                @if(!empty(pagesetting('right_image')) || !empty(pagesetting('sub_heading')) || !empty(pagesetting('second_heading')) || !empty(pagesetting('second_paragraph')))
                    <div class="am-works_info am-home-guide-section">
                        @if(!empty(pagesetting('sub_heading')) || !empty(pagesetting('second_heading')) || !empty(pagesetting('second_paragraph')))
                            <div class="am-home-guide">
                                <div class="am-works_info_description">
                                    @if(!empty(pagesetting('sub_heading'))) 
                                        <span
                                            @if((!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)') || (!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)'))
                                                style="
                                                    @if(!empty(pagesetting('pre_heading_text_color')) && pagesetting('pre_heading_text_color') !== 'rgba(0,0,0,0)')
                                                        color: {{ pagesetting('pre_heading_text_color') }};
                                                    @endif
                                                    @if(!empty(pagesetting('pre_heading_bg_color')) && pagesetting('pre_heading_bg_color') !== 'rgba(0,0,0,0)')
                                                        background-color: {{ pagesetting('sub_heading_bg_color') }};
                                                    @endif
                                                "
                                            @endif>
                                            {{ pagesetting('sub_heading') }}
                                        </span> 
                                    @endif 
                                    @if(!empty(pagesetting('second_heading'))) <h3>{!! pagesetting('second_heading') !!}</h3> @endif
                                    @if(!empty(pagesetting('second_paragraph'))) {!! pagesetting('second_paragraph') !!} @endif
                                </div>
                            </div>
                        @endif
                        @if(!empty(pagesetting('right_image')))
                        <div class="am-works_info_user">
                            @if(!empty(pagesetting('right_image')[0]['path']))
                                <figure><img src="{{url(Storage::url(pagesetting('right_image')[0]['path']))}}" alt="User guide image"></figure>
                            @endif
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>