
<div class="am-reviews_section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-reviews_section_wrap">
                        <div class="am-reviews_title">
                            <h3>{{ __('tutor.student_reviews') }}</h3>
                        </div>
                        <div class="am-reviews_wrap">
                            <div class="am-reviews_sidebar">
                                <div class="am-reviews_sidebar_head">
                                    <strong>{{ number_format($tutorAvgRatings , 1) }}</strong>
                                    <div class="am-reviews_sidebar_stars">
                                        <span>
                                            @php
                                            $fullStars = floor($tutorAvgRatings);
                                            $halfStars = ($tutorAvgRatings - $fullStars >= 0.5) ? 1 : 0;
                                            $emptyStars = 5 - $fullStars - $halfStars;
                                            @endphp

                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="am-icon-star-filled"></i>
                                            @endfor

                                            @if ($halfStars)
                                                <i class="am-icon-star-filled am-icon-start-empty"></i>
                                            @endif

                                            @for ($i = 0; $i < $emptyStars; $i++)
                                                <i class="am-icon-star-filled am-icon-start-empty"></i>
                                            @endfor
                                        </span>
                                        <em>{{ __('tutor.based_on') }} <em>{{ $tutorReviewCount }}</em> {{ $tutorReviewCount == 1 ? __('tutor.rating') : __('tutor.ratings') }}</em>
                                    </div>
                                </div>
                                <ul class="am-reviews_ratio">
                                    @foreach ($tutorRatingsCount as $rating => $count)
                                        <li>
                                            <div class="am-reviews_ratio_title">
                                                <span>{{ $rating }}.0</span>
                                                <em>{{ $count }}</em>
                                            </div>
                                            <div class="am-progressbar">
                                                @php
                                                    $progressWidth = ($tutorReviewCount > 0) ? ($count / $tutorReviewCount) * 100 : 0;
                                                @endphp
                                                <span style="width: {{ $progressWidth }}%;"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @if ($allTutorRatings->count() > 0)
                                <div class="am-comments">
                                    <ul class="am-comments_list">
                                        @foreach ($allTutorRatings  as $review)
                                            <li>
                                                <div class="am-comments_user">
                                                    <figure class="am-comments_img">

                                                        @if (!empty($review?->profile?->image) && Storage::disk(getStorageDisk())->exists($review?->profile?->image))
                                                        <img src="{{ resizedImage($review->profile?->image,42,42) }}" alt="{{$review->profile?->image}}" />
                                                        @else 
                                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 42, 42) }}" alt="{{ $review->profile?->image }}" />
                                                        @endif
                                                    </figure>
                                                    <div class="am-comments_user_name">
                                                        <h4>{{ $review?->profile?->short_name }}
                                                            @if ($review?->profile?->user?->address?->country?->short_code)
                                                                <span class="flag flag-{{ strtolower($review->profile->user?->address?->country?->short_code) }}"></span>
                                                            @endif
                                                        </h4>
                                                        <span>{{$review?->created_at?->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="am-comment">
                                                    <div class="am-comment_rate">
                                                        <div class="am-comment_rate_stars">
                                                            <div class="am-comment_rate_stars">
                                                                @php
                                                                    $fullStars = floor($review?->rating);
                                                                    $halfStars = ($review?->rating - $fullStars >= 0.5) ? 1 : 0;
                                                                    $emptyStars = 5 - $fullStars - $halfStars;
                                                                @endphp

                                                                @for ($i = 0; $i < $fullStars; $i++)
                                                                    <i class="am-icon-star-filled"></i>
                                                                @endfor

                                                                @if ($halfStars)
                                                                    <i class="am-icon-star-filled am-icon-start-empty"></i>
                                                                @endif

                                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                                    <i class="am-icon-star-filled am-icon-start-empty"></i>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <span><em>{{ number_format($review?->rating, 1) }}</em>/5.0</span>
                                                    </div>
                                                    @php
                                                        $comment = strip_tags($review?->comment);
                                                        $shortComment = Str::limit($comment, 180, preserveWords: true);
                                                    @endphp
                                                    <div class="am-addmore" x-data="{ showMore: false }">
                                                        @if (Str::length($comment) > 180)
                                                            <p x-show="!showMore">
                                                                {{ $shortComment }}
                                                                    <a href="javascript:void(0);" @click="showMore = true">{{ __('general.show_more') }}</a>
                                                            </p>
                                                            <p x-show="showMore" x-cloak>
                                                                {{ $comment }}
                                                                <a href="javascript:void(0);" @click="showMore = false">{{ __('general.show_less') }}</a>
                                                            </p>
                                                        @else
                                                            <div class="full-description">
                                                                {!! $comment !!}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @if($allTutorRatings->total() > 1)
                                        <div class="am-pagination am-pagination_two">
                                            {{ $allTutorRatings->links('pagination.pagination', ['scrollTo' => '.am-reviews_section']) }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="am-norecord">
                                    <div class="am-norecord_content">
                                        <figure><img src="{{ asset('images/no-review.png') }}" alt="no record"></figure>
                                        <h5>{{ __('general.no_reviews_yet') }}</h5>
                                        <span>{{ __('general.no_records') }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
