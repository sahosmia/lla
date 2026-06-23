
<section class="am-youtube-section">
    <div class="container">
        @if(!empty(pagesetting('heading')) 
            || !empty(pagesetting('description')) 
            || !empty(pagesetting('button_text'))
            || !empty(pagesetting('youtube_url')))
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="am-tutor-vision">
                        <div class="am-content_box am-left-text">
                            @if(!empty(pagesetting('heading'))) <h3>{!! pagesetting('heading') !!}</h3> @endif
                            @if(!empty(pagesetting('description'))) {!! pagesetting('description') !!} @endif
                            @if(!empty(pagesetting('button_text')))
                                <a href="{{ !empty(pagesetting('button_url')) ? pagesetting('button_url') : 'javascript:void(0);' }}" class="am-btn">
                                    {{ pagesetting('button_text') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    @php
                        $youtube_url = pagesetting('youtube_url');
                        $embed_url = '';
                        if (!empty($youtube_url)) {
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtube_url, $matches)) {
                                $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
                            }
                        }
                    @endphp
                    @if(!empty($embed_url))
                        <div class="am-youtube-video" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px;">
                            <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="{{ $embed_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                    @else
                        @if(!empty($youtube_url))
                            <div class="am-youtube-video-error">
                                <p>{{ __('Invalid YouTube URL') }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>
</section>
