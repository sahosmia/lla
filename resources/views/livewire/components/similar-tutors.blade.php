<div class="am-similar-tutor">
    <div class="container">
        <div class="row">
            @if($similarTutors->isNotEmpty())
                <div class="col-12">
                    <div class="am-userinfomore_title">
                        <h3>{{ __('tutor.similar_tutors') }}</h3>
                    </div>
                    <ul class="am-similaruser-list">
                        @foreach ($similarTutors as $item)
                        <li>
                            <div class="am-similar-user">
                                <div class="am-tutordetail_user">
                                    <figure class="am-tutorvone_img">
                                        @if (!empty($item->profile?->image) && Storage::disk(getStorageDisk())->exists($item->profile?->image))
                                        <img src="{{ resizedImage($item->profile?->image,40,40) }}" alt="{{$item->profile?->image}}" />
                                        @else 
                                            <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40) }}" alt="{{ $item->profile?->image }}" />
                                        @endif
                                    </figure>
                                    <div class="am-tutordetail_user_name">
                                        <h3>
                                            <a href="{{ route('tutor-detail',['slug' => $item->profile->slug]) }}">{{ $item->profile->full_name }}</a>
                                            @if($item?->profile?->verified_at)
                                                <x-frontend.verified-tooltip />
                                            @endif
                                            @if ($item?->address?->country?->short_code)
                                                <span class="flag flag-{{ strtolower($item?->address?->country?->short_code) }}"></span>
                                            @endif
                                        </h3>
                                        <span>{{ $item?->profile->tagline }}</span>
                                    </div>
                                </div>
                                <ul class="am-tutorreviews-list">
                                    @if(isPaidSystem())
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <span class="am-uniqespace am-currency_conversion">{!! formatAmount($item->min_price) !!}<em>{{ __('tutor.session_text') }}</em></span>
                                            </div>
                                        </li>
                                    @endif
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon"><i class="am-icon-star-01"></i></div>
                                            <span class="am-uniqespace">{{ number_format($item->avg_rating, 1) }} <em>/5.0 ({{ $item->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $item->total_reviews] ) }})</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon"><i class="am-icon-user-group"></i></div>
                                            <span>{{$item->active_students}} <em>{{ $item->active_students == '1' ? __('tutor.active_student') : __('tutor.active_students', ['count' => $item->active_students ]) }}</em></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="am-tutorreview-item">
                                            <div class="am-tutorreview-item_icon"><i class="am-icon-menu-2"></i></div>
                                            @php
                                                $totalSessions = $item->subjects->flatMap(function ($subject) {
                                                    return $subject->slots;
                                                })->count();
                                            @endphp
                                            <span> {{ $totalSessions }} <em>{{ $totalSessions == 1 ? __('tutor.session') : __('tutor.sessions',) }}</em></span>
                                        </div>
                                    </li>
                                    @if(!empty($item?->languages))
                                        <li>
                                            <div class="am-tutorreview-item">
                                                <div class="am-tutorreview-item_icon"><i class="am-icon-language-1"></i></div>
                                                <div class="wa-tags-list">
                                                    @if(!empty($item?->languages))
                                                        <ul>
                                                            @if(!empty($item->profile->native_language))
                                                                <li><span>{{ ucfirst($item->profile->native_language)  }}</span></li>
                                                            @endif
                                                            @foreach ($item?->languages->slice(0, 3) as $lan)
                                                                <li><span>{{ ucfirst( $lan->name )}}</span></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                                @if($item?->languages?->count() > 3)
                                                    <div class="am-more am-custom-tooltip">
                                                        <span class="am-tooltip-text">
                                                            @foreach ($item?->languages->slice(3, $item?->languages?->count() - 1) as $lan)
                                                                <span>{{ ucfirst( $lan->name )}}</span>
                                                            @endforeach
                                                        </span>
                                                        +{{ $item?->languages?->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                                <div class="am-similaruser-btns">
                                    <div class="am-sendmessage-btn">
                                        @php
                                        $isFavourite = in_array($item->id, $favouriteTutors);
                                    @endphp
                                        <livewire:pages.tutor.action.action
                                        :tutor="$item"
                                        :isFavourite="$isFavourite"
                                        :wire:key="'tutor-action-'.$item->id"
                                                />
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="am-similaruser-btn">
                        <a href="{{ url('find-tutors') }}">
                            <button class="am-white-btn">{{ __('tutor.view_all_tutors') }}</button>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
