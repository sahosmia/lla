<div class="am-userinfomore">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfomore_wrap">
                    <div class="nav nav-tabs am-userinfomore_tab" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-education-tab" data-bs-toggle="tab" data-bs-target="#nav-aducation" type="button" role="tab" aria-controls="nav-aducation" aria-selected="true">{{ __('tutor.education') }}</button>
                        <button class="nav-link" id="nav-experience-tab" data-bs-toggle="tab" data-bs-target="#nav-experience" type="button" role="tab" aria-controls="nav-experience" aria-selected="false">{{ __('tutor.experience') }}</button>
                        <button class="nav-link" id="nav-certification-tab" data-bs-toggle="tab" data-bs-target="#nav-certification" type="button" role="tab" aria-controls="nav-certification" aria-selected="false">{{ __('tutor.certification_awards') }}</button>
                    </div>
                    <div class="tab-content am-userinfomore_content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-aducation" role="tabpanel" aria-labelledby="nav-education-tab">
                            <div class="am-userinfomore_title">
                                <h3>{{ __('tutor.education') }}</h3>
                            </div>
                            @if ($educations->count() > 0)
                                <div class="am-userinfomore_cards">
                                    @foreach ($educations as $key => $education)
                                        <div class="am-userinfomore_card" wire:key="{{ $key.'-'.time() }}" id="education-{{ $key }}">
                                            <span>
                                                {{ date('Y', strtotime($education->start_date)) }} - {{ $education->ongoing ? __('general.current') : date('Y', strtotime($education->end_date)) }}
                                            </span>
                                            <div class="am-userinfomore_card_info">
                                                <h4>{{  $education->course_title  }}</h4>
                                                <ul>
                                                    <li><i class="am-icon-book-1"></i>{{ $education->institute_name }}</li>

                                                    <li><i class="am-icon-location"></i>{{ ucfirst($education->city) }}, {{ ucfirst($education?->country?->name) }}</li>
                                                </ul>
                                                @if(!empty($education->description))
                                                    <div class="am-toggle-text">
                                                        <div class="am-addmore">
                                                            @php
                                                                $fullDescription  = strip_tags($education->description);
                                                                $shortDescription = Str::limit($fullDescription, 100, preserveWords: true);
                                                            @endphp
                                                            @if (Str::length($fullDescription) > 100)
                                                                <div class="short-description">
                                                                    {!! $shortDescription !!}
                                                                    <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_more') }}</a>
                                                                </div>
                                                                <div class="full-description d-none">
                                                                    {!! $fullDescription !!}
                                                                    <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_less') }}</a>
                                                                </div>
                                                            @else
                                                                <div class="full-description">
                                                                    {!! $fullDescription !!}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                @include('livewire.components.no-record')
                            @endif

                        </div>
                        <div class="tab-pane fade" id="nav-experience" role="tabpanel" aria-labelledby="nav-experience-tab">
                            <div class="am-userinfomore_title">
                                <h3>{{ __('tutor.experience') }}</h3>
                            </div>
                            @if ($experiences->count() > 0)
                            <div class="am-userinfomore_cards">
                                @foreach ($experiences as $key => $experience)
                                    <div class="am-userinfomore_card" wire:key="{{ $key.'-'.time() }}" id="experience-{{ $key }}">
                                        <span>{{ date('Y', strtotime($experience->start_date)) }} - {{ $experience->is_current ? __('general.current') : date('Y', strtotime($experience->end_date)) }}</span>
                                        <div class="am-userinfomore_card_info">
                                            <h4>{{ $experience->title }}</h4>
                                            <ul>
                                            <li><i class="am-icon-book-1"></i>{{ $experience->company }}</li>
                                                <li><i class="am-icon-briefcase-02"></i> {{ $employmentTypes[$experience->employment_type] }}</li>
                                                <li>
                                                    <i class="am-icon-location"></i>
                                                    @if($experience->location == 'onsite')
                                                        {{ ucfirst($experience?->country?->name) }}, {{ ucfirst($experience->city) }}
                                                    @else
                                                        {{ ucfirst($experience->location) }}
                                                    @endif
                                                </li>
                                            </ul>
                                            @if(!empty($education->description))
                                                <div class="am-toggle-text">
                                                    <div class="am-addmore">
                                                        @php
                                                            $fullDescription  = strip_tags($experience->description);
                                                            $shortDescription = Str::limit($fullDescription, 100, preserveWords: true);
                                                        @endphp
                                                        @if (Str::length($fullDescription) > 100)
                                                            <div class="short-description">
                                                                {!! $shortDescription !!}
                                                                <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_more') }}</a>
                                                            </div>
                                                            <div class="full-description d-none">
                                                                {!! $fullDescription !!}
                                                                <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_less') }}</a>
                                                            </div>
                                                        @else
                                                            <div class="full-description">
                                                                {!! $fullDescription !!}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @else
                                @include('livewire.components.no-record')
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-certification" role="tabpanel" aria-labelledby="nav-certification-tab">
                            <div class="am-userinfomore_title">
                                <h3>{{ __('tutor.certification_awards') }}</h3>
                            </div>
                            @if ($certificates->count() > 0)
                            <div class="am-userinfomore_cards">
                                @foreach ($certificates as $key => $certificate)
                                <div class="am-userinfomore_card" wire:key="{{ $key.'-'.time() }}" id="certificate-{{ $key }}">
                                    @if(!empty($certificate->image))
                                        <figure class="am-userinfomore_card_img">
                                            <img src="{{ url(Storage::url($certificate->image)) }}" alt="image">
                                        </figure>
                                    @endif
                                    <div class="am-userinfomore_card_info">
                                        <h4>{{ $certificate->title }}</h4>
                                        <ul>
                                            <li><i class="am-icon-book-1"></i>{{ $certificate->institute_name}}</li>
                                            <li><i class="am-icon-calender-duration"></i>{{ date('M d, Y', strtotime($certificate->issue_date)) }}</li>
                                        </ul>
                                        @if(!empty($education->description))
                                            <div class="am-toggle-text">
                                                <div class="am-addmore">
                                                    @php
                                                        $fullDescription  = strip_tags($certificate->description);
                                                        $shortDescription = Str::limit($fullDescription, 100, preserveWords: true);
                                                    @endphp
                                                    @if (Str::length($fullDescription) > 100)
                                                        <div class="short-description">
                                                            {!! $shortDescription !!}
                                                            <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_more') }}</a>
                                                        </div>
                                                        <div class="full-description d-none">
                                                            {!! $fullDescription !!}
                                                            <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_less') }}</a>
                                                        </div>
                                                    @else
                                                        <div class="full-description">
                                                            {!! $fullDescription !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            @include('livewire.components.no-record')
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
