@if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions'))
    <div class="am-subscription">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-subscription_content">
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
                        <livewire:subscriptions :role="pagesetting('subscriptions_for')" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@pushOnce('styles')
    <link rel="stylesheet" href="{{ asset('modules/subscriptions/css/main.css') }}">
@endpushOnce