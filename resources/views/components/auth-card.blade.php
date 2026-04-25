<div class="am-main-login">
    <div class="am-auth-page">
        <div class="am-login-left">
            {{ $logo }}
            <div class="am-login-left_title">
                <h2>{{ __('auth.login_left_h2') }}</h2>
                <span>{{ __('auth.login_left_span') }}</span>
            </div>
            <div class="am-learning_video am-auth-video">
                <div class="am-learning_video_info" wire:ignore>
                    @if(!empty(setting('_general.auth_pages_video')))
                        <video class="video-js" data-setup='{}' preload="auto" wire:key="auth-video" id="auth-video" width="320" height="240" controls >
                            <source src="{{ url(Storage::url(setting('_general.auth_pages_video')[0]['path'])) }}#t=0.1" wire:key="auth-video-src" type="video/mp4" >
                        </video>
                    @endif
                </div>
                <div class="am-learning_video_tag">
                    <div class="am-learning_video_tag_talent">
                        <div>
                            <svg class="am-text-svg" viewBox="0 0 100 100">
                                <path id="circlePath" d="M 10, 50 a 40,40 0 1,1 80,0 40,40 0 1,1 -80,0"/>
                                <text>
                                    <textPath href="#circlePath">
                                        {{ __('auth.auth_slogan') }}
                                    </textPath>
                                </text>
                            </svg>
                            <span>
                                <svg width="73" height="74" viewBox="0 0 73 74" fill="none">
                                    <g filter="url(#filter0_d_4348_26461)">
                                        <path d="M36.2217 21.2363L39.9682 31.361L50.0928 35.1074L39.9682 38.8539L36.2217 48.9786L32.4752 38.8539L22.3506 35.1074L32.4752 31.361L36.2217 21.2363Z" fill="#F55C2B"/>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_4348_26461" x="0.156801" y="0.892025" width="72.1298" height="72.1298" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                        <feOffset dy="1.84948"/>
                                        <feGaussianBlur stdDeviation="11.0969"/>
                                        <feComposite in2="hardAlpha" operator="out"/>
                                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_4348_26461"/>
                                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_4348_26461" result="shape"/>
                                        </filter>
                                    </defs>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <p>{{ __('auth.auth_pages_left_desc') }}</p>
                </div>
                @if(!empty(setting('_general.auth_pages_image_1')))
                    <figure class="am-learning_video_tutors-img">
                        <img src="{{ url(Storage::url(setting('_general.auth_pages_image_1')[0]['path'])) }}" alt="image">
                    </figure>
                @endif
                @if(!empty(setting('_general.auth_pages_image_2')))
                    <figure class="am-learning_video_talents-img">
                        <img src="{{ url(Storage::url(setting('_general.auth_pages_image_2')[0]['path'])) }}" alt="image">
                    </figure>
                @endif
            </div>
        </div>
    </div>
    <div class="am-login-right">
        {{ $formHeader }}
        {{ $slot }}
    </div>
    <x-gdpr />
</div>
