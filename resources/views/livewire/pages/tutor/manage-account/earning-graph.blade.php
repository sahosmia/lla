<div class="am-dbbox">
    <div class="am-dbbox_title">
        <h2>{{ __('tutor.earning_details') }}</h2>
        <div class="am-dbbox_title_sorting">
            <em>{{ __('tutor.filter_by') }}</em>
            <div class="am-booking-calander-date flatpicker" wire:ignore>
                <input type="text" class="form-control" id="calendar-month-year">
            </div>
        </div>
    </div>
    <div class="am-dbbox_content" wire:ignore>
        <canvas id="am-themechart" width="400" height="200"></canvas>
    </div>
</div>
