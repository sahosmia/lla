<section class="am-faqs_section"> 
    <div class="am-page-title-wrap">
        <div class="am-themetabwrap">
            <div class="container">
                @if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('tutor_btn_txt')))
                    <ul class="nav nav-pills am-faqs-tabs" id="pills-tab" role="tablist">
                        @if(!empty(pagesetting('student_btn_txt')))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"> 
                                    <i class="am-icon-book-1"></i>{{ pagesetting('student_btn_txt') }}
                                </button>
                            </li>
                        @endif
                        @if(!empty(pagesetting('tutor_btn_txt')))
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> 
                                <i class="am-icon-user-check"></i>{{ pagesetting('tutor_btn_txt') }}
                            </button>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="am-faqs_section_contant">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!empty(pagesetting('students_faqs_data')) || !empty(pagesetting('tutors_faqs_data')))
                        <div class="am-faq">
                            <div class="am-faq-page">
                                @if(empty(pagesetting('students_faqs_data')) || !empty(pagesetting('tutors_faqs_data')))
                                    <div class="am-faqs-tabs-detail">
                                        @if(!empty(pagesetting('students_faqs_data')) || !empty(pagesetting('tutors_faqs_data')))
                                            <div class="tab-content am-faqtab-content" id="pills-tabContent">
                                                @if(!empty(pagesetting('students_faqs_data')))    
                                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                            @foreach(pagesetting('students_faqs_data') as $key => $faq)
                                                               @if(!empty($faq['question']) || !empty($faq['answer']))
                                                                    <div class="accordion-item">
                                                                        @if(!empty($faq['question']))
                                                                            <h2 class="accordion-header" id="flush-headingOne{{ $key }}">
                                                                                <span><i class="am-icon-file-02"></i></span>
                                                                                <button class="accordion-button collapsed {{ $loop->first ? 'show' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $key }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="flush-collapseOne{{ $key }}">
                                                                                    {!! $faq['question'] !!}
                                                                                </button>
                                                                            </h2>
                                                                        @endif
                                                                        @if(!empty($faq['answer']))
                                                                            <div id="flush-collapseOne{{ $key }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="flush-headingOne{{ $key }}" data-bs-parent="#accordionFlushExample">
                                                                                <div class="accordion-body">{!! $faq['answer'] !!}</div>
                                                                            </div>
                                                                        @endif
                                                                    </div>           
                                                               @endif   
                                                            @endforeach  
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(!empty(pagesetting('tutors_faqs_data'))) 
                                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                                        <div class="accordion accordion-flush" id="accordionFlushExamplev2">
                                                            @foreach(pagesetting('tutors_faqs_data') as $key => $faq)
                                                                @if(!empty($faq['question']) || !empty($faq['answer']))
                                                                    <div class="accordion-item">
                                                                        @if(!empty($faq['question']))
                                                                            <h2 class="accordion-header" id="flush-headingOne{{ $key }}">
                                                                                <span><i class="am-icon-file-02"></i></span>
                                                                                <button class="accordion-button collapsed {{ $loop->first ? 'show' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne{{ $key }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="flush-collapseOne">
                                                                                    {!! $faq['question'] !!}
                                                                                </button>
                                                                            </h2>
                                                                        @endif
                                                                        @if(!empty($faq['answer']))
                                                                            <div id="flush-collapseOne{{ $key }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="flush-headingOne{{ $key }}" data-bs-parent="#accordionFlushExample">
                                                                                <div class="accordion-body">{!! $faq['answer'] !!}</div>
                                                                            </div>
                                                                        @endif
                                                                    </div>     
                                                                @endif                    
                                                            @endforeach  
                                                        </div>
                                                    </div>
                                                @endif 
                                            </div>       
                                        @endif                         
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>  
</section>

