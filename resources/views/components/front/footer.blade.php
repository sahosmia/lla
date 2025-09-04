@props(['page'=> null])
@php
    $footerVariations = setting('_front_page_settings.footer_variation_for_pages');
    $footerVariation  = '';
    if (!empty($footerVariations)) {
        foreach ($footerVariations as $key => $variation) {
           if($variation['page_id'] == $page?->id) {
                $footerVariation = $variation['footer_variation'];
                break;
           }
        }
    }
@endphp

@if($footerVariation != 'am-footer_three')
    <footer @class(['am-footer', $footerVariation])>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-footer_wrap">
                        <div class="am-footer_logoarea">
                            <strong class="am-flogo">
                                <x-application-logo :variation="'white'" />
                            </strong>
                            @if(!empty(setting('_front_page_settings.footer_paragraph')))
                                <p>{!! setting('_front_page_settings.footer_paragraph') !!}</p>
                            @endif
                            @if(
                                !empty(setting('_front_page_settings.footer_contact')) ||
                                !empty(setting('_front_page_settings.footer_email')) ||
                                !empty(setting('_front_page_settings.footer_address'))
                            )
                                <ul class="am-footer_contact">
                                    @if(!empty(setting('_front_page_settings.footer_contact')))
                                        <li>
                                            <a href="tel:{!! setting('_front_page_settings.footer_contact') !!}"><i class="am-icon-audio-03"></i>{!! setting('_front_page_settings.footer_contact') !!}</a>
                                        </li>
                                    @endif
                                    @if(!empty(setting('_front_page_settings.footer_email')))
                                        <li>
                                            <a href="mailto:hello@gmail.com"><i class="am-icon-email-01"></i>{!! setting('_front_page_settings.footer_email') !!}</a>
                                        </li>
                                    @endif
                                    @if(!empty(setting('_front_page_settings.footer_address')))
                                        <li>
                                            <address><i class="am-icon-location"></i>{!! setting('_front_page_settings.footer_address') !!}</address>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                            @if (
                                !empty( setting('_general.fb_link')) ||
                                !empty( setting('_general.insta_link')) ||
                                !empty(setting('_general.linkedin_link')) ||
                                !empty(setting('_general.yt_link')) ||
                                !empty(setting('_general.tiktok_link'))
                                )
                                <ul class="am-socialmedia">
                                    @if ( !empty( setting('_general.fb_link')))
                                        <li>
                                            <a href="{{ setting('_general.fb_link') }}">
                                                <i class="am-icon-facebook"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ( !empty( setting('_general.insta_link')))
                                        <li>
                                            <a href="{{ setting('_general.insta_link') }}">
                                                <i class="am-icon-instagram"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ( !empty( setting('_general.linkedin_link')))
                                        <li>
                                            <a href="{{ setting('_general.linkedin_link') }}">
                                                <i class="am-icon-linkedin"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ( !empty( setting('_general.yt_link')))
                                        <li>
                                            <a href="{{ setting('_general.yt_link') }}">
                                                <i class="am-icon-youtube"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ( !empty( setting('_general.tiktok_link')))
                                        <li>
                                            <a href="{{ setting('_general.tiktok_link') }}">
                                                <i class="am-icon-tiktok"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                             @if(!empty(setting('_front_page_settings.footer_button_text')))
                                <a 
                                    href="{{ !empty(setting('_front_page_settings.footer_button_url') && setting('_lernen.allow_register') !== 'no') ? url(setting('_front_page_settings.footer_button_url'))  : '#' }}"
                                    class="am-btn"
                                >
                                    {{ setting('_front_page_settings.footer_button_text') }}
                                </a>
                            @endif
                        </div>
                        <div class="am-fnavigation_wrap">
                            @if (getMenu('footer', 'Footer menu 1')->isNotEmpty())
                                <nav class="am-fnavigation">
                                    <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.quick_links_heading') }}</h3>
                                    </div>
                                    @if (!empty(getMenu('footer', 'Footer menu 1')))
                                    <ul>
                                        @foreach (getMenu('footer', 'Footer menu 1') as $item)
                                            <x-menu-item :menu="$item" />
                                        @endforeach
                                    </ul>
                                    @endif
                                </nav>
                            @endif
                            @if (getMenu('footer', 'Footer menu 2')->isNotEmpty())
                                <nav class="am-fnavigation">
                                     <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.tutors_by_country_heading') }}</h3>
                                    </div>
                                    @if (!empty(getMenu('footer', 'Footer menu 2')))
                                    <ul>
                                        @foreach (getMenu('footer', 'Footer menu 2') as $item)
                                            <x-menu-item :menu="$item" /> 
                                        @endforeach
                                    </ul>
                                    @endif
                                </nav>
                            @endif
                            @if (getMenu('footer', 'Footer menu 3')->isNotEmpty())
                                <nav class="am-fnavigation">
                                   <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.our_services_heading') }}</h3>
                                    </div>
                                    <ul>
                                        @if (!empty(getMenu('footer', 'Footer menu 3')))
                                            @foreach (getMenu('footer', 'Footer menu 3') as $item)
                                                <x-menu-item :menu="$item" /> 
                                            @endforeach
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                            
                            {{-- @if (getMenu('footer', 'Footer menu 4')->isNotEmpty())
                                <nav class="am-fnavigation">
                                   <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.one_on_one_sessions_heading') }}</h3>
                                    </div>
                                    <ul>
                                        @if (!empty(getMenu('footer', 'Footer menu 4')))
                                            @foreach (getMenu('footer', 'Footer menu 4') as $item)
                                                <x-menu-item :menu="$item" /> 
                                            @endforeach
                                        @endif
                                    </ul>
                                </nav>
                            @endif --}}
                            
