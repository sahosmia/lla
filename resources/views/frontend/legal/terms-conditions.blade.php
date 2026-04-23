@extends('layouts.frontend-app')
@section('content')
<div class="am-terms-conditions-area am-section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="am-legal-content">
                    <h1>{{ __('Terms & Conditions') }}</h1>
                    <div class="am-legal-text mt-4">
                        <p>{{ __('By accessing and using this website, you agree to the following terms:') }}</p>
                        <ul>
                            <li>{{ __('All content is for educational and training purposes only') }}</li>
                            <li>{{ __('Course schedules, fees, and formats may change without prior notice') }}</li>
                            <li>{{ __('Registration is subject to confirmation') }}</li>
                            <li>{{ __('Certificates are issued upon successful completion of applicable programs') }}</li>
                            <li>{{ __('Unauthorized copying or distribution of content is prohibited') }}</li>
                        </ul>
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
    .am-legal-text p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    .am-legal-text ul {
        padding-left: 20px;
    }
    .am-legal-text ul li {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 10px;
        list-style-type: disc;
    }
</style>
@endpush
