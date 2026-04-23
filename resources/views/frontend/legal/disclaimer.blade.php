@extends('layouts.frontend-app')
@section('content')
<div class="am-disclaimer-area am-section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="am-legal-content">
                    <h1>{{ __('Disclaimer') }}</h1>
                    <div class="am-legal-text mt-4">
                        <p>{{ __('The Learning Line Academy provides training and educational services only. The content shared through courses, videos, or materials does not constitute legal, regulatory, or professional advice. Participants are advised to apply learning based on their organizational policies and applicable laws. The Academy shall not be liable for any decisions taken based on the training content.') }}</p>
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
</style>
@endpush
