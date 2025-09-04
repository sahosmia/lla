<div class="am-guidesteps">
    @if(!empty(pagesetting('pre_heading')) 
        || !empty(pagesetting('heading')) 
        || !empty(pagesetting('paragraph')) 
        || !empty(pagesetting('steps_data')) 
        || !empty(pagesetting('primary_btn_url')) 
        || !empty(pagesetting('primary_btn_text')) 
        || !empty(pagesetting('secondary_btn_url')) 
        || !empty(pagesetting('secondary_btn_text'))
        || !empty(pagesetting('first_shape_image'))
        || !empty(pagesetting('second_shape_image')))
        <div class="am-guidesteps_contentwrap">
            @if(!empty(pagesetting('pre_heading')) 
                || !empty(pagesetting('heading')) 
                || !empty(pagesetting('paragraph')) 
                || !empty(pagesetting('steps_data')) 
                || !empty(pagesetting('primary_btn_url')) 
                || !empty(pagesetting('primary_btn_text')) 
                || !empty(pagesetting('secondary_btn_url')) 
                || !empty(pagesetting('secondary_btn_text')))
                <div class="am-guidesteps_content">
                    @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
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
                            @if(!empty(pagesetting('heading'))) <h2>{!! pagesetting('heading') !!}</h2> @endif
                            @if(!empty(pagesetting('paragraph'))) <p>{!! pagesetting('paragraph') !!}</p> @endif
                        </div>
                    @endif
                    @if(!empty(pagesetting('steps_data')))
                        <ul class="am-guidesteps_list">
                            @foreach(pagesetting('steps_data') as $option)
                                @if(!empty($option['step_heading']) || !empty($option['step_paragraph']) || !empty($option['step_icon']))
                                    <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="{{ $loop->index * 200 }}">
                                        <div class="am-guidesteps_list_item">
                                            @if(!empty($option['step_icon']))<span><i class="{!! $option['step_icon'] !!}"></i></span>@endif
                                            @if(!empty($option['step_heading']) || !empty($option['step_paragraph']))
                                                <div class="am-guidesteps_list_info">
                                                    @if(!empty($option['step_heading'])) <h5>{!! $option['step_heading'] !!}</h5> @endif
                                                    @if(!empty($option['step_paragraph'])) <p>{!! $option['step_paragraph'] !!}</p> @endif
                                                </div>
                                            @endif   
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                    @if(!empty(pagesetting('primary_btn_url')) || !empty(pagesetting('primary_btn_text')) 
                        || !empty(pagesetting('secondary_btn_url')) || !empty(pagesetting('secondary_btn_text')))
                        <div class="am-guidesteps_btns" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="800">
                            @if(!empty(pagesetting('primary_btn_text')))
                                <a href="@if(!empty(pagesetting('primary_btn_url'))) {{ pagesetting('primary_btn_url') }} @endif" class="am-explore-btn">
                                    {{ pagesetting('primary_btn_text') }}
                                </a>
                            @endif
                            @if(!empty(pagesetting('secondary_btn_text')))
                                <a href="@if(!empty(pagesetting('secondary_btn_url'))) {{ pagesetting('secondary_btn_url') }} @endif" class="am-demo-btn tu-themegallery tu-thumbnails_content vbox-item" data-autoplay="true" data-vbtype="video" "="">
                                    <i class="am-icon-play-filled"></i> 
                                    {{ pagesetting('secondary_btn_text') }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
            @if(!empty(pagesetting('first_shape_image')) || !empty(pagesetting('second_shape_image')))
                @if(!empty(pagesetting('first_shape_image')[0]['path']))
                    <img class="am-stepbgimg-1" src="{{url(Storage::url(pagesetting('first_shape_image')[0]['path']))}}" alt="Background shape image">
                @endif
                @if(!empty(pagesetting('second_shape_image')[0]['path']))
                    <img class="am-stepbgimg-2" src="{{url(Storage::url(pagesetting('second_shape_image')[0]['path']))}}" alt="Background shape image">
                @endif
            @endif
        </div>
    @endif
    @if(!empty(pagesetting('main_image')))
        <div class="am-guidesteps_bookingsection" data-aos="fade-left" data-aos-easing="ease" data-aos-delay="200">
            <figure>
                <img src="{{url(Storage::url(pagesetting('main_image')[0]['path']))}}" alt="Guide steps image">
            </figure>
        </div>
    @endif
</div>

@pushOnce('styles')
@vite(['public/css/venobox.min.css'])
@endpushOnce
@pushOnce('scripts')
    <script src="{{ asset('js/venobox.min.js')}}"></script>
    <script section='guide-steps'>
        document.addEventListener('DOMContentLoaded', (event) => {
            initVenobox()
        });
    </script>
@endpushOnce

