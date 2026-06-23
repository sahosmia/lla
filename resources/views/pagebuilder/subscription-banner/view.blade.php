@if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions'))
    <div class="am-learning am-subcription-banner"> 
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-learning_content">
                        <div class="am-learning_details">
                            @if(!empty(pagesetting('heading')))
                                <h1>
                                    {!! pagesetting('heading') !!}
                                </h1>
                            @endif
                            @if(!empty(pagesetting('paragraph')))
                                <p>
                                    {!! pagesetting('paragraph') !!}
                                </p>
                            @endif
                            @if(!empty(pagesetting('student_btn_url')) || !empty(pagesetting('student_btn_txt')) || !empty(pagesetting('tutor_btn_url')) || !empty(pagesetting('tutor_btn_txt')))
                                <div class="am-btns">
                                    @php
                                        $primaryBtn = pagesetting('active_banner_btn') === 'tutor' ? 'tutor' : 'student';
                                        $secondaryBtn = $primaryBtn === 'tutor' ? 'student' : 'tutor';
                                    @endphp

                                    @if(!empty(pagesetting("{$primaryBtn}_btn_txt")))
                                        <a href="{{ pagesetting("{$primaryBtn}_btn_url") ?? '#' }}" class="am-primary-btn">
                                            {{ pagesetting("{$primaryBtn}_btn_txt") }}
                                        </a>
                                    @endif

                                    @if(!empty(pagesetting("{$secondaryBtn}_btn_txt")))
                                        <a href="{{ pagesetting("{$secondaryBtn}_btn_url") ?? '#' }}" class="am-primary-btn-white">
                                            {{ pagesetting("{$secondaryBtn}_btn_txt") }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if(!empty(pagesetting('banner_image')) || !empty(pagesetting('cursor_image')))
                            <div class="am-learning_video">
                                <figure class="am-learning_video_img">
                                    @if(!empty(pagesetting('banner_image')))
                                        <img src="{{url(Storage::url(pagesetting('banner_image')[0]['path']))}}" alt="Banner image">
                                    @endif
                                    @if(!empty(pagesetting('cursor_image')))
                                        <figcaption>
                                            <img class="am-rendom-floating" src="{{ url(Storage::url(pagesetting('cursor_image')[0]['path'])) }}" alt="Cursor image">
                                        </figcaption>
                                    @endif
                                </figure>
                            </div>  
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@pushOnce('styles')
    <link rel="stylesheet" href="{{ asset('modules/subscriptions/css/main.css') }}">
@endpushOnce