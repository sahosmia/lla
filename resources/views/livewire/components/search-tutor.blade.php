
<div class="col-12 col-lg-8 col-xl-9" id="am-tutor_list" wire:init="loadPage" x-data="{
        message: @entangle('message'),
        recepientId: @entangle('recepientId'),
        charLeft:500,
        init(){
            this.updateCharLeft();
        },
        tutorInfo:{},
        updateCharLeft() {
            let maxLength = 500;
            let messageLength = this.message ? this.message.length : 0;
            if (messageLength ?? 0 > maxLength) {
                this.message = this.message.substring(0, maxLength);
            }
            this.charLeft = maxLength - messageLength ?? 0;
        }
    }">
    @if(empty($isLoadPage))
        <div>
            @include('skeletons.tutor-list')
        </div>
    @else
        <div class="d-none tutors-skeleton" wire:target="filters" wire:loading.class.remove="d-none">
            @include('skeletons.tutor-list')
        </div>
        <div wire:loading.class="d-none" wire:target="filters" class="am-tutorlist">
            @if($tutors->isNotEmpty())
                <div class="am-tutorsearch">
                    @foreach ($tutors as $tutor)
                        @php
                            $tutorInfo['name'] = $tutor->profile->full_name;
                            $tutorInfo['id'] = $tutor?->id;
                            if (!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image)) {
                                $tutorInfo['image'] = resizedImage($tutor->profile->image, 36, 36);
                            } else {
                                $tutorInfo['image'] = setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 36, 36);
                            }
                        @endphp
                        @if(!empty($tutor?->profile?->intro_video))
                            <div class="am-tutorsearch_card" id="profile-{{ $tutor->id }}">
                                <div class="am-tutorsearch_video">
                                    @if(!empty($tutor->profile->intro_video))
                                        <video class="video-js" data-setup='{}' preload="auto" wire:key="profile-video-{{ $tutor->id }}" id="profile-video-{{ $tutor->id }}" width="320" height="240" controls >
                                            <source src="{{ url(Storage::url($tutor->profile->intro_video)).'?key=profile-video'. $tutor->id }}#t=0.1" wire:key="profile-video-src-{{ $tutor->id }}" type="video/mp4" >
                                        </video>
                                    @endif
                                    <div class="am-tutorsearch_btns">
                                        <a href="{{ route('tutor-detail',['slug' => $tutor->profile->slug]).'#availability' }}" class="am-white-btn">{{ __('tutor.book_session') }}<i class="am-icon-calender-duration"></i></a>
                                        @if(Auth::check() && $allowFavAction)
                                            <a href="javascript:;" @click=" tutorInfo = @js($tutorInfo);threadId=''; recepientId=@js($tutor->id); $nextTick(() => $wire.dispatch('toggleModel', {id: 'message-model-'+@js($tutor->id),action:'show'}) )" class="am-btn">{{ __('tutor.send_message') }}<i class="am-icon-chat-03"></i></a>
                                            <a href="javascript:void(0);" id="toggleFavourite-{{ $tutor->id }}" wire:click.prevent="toggleFavourite({{ $tutor->id }})" @class(['am-likebtn', 'active' => in_array($tutor->id, $favouriteTutors)])> <i class="am-icon-heart-01"></i></a>
                                        @else
                                            <a href="javascript:void(0);"
                                            @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `{{ Auth::check() ?  __('general.not_allowed') : __('general.login_error') }}` })" class="am-btn">{{ __('tutor.send_message') }}<i class="am-icon-chat-03"></i></a>
                                            <a href="javascript:void(0);"
                                            @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `{{ Auth::check() ?  __('general.not_allowed') : __('general.login_error') }}` })" class="am-likebtn"><i class="am-icon-heart-01"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="am-tutorsearch_content">
                                    <div class="am-tutorsearch_head">
                                        <div class="am-tutorsearch_user">
                                            <figure class="am-tutorvone_img">
                                                @if(!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image))
                                                    <img src="{{ resizedImage($tutor->profile->image, 100, 100) }}" class="am-user_image" alt="{{$tutor->profile->full_name}}" />
                                                @else 
                                                    <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 100, 100) }}" alt="{{ $tutor->profile->full_name }}" />
                                                @endif
                                                <span @class(['am-userstaus', 'am-userstaus_online' => $tutor->is_online])></span>
                                            </figure>
                                            <div class="am-tutorsearch_user_name">
                                                <h3>
                                                    <a href="{{ route('tutor-detail',['slug' => $tutor->profile->slug]) }}">{{ $tutor->profile->full_name }}</a>
                                                    @if($tutor?->profile?->verified_at)
                                                        <x-frontend.verified-tooltip />
                                                    @endif
                                                    @if(!empty($tutor?->address?->country?->short_code))
                                                        <span class="flag flag-{{ strtolower($tutor?->address?->country?->short_code) }}"></span>
                                                    @endif
                                                </h3>
                                                @if($tutor->profile->tagline)
                                                    <span>
                                                        {!! $tutor->profile->tagline !!}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(isPaidSystem())
                                            <div class="am-tutorsearch_fee">
                                                <span>{{ __('tutor.session_fee') }}</span>
                                                <strong>{{ formatAmount($tutor->min_price) }}<em>/{{ __('tutor.session') }}</em></strong>
                                            </div>
                                        @endif
                                    </div>
                                    <ul class="am-tutorsearch_info">
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                                            <span>{{ number_format($tutor->avg_rating, 1) }}<em>/5.0 ({{ $tutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $tutor->total_reviews] ) }})</em></span>
                                        </li>
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                            <span>{{$tutor->active_students}} <em>{{ $tutor->active_students == '1' ? __('tutor.booked_session') : __('tutor.booked_sessions') }}</em></span>
                                        </li>
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-menu-2"></i></div>
                                            <span>{{$tutor->subjects->sum('sessions')}} <em>{{ $tutor->subjects->sum('sessions') == 1 ? __('tutor.session') : __('tutor.sessions') }}</em></span>
                                        </li>
                                        <li>
                                            <div class="am-tutorsearch_info_icon"><i class="am-icon-language-1"></i></div>
                                            <span> {{ __('tutor.language_know') }}</span>
                                            <div class="wa-tags-list">
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
                                    </ul>
                                    @if(!empty($tutor->profile->description))
                                        <div class="am-toggle-text">
                                            <div class="am-addmore">
                                                @php
                                                    $fullDescription  = strip_tags($tutor->profile->description);
                                                    $shortDescription = Str::limit($fullDescription, 220, preserveWords: true);
                                                @endphp
                                                @if (Str::length($fullDescription) > 220)
                                                    <div class="short-description">
                                                        {!! $shortDescription !!}
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
                        @else
                                <div class="am-tutorsearch_card am-tutorsearch_novideo" id="profile-{{ $tutor->id }}">
                                    <div class="am-tutorsearch_content">
                                        <div class="am-tutorsearch_head">
                                            <div class="am-tutorsearch_user">
                                                <figure class="am-tutorvone_img">
                                                    @if(!empty($tutor->profile->image) && Storage::disk(getStorageDisk())->exists($tutor->profile->image))
                                                        <img src="{{ resizedImage($tutor->profile->image, 50, 50) }}" class="am-user_image" alt="{{$tutor->profile->full_name}}" />
                                                    @else 
                                                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 50, 50) }}" alt="{{ $tutor->profile->full_name }}" />
                                                    @endif
                                                    <span @class(['am-userstaus', 'am-userstaus_online' => $tutor->is_online])></span>
                                                </figure>
                                                <div class="am-tutorsearch_user_name">
                                                    <h3>
                                                        <a href="{{ route('tutor-detail',['slug' => $tutor->profile->slug]) }}">{{ $tutor->profile->full_name }}</a>
                                                        @if($tutor?->profile?->verified_at)
                                                            <x-frontend.verified-tooltip />
                                                        @endif
                                                        @if(!empty($tutor?->address?->country?->short_code))
                                                            <span class="flag flag-{{ strtolower($tutor?->address?->country?->short_code) }}"></span>
                                                        @endif
                                                    </h3>
                                                    @if($tutor->profile->tagline)
                                                        <span>
                                                            {{ $tutor->profile->tagline }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(isPaidSystem())
                                                <div class="am-tutorsearch_fee">
                                                    <span>{{ __('tutor.session_fee') }}</span>
                                                    <strong>{{ formatAmount($tutor->min_price) }}<em>/{{ __('tutor.session') }}</em></strong>
                                                </div>
                                            @endif
                                        </div>
                                        <ul class="am-tutorsearch_info">
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                                                <span>{{ number_format($tutor->avg_rating, 1) }}<em>/5.0 ({{ $tutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $tutor->total_reviews] ) }})</em></span>
                                            </li>
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                                                <span>{{$tutor->active_students}} <em>{{ $tutor->active_students == '1' ? __('tutor.active_student') : __('tutor.active_students') }}</em></span>
                                            </li>
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-menu-2"></i></div>
                                                <span>{{$tutor->subjects->sum('sessions')}} <em>{{ $tutor->subjects->sum('sessions') == 1 ? __('tutor.session') : __('tutor.sessions') }}</em></span>
                                            </li>
                                            <li>
                                                <div class="am-tutorsearch_info_icon"><i class="am-icon-language-1"></i></div>
                                                <span> {{ __('tutor.language_know') }}</span>
                                                <div class="wa-tags-list">
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
                                        </ul>
                                        @if(!empty($tutor->profile->description))
                                            <div class="am-toggle-text">
                                                <div class="am-addmore">
                                                    @php
                                                        $fullDescription  = strip_tags($tutor->profile->description);
                                                        $shortDescription = Str::limit($fullDescription, 220, preserveWords: true);
                                                    @endphp
                                                    @if (Str::length($fullDescription) > 220)
                                                        <div class="short-description">
                                                            {!! $shortDescription !!}
                                                        </div>
                                                    @else
                                                        <div class="full-description">
                                                            {!! $fullDescription !!}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="am-tutorsearch_btns">
                                                    <a href="{{ route('tutor-detail',['slug' => $tutor->profile->slug]).'#availability' }}" class="am-white-btn">{{ __('tutor.book_session') }}<i class="am-icon-calender-duration"></i></a>
                                                    @if(Auth::check() && $allowFavAction)
                                                        <a href="javascript:;" @click=" tutorInfo = @js($tutorInfo);threadId=''; recepientId=@js($tutor->id); $nextTick(() => $wire.dispatch('toggleModel', {id: 'message-model-'+@js($tutor->id),action:'show'}) )" class="am-btn">{{ __('tutor.send_message') }}<i class="am-icon-chat-03"></i></a>
                                                        <a href="javascript:void(0);" id="toggleFavourite-{{ $tutor->id }}" wire:click.prevent="toggleFavourite({{ $tutor->id }})" @class(['am-likebtn', 'active' => in_array($tutor->id, $favouriteTutors)])> <i class="am-icon-heart-01"></i></a>
                                                    @else
                                                        <a href="javascript:void(0);"
                                                        @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `{{ Auth::check() ?  __('general.not_allowed') : __('general.login_error') }}` })" class="am-btn">{{ __('tutor.send_message') }}<i class="am-icon-chat-03"></i></a>
                                                        <a href="javascript:void(0);"
                                                        @click="$wire.dispatch('showAlertMessage', {type: `error`, message: `{{ Auth::check() ?  __('general.not_allowed') : __('general.login_error') }}` })" class="am-likebtn"><i class="am-icon-heart-01"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                        @endif
                    @endforeach
                    <div class="am-pagination am-pagination_two">
                        {{ $tutors->links('pagination.pagination', data:['scrollTo'=>false]) }}
                    </div>
                </div>
            @else
                <div class="am-norecord-found">
                    <figure>
                        <img src="{{ asset('images/subjects.png') }}" alt="no record">
                    </figure>   
                    <strong>{{ __('general.not_found') }}
                        <span>{{ __('general.not_found_desc') }}</span>
                    </strong>
                </div>
            @endif
        </div>
    @endif
    @include('livewire.pages.tutor.action.message')
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('toggleFavIcon', (event) => {
                $(`#toggleFavourite-${event.detail.userId}`).toggleClass('active');
            })
            document.addEventListener('initVideoJs', (event) => {
                setTimeout(() => {
                    jQuery('.video-js').each((index, item) => {
                        item.onloadeddata =  function(){
                            videojs(item);
                        }
                    })
                }, event.detail.timeout ?? 500);
            });
        });
    </script>
@endpush
