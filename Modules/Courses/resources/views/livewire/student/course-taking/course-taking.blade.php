<div class="cr-coursesdetails">
    <div class="cr-sidebar" >
        <div class="cr-sidebar_logo">
            <strong class="cr-logo">
                <a href="{{url('/')}}">
                    <figure>
                        <img src="{{ $logo }}" alt="app logo">
                    </figure>
                </a>
            </strong>
            <div class="cr-sidebar_toggle">
                <a href="javascript:void(0);">
                    <i class="am-icon-dashbard"></i>
                </a>
            </div>
        </div>
        @if(!empty($backRoute))
            <div class="cr-sidebar_goback">
                <a href="{{ $backRoute }}">
                    <i class="am-icon-chevron-left"></i>
                    {{ __('courses::courses.back_to_course') }}
                </a>
            </div>
        @endif
        <div class="cr-sidebar_title">
            <span>{{ __('courses::courses.course_outline') }}</span>
            <h2>{{ $course->title }}</h2>
        </div>
        <div class="cr-sidebar_contentwrap"> 
            <div id="cr-sidebar_accordion" class="cr-sidebar_accordion">
                @php 
                    $counter = 1;
                @endphp
                @foreach ($course->sections as $key => $section)
                    <div class="cr-sidebar_accordion_item accordion-item">
                        <div class="cr-sidebar_accordion_title" id="cr-heading{{ $key }}">
                            <a 
                                href="javascript:void(0);" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#cr-collapse{{ $key }}" 
                                aria-expanded="{{ !empty($activeCurriculum['section_id']) && $activeCurriculum['section_id'] == $section->id ? 'true' : 'false' }}" 
                                aria-controls="cr-collapse{{ $key }}"
                                @class([
                                    'collapsed' => !empty($activeCurriculum['section_id']) && $activeCurriculum['section_id'] != $section->id
                                ])
                                >
                                <em>{{ $key + 1 }}.</em>
                                <span><span>{{ $section->title }}</span>
                                    <em> 
                                        {{ $section->curriculums->where('watchtime', '>=', 'content_length')->count() }} /
                                        {{ $section->curriculums->count() }} | 
                                        {{ getCourseDuration($section->curriculums->sum('content_length')) }}
                                    </em>
                                </span>
                                <i class="am-icon-chevron-right"></i>
                            </a>
                        </div>
                        @if($section->curriculums->count() > 0)
                            <div @class([
                                'cr-sidebar_accordion_content', 
                                'accordion-collapse', 
                                'collapse',
                                'show' => !empty($activeCurriculum['section_id']) && $activeCurriculum['section_id'] == $section->id
                            ]) id="cr-collapse{{ $key }}" aria-labelledby="cr-heading{{ $key }}" data-bs-parent="#cr-sidebar_accordion">
                                @foreach ($section->curriculums as $curriculum)
                                    <div class="cr-sidebar_accordion_content_item">
                                        <a 
                                            href="javascript:void(0);" 
                                            id="cr-curriculum-{{ $counter }}"
                                            @class(['cr-active' => !empty($activeCurriculum['id']) && $activeCurriculum['id'] == $curriculum['id']])
                                            @if(!empty($activeCurriculum['id']) && $activeCurriculum['id'] != $curriculum['id'])
                                            wire:click.prevent="setActiveCurriculum({{ $curriculum }})"
                                            @endif
                                            >
                                            <span>
                                                <span>{{ $curriculum->title }}</span>
                                                <em>{{ getCourseDuration($curriculum->content_length) }}</em>
                                            </span>
                                            <i>
                                                @if($curriculum->type == 'article')
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.75 0.937655C9.67007 0.9375 9.5852 0.9375 9.49477 0.9375H7.2375C5.55734 0.9375 4.71726 0.9375 4.07553 1.26448C3.51104 1.5521 3.0521 2.01104 2.76448 2.57553C2.4375 3.21726 2.4375 4.05734 2.4375 5.7375V12.2625C2.4375 13.9427 2.4375 14.7827 2.76448 15.4245C3.0521 15.989 3.51104 16.4479 4.07553 16.7355C4.71726 17.0625 5.55734 17.0625 7.2375 17.0625H10.7625C12.4427 17.0625 13.2827 17.0625 13.9245 16.7355C14.489 16.4479 14.9479 15.989 15.2355 15.4245C15.5625 14.7827 15.5625 13.9427 15.5625 12.2625V7.00523C15.5625 6.9148 15.5625 6.82994 15.5623 6.75001H13.7H13.6696C13.1354 6.75002 12.6896 6.75003 12.3253 6.72027C11.9454 6.68923 11.5888 6.62212 11.2515 6.45028C10.7341 6.18663 10.3134 5.76593 10.0497 5.24848C9.87789 4.91122 9.81078 4.55456 9.77974 4.17468C9.74998 3.81045 9.74999 3.3646 9.75 2.83046V2.83044L9.75 2.80001V0.937655ZM15.3875 5.25001C15.318 5.05562 15.2286 4.86865 15.1204 4.69215C14.9349 4.3894 14.6755 4.12997 14.1566 3.61112L12.8889 2.34339L12.8889 2.34338C12.37 1.82453 12.1106 1.5651 11.8078 1.37958C11.6314 1.27142 11.4444 1.18197 11.25 1.1125V2.80001C11.25 3.37244 11.2506 3.75665 11.2748 4.05253C11.2982 4.33966 11.3401 4.47694 11.3862 4.5675C11.5061 4.8027 11.6973 4.99393 11.9325 5.11377C12.0231 5.15991 12.1604 5.20179 12.4475 5.22525C12.7434 5.24943 13.1276 5.25001 13.7 5.25001H15.3875ZM6.75 8.25001C6.33579 8.25001 6 8.5858 6 9.00001C6 9.41422 6.33579 9.75001 6.75 9.75001H11.25C11.6642 9.75001 12 9.41422 12 9.00001C12 8.5858 11.6642 8.25001 11.25 8.25001H6.75ZM6.75 11.25C6.33579 11.25 6 11.5858 6 12C6 12.4142 6.33579 12.75 6.75 12.75H9.75C10.1642 12.75 10.5 12.4142 10.5 12C10.5 11.5858 10.1642 11.25 9.75 11.25H6.75Z" fill="#585858"/>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.9375 9C0.9375 4.5472 4.5472 0.9375 9 0.9375C13.4528 0.9375 17.0625 4.5472 17.0625 9C17.0625 13.4528 13.4528 17.0625 9 17.0625C4.5472 17.0625 0.9375 13.4528 0.9375 9ZM10.4114 7.304C11.3112 7.8664 11.7612 8.1476 11.9154 8.50762C12.0502 8.82204 12.0502 9.17796 11.9154 9.49238C11.7612 9.8524 11.3112 10.1336 10.4114 10.696L10.185 10.8375C9.18628 11.4617 8.68692 11.7738 8.27483 11.7407C7.91563 11.7118 7.58636 11.5293 7.3715 11.24C7.125 10.9081 7.125 10.3192 7.125 9.1415V8.8585C7.125 7.68076 7.125 7.09189 7.3715 6.76C7.58636 6.4707 7.91563 6.28821 8.27483 6.25933C8.68692 6.2262 9.18628 6.5383 10.185 7.1625L10.4114 7.304Z" fill="#585858"/>
                                                    </svg>
                                                @endif
                                            </i>
                                        </a>
                                    </div>
                                    @php 
                                        $counter++;
                                    @endphp
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="cr-coursedetails_content">
        <div wire:ignore class="cr-usercourse_header">
            @if(auth()->user()->role == 'student')
                <div x-data="{ progress: @js(floor($progress)) }" 
                x-on:updated-progress.window="
                progress = $event.detail.progress; 
                if( $event.detail.resultAssigned){
                    let modal = new bootstrap.Modal(document.getElementById('course_completed_popup'));
                   modal.show();
                }
                " class="cr-usercourse_header_progress">
                    <span>{{ __('courses::courses.course_progress') }}<em x-text="progress+'%'"></em></span>
                    <div class="cr-usercourse_header_progress_bar">
                        <div class="cr-usercourse_header_progress_bar_inner" :style="'width: '+progress+'%'"> </div>
                    </div>
                </div>
            @endif
            <div class="cr-usercourse_header_actions">
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#cr-sharemodal" class="cr-btn">
                    {{ __('courses::courses.share') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <g opacity="0.6" clip-path="url(#clip0_13156_65705)">
                            <path d="M8.25 9.75L8.53457 10.4899C9.5894 13.2326 10.1168 14.6039 10.825 14.9489C11.4376 15.2472 12.1598 15.2132 12.7416 14.8586C13.4143 14.4486 13.8104 13.0338 14.6028 10.2041L15.716 6.22824C16.2177 4.43672 16.4685 3.54096 16.2357 2.92628C16.0327 2.39035 15.6096 1.96724 15.0737 1.76427C14.459 1.53147 13.5633 1.78228 11.7717 2.28391L7.79584 3.39716C4.96617 4.18947 3.55133 4.58563 3.14136 5.25828C2.78678 5.84005 2.75275 6.56231 3.05106 7.17484C3.39597 7.88306 4.76729 8.41049 7.50992 9.46536L8.25 9.75ZM8.25 9.75L10.125 7.875" stroke="#8E8E8E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_13156_65705">
                            <rect width="18" height="18" fill="white"/>
                            </clipPath>
                        </defs>
                    </svg>
                </a>
                <div class="cr-usercourse_header_actions_dropdown">
                    <x-frontend.user-menu :showCart="false" :showMessage="false" />
                </div>
            </div>
        </div>
        <div class="cr-coursedetails_body">
            <div class="cr-coursedetails_body_video">
                @if(!empty($activeCurriculum))
                    @php 
                        $nextItem = $nextCurriculumItem[$activeCurriculum['id']];
                    @endphp
                    @if(!empty($nextItem))
                        <div class="cr-next-curriculum d-none" >
                            <div class="cr-next-curriculum_content">
                                <span>{{ __('courses::courses.subtitle') }}</span>
                                <h2 class="cr-next-curriculum-title">{{ $nextItem['title'] }}</h2>
                                <p class="cr-next-curriculum-description">{{ $nextItem['description'] }}</p>
                                <button class="cr-next-curriculum_btn" wire:click.prevent="nextCurriculum({{ $nextItem['id'] }})">
                                    @if( in_array($nextItem['type'], ['video','yt_link','vm_link']) )
                                        <i class="am-icon-play-filled"></i>{{ __('courses::courses.play_next') }}
                                    @else
                                        <i class="am-icon-book-1"></i> {{ __('courses::courses.next') }}
                                    @endif
                                </button>
                            </div>
                        </div>
                    @endif

                    @if($activeCurriculum['type'] == 'video')
                        <div class="cr-card-skeleton" id="cr-card-skeleton-{{ $activeCurriculum['id'] }}">
                            <div class="cr-image-wrapper-skeleton">
                            </div>
                        </div>
                        <div class="cr-coursetasking-video"
                            x-data="{ showVideo: false }" 
                            x-init="
                                showVideo = true; 
                                $nextTick(() => {
                                    let video = document.getElementById('video-{{ $activeCurriculum['id'] }}');
                                    if (video) {
                                        let player = videojs(video, {
                                                        controls: true,
                                                        autoplay: false,
                                                        playbackRates: [0.5, 1, 1.5, 2]
                                                    });
                                        player.ready(() => {
                                            player.load();
                                        });
                                    } 
                                });"
                        >
                            <!-- Use x-show instead of x-if -->
                            <template x-if="showVideo">
                                <video 
                                    id="video-{{ $activeCurriculum['id'] }}"
                                    preload="auto" 
                                    class="video-js vjs-default-skin d-none" 
                                    data-setup="{}"
                                    onloadstart="initializeVideoPlayer(this, '{{ $activeCurriculum['id'] }}')"
                                    onloadeddata="initializeVideoPlayer(this, '{{ $activeCurriculum['id'] }}')"
                                    onplay="updateWatchtime({{ $activeCurriculum['id'] }})" 
                                    width="320" 
                                    height="240" 
                                    controls
                                >
                                    <source src="{{ $activeCurriculum['media_path'] }}" type="video/mp4">
                                </video>
                            </template>
                            <strong class="am-logo">
                                @if(!empty(setting('_general.watermark_logo')))
                                    <img src="{{ url(Storage::url(setting('_general.watermark_logo')[0]['path'])) }}" alt="watermark-logo">
                                @else
                                    <img src="{{ asset('modules/courses/images/green-logo.png') }}" alt="watermark-logo">
                                @endif
                            </strong>
                            <div class="cr-video-info">
                                <figure>
                                    @if (!empty($course?->instructor?->profile?->image) && Storage::disk(getStorageDisk())->exists($course?->instructor?->profile?->image))
                                        <img src="{{ resizedImage($course?->instructor?->profile?->image,50,50) }}" alt="{{ $course?->instructor?->profile?->image }}" />
                                    @else
                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 50, 50) }}" alt="{{ $course?->instructor?->profile?->image }}" />
                                    @endif
                                </figure>
                                @if(!empty($course?->instructor?->profile?->full_name) || !empty($course?->instructor?->profile?->tagline))
                                <div class="cr-video-info_content">
                                    <h6>
                                        @if(!empty($course?->instructor?->profile?->full_name))
                                            {{$course?->instructor?->profile?->full_name}}
                                        @endif
                                    </h6>
                                    @if(!empty($course?->instructor?->profile?->tagline))
                                        <span>{{$course?->instructor?->profile?->tagline}}</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>                    
                    @elseif($activeCurriculum['type'] == 'yt_link')
                        @php
                            $yt_link = explode('v=', $activeCurriculum['media_path']);
                            $yt_id = end($yt_link);
                        @endphp
                        <div x-data="{
                            onYouTubeIframeAPIReady(videoId){
                                console.log('videoId: ' + videoId);
                                const ytPlayer = new YT.Player(`yt-video-${videoId}`, {
                                    events: {
                                        onReady: function (event) {
                                            const ytVideoDuration = event.target.getDuration();
                                            console.log('evt', ytVideoDuration, event);
                                            event.target.playVideo();
                                            console.log('Video started playing');
                                        },
                                        onStateChange: function (event) {
                                            console.log('onStateChange', event);
                                            if (event.data === YT.PlayerState.ENDED) {
                                                let role = @js(auth()->user()->role);
                                                if(role == 'student'){
                                                    @this.call('updateWatchtime', true);
                                                }
                                                showNextItemContent();
                                            }
                                        }
                                    },
                                });
                                console.log('ytPlayer', ytPlayer);
                                ytPlayer.options.events.onStateChange = function() {
                                    console.log('onStateChange');
                                };
                            },
                        }">
                            <iframe 
                                id="yt-video-{{ $activeCurriculum['id'] }}" 
                                src="https://www.youtube.com/embed/{{ $yt_id }}?enablejsapi=1" 
                                frameborder="0" 
                                x-on:load="onYouTubeIframeAPIReady('{{ $activeCurriculum['id'] }}')"
                                allowfullscreen
                            ></iframe>
                        </div>
                    @elseif($activeCurriculum['type'] == 'vm_link')
                        @php
                            $videoId = '';
                                if (preg_match('/vimeo\.com\/(\d+)/', $activeCurriculum['media_path'], $matches)) {
                                    $videoId = $matches[1];
                                }
                        @endphp
                            <div x-data="{
                                        onVimeoIframeAPIReady(videoId){
                                            console.log('videoId: ' + videoId);
                                            if(jQuery(`#vm-video-${videoId}`)?.length){
                                                const vimeoPlayer = new Vimeo.Player(`vm-video-${videoId}`);
                                                vimeoPlayer.on('ended', function() {
                                                    let role = @js(auth()->user()->role);
                                                    if(role == 'student'){
                                                        @this.call('updateWatchtime', true);
                                                    }
                                                    showNextItemContent();
                                                });
                                            }
                                        },
                                    }">
                                <iframe
                                id="vm-video-{{ $activeCurriculum['id'] }}"
                                class="am-iframe-video"
                                src="https://player.vimeo.com/video/{{ $videoId }}?api=1&player_id=vm-video-{{ $activeCurriculum['id'] }}"
                                frameborder="0"
                                x-on:load="onVimeoIframeAPIReady('{{ $activeCurriculum['id'] }}')"
                                allowfullscreen
                                wire:key="profile-video-src-{{ $activeCurriculum['id'] . time() }}"></iframe>
                            </div>

                    @elseif($activeCurriculum['type'] == 'article')
                        @if(auth()->user()->role == 'student')
                            <div 
                                id="article-{{ $activeCurriculum['id'] }}"
                                class="cr-coursedetails_article" 
                            >
                                <div class="cr-coursedetails_article_wrap">{!! $activeCurriculum['article_content'] !!}</div>
                                <div class="cr-coursedetails_article_actions">                                 
                                    @if( 
                                        isset($activeCurriculum['watchtime']['duration']) && isset($activeCurriculum['content_length'])
                                        && ($activeCurriculum['watchtime']['duration'] == $activeCurriculum['content_length'])
                                        )
                                        @if(!empty($curriculumOrder[$activeCurriculum['id']]))
                                            <a href="javascript:void(0);" class="am-btn" wire:click.prevent="nextCurriculum({{ $curriculumOrder[$activeCurriculum['id']] }})">Go to next item</a>
                                        @endif
                                        <button type="button" class="am-btnnext"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none"><path d="M3.16699 8.66667L6.50033 12L13.8337 4" stroke="#34A853" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/></svg> Completed</button>
                                    @else
                                        <button type="button" class="am-btn" wire:click.prevent="markAsCompleted()">Mark as complete</button>
                                    @endif
                                </div>

                            </div>
                        @else
                            <div id="article-{{ $activeCurriculum['id'] }}" class="cr-coursedetails_article" >
                                <div class="cr-coursedetails_article_wrap">{!! $activeCurriculum['article_content'] !!}</div>
                            </div>
                        @endif
                    @endif
                @else
                    <div wire:ignore class="cr-image-wrapper" x-data="{
                        isPlaying: false,
                        url : '{{ asset(Storage::url($course?->promotionalVideo?->path)) }}',
                        playVideo() {
                            this.isPlaying = true;
                            this.$nextTick(() => {
                                const player = videojs('promotional-video');
                                player.play();
                            });
                        }
                    }">
                        <template x-if="isPlaying">
                            <video class="video-js" data-setup='{"autoplay": true}' onloadeddata="videojs(this)" preload="auto" id="promotional-video" width="320" height="240" controls>
                                <source :src="url" type="video/mp4">
                            </video>
                        </template>
                        <template x-if="!isPlaying">
                            <figure class="cr-image-wrapper">
                                @if(!empty($course->thumbnail?->path) && Storage::disk(getStorageDisk())->exists($course->thumbnail?->path))
                                    <img src="{{ Storage::url($course->thumbnail->path) }}" alt="{{ $course->title }}" class="cr-background-image" />
                                @else
                                    <img src="{{ asset('modules/courses/images/course.png') }}" alt="{{ $course->title }}" />
                                @endif
                            
                                @if(!empty($course?->promotionalVideo?->path) && Storage::disk(getStorageDisk())->exists($course?->promotionalVideo?->path))
                                    <figcaption @click="playVideo">
                                        <button >
                                            <i class="am-icon-play-filled"></i>
                                        </button>
                                    </figcaption>
                                @endif
                            </figure>
                        </template>
                    </div>
                    
                @endif
            </div>
            <div class="cr-coursecontent">
                <div class="cr-coursecontent_body" x-data="{ activeTab: 'cr-overview' }">
                    <ul wire:ignore class="cr-coursecontent_tabs nav nav-tabs" id="cr-coursecontenttab" role="tablist">
                        <li class="nav-item cr-coursecontent_tab" :class="{ 'active': activeTab === 'cr-overview' }" role="cr-coursecontent_tab">
                            <button class="nav-link" @click="activeTab = 'cr-overview'" id="cr-overview-tab" data-bs-toggle="tab" data-bs-target="#cr-overview" type="button" role="tab" aria-controls="cr-overview" aria-selected="true">{{ __('courses::courses.overview') }}</button>
                        </li>
                        <li class="nav-item cr-coursecontent_tab" :class="{ 'active': activeTab === 'cr-faq' }" role="cr-coursecontent_tab">
                            <button class="nav-link" @click="activeTab = 'cr-faq'" id="cr-faq-tab" data-bs-toggle="tab" data-bs-target="#cr-faq" type="button" role="tab" aria-controls="cr-faq" aria-selected="false">{{ __('courses::courses.prerequisites_and_faqs') }}</button>
                        </li>
                        @if(\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise') && !empty($course->discussion_forum))
                            <li class="nav-item cr-coursecontent_tab" :class="{ 'active': activeTab === 'cr-discussion' }" role="cr-coursecontent_tab">
                                <button class="nav-link" @click="activeTab = 'cr-discussion'" id="cr-discussion-tab" data-bs-toggle="tab" data-bs-target="#cr-discussion" type="button" role="tab" aria-controls="cr-discussion" aria-selected="false">{{ __('courses::courses.discussion_forum') }}</button>
                            </li>
                        @endif
                        <li class="nav-item cr-coursecontent_tab" :class="{ 'active': activeTab === 'cr-noticeboard' }" role="cr-coursecontent_tab">
                            <button class="nav-link" @click="activeTab = 'cr-noticeboard'" id="cr-noticeboard-tab" data-bs-toggle="tab" data-bs-target="#cr-noticeboard" type="button" role="tab" aria-controls="cr-noticeboard" aria-selected="false">{{ __('courses::courses.noticeboard') }}</button>
                        </li>
                    </ul>
                    <div class="cr-coursecontent_tabs_content tab-content" id="cr-tab-content" wire:ignore.self>
                        <div wire:ignore.self class="tab-pane fade active" x-bind:class="{ 'show active': activeTab === 'cr-overview' }" id="cr-overview" role="tabpanel" aria-labelledby="cr-overview-tab">
                            <section class="cr-course-details-banner">
                                <div class="cr-course-details-area">
                                    <div class="cr-course-details-info">
                                        @if (!empty($course->title) || !empty($course->subtitle))
                                            <div class="am-searchhead_title">
                                                <div class="cr-title-box">
                                                    @if (!empty($course->title))
                                                        <h2>{{ $course->title }}</h1>
                                                    @endif
                                                    <span data-toggle="modal" data-bs-toggle="modal" data-bs-target="#back-confirm-popup"><em>{{ __('courses::courses.in') }}:</em> {!! $course->category?->name !!}</span>
                                                </div>
                                                @if (!empty($course->subtitle))
                                                    <p>{{ $course->subtitle }}</p>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="cr-course-meta">
                                            <div class="cr-rating-container">
                                                <span @class([
                                                    'cr-stars',
                                                    'cr-' . floor($course->ratings_avg_rating) . 'star' => !empty($course->ratings_count)
                                                ])>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="am-icon-star-01"></i>
                                                    @endfor
                                                </span>
                                                <span class="cr-rating-score">{{ number_format($course->ratings_avg_rating, 1) }}</span>
                                                <span class="cr-review-count">({{ $course->ratings_count }} {{ __('courses::courses.reviews') }})</span>
                                            </div>
                                          
                                            @if (!empty($course->updated_at))
                                                <div class="cr-last-updated">
                                                    <span>
                                                        <i class="am-icon-time"></i>
                                                    </span>
                                                    <span class="cr-update-date">{{ __('courses::courses.last_updated') }}: {{ \Carbon\Carbon::parse($course->updated_at)->format('M d, Y') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="cr-course-stats">
                                            @if (!empty($course->level))
                                                <div class="cr-stat-item">
                                                    <div class="cr-stat-icon-wrapper">
                                                        <i class="am-icon-bar-chart-04"></i>
                                                    </div>
                                                    <div class="cr-stat-content">
                                                        <span class="cr-stat-label">{{ __('courses::courses.level') }}</span>
                                                        <span class="cr-stat-value">{{ __('courses::courses.'. $course->level) }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (!empty($course->language))
                                                <div class="cr-stat-item">
                                                    <div class="cr-stat-icon-wrapper">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none"><path opacity="0.7" d="M13.75 8C13.75 11.4518 10.9518 14.25 7.5 14.25M13.75 8C13.75 4.54822 10.9518 1.75 7.5 1.75M13.75 8C13.75 6.61929 10.9518 5.5 7.5 5.5C4.04822 5.5 1.25 6.61929 1.25 8M13.75 8C13.75 9.38071 10.9518 10.5 7.5 10.5C4.04822 10.5 1.25 9.38071 1.25 8M7.5 14.25C4.04822 14.25 1.25 11.4518 1.25 8M7.5 14.25C8.88071 14.25 10 11.4518 10 8C10 4.54822 8.88071 1.75 7.5 1.75M7.5 14.25C6.11929 14.25 5 11.4518 5 8C5 4.54822 6.11929 1.75 7.5 1.75M1.25 8C1.25 4.54822 4.04822 1.75 7.5 1.75" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </div>
                                                    <div class="cr-stat-content">
                                                        <span class="cr-stat-label">{{ __('courses::courses.language') }}</span>
                                                        <span class="cr-stat-value">{{ $course->language?->name }}</span>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="cr-stat-item">
                                                <div class="cr-stat-icon-wrapper">
                                                    <i class="am-icon-user-group"></i>
                                                </div>
                                                <div class="cr-stat-content">
                                                    <span class="cr-stat-label">{{ __('courses::courses.enrolments') }}</span>
                                                    <span class="cr-stat-value">{{ number_format($course?->enrollments_count ?? 0) }} {{$course?->enrollments_count == 1 ? __('courses::courses.student') : __('courses::courses.students') }}</span>
                                                </div>
                                            </div>
                                            <div class="cr-stat-item">
                                                <div class="cr-stat-icon-wrapper">
                                                    <i class="am-icon-eye-open-01"></i>
                                                </div>
                                                <div class="cr-stat-content">
                                                    <span class="cr-stat-label">{{ __('courses::courses.views') }}</span>
                                                    <span class="cr-stat-value">{{ number_format($course->views_count) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            @if (!empty($course->description))
                                <div class="cr-overview-course cr-desc-section" 
                                    x-bind:class="{ 'cr-desc-section-show': showMore }" 
                                    id="overview" 
                                    x-data="{ 
                                        showMore: false,
                                        get textValue() {
                                            return this.showMore ? '{{ __('courses::courses.show_less') }}' : '{{ __('courses::courses.show_more') }}'
                                        }
                                    }"
                                >
                                <div class="cr-desc-content">
                                    <h3>{{ __('courses::courses.description') }}</h3>
                                    <p>{!! preg_replace('/<[^\/>]*>(\s|&nbsp;)*<\/[^>]*>/', '', $course->description) !!}</p>
                                </div>
                                    @if(strlen(strip_tags($course->description)) > 220)
                                        <a href="javascript:void(0);" 
                                           class="cr-show" 
                                           @click="showMore = !showMore"
                                           x-text="textValue">
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div wire:ignore.self class="tab-pane fade" x-bind:class="{ 'show active': activeTab === 'cr-faq' }" id="cr-faq" role="tabpanel" aria-labelledby="cr-faq-tab">
                            @if((!empty($course->faqs) && $course?->faqs?->count() > 0) || !empty($course->prerequisites))
                                @if (!empty($course->faqs) && $course->faqs->count() > 0)
                                    <div class="cr-overview-course" id="prerequisites-&-faq">
                                        <h3>{{ __('courses::courses.faqs_title') }}</h3>
                                        <div class="cr-faq-accordion cr-detail-faq-accordion">
                                            <div class="accordion">
                                                @foreach ($course->faqs as $key => $faq)
                                                    <div class="accordion-item">
                                                        <input type="radio" name="accordion" {{ $key == 0 ? 'checked' : '' }} id="faq-{{ $faq->id }}" class="accordion-checkbox">
                                                        <label for="faq-{{ $faq->id }}" class="cr-course-item accordion-header">
                                                            <div class="cr-contentbox">
                                                                <span>{{ $faq->question }}</span>
                                                            </div>
                                                            <span class="accordion-icon">
                                                                <svg  width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                                    <path d="M4.5 6.75L9 11.25L13.5 6.75" stroke="#585858" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </span>
                                                        </label>
                                                        <div class="accordion-content">
                                                            <p>{!! $faq->answer !!}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>   
                                        </div>
                                    </div>
                                @endif
                                @if (!empty($course->prerequisites))
                                    <div class="cr-overview-course" id="prerequisites">
                                        <h3>{{ __('courses::courses.prerequisites_title') }}</h3>
                                        <div class="cr-prerequisites-frame">
                                        {!! $course->prerequisites !!}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="cr-norecord">
                                    <div class="cr-norecord_content">
                                        <figure><img src="{{ asset('modules/courses/images/cr-no-record.png') }}" alt="no record"></figure>
                                        <h5>{{ __('courses::courses.no_record_found') }}</h5>
                                        <span>{{ __('courses::courses.no_faqs_available') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if(\Nwidart\Modules\Facades\Module::has('forumwise') && \Nwidart\Modules\Facades\Module::isEnabled('forumwise') && !empty($course->discussion_forum))
                            <div wire:ignore.self class="tab-pane fade" x-bind:class="{ 'show active': activeTab === 'cr-discussion' }" id="cr-discussion" role="tabpanel" aria-labelledby="cr-discussion-tab">
                                <div class="cr-overview-course cr-discussion-course">
                                    <h3>{{ __('courses::courses.discussion_forum') }}</h3>
                                    <livewire:courses::discussion-forum :topicId="$course->id" />
                                </div>
                            </div>
                        @endif
                        <div wire:ignore.self class="tab-pane fade cr-noticeboard-tab" x-bind:class="{ 'show active': activeTab === 'cr-noticeboard' }" id="cr-noticeboard" role="tabpanel" aria-labelledby="cr-noticeboard-tab">
                            <div class="cr-forum-item-wrapper">
                                @if($course->noticeboards->count() > 0)
                                    <h3>{{ __('courses::courses.noticeboard') }}</h3>
                                    @foreach ($course->noticeboards as $noticeboard)
                                        <div class="cr-noticeboard-item">
                                            <span class="cr-noticeboard_date">{{ $noticeboard?->created_at?->format('M d, Y') }}</span>
                                            <p>{!! $noticeboard->content !!}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="cr-norecord">
                                        <div class="cr-norecord_content">
                                            <figure><img src="{{ asset('modules/courses/images/cr-no-record.png') }}" alt="no record"></figure>
                                            <h5>{{ __('courses::courses.no_record_found') }}</h5>
                                            <span>{{ __('courses::courses.no_notices_posted') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cr-coursecontent_sidebar">
                    <div class="cr-course-sidebar" style="top: 0px;">
                        <div class="cr-course-card">
                            <div class="cr-course-details">
                                <div class="cr-course-includes">
                                    <h2 class="cr-includes-title">{{ __('courses::courses.course_includes') }}:</h2>
                                    <ul class="cr-includes-list">
                                        <li class="cr-includes-item">
                                            <i class="am-icon-list-02"></i>
                                            <div class="cr-includes-text">
                                                <span class="cr-includes-value">{{ $course->sections_count }}</span>
                                                <span class="cr-includes-label">{{ $course->sections_count > 1 ? __('courses::courses.topics') : __('courses::courses.topic') }}</span>
                                            </div>
                                        </li>
                                        <li class="cr-includes-item">
                                            <i class="am-icon-book-1"></i>
                                            <div class="cr-includes-text">
                                                <span class="cr-includes-value">{{ $course->curriculums_count }}</span>
                                                <span class="cr-includes-label">{{ $course->curriculums_count > 1 ? __('courses::courses.lessons') : __('courses::courses.lesson') }}</span>
                                            </div>
                                        </li>
                                        @if(!empty($totalArticles))
                                            <li class="cr-includes-item">
                                                <i class="am-icon-book"></i>
                                                <div class="cr-includes-text">
                                                    <span class="cr-includes-value">{{ number_format($totalArticles) }}</span>
                                                    <span class="cr-includes-label">{{ $totalArticles == 1 ? __('courses::courses.article') : __('courses::courses.articles') }}</span>
                                                </div>
                                            </li>
                                        @endif
                                        @if(!empty($totalVideos))
                                            <li class="cr-includes-item">
                                                <i class="am-icon-play"></i>
                                                <div class="cr-includes-text">
                                                    @php 
                                                        $total_duration = $course->curriculums->where('type', 'video')->sum('content_length');
                                                    @endphp
                                                    <span class="cr-includes-value">{{ number_format($totalVideos) }}</span>
                                                    <span class="cr-includes-label">{{ $totalVideos == 1 ? __('courses::courses.video') : __('courses::courses.videos') }} of {{ getCourseDuration($total_duration) }}</span>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if( auth()->user()->role == 'student')
                            <div class="cr-course-card">
                                <div class="cr-course-details">
                                    @if(empty($studentRating))
                                    <div class="cr-course-includes cr-course-rating-wrap">
                                        <div>
                                            <div class="cr-course-rating">
                                                <h2>{{ __('courses::courses.leave_rating') }}</h2>
                                                <div class="cr-rating-container">
                                                    <span x-data="{ rating: @entangle('rating') }" 
                                                        x-bind:class="'cr-stars' + (rating ? ' cr-' + rating + 'star' : '')"
                                                        class="cr-stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="am-icon-star-01" 
                                                            id="rating-{{ $i }}" 
                                                            x-on:click="rating = {{ $i }}"
                                                            x-bind:class="{ 'active': rating >= {{ $i }} }"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                            </div>
                                            @error('rating')
                                                <span class="am-error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="cr-rating-form" x-data="{ show: false, description: @entangle('description') }">
                                            <textarea class="form-control" placeholder="{{ __('courses::courses.write_description') }}" x-model="description"></textarea>
                                            <template x-if=" description?.length > 0">
                                                <div class="cr-character-count-wrapper">
                                                    <span class="cr-character-count" x-text="1000 - description.length"></span> 
                                                    {{ __('courses::courses.characters_left') }}
                                                </div>
                                            </template>
                                            @error('description')
                                                <span class="am-error-msg">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="cr-rating-btn-wrapper">
                                            <button class="am-btn cr-rating-btn" wire:click.prevent="submitRating" wire:loading.attr="disabled" wire:loading.class="am-btn_disabled">{{ __('courses::courses.submit') }}</button>
                                        </div>
                                    </div>
                                    @else
                                        <div class="cr-course-includes cr-course-rating-wrap">
                                            <div>
                                                <h5>{{ __('courses::courses.your_ratings') }}</h5>
                                            </div>
                                            <div x-data="{ rating: {{ $studentRating->rating }} }" class="cr-rating-container">
                                                <span x-bind:class="'cr-stars' + (rating ? ' cr-' + rating + 'star' : '')"
                                                        class="cr-stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="am-icon-star-01" 
                                                            id="rating-{{ $i }}" 
                                                            x-on:click="rating = {{ $i }}"
                                                            x-bind:class="{ 'active': rating >= {{ $i }} }"></i>
                                                        @endfor
                                                    </span>
                                            </div>
                                            <div class="cr-rating-description">
                                                <p>{!! $studentRating->comment !!}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        @if (!empty($course->instructor))
                            <div class="am-similar-user">
                                <div class="am-tutordetail_user" onclick="window.open(`{{ route('tutor-detail',['slug' => $course->instructor?->profile?->slug]) }}`, '_blank')">
                                    @if(!empty($course->instructor->profile?->image))
                                        <figure class="am-tutorvone_img">
                                            <img src="{{ url(Storage::url($course->instructor->profile?->image)) }}" alt="{{ $course->instructor->profile?->short_name }}">
                                        </figure>
                                    @endif
                                    <div class="am-tutordetail_user_name">
                                        <h3>
                                            @if(!empty($course->instructor->profile?->full_name))  
                                                <a href="javascript:void(0);">{{ $course->instructor->profile?->full_name }}</a>
                                            @endif
                                            <div class="am-custom-tooltip">
                                                @if (!empty($course->instructor?->profile?->verified_at))
                                                <span class="am-tooltip-text">
                                                    <span>{{ __('courses::courses.verified') }}</span>
                                                </span>
                                                <i class="am-icon-user-check"></i>
                                                @endif
                                            </div>
                                            @if(!empty($course->instructor?->address?->country?->short_code))
                                                <span class="flag flag-{{ strtolower($course->instructor?->address?->country?->short_code) }}"></span>
                                            @endif
                                        </h3>
                                        <span>{{ $course->instructor?->profile?->tagline }}</span>
                                    </div>
                                </div>
                                <ul class="am-tutorreviews-list">
                                    @if (!empty($instructorAvgReviews) && !empty($instructorReviewsCount))
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <div class="am-tutorreview-item_icon">
                                                    <i class="am-icon-star-filled"></i>
                                                </div>
                                                    <span class="am-uniqespace">{{ number_format($instructorAvgReviews, 1) }} <em>/5.0 ({{ $instructorReviewsCount. ' '. ($instructorReviewsCount > 1 ? __('courses::courses.reviews') : __('courses::courses.review')) }} )</em></span>
                                                </div>
                                            </li>
                                        @endif
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon">
                                                <i class="am-icon-user-group"></i>
                                            </div>
                                            <span>{{ number_format($course->active_students_count) }}
                                                <em>
                                                    {{ $course->active_students_count == 1 ? __('courses::courses.active_student') : __('courses::courses.active_students') }}
                                                </em>
                                            </span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none"><g opacity="0.7"><path d="M9 16.5C13.1421 16.5 16.5 13.1421 16.5 9C16.5 4.85786 13.1421 1.5 9 1.5C4.85786 1.5 1.5 4.85786 1.5 9C1.5 13.1421 4.85786 16.5 9 16.5ZM7.18201 7.23984C7.18201 6.4545 8.04578 5.97564 8.71184 6.39173L11.5295 8.15195C12.1564 8.54359 12.1564 9.45654 11.5295 9.84817L8.71184 11.6084C8.04578 12.0245 7.18201 11.5456 7.18201 10.7603V7.23984Z" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></g></svg>
                                            </div>
                                            <span> {{ number_format( $this->instructorCoursesCount ) }} <em>{{ $this->instructorCoursesCount == 1 ? __('courses::courses.course') : __('courses::courses.courses') }}</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon">
                                                <i class="am-icon-megaphone-01"></i>
                                            </div>
                                            <span> <em>{{ __('courses::courses.i_can_speak') }}</em></span>
                                        </div>
                                        @if(!empty($course->instructor->languages))
                                        <div class="am-tutorreview-item">
                                            <div class="wa-tags-list">
                                                <ul x-data="{ open: false }">
                                                    @if (!empty($course->instructor->profile?->native_language))
                                                        <li>
                                                            <span>
                                                                {{ ucfirst($course->instructor->profile->native_language) }}
                                                                <em>{{ __('courses::courses.native') }}</em>
                                                            </span>
                                                        </li>
                                                    @endif

                                                    @foreach ($course->instructor->languages as $index => $language)
                                                        @if ($index < 2)
                                                            <li><span>{{ ucfirst($language->name) }}</span></li>
                                                        @else
                                                            <li x-show="open"><span>{{ ucfirst($language->name) }}</span></li>
                                                        @endif
                                                    @endforeach

                                                    @if ($course->instructor->languages->count() > 2)
                                                        <li>
                                                            <a href="javascript:void(0);" @click="open = !open">
                                                                <span x-show="!open">
                                                                    +{{ $course->instructor->languages->count() - 2 }} {{ __('courses::courses.more') }}
                                                                </span>
                                                                <span x-show="open">
                                                                    {{ __('courses::courses.show_less') }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    </li>
                                </ul>
                                @if( !empty($course->instructor?->profile?->description))
                                    <p class="cr-instructor-bio">   
                                        {{ Str::words(strip_tags($course->instructor?->profile?->description), 50) }}
                                    </p>
                                @endif
                                <div class="cr-profile-footer">
                                    @if(!empty($course->instructor?->socialProfiles) && $course->instructor?->socialProfiles->isNotEmpty())
                                        <ul class="cr-social-icons">
                                            @php
                                                $validProfiles = $course->instructor?->socialProfiles->filter(function($profile) {
                                                    return !empty($profile->url);
                                                })->take(4);
                                            @endphp
                                            @foreach ($validProfiles as $socialProfile)
                                                <li>
                                                    <a href="{{ $socialProfile->url }}" target="_blank">
                                                        @if($socialProfile->type == 'Pinterest')
                                                            <x-courses::icons.pinterest />
                                                        @else
                                                            <i class="{{ $socialIcons[$socialProfile->type] }}"></i>
                                                        @endif
                                                        <span class="am-tooltip-text">
                                                            <span>{{ $socialProfile->type }}</span>
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    <a href="{{ route('tutor-detail', ['slug' => $course->instructor?->profile->slug]) }}">
                                        <button class="cr-view-profile-btn">{{ __('courses::courses.view_profile') }}</button>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cr-sharemodal modal fade" id="cr-sharemodal" tabindex="-1" aria-labelledby="shareModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="am-modal-header">
                    <h2 id="shareModalLabel">{{ __('courses::courses.share_this_course') }}</h2>
                    <span class="am-closepopup" data-bs-dismiss="modal"><i class="am-icon-multiply-01"></i></span>
                </div>
                <div class="am-modal-body">
                    <div class="am-share-link" x-data="{copied: false, textToCopy: '{{ route('courses.course-detail', ['slug' => $course->slug]) }}'}">
                        <label>{{ __('courses::courses.url') }}</label>
                        <div class="cr-copy-link">
                            <input type="text" disabled class="form-control" readonly value="{{ route('courses.course-detail', ['slug' => $course->slug]) }}">
                            <button @click="navigator.clipboard.writeText(textToCopy).then(() => { copied = true; setTimeout(() => copied = false, 1000) }).catch(() => {})" class="cr-btncopy">
                                <i class="am-icon-copy-01"></i>
                                <template x-if="copied">
                                    <span class="am-tooltip-text" x-bind:class="{ 'am-tooltip-text-enable': copied }" x-show="copied" x-transition>{{ __('general.copied') }}</span>
                                </template>
                            </button>
                        </div>
                    </div>
                    <div class="cr-share-icons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('courses.course-detail', ['slug' => $course->slug])) }}" 
                        target="_blank" 
                        class="cr-facebook">
                            <img src="{{ asset('modules/courses/images/icons-images/fb.png') }}" alt="Facebook">
                            <span>{{ __('courses::courses.facebook') }}</span>
                        </a>

                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('courses.course-detail', ['slug' => $course->slug])) }}&text={{ urlencode($course->title) }}" 
                        target="_blank"
                        class="cr-twitter">
                            <img src="{{ asset('modules/courses/images/icons-images/twitter.png') }}" alt="twitter">
                            <span>{{ __('courses::courses.twitter') }}</span>
                        </a>

                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('courses.course-detail', ['slug' => $course->slug])) }}&title={{ urlencode($course->title) }}" 
                        target="_blank"
                        class="cr-linkedin">
                            <img src="{{ asset('modules/courses/images/icons-images/linkedin.png') }}" alt="LinkedIn">
                            <span>{{ __('courses::courses.linkedin') }}</span>
                        </a>

                        <a href="https://wa.me/?text={{ urlencode($course->title . ' ' . route('courses.course-detail', ['slug' => $course->slug])) }}"
                        target="_blank" 
                        class="cr-instagaram">
                            <img src="{{ asset('modules/courses/images/icons-images/insta.png') }}" alt="instagaram">
                            <span>{{ __('courses::courses.instagaram') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(isActiveModule('quiz'))
        <div class="modal fade am-complete-popup am-successfully-popup" id="course_completed_popup" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="am-modal-body">
                        <span data-bs-dismiss="modal" class="am-closepopup">
                            <i class="am-icon-multiply-01"></i>
                        </span>
                        <div class="am-deletepopup_icon confirm-icon">
                            <span>
                                <i class="am-icon-check-circle06"></i>
                            </span>
                        </div>
                        <div class="am-successfully_title">
                            <h3>{{__('courses::courses.course_completed_heading')}}</h3>
                            <p>{{__('courses::courses.course_completed_para')}}</p>
                            <a href="{{ route('quiz.student.quizzes') }}" class="am-btn">{{__('courses::courses.view_quizzes')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @vite([
        'public/css/videojs.css',
        'public/css/flags.css',
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('modules/courses/js/nouislider.min.js')}}"></script>
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script src="https://www.youtube.com/iframe_api"></script>
    <script src="https://player.vimeo.com/api/player.js"></script>

    <script>
        document.addEventListener('contextmenu', event => event.preventDefault()); 
        document.addEventListener('keydown', function(event) { 
            if (event.key === "F12" || 
                (event.ctrlKey && event.shiftKey && (event.key === "I" || event.key === "J" || event.key === "C")) || 
                (event.ctrlKey && event.key === "U")) {
                event.preventDefault();
            }
            if ((event.metaKey && event.altKey && (event.key === "I" || event.key === "J" || event.key === "C")) ||
                (event.metaKey && event.key === "U")) {
                event.preventDefault();
            }
        });
        setInterval(() => {
            (function() {
                console.log = console.warn = console.error = () => { return false; };
            })();
        }, 1000);
        
        function showNextItemContent (){
            $('.cr-next-curriculum').removeClass('d-none');
        }

        // document.addEventListener('livewire:initialized', () => {
        //     Livewire.on('openModal', (modalId) => {
        //         let modal = new bootstrap.Modal();
        //         modal.show();
        //     });
        // });
        function initializeVideoPlayer(videoElement, courseId) {
            
            if (!videoElement.player) {
                let player = videojs(videoElement, {
                    controls: true,
                    autoplay: false,
                    playbackRates: [0.5, 1, 1.5, 2]
                });
                videoElement.player = player;
                
                player.on('loadstart', function() {
                    player.addClass('vjs-waiting');
                    $(`#cr-card-skeleton-${courseId}`).remove();
                    player.removeClass('d-none');
                });
                
                player.on('loadeddata', function() {
                    player.removeClass('vjs-waiting');
                    player.removeClass('d-none');
                    $(`#cr-card-skeleton-${courseId}`)?.remove();
                });
                
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
            }
        }

        function updateWatchtime(curriculumId) {
            let video = document.getElementById("video-"+curriculumId+"_html5_api");
            let interval;
            if (video.duration <= 60) {
                video.addEventListener('ended', function() {
                    let role = @js(auth()->user()->role);
                    if(role == 'student'){
                        @this.call('updateWatchtime', true);
                    }
                    showNextItemContent()
                });
            } else {
                interval = setInterval(function() {
                    if (!video.paused) {
                        let role = @js(auth()->user()->role);
                        if(role == 'student'){
                            @this.call('updateWatchtime');
                        }
                    }
                }, 60000);
                video.addEventListener('ended', function() {
                    let role = @js(auth()->user()->role);
                    if(role == 'student'){
                        @this.call('updateWatchtime', true);
                    }
                    showNextItemContent();
                    clearInterval(interval);
                });
            }
            video.addEventListener('unload', function() {
                if (interval) {
                    clearInterval(interval);
                }
            });
        }

        document.addEventListener("DOMContentLoaded", (event) => {
            jQuery(document).on('click', '.cr-sidebar_toggle', function() {
            jQuery('.cr-sidebar').toggleClass('cr-togglesidebar');
            });
            jQuery(document).on('click', '.cr-sidebar_toggle', function() {
            jQuery('.cr-coursesdetails').toggleClass('cr-coursesdetails_fullwidth');
            });
        });
        
    </script>
@endpush

