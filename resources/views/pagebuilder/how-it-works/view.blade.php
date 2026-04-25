
<section class="am-works"> 
    <div class="am-page-title-wrap">
        <div class="am-themetabwrap">
            <div class="container">
                @if(!empty(pagesetting('student_btn_txt')) || !empty(pagesetting('tutor_btn_txt')))
                    <ul class="nav nav-pills am-faqs-tabs" id="pills-tab" role="tablist">
                        @if(!empty(pagesetting('student_btn_txt')))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"> <i class="am-icon-book-1"></i>{{ pagesetting('student_btn_txt') }}</button>
                            </li>
                        @endif
                        @if(!empty(pagesetting('tutor_btn_txt')))
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"> <i class="am-icon-user-check"></i>{{ pagesetting('tutor_btn_txt') }}</button>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="am-works_contant">
        <div class="container">
            <div class="row">
                @if(!empty(pagesetting('pre_heading')) 
                    || !empty(pagesetting('heading'))       
                    || !empty(pagesetting('paragraph'))
                    || !empty(pagesetting('student_btn_txt'))
                    || !empty(pagesetting('tutor_btn_txt'))
                    || !empty(pagesetting('student_repeater'))
                    || !empty(pagesetting('tutor_repeater')))
                    <div class="am-faqs-tabs-detail am-how-it-works-detail">
                        @if(!empty(pagesetting('student_repeater')) || !empty(pagesetting('tutor_repeater')))
                            <div class="tab-content am-faqtab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    @if(!empty(pagesetting('student_repeater')))
                                        @foreach(pagesetting('student_repeater') as $key => $option)
                                            @if($loop->odd)
                                                <div class="am-works_info">
                                                    <div>
                                                        @if(!empty($option['std_btn_icon']))
                                                            <span class="am-works_info_tag">
                                                                <i class="{!! $option['std_btn_icon'] !!}"></i>
                                                            </span>
                                                        @endif
                                                        <div class="am-works_info_description">
                                                            @if(!empty($option['student_sub_heading'])) 
                                                                @if ($option['student_sub_heading'] == 'Sign Up')
                                                                    <span><a href="{{ setting('_lernen.allow_register') !== 'no' ? 'register' : '#' }}">{{ $option['student_sub_heading'] }}</a></span> 
                                                                @else
                                                                    <span>{{ $option['student_sub_heading'] }}</span> 
                                                                @endif
                                                            @endif
                                                            @if(!empty($option['student_heading'])) <h3>{!! $option['student_heading'] !!}</h3> @endif
                                                            @if(!empty($option['student_paragraph'])) {!! $option['student_paragraph'] !!} @endif
                                                        </div>
                                                    </div>
                                                    <div class="am-works_info_user">
                                                        @if(!empty($option['student_image']))
                                                            @if(!empty($option['student_image'][0]['path']))
                                                                <figure><img src="{{url(Storage::url($option['student_image'][0]['path']))}}" alt="Student image"></figure>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="am-works_info">
                                                    <div class="am-works_info_user">
                                                        @if(!empty($option['student_image']))
                                                            @if(!empty($option['student_image'][0]['path']))
                                                                <figure><img src="{{url(Storage::url($option['student_image'][0]['path']))}}" alt="Tutor image"></figure>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if(!empty($option['std_btn_icon']))
                                                            <span class="am-works_info_tag">
                                                                <i class="{!! $option['std_btn_icon'] !!}"></i>
                                                            </span>
                                                        @endif
                                                        <div class="am-works_info_description">
                                                            @if(!empty($option['student_sub_heading'])) 
                                                                @if ($option['student_sub_heading'] == 'Find a Tutor')
                                                                    <span><a href="find-tutors">{{ $option['student_sub_heading'] }}</a></span> 
                                                                @else
                                                                    <span>{{ $option['student_sub_heading'] }}</span> 
                                                                @endif
                                                            @endif
                                                            @if(!empty($option['student_heading'])) <h3>{!! $option['student_heading'] !!}</h3> @endif
                                                            @if(!empty($option['student_paragraph'])) {!! $option['student_paragraph'] !!} @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    @if(!empty(pagesetting('tutor_repeater')))
                                        @foreach(pagesetting('tutor_repeater') as $option)
                                            @if($loop->odd)
                                                <div class="am-works_info">
                                                    <div>
                                                        @if(!empty($option['tutor_btn_icon']))
                                                            <span class="am-works_info_tag">
                                                                <i class="{!! $option['tutor_btn_icon'] !!}"></i>
                                                            </span>
                                                        @endif
                                                        <div class="am-works_info_description">
                                                            @if(!empty($option['tutor_sub_heading'])) 
                                                                @if ($option['tutor_sub_heading'] == 'Sign Up')
                                                                    <span><a href="{{ setting('_lernen.allow_register') !== 'no' ? 'register' : '#' }}">{{ $option['tutor_sub_heading'] }}</a></span> 
                                                                @else
                                                                    <span>{{ $option['tutor_sub_heading'] }}</span> 
                                                                @endif
                                                            @endif
                                                            @if(!empty($option['tutor_heading'])) <h3>{!! $option['tutor_heading'] !!}</h3> @endif
                                                            @if(!empty($option['tutor_paragraph'])) {!! $option['tutor_paragraph'] !!} @endif                                              
                                                        </div>
                                                    </div>
                                                    <div class="am-works_info_user">
                                                        @if(!empty($option['tutor_image']))
                                                            @if(!empty($option['tutor_image'][0]['path']))
                                                                <figure><img src="{{url(Storage::url($option['tutor_image'][0]['path']))}}" alt="Tutor image"></figure>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <div class="am-works_info">
                                                    <div class="am-works_info_user">
                                                        @if(!empty($option['tutor_image']))
                                                            @if(!empty($option['tutor_image'][0]['path']))
                                                                <figure><img src="{{url(Storage::url($option['tutor_image'][0]['path']))}}" alt="Tutor image"></figure>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div>
                                                        @if(!empty($option['tutor_btn_icon']))
                                                            <span class="am-works_info_tag">
                                                                <i class="{!! $option['tutor_btn_icon'] !!}"></i>
                                                            </span>
                                                        @endif
                                                        <div class="am-works_info_description">
                                                            @if(!empty($option['tutor_sub_heading'])) 
                                                                @if ($option['tutor_sub_heading'] == 'Set Availability')
                                                                    <span><a href="login">{{ $option['tutor_sub_heading'] }}</a></span> 
                                                                @else
                                                                    <span>{{ $option['tutor_sub_heading'] }}</span> 
                                                                @endif
                                                            @endif
                                                            @if(!empty($option['tutor_heading'])) <h3>{!! $option['tutor_heading'] !!}</h3> @endif
                                                            @if(!empty($option['tutor_paragraph'])) {!! $option['tutor_paragraph'] !!} @endif   
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>  
                        @endif                              
                    </div>    
                @endif
            </div>
        </div>
    </div>
</section>
