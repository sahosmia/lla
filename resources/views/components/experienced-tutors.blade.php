<ul class="am-experience-tutor-list">
    @foreach ($experiencedTutors as $singleTutor)
        <li>
            <div class="am-experience-tutor-card">
                <div class="am-experience-tutor-img">
                    @if ($singleTutor?->profile?->image)    
                        <img src="{{ url(Storage::url($singleTutor?->profile?->image)) }}" alt="image-description">
                    @else
                        <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 34, 34) }}" alt="profile image" />
                    @endif
                    @guest
                        <span>
                            <i class="am-icon-heart-01" onclick="window.location.href='{{ route('login') }}'"></i>
                        </span>
                    @endguest
                    <a href="{{ route('login') }}">
                        <i class="am-icon-send-04"></i>
                    </a>
                </div>
                <div class="am-experience-tutor-info">
                    <div class="am-experience-tutor-name">
                        <div class="am-tutorsearch_user_name">
                            <h3>
                                {{ $singleTutor?->profile?->first_name }} {{ $singleTutor?->profile?->last_name }}
                                @if($singleTutor->profile->verified_at)
                                    <x-frontend.verified-tooltip />
                                @endif
                            </h3>
                        </div> 
                        @if ($singleTutor?->address?->country?->short_code)
                            <span class="flag flag-{{ strtolower($singleTutor?->address?->country?->short_code) }}"></span>
                        @endif
                    </div>
                    <ul class="am-tutorsearch_info">
                        @if(isPaidSystem())
                            <li>
                                <span class="am-currency_conversion">{!! formatAmount($singleTutor->min_price) !!}<em>{{ __('app.hr') }}</em></span>
                            </li>
                        @endif
                        <li>
                            <div class="am-tutorsearch_info_icon"><i class="am-icon-star-01"></i></div>
                            <span>{{ number_format($singleTutor->avg_rating, 1) }}<em>/5.0 ( {{ $singleTutor->total_reviews == 1 ? __('general.review_count') : __('general.reviews_count', ['count' => $singleTutor->total_reviews] ) }})</em></span>
                        </li>
                        <li>
                            <div class="am-tutorsearch_info_icon"><i class="am-icon-user-group"></i></div>
                            <span>{{ $singleTutor->active_students }} <em>{{ __('general.active_students') }}</em></span>
                        </li>
                    </ul>
                </div>
            </div>
        </li>  
    @endforeach
</ul>

@push('styles')
    @vite([
        'public/css/flags.css'
    ])
@endpush