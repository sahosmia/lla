@extends('layouts.frontend-app')
@section('content')
<div class="am-privacy-policy-area am-section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="am-legal-content">
                    <h1>{{ __('Privacy Policy') }}</h1>
                    <div class="am-legal-text mt-4">
                        <p>{{ __('The Learning Line Academy is committed to protecting the privacy of its users.') }}</p>
                        <h3>{{ __('Privacy Policy Statement:') }}</h3>
                        <p>{{ __('We collect personal information such as name, email address, and contact number solely for communication, registration, and service delivery purposes. We do not sell, share, or disclose personal information to third parties except where required by law. By using this website, you consent to the collection and use of information in accordance with this policy.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .am-section-padding {
        padding: 80px 0;
    }
    .am-legal-content h1 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 30px;
    }
    .am-legal-content h3 {
        font-size: 24px;
        font-weight: 600;
        margin-top: 30px;
        margin-bottom: 15px;
    }
    .am-legal-text p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 15px;
    }
</style>
@endpush
