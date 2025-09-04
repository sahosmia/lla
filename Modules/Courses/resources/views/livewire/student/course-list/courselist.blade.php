<div class="cr-allcourses" wire:init="loadCoursesData">
    <div class="cr-allcourses_title">
        <div>
            <h2>{{ __('courses::courses.all_courses_heading') }}</h2>
            <p>{{ __('courses::courses.course_sub_title') }}</p>
        </div>
        <div class="am-searchinput">
            <input type="text" wire:model.live.debounce.500ms="keyword" value="" placeholder="{{ __('courses::courses.search_by_keyword') }}" class="form-control" id="keyword">
            <span class="am-searchinput_icon">
                <i class="am-icon-search-02"></i>
            </span>
        </div>
    </div>
    <div class="cr-allcourses_list" wire:target="filters">
        @if($isLoading)
            @for ($i = 0; $i < 5; $i++)
                <div class="cr-card cr-card-skeleton">
                    <div class="cr-image-wrapper"></div>
                    <div class="cr-course-card">
                        <div class="cr-course-header">
                            <div class="cr-instructor-info">
                                <div class="cr-instructor-details">
                                    <div class="cr-instructor-name">
                                        <div class="cr-userimg"></div>
                                        <div class="cr-username"></div>
                                    </div>
                                </div>
                                <div class="cr-favrbtn"></div>
                            </div>
                            <div class="cr-course-title"></div>
                            <div class="cr-course-category"></div>
                        </div>
                        <div class="cr-usercourse_header_progress">
                            <span>
                                <div class="cr-progress-title"></div>
                                <div class="cr-progress-percentage"></div>
                            </span>
                            <div class="cr-usercourse_header_progress_bar"></div>
                        </div>
                        <div class="cr-cardbtn"></div>
                    </div>
                </div>
            @endfor
        @else
            @if ($courses->isNotEmpty())  
                @foreach ($courses as $data)
                    @php $course = $data->course; @endphp
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
                                    <video :id="'course-'+courseId" onloadeddata="let player = videojs(this); player.removeClass('d-none'); setTimeout(() => player.play(), 100);" class="d-none video-js vjs-default-skin d-none-playBtn" width="100%" height="100%" controls>
                                        <source :src="videoUrl" type="video/mp4" x-ref="video" >
                                    </video>
                                </div>
                            </template>
                            <template x-if="!isOpen">
                                <img height="200" width="360" src="{{ !empty($course->thumbnail->path) ? url(Storage::url($course->thumbnail->path)) : asset('modules/courses/images/course.png') }}" alt="{{ $course->title }}" class="cr-background-image" />
                            </template>
                            @if(!empty($course?->promotionalVideo?->path) && Storage::disk(getStorageDisk())->exists($course?->promotionalVideo?->path) )
                                <template x-if="!isOpen">
                                    <figcaption>
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
                                    
                                    <button wire:click="likeCourse({{ $course->id }})" @class(['cr-bookmark-button','cr-likedcard' => in_array($course->id, $favCourseIds) ]) aria-label="{{ __('courses::courses.like_this_course') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="{{ in_array($course->id, $favCourseIds) ? '#F63C3C' : 'none' }}">
                                            <g opacity="1">
                                                <path opacity="1" d="M7.9987 14C8.66536 14 14.6654 10.6668 14.6654 6.00029C14.6654 3.66704 12.6654 2.02937 10.6654 2.00043C9.66537 1.98596 8.66536 2.33377 7.9987 3.33373C7.33203 2.33377 6.31473 2.00043 5.33203 2.00043C3.33203 2.00043 1.33203 3.66704 1.33203 6.00029C1.33203 10.6668 7.33204 14 7.9987 14Z" stroke="#F63C3C" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"/>
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                                <div class="am-custom-tooltip">
                                    <a class="cr-course-title" href="{{ route('courses.course-detail', ['slug' => $course->slug]) }}">{{ html_entity_decode($course->title) }}</a>
                                </div>
                                <div class="cr-course-category">
                                    <span>{{ __('courses::courses.in') }}</span>
                                    <a href="javascript:void(0);" class="cr-category-link">{{ $course->category->name }}</a>
                                </div>
                            </div>
                            <div class="cr-usercourse_header_progress">
                                @php 
                                    $progress = 0;
                                    if(!empty($data->course_progress_sum_duration) && !empty($course->content_length)) {
                                        $progress = floor(($data->course_progress_sum_duration / $course->content_length) * 100);
                                    }
                                @endphp
                                <span>{{ __('courses::courses.course_progress') }}<em>{{ $progress }}%</em></span>
                                <div class="cr-usercourse_header_progress_bar">
                                    <div class="cr-usercourse_header_progress_bar_inner" style="width: {{ $progress }}%"> </div>
                                </div>
                            </div>
                            <a href={{ route('courses.course-taking', ['slug' => $course->slug]) }} class="cr-start-course">
                                {{ __('courses::courses.start_course') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="cr-courses-emptycase">
                    <div class="cr-no-record-container">
                        <figure>
                            <img src="{{ asset('modules/courses/images/empty-view.png') }}" alt="empty-view">
                        </figure>
                        <h6>{{ __('courses::courses.no_course_found') }}</h6>
                        <p>{{ __('courses::courses.no_course_found_desc') }}</p>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>


@push('styles')
<link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    @vite([
        'public/css/videojs.css',
        'public/css/flags.css',
    ])
@endpush

@push('scripts')
<script src="{{ asset('js/video.min.js') }}"></script>
<script type="text/javascript" data-navigate-once>
    document.addEventListener('loadPageJs', (event) => {
        setTimeout(function() {
            initPriceRange();
        }, 50);
    });
    function initializeVideoPlayer(videoElement, courseId) {
        if (!videoElement.player) {
            let player = videojs(videoElement);
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
</script>
@endpush
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
</script>
