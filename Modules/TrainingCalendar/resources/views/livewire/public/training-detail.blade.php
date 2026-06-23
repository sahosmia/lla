<div class="tc-training-detail am-section-load">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="tc-training-detail_content">
                    <span class="am-coursetag detail-tag-{{ $training->type }}">{{ ucfirst($training->type) }}</span>
                    <h1 class="tc-training-detail_title">{{ $training->title }}</h1>
                    
                    @if($training->description)
                        <div class="tc-training-detail_desc">
                            {!! nl2br(e($training->description)) !!}
                        </div>
                    @endif
                    
                    <div class="meta-section-divider"></div>
                    
                    <ul class="tc-training-detail_meta list-unstyled">
                        <li>
                            <div class="meta-icon-box"><i class="am-icon-calender-day"></i></div>
                            <div>
                                <small class="text-muted d-block">{{ __('trainingcalendar::trainingcalendar.event_datetime') }}</small>
                                <span>{{ $training->event_datetime?->format('M d, Y • h:i A') }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="meta-icon-box"><i class="am-icon-calender-day"></i></div>
                            <div>
                                <small class="text-muted d-block">{{ __('trainingcalendar::trainingcalendar.registration_deadline') }}</small>
                                <span>{{ $training->registration_deadline?->format('M d, Y • h:i A') }}</span>
                            </div>
                        </li>
                        @if($training->type === 'offline' && $training->venue)
                            <li>
                                <div class="meta-icon-box"><i class="am-icon-location"></i></div>
                                <div>
                                    <small class="text-muted d-block">{{ __('trainingcalendar::trainingcalendar.venue') }}</small>
                                    <span>{{ $training->venue }}</span>
                                </div>
                            </li>
                        @endif
                        <li>
                            <div class="meta-icon-box"><i class="am-icon-user-01"></i></div>
                            <div>
                                <small class="text-muted d-block">{{ __('trainingcalendar::trainingcalendar.tutor') }}</small>
                                <span>{{ $training->tutor?->profile?->full_name ?? 'Expert Trainer' }}</span>
                            </div>
                        </li>
                        <li>
                            <div class="meta-icon-box"><i class="am-icon-layer-01"></i></div>
                            <div>
                                <small class="text-muted d-block">{{ __('trainingcalendar::trainingcalendar.price') }}</small>
                                <span class="detail-price-amount">{!! formatAmount($training->price, true) !!}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="tc-training-detail_sidebar">
                    <div class="card tc-training-detail_card">
                        <div class="card-body p-4">
                            @if($alreadyRegistered)
                                <div class="modern-status-alert alert-success-custom">
                                    <i class="am-icon-check-circle"></i>
                                    <div>{{ __('trainingcalendar::trainingcalendar.already_registered') }}</div>
                                </div>
                            @elseif(!$training->isRegistrationOpen())
                                <div class="modern-status-alert alert-warning-custom">
                                    <i class="am-icon-clock"></i>
                                    <div>{{ __('trainingcalendar::trainingcalendar.registration_closed') }}</div>
                                </div>
                            @else
                                <h5 class="tc-training-detail_card_title">{{ __('trainingcalendar::trainingcalendar.register_now') }}</h5>
                                
                                @guest
                                    <div class="guest-login-notice">
                                        <span>{{ __('trainingcalendar::trainingcalendar.login_required') }}</span>
                                        <a href="{{ route('login') }}" class="modern-submit-btn text-center justify-content-center">
                                            {{ __('general.login') }}
                                        </a>
                                    </div>
                                @else
                                    <form wire:submit.prevent="register" class="tc-training-detail_form">
                                        <div class="form-group mb-3">
                                            <label class="modern-form-label">{{ __('trainingcalendar::trainingcalendar.name') }}</label>
                                            <input type="text" class="form-control modern-input" wire:model="name">
                                            @error('name') <span class="text-danger d-block mt-1 small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="modern-form-label">{{ __('trainingcalendar::trainingcalendar.email') }}</label>
                                            <input type="email" class="form-control modern-input" wire:model="email">
                                            @error('email') <span class="text-danger d-block mt-1 small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="modern-form-label">{{ __('trainingcalendar::trainingcalendar.phone') }}</label>
                                            <input type="text" class="form-control modern-input" wire:model="phone">
                                            @error('phone') <span class="text-danger d-block mt-1 small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="form-group mb-4">
                                            <label class="modern-form-label">{{ __('trainingcalendar::trainingcalendar.profession') }}</label>
                                            <input type="text" class="form-control modern-input" wire:model="profession">
                                            @error('profession') <span class="text-danger d-block mt-1 small">{{ $message }}</span> @enderror
                                        </div>
                                        
<button
    type="submit"
    class="modern-submit-btn"
    wire:loading.attr="disabled"
>
    <span class="btn-content-flex">
        {{ $training->isFree() ? __('trainingcalendar::trainingcalendar.register_free') : __('trainingcalendar::trainingcalendar.pay_and_register') }}
        <i class="am-icon-arrow-right"></i>
    </span>
</button>
                                    </form>
                                @endguest
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-brand: #4f46e5;
        --primary-hover: #4338ca;
        --slate-700: #334155;
        --slate-500: #64748b;
        --border-color: #f1f5f9;
    }

    .tc-training-detail {
        padding: 50px 0 80px;
        background-color: #f8fafc;
    }
    
    .tc-training-detail_content {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
    }
    
    .tc-training-detail_title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin: 16px 0 20px;
        line-height: 1.3;
    }
    
    .tc-training-detail_desc {
        color: var(--slate-700);
        margin-bottom: 30px;
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .meta-section-divider {
        height: 1px;
        border-top: 1px dashed #e2e8f0;
        margin: 30px 0;
    }
    
    /* মেটা লিস্ট গ্রিড স্টাইল */
    .tc-training-detail_meta {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    
    .tc-training-detail_meta li {
        display: flex;
        align-items: center;
        gap: 14px;
        color: #1e293b;
        font-size: 0.95rem;
    }
    
    .meta-icon-box {
        width: 42px;
        height: 42px;
        background: #f1f5f9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .meta-icon-box i {
        font-size: 1.1rem;
        color: var(--primary-brand);
    }

    .detail-price-amount {
        font-weight: 800;
        color: #0f172a;
        font-size: 1.1rem;
    }
    
    /* সাইডবার এবংカード */
    .tc-training-detail_sidebar {
        position: sticky;
        top: 40px;
        z-index: 10;
    }
    
    .tc-training-detail_card {
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
        background: #ffffff;
        overflow: hidden;
    }
    
    .tc-training-detail_card_title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #0f172a;
        margin-bottom: 24px;
    }

    /* ফর্ম কাস্টমাইজেশন */
    .modern-form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--slate-700);
        margin-bottom: 6px;
    }

    .modern-input {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .modern-input:focus {
        border-color: var(--primary-brand);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }

    /* মডার্ন বাটন স্টাইল */
    .modern-submit-btn {
        width: 100%;
        background: var(--primary-brand, #4f46e5);
        color: #ffffff !important;
        border: none;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-submit-btn:hover {
        background: var(--primary-hover);
    }

    .modern-submit-btn:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    /* ফ্লেক্সবক্স ওভাররাইড - যা লোডিং কালীন ডিজাইন ভাঙা আটকাবে */
    .btn-content-flex, 
    .btn-loading-flex {
        display: flex !important; 
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
    }

    /* কাস্টম অ্যালার্ট এবং নোটিশ */
    .modern-status-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .alert-success-custom { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .alert-warning-custom { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
    
    .guest-login-notice {
        background: #f8fafc;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        text-align: center;
    }
    
    .guest-login-notice p {
        color: var(--slate-700);
        font-size: 0.9rem;
        margin-bottom: 12px;
    }

    /* কোর্স ট্যাগ */
    .am-coursetag {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-block;
    }
    .detail-tag-online { background: #e0f2fe; color: #0369a1; }
    .detail-tag-offline { background: #fef3c7; color: #92400e; }
    
    /* স্পিনারের সাইজ ও আইকন কালার ফিক্স */
    .modern-submit-btn .spinner-border-sm {
        width: 1.1rem;
        height: 1.1rem;
        border-width: 0.2em;
    }
    .am-section-load p:before {
    content: "";
    width: 16px;
    height: 16px;
    border-radius: 50%;
    animation: 0.5s btnloader infinite linear;
    border: 2px solid rgba(88, 88, 88, 0.5);
    border-top-color: rgba(88, 88, 88, 0.1);
}
    
    .am-icon-arrow-right:before {
        color: #ffffff;
    }
    .am-section-load {
    
    height: auto;
}
</style>
@endpush