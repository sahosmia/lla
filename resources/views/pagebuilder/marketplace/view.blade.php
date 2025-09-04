
<section class="am-marketplace"> 
    @if(!empty(pagesetting('shape_image')))
        @if(!empty(pagesetting('shape_image')[0]['path']))
            <img class="am-section-shape" src="{{url(Storage::url(pagesetting('shape_image')[0]['path']))}}" alt="Background shape image">
        @endif 
    @endif 
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('icon'))
                    || !empty(pagesetting('list-data')) 
                    || !empty(pagesetting('start_journ_heading')) 
                    || !empty(pagesetting('start_journ_description')) 
                    || !empty(pagesetting('get_start_btn_text'))
                    || !empty(pagesetting('get_start_btn_url'))
                    || !empty(pagesetting('image')))
                    <div class="am-marketplace_content">
                        @if(!empty(pagesetting('pre_heading')) 
                            || !empty(pagesetting('heading')) 
                            || !empty(pagesetting('paragraph')) 
                            || !empty(pagesetting('icon'))
    
                            || !empty(pagesetting('list-data')) 
                            || !empty(pagesetting('start_journ_heading')) 
                            || !empty(pagesetting('start_journ_description')) 
                            || !empty(pagesetting('get_start_btn_text'))
                            || !empty(pagesetting('get_start_btn_url')))
                            <div class="am-marketplace_content_list">
                                @if(!empty(pagesetting('icon')))
                                    <span>
                                        <i class="{!! pagesetting('icon') !!}"></i>
                                    </span>
                                @endif
                                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph'))) 
                                    <div class="am-marketplace_content_list_info">
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
                                @endif 
                                @if(!empty(pagesetting('list-data')))    
                                    <div class="am-marketplace_content_list_details">
                                        @if(!empty( pagesetting('list-data')))
                                            <ul>
                                                @foreach(pagesetting('list-data') as $data)
                                                    <li>
                                                        <span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                <path d="M9 0L11.4308 6.56918L18 9L11.4308 11.4308L9 18L6.56918 11.4308L0 9L6.56918 6.56918L9 0Z" fill="white"/>
                                                            </svg>
                                                        </span>
                                                        <h6>{!! $data['list_item'] !!}</h6>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endif
                                @if(!empty(pagesetting('get_start_btn_text'))) 
                                    <a href="@if(!empty(pagesetting('get_start_btn_url'))) {{ pagesetting('get_start_btn_url') }} @endif" class="am-marketplace_content_list_btn am-btn">
                                        {{ pagesetting('get_start_btn_text') }}
                                    </a>
                                @endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('image')))
                            <div class="am-marketplace_content_video">
                                @if(!empty(pagesetting('image')[0]['path']))
                                    <img src="{{url(Storage::url(pagesetting('image')[0]['path']))}}" alt="Marketplace image">
                                @endif
                            </div>
                        @endif
                    </div>  
                @endif
            </div>
        </div>
    </div>
</section>