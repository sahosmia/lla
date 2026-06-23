<div class="tc-browse-trainings-section am-section-load">
    <div class="container">
        <div class="am-title_wrap mb-4">
            <h2 class="section-main-title">{{ __('trainingcalendar::trainingcalendar.browse_trainings') }}</h2>
        </div>
        
        <div class="filter-search-wrapper row g-3 mb-4">
            <div class="col-md-8 col-lg-6">
                <div class="search-input-box">
                    <i class="am-icon-search search-icon"></i>
                    <input type="text" class="form-control modern-filter-input icon-padding" wire:model.live.debounce.400ms="keyword" placeholder="{{ __('general.search') }}...">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <select class="form-select modern-filter-select" wire:model.live="type">
                    <option value="">{{ __('trainingcalendar::trainingcalendar.type') }}</option>
                    <option value="online">{{ __('trainingcalendar::trainingcalendar.online') }}</option>
                    <option value="offline">{{ __('trainingcalendar::trainingcalendar.offline') }}</option>
                </select>
            </div>
        </div>

        <div class="row g-4">
            @forelse($trainings as $training)
                <div class="col-md-6 col-lg-4">
                    <div class="modern-training-card h-100">
                        <div class="card-body-content">
                            <div class="card-top-meta">
                                <span class="am-coursetag detail-tag-{{ $training->type }}">
                                    {{ ucfirst($training->type) }}
                                </span>
                                <span class="registered-badge">
                                    <i class="am-icon-user-01"></i> {{ $training->paid_registrations_count }} Joined
                                </span>
                            </div>

                            <h4 class="training-card-title">
                                <a href="{{ route('trainingcalendar.detail', $training->slug) }}">
                                    {{ $training->title }}
                                </a>
                            </h4>
                            
                            @if(isset($training->tutor->profile))
                                <div class="card-tutor-profile d-flex align-items-center mb-3">
                                    @if(!empty($training->tutor->profile->image))
                                        <img src="{{ asset('storage/' . $training->tutor->profile->image) }}" alt="Tutor" class="tutor-avatar-img me-2">
                                    @else
                                        <div class="tutor-avatar-placeholder me-2">
                                            {{ substr($training->tutor->profile->first_name ?? 'T', 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="tutor-info-text">
                                        <small class="text-muted d-block" style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Trainer</small>
                                        <span class="tutor-name-txt">{{ ($training->tutor->profile->first_name ?? '') . ' ' . ($training->tutor->profile->last_name ?? '') }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="training-card-meta-list">
                                <div class="meta-item">
                                    <i class="am-icon-calender-day"></i>
                                    <span>{{ $training->event_datetime?->format('M d, Y • h:i A') }}</span>
                                </div>
                                <div class="meta-item price-item">
                                    <i class="am-icon-layer-01"></i>
                                    <span class="card-price-amount">{!! formatAmount($training->price, true) !!}</span>
                                </div>
                            </div>
                            
                            <div class="card-action-area">
                                <a href="{{ route('trainingcalendar.detail', $training->slug) }}" class="modern-card-btn">
                                    {{ __('general.view') }}
                                    <i class="am-icon-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="no-data-wrapper text-center py-5">
                        <span class="text-muted">{{ __('trainingcalendar::trainingcalendar.no_trainings') }}</span>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $trainings->links('pagination.custom') }}
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --primary-brand: #4f46e5;
        --primary-hover: #4338ca;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --border-color: #f1f5f9;
    }

    .tc-browse-trainings-section {
        padding: 60px 0;
        background-color: #f8fafc;
    }

    .section-main-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--slate-900);
    }

    /* ফিল্টার অ্যান্ড কাস্টম ইনপুট */
    .modern-filter-input, 
    .modern-filter-select {
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background-color: #ffffff;
    }

    .modern-filter-input:focus, 
    .modern-filter-select:focus {
        border-color: var(--primary-brand);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .search-input-box {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--slate-500);
        font-size: 1.1rem;
    }

    .icon-padding {
        padding-left: 42px !important;
    }

    /* প্রিমিয়াম ট্রেনিং কার্ড */
    .modern-training-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }

    .modern-training-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        border-color: #e2e8f0;
    }

    .card-body-content {
        padding: 28px;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-top-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .registered-badge {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--slate-500);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .training-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 16px;
    }

    .training-card-title a {
        color: var(--slate-900);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .modern-training-card:hover .training-card-title a {
        color: var(--primary-brand);
    }

    /* কার্ড মেটা লিস্ট */
    .training-card-meta-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
        margin-top: auto; /* বাটন সবসময় কার্ডের নিচে পুশ করবে */
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--slate-700);
        font-size: 0.92rem;
    }

    .meta-item i {
        color: var(--primary-brand);
        font-size: 1rem;
        width: 16px;
    }

    .card-price-amount {
        font-weight: 700;
        color: var(--slate-900);
    }

    /* অ্যাকশন বাটন */
    .card-action-area {
        margin-top: 8px;
    }

    .modern-card-btn {
        width: 100%;
        background: #f1f5f9;
        color: var(--slate-700) !important;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.95rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .modern-training-card:hover .modern-card-btn {
        background: var(--primary-brand);
        color: #ffffff !important;
    }

    .modern-card-btn i {
        font-size: 0.9rem;
        transition: transform 0.2s ease;
    }

    .modern-card-btn:hover i {
        transform: translateX(4px);
    }

    /* কোর্স ট্যাগ */
    .am-coursetag {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-block;
    }
    .detail-tag-online { background: #e0f2fe; color: #0369a1; }
    .detail-tag-offline { background: #fef3c7; color: #92400e; }

    .no-data-wrapper {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .am-section-load {
    height: auto;
    }
    
    .card-tutor-profile img {
    width: 30px;
    border: 1px solid;
    border-radius: 50px;
}
</style>
@endpush