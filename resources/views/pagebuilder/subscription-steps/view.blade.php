@if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions'))
    <div class="am-marketplace am-how-itwork">
        @if(!empty(pagesetting('shape_img')))
            @if(!empty(pagesetting('shape_img')[0]['path']))
                <img class="am-shap-image" src="{{url(Storage::url(pagesetting('shape_img')[0]['path']))}}" alt="shap image">
            @endif
        @endif
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')) || !empty(pagesetting('btn_txt')))
                        <div class="am-explore-tutor">
                            @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                                <div class="am-steps_content_unlock">
                                    @if(!empty(pagesetting('pre_heading')))
                                        <span>
                                            {!! pagesetting('pre_heading') !!}
                                        </span>
                                    @endif
                                    @if(!empty(pagesetting('heading')))
                                        <h3>
                                            {!! pagesetting('heading') !!}
                                        </h3>
                                    @endif
                                    @if(!empty(pagesetting('paragraph')))
                                        <p>
                                            {!! pagesetting('paragraph') !!}
                                        </p>
                                    @endif
                                </div>
                            @endif
                            @if(!empty(pagesetting('btn_txt')) || !empty(pagesetting('btn_url')))
                                <a class="am-btn" href="{{ setting('_lernen.allow_register') !== 'no' ? pagesetting('btn_url') : '#' }}">
                                    {{ pagesetting('btn_txt') }}
                                </a>
                            @endif
                        </div>
                    @endif
                    @if(!empty(pagesetting('steps_data')))
                        <div class="am-how-itwork-content row">
                            @foreach(pagesetting('steps_data') as $step)
                                <div class="col-12 col-lg-4 col-md-6 mb-4">
                                    <div class="am-steps_content_start_info">
                                        @if(!empty($step['sub_heading']))
                                            <span>{{ $step['sub_heading'] }}</span>
                                        @endif
                                        @if(!empty($step['step_image']))
                                            <figure>
                                                <img src="{{ url(Storage::url($step['step_image'][0]['path'])) }}" alt="image">
                                            </figure>
                                        @endif
                                        @if(!empty($step['step_heading']))
                                            <div class="am-steps_content_start_info_redirect">
                                                @if(!empty($step['step_heading']))
                                                    <h3>{{ $step['step_heading'] }}</h3>
                                                @endif
                                                @if(!empty($step['step_paragraph']))
                                                    <p>{{ $step['step_paragraph'] }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
@pushOnce('styles')
    <link rel="stylesheet" href="{{ asset('modules/subscriptions/css/main.css') }}">
@endpushOnce