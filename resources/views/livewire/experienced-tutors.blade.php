<div>
    @if($slider == false)
        <ul class="am-experience-tutor-list">
        @foreach ($experiencedTutors->take($selectTutor) as $singleTutor)
            <li data-aos="fade-up" data-aos-easing="ease" data-aos-delay="{{ $loop->iteration * 200 }}">
                <div class="am-experience-tutor-card">
                    <div class="am-experience-tutor-img">
                        @if ($sectionVerient == 'am-tutors-varient-two')
                            @if ($singleTutor->profile->image)
                                <img src="{{ url(Storage::url($singleTutor->profile->image)) }}" alt="Profile image">
                            @endif
                        @else
                            @if ($singleTutor->profile->image)
                                <img src="{{ url(Storage::url($singleTutor->profile->image)) }}" alt="Profile image">
                            @endif
                            @guest
                                <span>
                                    <i class="am-icon-heart-01" onclick="window.location.href='{{ route('login') }}'"></i>
                                </span>
                            @endguest
                            @if(Auth::check() && Auth()->user()->role == 'student')
                                <span class="{{ in_array($singleTutor->profile->id, $favouriteTutors) ? 'active' : '' }}">
                                    <i class="am-icon-heart-01" wire:click="favouriteTutor({{ $singleTutor->profile->id }})"></i>
                                </span>
                            @endif
                        @endif
                    </div>
                    @if($sectionVerient == 'am-tutors-varient-two')
                        <div class="am-experience-tutor-info"> 
                            <div class="am-experience-tutor-name">
                                <div class="am-tutorsearch_user_name">
                                    <h3>
                                        <a href="{{ route('tutor-detail',['slug' => $singleTutor->profile->slug]) }}">
                                            {{ $singleTutor->profile->first_name }} {{ $singleTutor->profile->last_name }}
                                        </a>
                                    </h3>
                                    @if($singleTutor->profile->tagline)
                                        <p>{{ $singleTutor->profile->tagline }}</p>
                                    @endif
                                    <a class="am-primary-btn" href="{{ route('tutor-detail', ['slug' => $singleTutor->profile->slug]) }}">
                                        {{ __('general.profile') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="am-experience-tutor-info">
                            <div class="am-experience-tutor-name">
                                <div class="am-tutorsearch_user_name">
                                    <h3>
                                        <a href="{{ route('tutor-detail',['slug' => $singleTutor->profile->slug]) }}">
                                            {{ $singleTutor->profile->first_name }} {{ $singleTutor->profile->last_name }}
                                        </a>
                                        @if($singleTutor->profile->verified_at)
                                            <x-frontend.verified-tooltip />
                                        @endif
                                        @if (!empty($singleTutor->address?->country?->short_code))
                                            <span class="flag flag-{{ strtolower($singleTutor->address?->country?->short_code) }}"></span>
                                        @endif
                                    </h3>
                                </div>
                            </div>
                            <ul class="am-tutorsearch_info">
                                @if(isPaidSystem())
                                    <li>
                                        <span class="am-currency_conversion">{!! formatAmount($singleTutor->min_price) !!}<em>{{ __('app.hr') }}</em></span>
                                    </li>
                                @endif
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-star-filled"></i></div>
                                    <span>{{ number_format($singleTutor->avg_rating, 1) }}<em>/5.0 ({{ $singleTutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $singleTutor->total_reviews] ) }})</em></span>
                                </li>
                                <li>
                                    <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                    <span>{{ $singleTutor->active_students }} <em>{{ __('general.active_students') }}</em></span>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
    @else
        <div class="am-featured-mentors-slider splide featured-slider" data-aos="fade-up" data-aos-easing="ease" data-aos-delay="400">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($experiencedTutors->take($selectTutor) as $singleTutor)
                        <li class="splide__slide">
                            <div class="am-experience-tutor-card">
                                @if ($singleTutor->profile->image)
                                    <figure class="am-experience-tutor-img">
                                        <img src="{{ url(Storage::url($singleTutor->profile->image)) }}" alt="Profile image" class="user-avatar" />
                                    </figure>
                                @endif
                                <div class="am-experience-tutor-info">
                                    <div class="am-experience-tutor-name">
                                        <div class="am-tutorsearch_user_name">
                                            <h3>
                                                <a href="{{ route('tutor-detail',['slug' => $singleTutor->profile->slug]) }}">
                                                    {{ $singleTutor->profile->first_name }} {{ $singleTutor->profile->last_name }}
                                                </a>
                                            </h3>
                                            @if($singleTutor->profile->tagline)
                                                <p>{{ $singleTutor->profile->tagline }}</p>
                                            @endif
                                            <a class="am-primary-btn" href="{{ route('tutor-detail', ['slug' => $singleTutor->profile->slug]) }}">
                                                {{ __('general.profile') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>

@push('styles')
    @vite(['public/css/flags.css'])
@endpush

@pushOnce('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initFeaturedMentorsSlider();
        });

        document.addEventListener('loadSectionJs', (event)=>{
            if(event.detail.sectionId === 'featured-mentors'){
                initFeaturedMentorsSlider();
            }
        });

        function initFeaturedMentorsSlider(){
            if (typeof Splide !== 'undefined') {
                const sliders = document.querySelectorAll('.featured-slider');
                sliders.forEach(slider => {
                new Splide(slider, {
                    gap: 24,
                    perPage: 4,
                    perMove: 1,
                    focus  : 1,
                    type: 'loop',
                    direction: document.documentElement.dir === 'rtl' ? 'rtl' : 'ltr',
                    pagination: false,
                    breakpoints: {
                        1024: {
                            perPage: 3,
                        },
                        768: {
                            perPage: 2,
                        },
                        576: {
                            perPage: 1,
                        },
                    },
                    }).mount();
                });
            }
        }
    </script>
@endpushOnce

