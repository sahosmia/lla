@extends('upcertify::layouts.app')

@push(config('upcertify.style_stack'))
    @if(config('upcertify.livewire_styles'))
        @livewireStyles()
    @endif
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/upcertify/css/fonts.css') }}">

    @if(!empty($body['fontFamilies']))
        @php
            $fontSet = $body['fontFamilies'];
            $families = collect($fontSet)->map(function($font) {
                return "family=" . urlencode($font) . ":ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900";
            })->join('&');
            $linkHref = "https://fonts.googleapis.com/css2?{$families}&display=swap";
        @endphp

        <link id="uc-custom-fonts" type="text/css" rel="stylesheet" href="{{ $linkHref }}">
    @endif
@endpush

@section(config('upcertify.content_yeild'))
    @php
        $certificateUrl = url()->current();
        $emailSubject = rawurlencode('Check Out My Certificate');
        $emailBody = rawurlencode("I wanted to share my recent achievement with you. You can view my certificate using the following link: $certificateUrl");
        $emailShareLink = "mailto:?subject={$emailSubject}&body={$emailBody}";
    @endphp
    <div class="uc-certificateprint">
        <x-upcertify::body :body="$body" :isPreview="true" />
        @if (request()->get('actions') != 'hide')
            <div class="uc-certificateprint_footer">
                <div class="uc-shareoptions">
                    <a href="javascript:void(0)" class="uc-share-btn">{{ __('upcertify::upcertify.share') }}</a>
                    <ul class="uc-shareoptions_list">
                        <li><a href="{{ $emailShareLink }}">{{ __('upcertify::upcertify.share_via_email') }}</a></li>
                        <li><a href="javascript:void(0);" onclick="copyLink()">{{ __('upcertify::upcertify.copy_link') }}</a></li>
                    </ul>
                </div>
                <a href="{{ route('upcertify.download', $uid) }}" class="uc-btn uc-download-btn">{{ __('upcertify::upcertify.download') }}<i><x-upcertify::icons.download /></i></a>
            </div>
        @endif
    </div>
@endsection

@push(config('upcertify.script_stack'))
    <script defer src="{{ asset('modules/upcertify/js/jquery.min.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            // Toggle share options list
            jQuery(document).on('click', '.uc-share-btn', function (e) {
                e.stopPropagation();
                jQuery('.uc-shareoptions_list').slideToggle();
            });

            // Close share options list when clicking outside
            jQuery(document).on('click', function (e) {
                if (!jQuery(e.target).closest('.uc-shareoptions').length) {
                    jQuery('.uc-shareoptions_list').slideUp();
                }
            });
        });
        
        function showToast(type, message) {
            // Create a new div element for the toast
            let toastDiv = document.createElement('div');
            toastDiv.className = `uc-toastr uc-toastr-show uc-toastr-${
                type === 'success' ? 'success' : 'alert'
            }`;

            // Create the icon SVG based on the type
            let icon =
                type === 'success'
                    ? '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 26 26" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.200195 13C0.200195 5.93071 5.93095 0.199951 13.0002 0.199951C20.0694 0.199951 25.8002 5.93071 25.8002 13C25.8002 20.0692 20.0694 25.8 13.0002 25.8C5.93095 25.8 0.200195 20.0692 0.200195 13ZM13.0002 1.79995C6.81461 1.79995 1.8002 6.81436 1.8002 13C1.8002 19.1855 6.81461 24.2 13.0002 24.2C19.1858 24.2 24.2002 19.1855 24.2002 13C24.2002 6.81436 19.1858 1.79995 13.0002 1.79995ZM19.6179 8.4572C19.93 8.76995 19.9294 9.27648 19.6167 9.58857L11.6452 17.5429C11.3327 17.8547 10.8266 17.8544 10.5145 17.5422L7.4497 14.4775C7.13728 14.1651 7.13728 13.6585 7.4497 13.3461C7.76212 13.0337 8.26865 13.0337 8.58107 13.3461L11.0808 15.8458L18.4865 8.45598C18.7993 8.1439 19.3058 8.14444 19.6179 8.4572Z" fill="#17B26A"/></svg>'
                    : '<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 16C1 7.71573 7.71573 1 16 1C24.2843 1 31 7.71573 31 16C31 24.2843 24.2843 31 16 31C7.71573 31 1 24.2843 1 16Z" stroke="#F04438" stroke-width="2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M9.41475 9.41475C9.63442 9.19508 9.99058 9.19508 10.2102 9.41475L16 15.2045L21.7898 9.41475C22.0094 9.19508 22.3656 9.19508 22.5852 9.41475C22.8049 9.63442 22.8049 9.99058 22.5852 10.2102L16.7955 16L22.5852 21.7898C22.8049 22.0094 22.8049 22.3656 22.5852 22.5852C22.3656 22.8049 22.0094 22.8049 21.7898 22.5852L16 16.7955L10.2102 22.5852C9.99058 22.8049 9.63442 22.8049 9.41475 22.5852C9.19508 22.3656 9.19508 22.0094 9.41475 21.7898L15.2045 16L9.41475 10.2102C9.19508 9.99058 9.19508 9.63442 9.41475 9.41475Z" fill="#F04438" stroke="#F04438" stroke-linecap="round" stroke-linejoin="round"/></svg>';

            // Set the inner HTML of the toast div
            toastDiv.innerHTML = `
                <i class="uc-toastr_icon">${icon}</i>
                <span class="uc-toastr_content">${message}</span>
            `;

            // Append the toast div to the body
            document.body.appendChild(toastDiv);

            // Remove the toast after 3 seconds
            setTimeout(function () {
                document.body.removeChild(toastDiv);
            }, 3000);
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            showToast('success', 'Link copied to clipboard');
        }

        function printCertificate() {
            var printContents = document.getElementById('uc-canvas-boundry').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