{{--                             
                            @if (getMenu('footer', 'Footer menu 5')->isNotEmpty())
                               <nav class="am-fnavigation">
                                   <div class="am-fnavigation_title">
                                        <h3>{{ setting('_front_page_settings.group_sessions_heading') }}</h3>
                                    </div>
                                    <ul>
                                        @if (!empty(getMenu('footer', 'Footer menu 5')))
                                            @foreach (getMenu('footer', 'Footer menu 5') as $item)
                                                <x-menu-item :menu="$item" /> 
                                            @endforeach
                                        @endif
                                    </ul>
                                </nav>
                            @endif --}}
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="am-footer_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="am-footer_info">
                            <p>
                                {{ __('general.copyright_txt',['year' => date('Y')]) }}
                            </p>
                            <nav>
                                <ul>
                                    <li><a href="{{ url('terms-condition') }}">{{ __('general.terms_and_conditions') }}</a></li>
                                    <li><a href="{{ url('privacy-policy') }}">{{ __('general.privacy_policy') }}</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <a class="am-clicktop" href="#"><i class="am-icon-arrow-up"></i></a>
        </div>
    </footer>
@else
    <footer class="am-footer-v4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="am-footer-content">
                        @if(!empty(setting('_front_page_settings.footer_heading')))
                            <h2 data-aos="fade-up"  data-aos-duration="400" data-aos-easing="ease">{!! setting('_front_page_settings.footer_heading') !!}</h2>
                        @endif
                        @if(!empty(setting('_front_page_settings.footer3_paragraph')))
                            <p data-aos="fade-up"  data-aos-duration="500" data-aos-easing="ease">{!! setting('_front_page_settings.footer3_paragraph') !!}</p>
                        @endif
                        @if(!empty(setting('_front_page_settings.primary_button_url')) 
                            || !empty(setting('_front_page_settings.primary_button_text'))
                            || !empty(setting('_front_page_settings.secondary_button_url')) 
                            || !empty(setting('_front_page_settings.secondary_button_text')))
                            <div class="am-actions" data-aos="fade-up"  data-aos-duration="600" data-aos-easing="ease">
                                @if(!empty(setting('_front_page_settings.primary_button_url')) || !empty(setting('_front_page_settings.primary_button_text')))
                                    <a href="{!! setting('_front_page_settings.primary_button_url') !!}" class="am-getstarted-btn">{!! setting('_front_page_settings.primary_button_text') !!}</a>
                                @endif
                                @if(!empty(setting('_front_page_settings.secondary_button_url')) || !empty(setting('_front_page_settings.secondary_button_text')))
                                    <a href="{!! setting('_front_page_settings.secondary_button_url') !!}" class="am-outline-btn">{!! setting('_front_page_settings.secondary_button_text') !!}</a>
                                @endif
                            </div>
                        @endif
                        @if (getMenu('footer', 'Footer menu 6')->isNotEmpty())
                            @if (!empty(getMenu('footer', 'Footer menu 6')))
                                <ul class="am-footer-nav">
                                    @foreach (getMenu('footer', 'Footer menu 6') as $item)
                                        <x-menu-item :menu="$item" />
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if (!empty(setting('_front_page_settings.footer_background_image')))
            <img class="am-img" src="{{ url(Storage::url(setting('_front_page_settings.footer_background_image')[0]['path'])) }}" alt="image-description">
        @endif
    </footer>
@endif












 











