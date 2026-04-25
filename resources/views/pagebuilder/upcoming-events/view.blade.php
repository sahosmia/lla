<section class="am-upcoming-events">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(!empty(pagesetting('pre_heading')) || !empty(pagesetting('heading')) || !empty(pagesetting('paragraph')))
                    <div class="am-section_title am-section_title_center">
                        @if(!empty(pagesetting('pre_heading')))
                            <span>{{ pagesetting('pre_heading') }}</span>
                        @endif
                        @if(!empty(pagesetting('heading')))
                            <h2>{!! pagesetting('heading') !!}</h2>
                        @endif
                        @if(!empty(pagesetting('paragraph')))
                            <p>{!! pagesetting('paragraph') !!}</p>
                        @endif
                    </div>
                @endif

                <livewire:upcoming-events :limit="pagesetting('events_limit') ?? 6" />
            </div>
        </div>
    </div>
</section>

@pushOnce('styles')
<style>
    .am-upcoming-events {
        padding: 80px 0;
        background: #f8f9fa;
    }
    .am-events-list {
        margin-top: 40px;
    }
    .am-event-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
        height: calc(100% - 30px);
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease;
    }
    .am-event-card:hover {
        transform: translateY(-5px);
    }
    .am-event-banner {
        position: relative;
        margin: 0;
        padding-top: 56.25%; /* 16:9 Aspect Ratio */
        overflow: hidden;
    }
    .am-event-banner img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .am-event-mode {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #f55c2b;
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .am-event-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .am-event-content h3 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #2b313c;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .am-event-details {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }
    .am-event-details li {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        color: #585d69;
        font-size: 14px;
    }
    .am-event-details li i {
        color: #f55c2b;
        font-size: 16px;
    }
    .am-event-btn {
        margin-top: auto;
        width: 100%;
        text-align: center;
        background: #2b313c;
        color: #fff;
        padding: 12px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: background 0.3s ease;
        border: none;
        cursor: pointer;
    }
    .am-event-btn:hover {
        background: #f55c2b;
        color: #fff;
    }
</style>
@endpushOnce
