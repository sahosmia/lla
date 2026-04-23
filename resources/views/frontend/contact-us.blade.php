@extends('layouts.frontend-app')
@section('content')
<div class="am-contact-us-area am-section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="am-contact-content">
                    <div class="am-section-title">
                        <h2>{{ __('Contact & Inquiry') }}</h2>
                        <p>{{ __('Get in Touch') }}</p>
                        <p>{{ __('For training inquiries, corporate programs, university collaboration, or general information, please contact us using the details below or submit the inquiry form.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-lg-4">
                <div class="am-contact-details">
                    <h3>{{ __('Contact Details') }}</h3>
                    <ul class="am-contact-list list-unstyled">
                        <li>
                            <strong>{{ __('Academy:') }}</strong> {{ __('The Learning Line Academy') }}
                        </li>
                        <li>
                            <strong>{{ __('Phone / WhatsApp:') }}</strong> <a href="tel:+8801742719724">+880 1742 719724</a>
                        </li>
                        <li>
                            <strong>{{ __('Email:') }}</strong> <a href="mailto:info@thelearninglineacademy.com">info@thelearninglineacademy.com</a>
                        </li>
                        <li>
                            <strong>{{ __('Mode:') }}</strong> {{ __('Online & Physical Training (as applicable)') }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="am-contact-form-wrapper">
                    <h3>{{ __('Inquiry Form') }}</h3>
                    <livewire:frontend.contact-form />
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
    .am-contact-details h3, .am-contact-form-wrapper h3 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
    }
    .am-contact-list li {
        margin-bottom: 15px;
        font-size: 16px;
    }
    .am-form-group {
        margin-bottom: 20px;
    }
    .am-form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
    }
</style>
@endpush
