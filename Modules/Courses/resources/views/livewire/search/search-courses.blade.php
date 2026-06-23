
<div class="cr-search-courses" wire:init="loadData">
    <div class="cr-courses-container">
        <div class="cr-searchhead">
            <ol class="am-breadcrumb">
                <li><a href="/" navigate="true">{{ __('courses::courses.home') }}</a></li>
                <li><em>/</em></li>
                <li class="active"><span>{{ __('courses::courses.search_courses') }}</span></li>
            </ol>
        </div>
        @if($tutor_id)
        <div class="am-resume_item am-resume_wrap">
            @if (!empty($user?->profile?->image) && Storage::disk(getStorageDisk())->exists($user?->profile?->image))
                <img src="{{ resizedImage($user?->profile?->image,50,50) }}" alt="{{$user?->profile?->image}}" />
            @else
                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 50, 50) }}" alt="{{ $user->profile->image }}" />
            @endif
            <div class="am-resume_content">
                <div class="am-resume_item_title">
                    <h3>{{$user?->profile?->full_name}}</h3>
                </div>
                <ul class="am-resume_item_info">
                    <li>
                        <span>
                            <i class="am-icon-book-1"></i>
                            {{ $user?->profile?->native_language }}
                        </span>
                    </li>
                    @if ($user?->address?->country?->short_code)
                    <li>
                        <span>
                            <span class="flag flag-{{ strtolower($user?->address?->country?->short_code) }}"></span>
                            {{ $user?->address?->country?->name}}
                        </span>
                    </li>
                    @endif
                    <li>
                        <span class="am-favrating">
                            <i class="am-icon-star-filled"></i>
                            <span class="am-uniqespace"><em>{{ number_format($user?->reviews_avg_rating, 1) }}</em>/5.0</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="am-itemdropdown">
                <span wire:click="closeTutorDetail" class="am-itemdropdown_btn">
                    <i class="am-icon-multiply-02"></i>
                </span>
            </div>
        </div>
        @endif
        <div class="cr-search-courses-area">
            <div class="cr-filters-sidebar-wapper">
                <div class="cr-filter-section">
                    <h2 class="cr-filter-title">{{ __('courses::courses.narrow_search') }}</h2>
                    @if ($showClearFilters)
                        <div class="cr-clear-filters" wire:click="resetFilters">
                            <span class="cr-clear-filters-text">
                                {{ __('courses::courses.clear_all_filters') }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M3.5 10.5L10.5 3.5M3.5 3.5L10.5 10.5" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="cr-filter-sidebar">
                    <div class="am-searchinput">
                        <input wire:model.live="filters.keyword" type="text" placeholder="{{ __('general.search_by_keyword') }}" class="form-control" id="keyword">
                        <span class="am-searchinput_icon">
                            <i class="am-icon-search-02"></i>
                        </span>
                    </div>
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        @if(!empty($categories))
                            <div class="accordion-item" wire:ignore>
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                        {{ __('courses::courses.category') }}
                                        <i class="am-icon-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">
                                        <div class="cr-filter-options">
                                            @foreach ($categories as $category)
                                                <div class="cr-filter-option" wire:ignore>
                                                    <input wire:model.live="searchCategories" type="checkbox" value="{{ $category->id }}" id="category-{{ $category->id }}" class="cr-checkbox" aria-label="{{ $category->name }}">
                                                    <label for="category-{{ $category->id }}" class="cr-option-details">
                                                        <span class="cr-option-label">{{ $category->name }}</span>
                                                    </label>
                                                    <span class="cr-option-count">({{ $category->active_courses_count }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!empty($ratingCounts) && is_array($ratingCounts))
                            <div class="accordion-item" wire:ignore>
                                <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">
                                        {{ __('courses::courses.ratings') }}
                                        <i class="am-icon-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                    <div class="accordion-body">
                                        <div class="cr-filter-options cr-rating-section">
                                            @foreach ($ratingCounts as $rating => $count)
                                            <div class="cr-filter-option">
                                                <input type="checkbox" id="rating-{{ $rating }}" class="cr-checkbox-input" wire:click="updateFiltersAvgRating({{ $rating }})" value="{{ $rating }}">
                                                <label for="rating-{{ $rating }}" class="cr-option-details">
                                                    <span class="cr-stars cr-{{ $rating }}star">
                                                        <i class="am-icon-star-01"></i>
                                                        <i class="am-icon-star-01"></i>
                                                        <i class="am-icon-star-01"></i>
                                                        <i class="am-icon-star-01"></i>
                                                        <i class="am-icon-star-01"></i>
                                                    </span>
                                                    <div class="cr-rating-stats">
                                                        <span class="cr-rating-value">{{ $rating }}</span>
                                                    </div>
                                                </label>
                                                <span class="cr-rating-count">({{ $count }})</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!empty($durationCounts ))
                            <div class="accordion-item" wire:ignore>
                                <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                        {{ __('courses::courses.course_duration') }}
                                        <i class="am-icon-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
                                    <div class="accordion-body">
                                        <div class="cr-filter-options">
                                            @foreach ($durationCounts as $duration => $count)
                                                <div class="cr-filter-option">
                                                    <input type="checkbox" id="duration-{{ $loop->index }}" class="cr-checkbox" aria-label="{{ $duration }}" wire:click="updateFiltersDuration({{ "'".Str::replace(' Hour', '', $duration)."'" }})" value="{{ Str::replace(' Hour', '', $duration) }}">
                                                    <label for="duration-{{ $loop->index }}" class="cr-option-details">
                                                        <span class="cr-option-label">{{ __('courses::courses.duration_hour', ['duration' => $duration]) }}</span>
                                                    </label>
                                                    <span class="cr-option-count">({{ number_format($count) }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif 
                        @if (!empty($levels))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="true" aria-controls="panelsStayOpen-collapseFour">
                                        {{ __('courses::courses.level') }}
                                        <i class="am-icon-chevron-down"></i>
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFour" wire:ignore>
                                    <div class="accordion-body">
                                        <div class="cr-filter-options">
                                            @foreach($levels as $name => $level)
                                                <div class="cr-filter-option">
                                                    <input type="checkbox" id="level-{{ $level['id'] }}" wire:model.live="filters.levels" value="{{ $level['name'] }}" class="cr-checkbox">
                                                    <label for="level-{{ $level['id'] }}" class="cr-option-details">
                                                        <span class="cr-level-name">{{ __('courses::courses.' . $name) }}</span>
                                                    </label>
                                                    <span class="cr-level-count">({{ $level['courses_count'] }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="accordion-item">
                            @if (isPaidSystem())
                                <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="true" aria-controls="panelsStayOpen-collapseFive">
                                        {{ __('courses::courses.price') }}
                                        <i class="am-icon-chevron-down"></i>
                                    </button>
                                </h2>
                            
                                <div wire:ignore id="panelsStayOpen-collapseFive" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingFive">
                                    <div class="accordion-body">
                                        <div class="cr-radio-options">
                                            <div class="cr-filter-option">
                                                <div class="am-radio">
                                                    <input wire:model.live="filters.pricing_type" type="radio" id="rf-all" name="price_type" value="all" checked>
                                                    <label for="rf-all">{{ __('courses::courses.all') }}</label>
                                                </div>
                                                <span class="cr-option-count">({{ number_format($totalCourses) }})</span>
                                            </div>
                                            <div class="cr-filter-option">
                                                <div class="am-radio">
                                                    <input wire:model.live="filters.pricing_type" type="radio" id="rf-paid" name="price_type" value="paid">
                                                    <label for="rf-paid">{{ __('courses::courses.paid') }}</label>
                                                </div>
                                                <span class="cr-option-count">({{ number_format($paidCourses) }})</span>
                                            </div>
                                            <div class="at-form-group cr-price-range">
                                                <div id="sliderrange" class="cr-slider-range"></div>
                                                <div class="cr-price-inputs">
                                                    <div class="cr-price-input">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path opacity="0.4" d="M4 10.6666C4 12.1393 5.19391 13.3333 6.66667 13.3333H9.67545C10.9593 13.3333 12 12.2925 12 11.0087C12 10.0081 11.3597 9.11983 10.4105 8.80343L5.58947 7.19641C4.64025 6.88 4 5.9917 4 4.99114C4 3.70732 5.04074 2.66659 6.32455 2.66659H9.33333C10.8061 2.66659 12 3.86049 12 5.33325M8 1.33325L8 14.6666" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        <input type="number" id="cr_min_price" value="100" aria-label="Minimum Price" min="0" max="1000" step="1">
                                                    </div>
                                                    <span class="cr-option-count">-</span>
                                                    <div class="cr-price-input">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path opacity="0.4" d="M4 10.6666C4 12.1393 5.19391 13.3333 6.66667 13.3333H9.67545C10.9593 13.3333 12 12.2925 12 11.0087C12 10.0081 11.3597 9.11983 10.4105 8.80343L5.58947 7.19641C4.64025 6.88 4 5.9917 4 4.99114C4 3.70732 5.04074 2.66659 6.32455 2.66659H9.33333C10.8061 2.66659 12 3.86049 12 5.33325M8 1.33325L8 14.6666" stroke="#585858" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                        <input type="number" id="cr_max_price" value="100" aria-label="Minimum Price" min="0" max="1000" step="1">
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if (!empty($languages))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="true" aria-controls="panelsStayOpen-collapseSix">
                                        {{ __('courses::courses.language') }}
                                        <i class="am-icon-chevron-down"></i>
                                    </button>
                                </h2>
                                <div wire:ignore id="panelsStayOpen-collapseSix" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingSix">
                                    <div class="accordion-body">
                                        <div class="cr-filter-options">
                                            @foreach ($languages as $language)
                                                <div class="cr-filter-option">
                                                    <input wire:model.live="searchLanguages" type="checkbox" value="{{ $language->id }}" id="language-{{ $language->id }}" class="cr-checkbox" aria-label="{{ $language->name }}">
                                                    <label for="language-{{ $language->id }}" class="cr-option-details">
                                                        <span class="cr-option-label">{{ $language->name }}</span>
                                                    </label>
                                                    <span class="cr-option-count">({{ number_format($language->active_courses_count) }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if ($showClearFilters)
                    <a wire:click="resetFilters" href="javascript:void(0);" class="cursor-pointer cr-clear-button">{{ __('courses::courses.clear_all_filters') }}</a>
                @endif
            </div>
            <div class="cr-search-results-wrapper">
                <div class="cr-search-results-container">
                    <div class="cr-results-summary">
                        @if($courses?->total() > 0)
                            @if($showClearFilters)
                                <span class="cr-results-text">{{ __('courses::courses.refined_results') }}</span>
                                <span class="cr-results-count">
                                    {{ $courses->total() < 10 ? str_pad($courses->total(), 2, '0', STR_PAD_LEFT) : number_format($courses->total()) }}
                                    {{ $courses->total() == 1 ? strtolower(__('courses::courses.course')) : strtolower(__('courses::courses.courses')) }}
                                </span>
                                <span class="cr-results-listing">{{ __('courses::courses.search_result_text') }}</span>
                            @else 
                                <span class="cr-results-count">{{ str_pad($courses->total(), 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="cr-results-listing">{{ $courses->total() == 1 ? __('courses::courses.course_available') : __('courses::courses.courses_available') }}</span>
                            @endif
                        @else
                            <span class="cr-results-text">{{ __('courses::courses.no_courses_found') }}</span>
                        @endif
                    </div>
                    <div class="cr-sorting-options">
                        <div class="at-form-group" wire:ignore>
                            <span class="cr-option-select">{{ __('courses::courses.sort_by') }}:</span>
                            <select class="am-select2" data-disable_onchange="false" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="filters.sort">
                                <option value="desc">{{ __('courses::courses.newest_first') }}</option>
                                <option value="asc">{{ __('courses::courses.oldest_first') }}</option>
                            </select>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M4 6L8 10L12 6" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                        @if(!empty($parPageList))
                            <div class="at-form-group" wire:ignore>
                                <span class="cr-option-select">{{ __('courses::courses.show_per_page') }}:</span>
                                <select class="am-select2" data-disable_onchange="false" data-componentid="@this" data-live="true" data-searchable="false" data-wiremodel="perPage">
                                    @foreach ($parPageList as $option)
                                        <option {{ $perPage == $option ? 'selected' : '' }} value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M4 6L8 10L12 6" stroke="#585858" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                @if($isLoading)
                    <div class="row">
                        @include('courses::skeletons.search-courses', ['total' => 6])
                    </div>
                @else
                    <div class="d-none row" wire:loading.class.remove="d-none" wire:target="updateFiltersAvgRating, perPage, searchCategories, searchLanguages, ratingCounts, durationCounts, priceTypeCounts, filters">
                        @include('courses::skeletons.search-courses',  ['total' => 6])
                    </div>
                    <div wire:loading.class="d-none" class="cr-search-list-container" wire:target="updateFiltersAvgRating, perPage, searchCategories, searchLanguages, ratingCounts, durationCounts, priceTypeCounts, filters">
                        @if ($courses->isNotEmpty())  
                            <div class="gy-4 row">
                                @foreach ($courses as $course)
                                    <div class="col-xs-12 col-sm-6 col-md-12 col-lg-6 col-xl-4 col-xxl-4">
                                        <div class="cr-card">
                                            <figure 
                                                class="cr-image-wrapper" 
                                                x-data="{ 
                                                    isOpen: false, 
                                                    videoUrl: '{{ !empty($course?->promotionalVideo?->path) ? url(Storage::url($course?->promotionalVideo?->path)) : '' }}',
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
                                                    <div class="cr-video-modal am-waiting">
                                                        <video
                                                            :id="'course-'+courseId"
                                                            onloadeddata="
                                                                let player = videojs(this); 
                                                                player.removeClass('d-none'); 
                                                                setTimeout(() => {
                                                                    player.play();
                                                                    let container = this.closest('.cr-video-modal');
                                                                    if (container) {
                                                                        container.classList.remove('am-waiting');
                                                                    }
                                                                }, 200);
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
                                                        <span class="am-loading-spinner"></span>
                                                    </div>
                                                </template>
                                                <template x-if="!isOpen">
                                                    <img height="200" width="360" src="{{ !empty($course->thumbnail->path) ? url(Storage::url($course->thumbnail->path)) : asset('modules/courses/images/course.png') }}" alt="{{ $course->title }}" class="cr-background-image" />
                                                </template>
                                                @if(!empty($course?->promotionalVideo?->path) && Storage::disk(getStorageDisk())->exists($course?->promotionalVideo?->path) )
                                                    <template x-if="!isOpen">
                                                        <figcaption>
                                                            @if (isPaidSystem() && !empty($course->pricing?->discount))
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
                                                                @if (!empty($course->instructor?->profile?->image) && Storage::disk(getStorageDisk())->exists($course->instructor?->profile?->image))
                                                                    <img src="{{ Storage::url($course->instructor?->profile?->image) }}" alt="{{ $course->instructor?->profile?->short_name }}" class="cr-instructor-avatar" />
                                                                @else
                                                                    <img src="{{ resizedImage('placeholder.png',42,42) }}" alt="{{ $course->instructor?->profile?->short_name }}" />
                                                                @endif
                                                                {{ $course->instructor?->profile?->short_name }}
                                                            </a>
                                                        </div>
                                                        <button wire:click="likeCourse({{ $course->id }})" @class(['cr-bookmark-button','cr-likedcard' => auth()->check() && collect($course->like_user_ids)->contains(auth()->id())]) aria-label="{{ __('courses::courses.like_this_course') }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="{{auth()->check() && collect($course->like_user_ids)->contains(auth()->id()) ? '#F63C3C' : 'none' }}">
                                                                <g opacity="1">
                                                                    <path opacity="1" d="M7.9987 14C8.66536 14 14.6654 10.6668 14.6654 6.00029C14.6654 3.66704 12.6654 2.02937 10.6654 2.00043C9.66537 1.98596 8.66536 2.33377 7.9987 3.33373C7.33203 2.33377 6.31473 2.00043 5.33203 2.00043C3.33203 2.00043 1.33203 3.66704 1.33203 6.00029C1.33203 10.6668 7.33204 14 7.9987 14Z" stroke="#F63C3C" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </g>
                                                            </svg>
                                                        </button>
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
                                                        @if (isPaidSystem() && !empty($course->pricing?->price) && !empty($course->pricing?->final_price) && $course->pricing?->price != 0.00 )
                                                            
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
                                    </div>
                                @endforeach
                                <!-- Repeat cards -->
                            </div>
                            {{ $courses->links('courses::pagination.pagination') }}
                        @else
                            <div class="cr-courses-emptycase">
                                <div class="cr-no-record-container">
                                    <figure>
                                        <img src="{{ asset('modules/courses/images/empty-view.png') }}" alt="empty-view">
                                    </figure>
                                    <h6>{{ __('courses::courses.no_courses_found_list') }}</h6>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('styles')
    <link rel="stylesheet" href="{{ asset('modules/courses/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/courses/css/nouislider.min.css') }}">
    @vite([
        'public/css/videojs.css',
        'public/css/flags.css',
    ])
@endpush

@push('scripts')
    <script defer src="{{ asset('modules/courses/js/nouislider.min.js')}}"></script>
    <script src="{{ asset('js/video.min.js') }}"></script>
    <script>
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
        var component = '';
        var slider = '';
        var player = null;

        document.addEventListener('livewire:navigated', function() {
            component = @this;
        },{ once: true });

        document.addEventListener('resetFilters', (event) => {
            resetFilters();
        });

        function resetFilters() {
            slider.noUiSlider.reset();
        }

        document.addEventListener('livewire:load', function () {
            function initializeSelect2() {
                $('.am-select2').select2();
            }

            initializeSelect2();

            Livewire.hook('message.processed', (message, component) => {
                initializeSelect2();
            });
        });

        document.addEventListener('loadPageJs', (event) => {
            setTimeout(function() {
                initPriceRange();
            }, 50);
        });

        function initPriceRange() {
            slider = document.getElementById('sliderrange');
            if (slider) {
                noUiSlider.create(slider, {
                    start: [0, 1000],
                    connect: true,
                    range: {
                        'min': 0,
                        'max': 1000
                    }
                });

                var minPriceInput = document.getElementById('cr_min_price');
                var maxPriceInput = document.getElementById('cr_max_price');

                slider.noUiSlider.on('update', function (values, handle) {
                    var value = values[handle];
                    if (handle) {
                        maxPriceInput.value = Math.round(value);
                    } else {
                        minPriceInput.value = Math.round(value);
                    }
                });

                slider.noUiSlider.on('change', function (values, handle) {
                    var minValue = Math.round(values[0]);
                    var maxValue = Math.round(values[1]);
                    component.set('filters.min_price', minValue);
                    component.set('filters.max_price', maxValue);
                });

                minPriceInput.addEventListener('change', function () {
                    slider.noUiSlider.set([this.value, null]);
                });

                maxPriceInput.addEventListener('change', function () {
                    slider.noUiSlider.set([null, this.value]);
                });
            }
        }
    </script>
@endpush