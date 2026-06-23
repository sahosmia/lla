@extends('layouts.admin-app')

@section('content')
    <style>
        label,
        p {
            margin-bottom: 0px;
            padding: 0 2px
        }
        .flex{
            display: flex;
        }
    </style>
    <main class="tb-main am-dispute-system">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="tb-dhb-mainheading flex">
                    <h4> {{ __('Inquiry Details') }}</h4>
                        <a href="{{ route('admin.inquiries.index') }}" class="tb-btn">{{ __('Back to List') }}</a>
                </div>
                <div class="am-disputelist_wrap">
                    <div class="am-disputelist am-custom-scrollbar-y p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Full Name:') }}</strong></label>
                                    <p>{{ $inquiry->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Email Address:') }}</strong></label>
                                    <p>{{ $inquiry->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Contact Number:') }}</strong></label>
                                    <p>{{ $inquiry->phone }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Inquiry Type:') }}</strong></label>
                                    <p>{{ $inquiry->inquiry_type }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Organization/University:') }}</strong></label>
                                    <p>{{ $inquiry->organization ?: 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Designation:') }}</strong></label>
                                    <p>{{ $inquiry->designation ?: 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Message:') }}</strong></label>
                                    <div class="p-3">
                                        {!! nl2br(e($inquiry->message)) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="tb-label"><strong>{{ __('Received Date:') }}</strong></label>
                                    <p>{{ $inquiry->created_at->format('F d, Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="tb-btn tb-btn-primary bg-danger border-danger">{{ __('Delete Inquiry') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
