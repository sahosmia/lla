<div>
@if($courses->isNotEmpty())
    <div class="am-testimonial-section">
        <div class="splide" id="courses-slider">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach ($courses as $course)
                        @if($sectionVerient == 'am-courses-block-two')
                            <li class="splide__slide">
                                <div class="cr-card">
                                    <figure class="cr-image-wrapper">
                                        <img height="200" width="360" src="{{ Storage::url($course?->thumbnail?->path) }}" alt="{{ $course?->title }}" class="cr-background-image">
                                        <figcaption>
                                            <span>{{ $course?->category?->name }}</span>
                                        </figcaption>
                                    </figure>
                                    <div class="cr-course-card">
                                        <div class="cr-course-header">
                                            <h2 class="cr-course-title">
                                                <a href="{{ route('courses.course-detail', ['slug' => $course?->slug]) }}">{{ html_entity_decode($course?->title) }}</a>
                                            </h2>
                                        </div>
                                        <div class="cr-instructor-details">
                                            <a href="{{ route('tutor-detail',['slug' => $course?->instructor?->profile?->slug]) }}" target="_blank" class="cr-instructor-name">
                                                <img src="{{ Storage::url($course?->instructor?->profile?->image) }}" alt="{{ $course?->instructor?->profile?->short_name }}" class="cr-instructor-avatar" />
                                                {{ $course?->instructor?->profile?->full_name }}
                                            </a>
                                        </div>
                                        <div class="cr-card_footer">
                                            <div class="cr-course-features">
                                                <div class="cr-info-item">
                                                    <span><em>{{ $course?->curriculums?->count() }}</em> {{ __('general.lessons') }}</span>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-globe"></i>
                                                    <span>{{ $course?->language?->name }}</span>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-time"></i>
                                                    @if (!empty($course?->content_length))
                                                        @if($course?->content_length > 0)
                                                            <em>
                                                                {{ getCourseDurationWithoutSecond($course?->content_length) }}
                                                            </em>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="cr-price-wrap">
                                                <div class="cr-price-info">
                                                    @if ($course?->pricing?->price != $course?->pricing?->final_price)
                                                        <span class="cr-original-price">
                                                            {!! formatAmount($course?->pricing?->price) !!}
                                                            <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                                <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                                <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                            </svg>
                                                        </span>
                                                    @endif
                                                    <div class="cr-discounted-price">
                                                        <span class="cr-price-amount">{!! formatAmount($course?->pricing?->final_price, true) !!}</span>
                                                    </div>
                                                </div> 
                                                <a href="{{ route('login') }}" class="am-btn">{{ __('general.enrole') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @elseif($sectionVerient == 'am-courses-block-three')
                            <li class="splide__slide">
                                <div class="cr-card">
                                    <figure class="cr-image-wrapper">
                                        <img height="200" width="360" src="{{ Storage::url($course?->thumbnail?->path) }}" alt="{{ $course?->title }}" class="cr-background-image">
                                    </figure>
                                    <div class="cr-course-card">
                                        <img src="{{ Storage::url($course?->instructor?->profile?->image) }}" alt="{{ $course?->instructor?->profile?->full_name }}" class="cr-instructor-avatar" />
                                        <div class="cr-user-detail">
                                            <a href="{{ route('tutor-detail',['slug' => $course?->instructor?->profile?->slug]) }}" target="_blank">
                                                <h4>{{ $course?->instructor?->profile?->full_name }}</h4>
                                            </a>
                                            <span>{{ __('courses::courses.author') }}</span>
                                            <div class="cr-price-info">
                                                @if ($course?->pricing?->price != $course?->pricing?->final_price)
                                                    <span class="cr-original-price">
                                                        {!! formatAmount($course?->pricing?->price, true) !!}
                                                        <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                            <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                            <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                        </svg>
                                                    </span>
                                                @endif
                                                <div class="cr-discounted-price">
                                                    <span class="cr-price-amount">{!! formatAmount($course?->pricing?->final_price, true) !!}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cr-course-header">
                                            <h2 class="cr-course-title">
                                                <a href="{{ route('courses.course-detail', ['slug' => $course?->slug]) }}">{{ html_entity_decode($course?->title) }}</a>
                                            </h2>
                                            <div class="cr-course-category">
                                                {{ __('general.in') }} <a href="{{ route('courses.search-courses', ['searchCategories' => [0 => $course?->category?->id]]) }}" class="cr-category-link">{{ $course?->category?->name }}</a>
                                            </div>
                                        </div>
                                        <div class="cr-card_footer">
                                            <div class="cr-course-features">
                                                <div class="cr-info-item">
                                                    <i class="am-icon-time"></i>
                                                    <span>{{ __('courses::courses.duration') }}</span>
                                                    @if (!empty($course?->content_length))
                                                        @if($course?->content_length > 0)
                                                            <em>
                                                                {{ getCourseDurationWithoutSecond($course?->content_length) }}
                                                            </em>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-book-1"></i>
                                                    <span>{{ __('general.lessons') }}</span>
                                                    <em>{{ $course?->curriculums?->count() }}</em>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-bar-chart-04"></i>
                                                    <span>{{ __('courses::courses.level') }}</span>
                                                    <em>{{ __('courses::courses.'. $course->level) }}</em>
                                                </div>
                                                <div class="cr-info-item">
                                                    <i class="am-icon-globe"></i>
                                                    <span>{{ __('courses::courses.language') }}</span>
                                                    <em>{{ $course?->language?->name }}</em>
                                                </div>
                                            </div>
                                            <div class="cr-price-wrap">
                                                <a href="{{ route('login') }}" class="am-btn">{{ __('general.enrole') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="splide__slide">
                                <div class="cr-card">
                                    <div class="cr-instructor-info">
                                        <div class="cr-instructor-details">
                                            <a href="{{ route('tutor-detail',['slug' => $course?->instructor?->profile?->slug]) }}" target="_blank" class="cr-instructor-name">
                                                <img src="{{ Storage::url($course?->instructor?->profile?->image) }}" alt="{{ $course?->instructor?->profile?->short_name }}" class="cr-instructor-avatar" />
                                                {{ $course?->instructor?->profile?->short_name }}
                                            </a>
                                        </div>
                                        @guest
                                            <button onclick="window.location.href='{{ route('login') }}'" class="cr-bookmark-button" aria-label="{{ __('courses::courses.like_this_course') }}">
                                                <i class="am-icon-heart-filled-1"></i>
                                            </button>
                                        @endguest
                                        @if(Auth::check() && Auth()->user()->role == 'student')
                                            <button wire:click="likeCourse({{ $course->id }})" 
                                                @class(['cr-bookmark-button','cr-likedcard' => auth()->check() && collect($course->like_user_ids)->contains(auth()->id())]) 
                                                aria-label="{{ __('courses::courses.like_this_course') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="{{auth()->check() && collect($course->like_user_ids)->contains(auth()->id()) ? '#F63C3C' : 'none' }}">
                                                    <g opacity="1">
                                                        <path opacity="1" d="M7.9987 14C8.66536 14 14.6654 10.6668 14.6654 6.00029C14.6654 3.66704 12.6654 2.02937 10.6654 2.00043C9.66537 1.98596 8.66536 2.33377 7.9987 3.33373C7.33203 2.33377 6.31473 2.00043 5.33203 2.00043C3.33203 2.00043 1.33203 3.66704 1.33203 6.00029C1.33203 10.6668 7.33204 14 7.9987 14Z" stroke="#F63C3C" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    </g>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    <figure class="cr-image-wrapper">
                                        <img height="200" width="360" src="{{ Storage::url($course?->thumbnail?->path) }}" alt="{{ $course?->title }}" class="cr-background-image">
                                        <figcaption>
                                            <i class="am-icon-book-1"></i>
                                            <span>{{ $course?->curriculums?->count() }} {{ __('general.lessons') }}</span>
                                        </figcaption>
                                    </figure>
                                    <div class="cr-course-card">
                                        <div class="cr-course-header">
                                            <div class="cr-course-category">
                                                {{ __('general.in') }} <a href="{{ route('courses.search-courses', ['searchCategories' => [0 => $course?->category?->id]]) }}" class="cr-category-link">{{ $course?->category?->name }}</a>
                                            </div>
                                            <h2 class="cr-course-title">
                                                <a href="{{ route('courses.course-detail', ['slug' => $course->slug]) }}">{{ html_entity_decode($course->title) }}</a>
                                            </h2>
                                        </div>
                                        <div class="cr-course-features">
                                            <div class="cr-info-item">
                                                <i class="am-icon-bar-chart-04"></i>
                                                <span>{{ __('courses::courses.level') }}</span>
                                                <em>{{ __('courses::courses.'. $course->level) }}</em>
                                            </div>
                                            <div class="cr-info-item">
                                                <i class="am-icon-globe"></i>
                                                <span>{{ __('courses::courses.language') }}</span>
                                                <em>{{ $course?->language?->name }}</em>
                                            </div>
                                            <div class="cr-info-item">
                                                <i class="am-icon-time"></i>
                                                <span>{{ __('courses::courses.duration') }}</span>
                                                @if (!empty($course?->content_length))
                                                    @if($course?->content_length > 0)
                                                        <em>
                                                            {{ getCourseDurationWithoutSecond($course?->content_length) }}
                                                        </em>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="cr-card_footer">
                                            <div class="cr-price-info">
                                                @if ($course?->pricing?->price != $course?->pricing?->final_price)
                                                    <span class="cr-original-price">
                                                        {!! formatAmount($course?->pricing?->price, true) !!}
                                                        <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                            <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                            <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                        </svg>
                                                    </span>
                                                @endif
                                                <div class="cr-discounted-price">
                                                    <span class="cr-price-amount">{!! formatAmount($course?->pricing?->final_price, true) !!}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('login') }}" class="am-btn">{{ __('general.enrole') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
</div>
@pushOnce('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('#courses-slider')) {
                setTimeout(function() {
                    initCoursesSlider();
                }, 50);
            }
        });

        document.addEventListener('loadSectionJs', function (event) {
            if (event.detail.sectionId === 'courses') {
                if (document.querySelector('#courses-slider')) {
                    initCoursesSlider();
                }
            }
        });

        function initCoursesSlider() {
            new Splide('#courses-slider', {
                gap: '16px',
                perPage: 4,
                perMove: 1,
                focus: 1,
                pagination: true,
                type: 'loop',
                direction: document.documentElement.dir === 'rtl' ? 'rtl' : 'ltr', 
                breakpoints: {
                    1399: {
                        perPage: 3,
                    },
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
@endPushOnce