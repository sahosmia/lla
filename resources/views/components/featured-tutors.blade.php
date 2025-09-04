<div id="am-handpick-tutor" class="am-handpick-tutor splide">
    <div class="splide__track">
        <ul class="splide__list">
            @foreach ($featuredTutors as $singleTutor)
                @if($singleTutor?->profile?->verified_at !== null)
                    <li class="splide__slide">
                        <div class="am-tutor-feature">
                            @if(!empty($singleTutor?->profile?->intro_video) && Storage::disk(getStorageDisk())->exists($singleTutor?->profile?->intro_video))
                                <video class="video-js" src="{{ url(Storage::url($singleTutor?->profile?->intro_video)) }}" controls></video>
                            @endif 
                            <div class="am-tutorsearch_user">
                                <figure class="am-tutorvone_img">
                                    @if($singleTutor?->profile?->image)
                                        <img src="{{ url(Storage::url($singleTutor?->profile?->image)) }}" alt="profile image">
                                    @else
                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="profile image" />
                                    @endif
                                    <span class="am-userstaus am-userstaus_online"></span>
                                </figure>
                                <div class="am-tutorsearch_user_name">
                                    <h3>
                                        <a href="{{ route('tutor-detail',['slug' => $singleTutor?->profile?->slug]) }}">
                                            {{ $singleTutor?->profile?->first_name }} {{ $singleTutor?->profile?->last_name }}
                                        </a>
                                        @if($singleTutor?->profile?->verified_at)
                                        <x-frontend.verified-tooltip />
                                        @endif
                                        @if ($singleTutor?->address?->country?->short_code)
                                            <span class="flag flag-{{ strtolower($singleTutor?->address?->country?->short_code) }}"></span>
                                        @endif
                                    </h3>
                                    <span>
                                        @foreach ($singleTutor->educations as $singleEducation)
                                            {{ $singleEducation?->course_title }}
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                            <ul class="am-tutorsearch_info">
                                @if(isPaidSystem())
                                    <li>
                                        <span class="am-currency_conversion">{!! formatAmount($singleTutor->min_price) !!}<em>{{ __('app.hr') }}</em></span>
                                    </li>
                                @endif
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                                    <span>{{ number_format($singleTutor->avg_rating, 1) }}<em>/5.0 ({{ $singleTutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $singleTutor->total_reviews] ) }})</em></span>

                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                    <span>{{ $singleTutor->active_students }} <em>{{ __('general.active_students') }}</em></span>
                                </li>
                            </ul>
                            <a href="{{ route('tutor-detail', ['slug' => $singleTutor?->profile?->slug]) }}" class="am-white-btn">{{ __('general.profile') }}</a>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

@push('styles')
    @vite(['public/css/flags.css'])
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', (event)=>{
        initFeaturedTutorsSlider();
    });

    document.addEventListener('loadSectionJs', (event)=>{
        if(event.detail.sectionId === 'featured-tutors'){
            setTimeout(()=>{
                initFeaturedTutorsSlider();
            }, 500);
        }
    });

    function initFeaturedTutorsSlider(){
            new Splide('.am-handpick-tutor' , {
                autoWidth: true,
                    perMove: 1,
                pagination: false,
                breakpoints: {
                    1024: {
                        perPage: 2,
                    },
                    768: {
                        perPage: 1,
                    },
                },
            }).mount();
        }
</script>
@endpush
