
<section class="am-vision-section">
    <div class="container-fluaid">
        @if(!empty(pagesetting('video'))
            || !empty(pagesetting('pre_heading')) 
            || !empty(pagesetting('heading')) 
            || !empty(pagesetting('paragraph')) 
            || !empty(pagesetting('list_data'))
            || !empty(pagesetting('discover_more_btn_text'))
            || !empty(pagesetting('discover_more_btn_url')))
            <div class="row">
                @if(!empty(pagesetting('video')))
                    <div class="col-12 col-lg-6">
                        @if(!empty(pagesetting('video')[0]['path']))
                            <video class="video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                <source src="{{ url(Storage::url(pagesetting('video')[0]['path'])) }}#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                            </video>
                        @endif
                    </div>
                @endif
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading')) 
                    || !empty(pagesetting('paragraph')) 
                    || !empty(pagesetting('list_data'))
                    || !empty(pagesetting('discover_more_btn_text'))
                    || !empty(pagesetting('discover_more_btn_url')))
                    <div class="col-12 col-lg-6">
                        <div class="am-tutor-vision">
                            <div class="am-content_box am-left-text">
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
                                @if(!empty(pagesetting('paragraph'))) <p>{!!pagesetting('paragraph') !!}</p> @endif
                                @if(!empty( pagesetting('list_data')))
                                    <ul>
                                        @foreach(pagesetting('list_data') as $data)
                                            @if(!empty($data['item_heading']) || !empty($data['list_item'])) 
                                                <li>
                                                    <span>
                                                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none">
                                                            <path d="M7.5 0.5L9.52568 5.97432L15 8L9.52568 10.0257L7.5 15.5L5.47432 10.0257L0 8L5.47432 5.97432L7.5 0.5Z" fill="#F55C2B"/>
                                                        </svg>
                                                    </span>
                                                    @if(!empty($data['item_heading']) || !empty($data['list_item'])) 
                                                        <div class="am-content_list">
                                                            <h6>{!! $data['item_heading'] !!}</h6>
                                                            <p>{!! $data['list_item'] !!}</p>
                                                        </div>
                                                    @endif
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                @if(!empty(pagesetting('discover_more_btn_text')) || !empty(pagesetting('discover_more_btn_url')))
                                    <a href="{{ setting('_lernen.allow_register') !== 'no' ? pagesetting('discover_more_btn_url') : '#' }}" class="am-marketplace_content_list_btn am-btn">
                                        {{pagesetting('discover_more_btn_text') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
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
                visionVideoJs();
            }, 500);
        }); 

        document.addEventListener('loadSectionJs', (event) => {
            if(event.detail.sectionId === 'vision'){
                visionVideoJs();
            }
        }); 

        function visionVideoJs(){
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