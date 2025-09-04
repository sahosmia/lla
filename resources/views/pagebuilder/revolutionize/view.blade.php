<div class="am-revolutionize">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-revolutionize_wrap">
                    @if(!empty(pagesetting('video')))
                        <div class="am-revolutionize_video">
                            @if(!empty(pagesetting('video')[0]['path']))
                                <video class="video-js" data-setup='{}' preload="auto" id="vision-video" width="940" height="737" controls >
                                    <source src="{{ url(Storage::url(pagesetting('video')[0]['path'])) }}#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                                </video>
                            @endif
                        </div>
                    @endif
                    <div class="am-revolutionize_content">
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
                                @if(!empty(pagesetting('heading')))<h2>{!! pagesetting('heading') !!}</h2>@endif
                                @if(!empty(pagesetting('paragraph'))){!! pagesetting('paragraph') !!}@endif
                            </div>
                        @endif
                        @if(!empty(pagesetting('revolutionize_repeater')))
                            <div class="am-revolutionize_achivments">
                                @foreach(pagesetting('revolutionize_repeater') as $option)
                                    <div class="am-revolutionize_achivments_content">
                                        @if(!empty($option['revolu_image'][0]['path']))
                                            <figure><img src="{{url(Storage::url($option['revolu_image'][0]['path']))}}" alt="Revolutionize image"></figure>
                                        @endif
                                        @if(!empty($option['revolu_heading']))<h4>{!! $option['revolu_heading'] !!}</h4>@endif
                                        @if(!empty($option['revolu_paragraph']))<p>{!! $option['revolu_paragraph'] !!}</p>@endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(!empty(pagesetting('bg_image')))
        @if(!empty(pagesetting('bg_image')[0]['path']))
            <img src="{{url(Storage::url(pagesetting('bg_image')[0]['path']))}}" alt="Background shape image">
        @endif
    @endif
</div>
@pushOnce('styles')
@vite(['public/css/videojs.css'])
@endpushOnce
@pushOnce('scripts')
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(() => {
                revolutionizeVideoJs();
            }, 500);
        });

        document.addEventListener('loadSectionJs', (event) => {
            if(event.detail.sectionId === 'revolutionize'){
                revolutionizeVideoJs();
            }
        });
 
        function revolutionizeVideoJs(){
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