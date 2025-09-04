@if(\Nwidart\Modules\Facades\Module::has('Subscriptions') && \Nwidart\Modules\Facades\Module::isEnabled('Subscriptions'))
    <div class="am-faqs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!empty(pagesetting('sub_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                        <div class="am-steps_content_unlock">
                            @if(!empty(pagesetting('sub_heading')))
                                <span>{!! pagesetting('sub_heading') !!}</span>
                            @endif
                            @if(!empty(pagesetting('heading')))
                                <h3>{!! pagesetting('heading') !!}</h3>
                            @endif
                            @if(!empty(pagesetting('paragraph')))
                                <p>{!! pagesetting('paragraph') !!}</p>
                            @endif
                        </div>
                    @endif
                    @if(!empty(pagesetting('faqs_data')))
                        <div class="am-faq-page">
                            <div class="am-faqtab-content">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    @foreach(array_values(pagesetting('faqs_data')) as $index => $faq)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-heading-{{ $index }}">
                                                <span>
                                                    @if($index == 0)
                                                        <i class="am-icon-file-02"></i>
                                                    @elseif($index == 1)
                                                        <i class="am-icon-book-1"></i>
                                                    @elseif($index == 2)
                                                        <i class="am-icon-lock-close"></i>
                                                    @elseif($index == 3)
                                                        <i class="am-icon-user-01"></i>
                                                    @elseif($index == 4)
                                                        <i class="am-icon-list-02"></i>
                                                    @endif
                                                </span>
                                                @if(!empty($faq['question']))
                                                    <button class="accordion-button collapsed {{ $loop->first ? '' : '' }}" 
                                                            type="button" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#flush-collapse-{{ $index }}" 
                                                            aria-expanded="false" 
                                                            aria-controls="flush-collapse-{{ $index }}">
                                                        {!! $faq['question'] !!}
                                                    </button>
                                                @endif
                                            </h2>
                                            @if(!empty($faq['answer']))
                                                <div id="flush-collapse-{{ $index }}" 
                                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                                    aria-labelledby="flush-heading-{{ $index }}" 
                                                    data-bs-parent="#accordionFlushExample">
                                                    <div class="accordion-body">
                                                        {!! $faq['answer'] !!}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>     
                            </div>
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