@extends('layouts.frontend-app')
@section('content')
<div class="am-search-detail-banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ol class="am-breadcrumb">
                    <li><a href="{{ url('/') }}">{{ __('sidebar.home') }}</a></li>
                    <li><em>/</em></li>
                    <li><a href="{{ route('find-tutors') }}">{{  __('sidebar.find_tutor') }}</a></li>
                    <li><em>/</em></li>
                    <li class="active"><span>{{ $tutor?->profile?->full_name }}</span></li>
                </ol>
                <div class="am-searchdetail">
                    <div class="am-search-userdetail">
                        <div class="am-tutordetail_head">
                            <div class="am-tutordetail_user">
                                <figure class="am-tutorvone_img">
                                    @if (!empty($tutor?->profile?->image) &&
                                    Storage::disk(getStorageDisk())->exists($tutor?->profile?->image))
                                        <img src="{{ resizedImage($tutor?->profile?->image,80,80) }}" alt="{{$tutor?->profile?->full_name}}" />
                                    @else 
                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 80, 80) }}" alt="{{ $tutor->profile?->full_name }}" />
                                    @endif
                                    <span @class(['am-userstaus','am-userstaus_online'=> $tutor?->is_online])></span>
                                </figure>
                                <div class="am-tutordetail_user_name">
                                    <h3>
                                        {{ $tutor?->profile?->full_name }}
                                        @if($tutor?->profile?->verified_at)
                                            <x-frontend.verified-tooltip />
                                        @endif
                                        @if ($tutor?->address?->country?->short_code)
                                        <span
                                            class="flag flag-{{ strtolower($tutor?->address?->country?->short_code) }}"></span>
                                        @endif
                                    </h3>
                                    @if(!empty($tutor?->profile?->tagline))
                                        <span>{!! $tutor?->profile?->tagline !!}</span>
                                    @endif
                                </div>
                            </div>
                            @if(!empty($tutor?->profile?->intro_video) && isPaidSystem())
                                <div class="am-tutordetail_fee">
                                    <strong> {!! formatAmountV2($tutor?->min_price) !!}<em>{{__('tutor.per_session') }}</em></strong>
                                    <span>{{ __('tutor.starting_from') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="am-tutordetail-reviews">
                            <div class="am-tutordetail-reviews_wrap">
                                <ul class="am-tutorreviews-list">
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-star-01"></i>
                                            <span class="am-uniqespace">{{ number_format($tutor?->avg_rating, 1) }}<em>/5.0 ({{
                                                    $tutor?->total_reviews == 1 ? __('general.review_count') :
                                                    __('general.reviews_count', ['count' => $tutor?->total_reviews] )
                                                    }})</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-user-group"></i>
                                            <span>{{$tutor?->active_students}} <em>
                                            {{ $tutor?->active_students == '1' ? __('tutor.booked_session') :
                                            __('tutor.booked_sessions') }}</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-menu-2"></i>
                                            <span>{{$tutor?->subjects->sum('sessions')}} <em>{{ $tutor?->subjects->sum('sessions') == 1 ? __('tutor.session') : __('tutor.sessions') }}</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <i class="am-icon-watch-1"></i>
                                            <span>{{ __('tutor.time', ['time' => rand(2, 5)]) }} <em>{{
                                                    __('tutor.response_time') }}</em></span>
                                        </div>
                                    </li>
                                    @if(hasSocialProfiles($tutor?->socialProfiles))
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                    <path d="M12.8337 6.99935C12.8337 10.221 10.222 12.8327 7.00033 12.8327M12.8337 6.99935C12.8337 3.77769 10.222 1.16602 7.00033 1.16602M12.8337 6.99935C12.8337 5.71069 10.222 4.66602 7.00033 4.66602C3.77866 4.66602 1.16699 5.71069 1.16699 6.99935M12.8337 6.99935C12.8337 8.28801 10.222 9.33268 7.00033 9.33268C3.77866 9.33268 1.16699 8.28801 1.16699 6.99935M7.00033 12.8327C3.77866 12.8327 1.16699 10.221 1.16699 6.99935M7.00033 12.8327C8.28899 12.8327 9.33366 10.221 9.33366 6.99935C9.33366 3.77769 8.28899 1.16602 7.00033 1.16602M7.00033 12.8327C5.71166 12.8327 4.66699 10.221 4.66699 6.99935C4.66699 3.77769 5.71166 1.16602 7.00033 1.16602M1.16699 6.99935C1.16699 3.77769 3.77866 1.16602 7.00033 1.16602" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <span><em>{{ __('tutor.social_profiles') }}</em></span>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                                @if(hasSocialProfiles($tutor?->socialProfiles))
                                    <ul class="am-tutorsocial-list">
                                        @foreach (setting('_social.platforms') as $platform)
                                            @if(hasSocialProfile($tutor?->socialProfiles, $platform))
                                                <li>
                                                    <a href="{{ getSocialProfileUrl($tutor?->socialProfiles, $platform) }}" target="_blank">
                                                        <img src="{{ asset('demo-content/social-icons/'. Str::slug($platform). '.svg') }}" alt="{{ $platform }}" />
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <ul class="am-tutorskills-list">
                                @if($tutor?->subjects->isNotEmpty())
                                    <li>
                                        <div class="am-tutorskills-item">
                                            <i class="am-icon-book-1"></i>
                                            <span>{{ __('tutor.i_can_teach') }}</span>
                                        </div>
                                        <ul x-data="{ open: false }">
                                        
                                                @foreach ($tutor?->subjects as $index => $sub)
                                                    @if ($index < 2) 
                                                        <li><span>{!! $sub->subject?->name !!}</span></li>
                                                    @else
                                                        <li x-show="open"><span>{!! $sub->subject?->name !!}</span></li>
                                                    @endif
                                                @endforeach
                                        
                                            @if ($tutor?->subjects->count() > 2)
                                                <li>
                                                    <a href="javascript:void(0);" @click="open = !open">
                                                        <span x-show="!open">{{ __('tutor.more_item', ['count' =>
                                                            $tutor?->subjects->count() - 2]) }}</span>
                                                        <span x-show="open">{{ __('tutor.show_less') }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                                <li>
                                    <div class="am-tutorskills-item">
                                        <i class="am-icon-megaphone-01"></i>
                                        <span>{{ __('tutor.i_can_speak') }}</span>
                                    </div>
                                    <div class="wa-tags-list">
                                        <p>{{ ucfirst($tutor?->profile?->native_language) }}<span>{{ __('tutor.native')}}</span></p>
                                        <ul>
                                            @foreach ($tutor?->languages->slice(0, 3) as $index => $lan)
                                            <li><span>{{ ucfirst( $lan->name )}}</span></li>
                                            @endforeach
                                        </ul>
                                        @if($tutor?->languages?->count() > 3)
                                        <div class="am-more am-custom-tooltip">
                                            <span class="am-tooltip-text">
                                                @php
                                                $tutorLanguages = $tutor?->languages->slice(3,
                                                $tutor?->languages?->count() - 1);
                                                @endphp
                                                @if (!empty($tutorLanguages))
                                                @foreach ($tutorLanguages as $lan)
                                                <span>{{ ucfirst( $lan->name )}}</span>
                                                @endforeach
                                                @endif
                                            </span>
                                            +{{ $tutor?->languages?->count() - 3 }}
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                <li>
                                    @if(\Nwidart\Modules\Facades\Module::has('starup') && \Nwidart\Modules\Facades\Module::isEnabled('starup'))
                                        <div class="am-tutorskills-item">
                                            <i class="am-icon-shield-check"></i>
                                            <span>{{ __('tutor.achievements') }}</span>
                                        </div>
                                        @if($tutor?->badges?->count() > 0)
                                        <div class="am-tutordetail_user_badge am-user_badge">
                                            @foreach ($tutor?->badges as $badge)
                                                <div class="am-custom-tooltip">
                                                    <span class="am-tooltip-text">
                                                        <span>{{ $badge?->name }}</span>
                                                    </span>
                                                    <figure class="am-shimmer">
                                                    @if (!empty($badge?->image) &&
                                                        Storage::disk(getStorageDisk())->exists($badge?->image))
                                                        <img src="{{ resizedImage($badge?->image,80,80) }}" alt="{{$badge?->name}}" />
                                                    @else 
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 80, 80) }}" alt="{{ $tutor->profile?->full_name }}" />
                                                    @endif
                                                    </figure>
                                                </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    @endif
                                </li>
                            </ul>
                        </div>
                        @if(!empty($tutor?->profile?->intro_video))
                            <div class="am-tutordetail-btns">
                                <livewire:pages.tutor.action.action :tutor="$tutor" :isFavourite="$isFavourite" :navigate="false"
                                    :key="$tutor->id" />
                            </div>
                        @endif
                    </div>
                    @if(!empty($tutor?->profile?->intro_video))
                        <div class="am-detailuser_video am-detailuser_video_main">
                            <video class="video-js" data-setup='{}' preload="auto" wire:key="profile-video-{{ $tutor->id }}"
                                id="profile-video-{{ $tutor->id }}" width="320" height="240" controls>
                                <source
                                    src="{{ url(Storage::url($tutor?->profile?->intro_video)).'?key=short-video' }}#t=0.1"
                                    wire:key="profile-video-src-{{ $tutor->id }}" type="video/mp4">
                            </video>
                        </div>
                    @else
                        <div class="am-detailuser_novideo">
                            @if(isPaidSystem())
                                <div class="am-tutordetail_fee">
                                    <strong> {!! formatAmountV2($tutor?->min_price) !!}<em>{{__('tutor.per_session') }}</em></strong>
                                    <span>{{ __('tutor.starting_from') }}</span>
                                </div>
                            @endif
                            <livewire:pages.tutor.action.action :tutor="$tutor" :isFavourite="$isFavourite" :navigate="false"
                            :key="$tutor->id" />
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="am-aboutuser_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="am-aboutuser_tab" x-data="{tab: 'about'}">
                    <li x-bind:class="tab == 'about' ? 'active' : ''">
                        <a href="#" @click="tab='about'" class="am-tabitem">{{ __('tutor.introduction') }}</a>
                    </li>
                    <li x-bind:class="tab == 'availability' ? 'active' : ''">
                        <a href="#availability" @click="tab='availability'" class="am-tabitem">{{
                            __('tutor.availability') }}</a>
                    </li>
                    @if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && $courses->isNotEmpty())
                        <li x-bind:class="tab == 'courses' ? 'active' : ''">
                            <a @click="tab='courses'" href="#courses" class="am-tabitem">{{
                                __('courses::courses.courses') }}</a>
                        </li>
                    @endif
                    <li x-bind:class="tab == 'highlights' ? 'active' : ''">
                        <a @click="tab='highlights'" href="#resume-highlights" class="am-tabitem">{{
                            __('tutor.resume_highlights') }}</a>
                    </li>
                    <li x-bind:class="tab == 'reviews' ? 'active' : ''">
                        <a @click="tab='reviews'" href="#reviews" class="am-tabitem">{{ __('tutor.reviews') }} <span>{{
                                $tutor?->total_reviews }}</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="am-userinfo_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-userinfo_content">
                    <h3>{{ __('tutor.about_me') }}</h3>
                    <div class="am-toggle-text">
                        <div class="am-addmore">
                            @php
                                $fullDescription  = $tutor?->profile?->description;
                                $shortDescription = Str::limit(strip_tags($fullDescription), 460, preserveWords: true);
                            @endphp
                            @if (Str::length(strip_tags($fullDescription)) > 460)
                                <p class="short-description">
                                    {!! $shortDescription !!}
                                    <a href="javascript:void(0);" class="toggle-description">{{ __('general.show_more') }}</a>
                                </p>
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-tutor-detail">
    <div class="am-booking_section" id="availability">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <livewire:components.tutor-sessions :user="$tutor" />
                </div>
            </div>
        </div>
        <div class="am-howtobook">
            @if (!empty(setting('_lernen.enable_booking_tips')) && (
            !empty(setting('_lernen.tips_for_booking_image')) ||
            !empty(setting('_lernen.tips_for_booking_heading')) ||
            !empty(setting('_lernen.tips_for_booking_bullets')) ||
            !empty(setting('_lernen.tips_for_booking_sub_heading')) ||
            !empty(setting('_lernen.tips_for_booking_sub_heading'))
            ))
            <a href="javascript:void(0);">
                <i class="am-icon-exclamation-01"></i>
                <!-- <span>{{ __('general.how_it_work') }}</span> -->
            </a>
            <div class="am-howtobook_popup">
                @if (!empty(setting('_lernen.tips_for_booking_image')[0]['path']))
                <figure class="am-howtobook_img">
                    <img src="{{ url(Storage::url(setting('_lernen.tips_for_booking_image')[0]['path'])) }}"
                        alt="img description">
                    <a href="javascript:void(0);" class="am-howtobook_close">
                        <i class="am-icon-multiply-02"></i>
                    </a>
                </figure>
                @endif
                <div class="am-howtobook_content">
                    <div class="am-howtobook_info">
                        @if (!empty(setting('_lernen.tips_for_booking_heading')))
                        <h3>{{ setting('_lernen.tips_for_booking_heading') }}</h3>
                        @endif
                        @if (!empty(setting('_lernen.tips_for_booking_bullets')))
                        <ol>
                            @foreach (setting('_lernen.tips_for_booking_bullets') as $bullet)
                            <li>
                                <span>{!! $bullet['tips_for_booking_bullet'] !!}</span>
                            </li>
                            @endforeach
                        </ol>
                        @endif
                    </div>
                    <div class="am-howtobook_info">
                        @if (!empty(setting('_lernen.tips_for_booking_sub_heading')))
                        <h3>{{ setting('_lernen.tips_for_booking_sub_heading') }}</h3>
                        @endif
                        @if (!empty(setting('_lernen.tips_for_booking_sub_bullets')))
                        <ol>
                            @foreach (setting('_lernen.tips_for_booking_sub_bullets') as $sub_bullet)
                            <li>
                                <span>{!! addBaseUrl($sub_bullet['tips_for_booking_sub_bullet']) !!}</span>
                            </li>
                            @endforeach
                        </ol>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses') && $courses->isNotEmpty())
        <div wire:ignore class="am-booking_section am-featured-courses" id="courses">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1>{{ __('courses::courses.featured_courses') }}</h1>
                        @if($courses->isNotEmpty())
                        <div id="am-handpick-tutor" class="am-handpick-tutor @if( $courses->count() > 3 ) splide @endif">
                            <div class="splide__track">
                                <ul class="splide__list">
                                        @foreach ($courses as $course)
                                            <li class="splide__slide">
                                                <div class="cr-card">
                                                    <figure 
                                                        class="cr-image-wrapper" 
                                                        x-data="{ 
                                                            isOpen: false, 
                                                            videoUrl: '{{ url(Storage::url($course?->promotionalVideo?->path)) }}',
                                                            courseId: '{{ $course->id }}',
                                                            playVideo() {
                                                                this.isOpen = true;
                                                                this.$nextTick(() => {
                                                                    let video = document.getElementById(`course-${this.courseId}`);
                                                                    if (video) {
                                                                        video.load();
                                                                    }
                                                                });
                                                            }
                                                        }">
                                                        <template x-if="isOpen">
                                                            <div class="cr-video-modal">
                                                                <video 
                                                                    :id="'course-'+courseId"
                                                                    onloadeddata="
                                                                        let player = videojs(this); 
                                                                        player.removeClass('d-none'); 
                                                                        setTimeout(() => player.play(), 100);
                                                                        player.on('playing', function() {
                                                                        let players = document.querySelectorAll('.video-js');
                                                                        let current = document.getElementById(this.id());
                                                                        players.forEach((element) => {
                                                                            if(current != element){
                                                                                let otherPlayer = videojs(element);
                                                                                if (!otherPlayer.paused()) {
                                                                                    otherPlayer.pause();
                                                                                }
                                                                            }
                                                                        });
                                                                    });
                                                                        " class="d-none video-js vjs-default-skin d-none-playBtn" width="100%" height="100%" controls>
                                                                    <source :src="videoUrl" type="video/mp4" x-ref="video" >
                                                                </video>
                                                            </div>
                                                        </template>
                                                        <template x-if="!isOpen">
                                                            <img height="200" width="360" src="{{ !empty($course->thumbnail->path) ? url(Storage::url($course->thumbnail->path)) : asset('vendor/courses/images/course.png') }}" alt="{{ $course->title }}" class="cr-background-image" />
                                                        </template>
                                                        @if(!empty($course?->promotionalVideo?->path) && Storage::disk(getStorageDisk())->exists($course?->promotionalVideo?->path) )
                                                            <template x-if="!isOpen">
                                                                <figcaption>
                                                                    @if (!empty($course->pricing?->discount))
                                                                        <span>{{ $course->pricing?->discount }}%{{ __('courses::courses.off') }}</span>
                                                                    @endif
        
                                                                    <button @click="playVideo()">
                                                                        <svg width="14" height="18" viewBox="0 0 14 18" fill="none">
                                                                            <path d="M0.109375 12.9487V5.0514C0.109375 3.16703 0.109375 2.22484 0.503774 1.69381C0.847558 1.23093 1.37438 0.93894 1.94911 0.892737C2.60845 0.839731 3.40742 1.33909 5.00537 2.33781L11.3232 6.28644C12.7629 7.18627 13.4828 7.63619 13.7296 8.21222C13.9452 8.7153 13.9452 9.28476 13.7296 9.78785C13.4828 10.3639 12.7629 10.8138 11.3232 11.7136L5.00537 15.6623C3.40742 16.661 2.60845 17.1603 1.94911 17.1073C1.37438 17.0611 0.847558 16.7691 0.503774 16.3063C0.109375 15.7752 0.109375 14.833 0.109375 12.9487Z" fill="white"/>
                                                                        </svg>
                                                                    </button>
                                                                </figcaption>
                                                            </template>
                                                        @endif
                                                    </figure>
                                                    <div class="cr-course-card">
                                                        <div class="cr-course-header">
                                                            <div class="cr-instructor-info">
                                                                <div class="cr-instructor-details">
                                                                    <a href="{{ route('tutor-detail',['slug' => $course->instructor?->profile?->slug]) }}" target="_blank" class="cr-instructor-name">
                                                                        <img src="{{ Storage::url($course->instructor?->profile?->image) }}" alt="{{ $course->instructor?->profile?->short_name }}" class="cr-instructor-avatar" />
                                                                        {{ $course->instructor?->profile?->short_name }}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <h2 class="cr-course-title">
                                                                <a href="{{ route('courses.course-detail', ['slug' => $course->slug]) }}">{{ html_entity_decode($course->title) }}</a>
                                                            </h2>
                                                            <div class="cr-course-category">
                                                                <a href="{{ route('courses.search-courses', ['searchCategories' => [0 => $course->category?->id]]) }}" class="cr-category-link">{{ $course->category->name }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="cr-course-features">
                                                            <div class="cr-filter-option">
                                                                <span @class(['cr-stars', 'cr-1star' => !empty($course->ratings_avg_rating)])>
                                                                    <i class="am-icon-star-01"></i>
                                                                </span>
                                                                <span class="cr-rating-score">{{ number_format($course->ratings_avg_rating, 1) }}</span>
                                                                <span class="cr-review-count">({{ $course->ratings_count == 1 ? __('courses::courses.single_reviews') : __('courses::courses.reviews_count', ['count' => $course->ratings_count]) }})</span>
                                                            </div>
                                                            <div class="cr-course-info">
                                                                <div class="cr-info-item">
                                                                    <i class="am-icon-bar-chart-04"></i>
                                                                    <span>{{ __('courses::courses.'. $course->level) }}</span>
                                                                </div>
                                                                <div class="cr-info-item">
                                                                    <i class="am-icon-dribbble-01"></i>
                                                                    <span>{{ $course->language->name }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="cr-lesson-count">
                                                                <i class="am-icon-book-1"></i>
                                                                <span>{{ $course->curriculums_count }} {{ __('courses::courses.lessons') }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="cr-price-container">
                                                            <div class="cr-price-info">
                                                                @if (!empty($course->pricing?->price) && !empty($course->pricing?->final_price) && $course->pricing?->price != 0.00 )
                                                                    
                                                                    @if ($course->pricing?->price != $course->pricing?->final_price)
                                                                        <span class="cr-original-price">
                                                                            {{ formatAmount($course->pricing?->price) }}
                                                                            <svg width="38" height="11" viewBox="0 0 38 11" fill="none">
                                                                                <rect x="37" width="1" height="37.3271" transform="rotate(77.2617 37 0)" fill="#686868"/>
                                                                                <rect x="37.2188" y="0.975342" width="1" height="37.3271" transform="rotate(77.2617 37.2188 0.975342)" fill="#F7F7F8"/>
                                                                            </svg>
                                                                        </span>
                                                                    @endif
                                                                    <div class="cr-discounted-price">
                                                                        <span class="cr-price-amount">{!! formatAmount($course->pricing?->final_price, true) !!}</span>
                                                                    </div>
                                                                @else
                                                                    <div class="cr-discounted-price">
                                                                        <span class="cr-price-amount">{{ __('courses::courses.free') }}</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            @if (!empty($course->content_length))
                                                                <div class="cr-duration-info">
                                                                    <i class="am-icon-time"></i>
                                                                    @if($course->content_length > 0)
                                                                        <span>
                                                                            {{ getCourseDuration($course->content_length) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="am-featured-courses-btn">
                            <a href="{{ route('courses.search-courses', ['tutor_id' => $tutor->id]) }}" class="am-btn">{{ __('courses::courses.view_all') }}</a>
                        </div>
                        @else
                            @include('livewire.components.no-record')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div id="resume-highlights">
        <livewire:components.tutor-resume lazy :user="$tutor" />
    </div>
    <div id="reviews">
        <livewire:components.students-reviews :user="$tutor" lazy />
    </div>
    <livewire:components.similar-tutors :user="$tutor" lazy />
</div>
@endsection


@push('styles')
    @vite([
        'public/css/flatpicker.css',
        'public/css/videojs.css',
        'public/css/flags.css'
    ])
    @if(\Nwidart\Modules\Facades\Module::has('courses') && \Nwidart\Modules\Facades\Module::isEnabled('courses'))
        <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @endif
@endpush

@push('scripts')
<script src="{{ asset('js/video.min.js') }}"></script>
<script>

    function initFeaturedTutorsSlider(){
        new Splide('.am-handpick-tutor' , {
            autoWidth: true,
            perMove: 1,
            perPage: 3,
            pagination: false,
            width: 1236,
            arrows: 'slider',
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

    document.addEventListener("DOMContentLoaded", (event) => {
        @if (count($courses) > 3)    
            initFeaturedTutorsSlider();
        @endif
        function isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            return (
                rect.top    >= 0 &&
                rect.left   >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right  <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        jQuery(document).on('click', '.am-howtobook > a', function() {
            const popup = jQuery('.am-howtobook_popup');
            popup.slideToggle('slow').toggleClass('active');
        });

        jQuery(document).on('click', '.am-howtobook_close', function() {
            const popup = jQuery('.am-howtobook_popup');
            popup.slideUp('slow').removeClass('active');
        });

        $(document).on('click','.toggle-description', function() {
            var parentContainer = $(this).closest('.am-addmore');

            parentContainer.find('.short-description').toggleClass('d-none');
            parentContainer.find('.full-description').toggleClass('d-none');
            if (parentContainer.find('.short-description').hasClass('d-none')) {
                $(this).text('{{ __('general.show_more') }}');
            } else {
                $(this).text('{{ __('general.show_less') }}');
            }
        });
    });
</script>
@endpush


