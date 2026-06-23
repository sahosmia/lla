
@if($trainings->isNotEmpty())
    <div class="row g-4"> 
        @foreach($trainings as $training)
            <div class="col-md-6 col-lg-4">
                <div class="modern-training-card">
                    
                

                    <div class="card-content-area">
                        <h3 class="training-title">
                            <a href="{{ route('trainingcalendar.detail', $training->slug) }}">{{ $training->title }}</a>
                        </h3>

                        <div class="training-meta-list">
                            <div class="meta-item">
                                <i class="am-icon-calender-day"></i>
                                <span>{{ $training->event_datetime?->format('M d, Y • h:i A') }}</span>
                            </div>
                            
                            @if($training->type === 'offline' && $training->venue)
                                <div class="meta-item venue-info" title="{{ $training->venue }}">
                                    <i class="am-icon-location"></i>
                                    <span>{{ Str::limit($training->venue, 35) }}</span>
                                </div>
                            @else
                                <div class="meta-item online-info">
                                    <i class="am-icon-globe"></i>
                                    <span>Live Virtual Session</span>
                                </div>
                            @endif
                            <div class="meta-item">
                                <span class="training-badge {{ $training->type === 'online' ? 'badge-online' : 'badge-offline' }}">
                            <span class="badge-dot"></span>
                            {{ ucfirst($training->type) }}
                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-action-footer">
                        <div class="price-section">
                            <!--<span class="price-label">Investment</span>-->
                            
                            <span class="price-amount">{!! $training->isFree() ? __('Free') : formatAmount($training->price, true) !!}</span>
                            <!--<span class="price-amount">{!! formatAmount($training->price, true) !!}</span>-->
                        </div>
                        <a href="{{ route('trainingcalendar.detail', $training->slug) }}" class="modern-action-btn">
                            {{ $training->isFree() ? __('Free Register') : __('Register Now') }}
                            <i class="am-icon-arrow-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
<style>
.modern-training-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-training-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    border-color: #e2e8f0;
}



.training-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.modern-training-card:hover .training-img {
    transform: scale(1.06);
}

.training-img-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #94a3b8;
    font-size: 2rem;
}

.training-badge {
    padding: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.badge-online {  color: #065f46; }
.badge-online .badge-dot { background: #10b981; }

.badge-offline {  color: #92400e; }
.badge-offline .badge-dot { background: #f59e0b; }

.card-content-area {
    padding: 20px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.training-title {
    font-size: 1.15rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 14px;
}

.training-title a {
    color: #1e293b;
    text-decoration: none;
    transition: color 0.2s ease;
}

.training-title a:hover {
    color: #4f46e5; 
}

.training-meta-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    border-top: 1px dashed #e2e8f0;
    padding-top: 12px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    font-size: 0.85rem;
}

.meta-item i {
    font-size: 1rem;
    color: #94a3b8;
}

.card-action-footer {
    padding: 16px 20px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.price-section {
    display: flex;
    flex-direction: column;
}


.price-amount {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
}

.modern-action-btn {
    background: #4f46e5; /* Primary Button Color */
    color: #ffffff !important;
    padding: 10px 18px;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background 0.2s ease;
}

.modern-action-btn:hover {
    background: #4338ca;
}

.modern-action-btn i {
    transition: transform 0.2s ease;
}
.am-icon-arrow-right:before{
    color: #fff;
}

.modern-action-btn:hover i {
    transform: translateX(4px);
}

.am-section_title.am-section_title_center {
    text-align: center;
    margin: 0 auto 50px;
}
</style>
    </div>

@endif