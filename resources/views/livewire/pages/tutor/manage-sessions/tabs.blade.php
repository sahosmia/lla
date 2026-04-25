
<ul class="am-userperinfo_tab">
    <li @class(['am-active'=> $activeRoute == 'tutor.bookings.subjects'])>
        <a href="{{ route('tutor.bookings.subjects') }}" wire:navigate.remove>
            {{__('subject.subject_title') }}
        </a>
    </li>
    <li @class(['am-active'=> in_array($activeRoute, ['tutor.bookings.manage-sessions','tutor.bookings.session-detail'])])>
        <a href="{{ route('tutor.bookings.manage-sessions') }}" wire:navigate.remove>
            {{__('calendar.title') }}
        </a>
    </li>
    <li @class(['am-active'=> $activeRoute == 'tutor.bookings.upcoming-bookings'])>
        <a href="{{ route('tutor.bookings.upcoming-bookings') }}" wire:navigate.remove>
            {{ __('calendar.upcoming_bookings') }}
        </a>
    </li>
</ul>
