@if(!empty($bookings))
    <h3 style="font-size: 14px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('courses::courses.sessions_detail') }}</h3>
    <div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
        <table style="width: 100%;">
            <thead>
                <tr>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">
                    {{ 
                        $emailFor == 'tutor' 
                        ? (!empty(setting('_lernen.student_display_name')) ? setting('_lernen.student_display_name') : __('general.student')) 
                        : (!empty(setting('_lernen.tutor_display_name')) ? setting('_lernen.tutor_display_name') : __('general.tutor')) 
                    }}
                </th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('booking.subject') }}</th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('calendar.date_time') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        @php
                            $img  = $emailFor == 'student' ? $booking['tutorImg'] : $booking['studentImg'];
                            $name = $emailFor == 'student' ? $booking['tutorName'] : $booking['studentName'];
                        @endphp
                        <td style="display: flex; align-items:center; gap: 10px; padding: 10px 20px;">
                            @if (!empty($img) && Storage::disk(getStorageDisk())->exists($img))
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="{{ resizedImage($img, 40, 40) }}" alt="{{ $name }}">
                            @else 
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40) }}" alt="{{ $name }}">
                            @endif
                            <h6 style="font-size: 14px; font-weight: 400; color: #585858; line-height: 20px; margin: 0;">{{ $name }}</h6>
                        </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;">{!! $booking['subjectName'] !!} </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;">{!! $booking['sessionTime'] !!}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@if(!empty($courses))
<h3 style="font-size: 14px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('courses::courses.courses_detail') }}</h3>
    <div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
        <table style="width: 100%;">
            <thead>
                <tr>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ $emailFor == 'tutor' ? (setting('_lernen.student_display_name') ?? __('general.student')) : (setting('_lernen.tutor_display_name') ?? __('general.tutor')) }}</th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('courses::courses.course_title') }}</th>
                @if(isPaidSystem())
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('courses::courses.price') }}</th>
                @endif
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr>
                        @php
                            $img  = $emailFor == 'student' ? $course['tutorImg'] : $course['studentImg'];
                            $name = $emailFor == 'student' ? $course['tutorName'] : $course['studentName'];
                        @endphp
                        <td style="display: flex; align-items:center; gap: 10px; padding: 10px 20px;">
                            @if (!empty($img) && Storage::disk(getStorageDisk())->exists($img))
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="{{ resizedImage($img, 40, 40) }}" alt="{{ $name }}">
                            @else 
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 40, 40) }}" alt="{{ $name }}">
                            @endif
                            <h6 style="font-size: 14px; font-weight: 400; color: #585858; line-height: 20px; margin: 0;">{{ $name }}</h6>
                        </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;">{!! $course['courseTitle'] !!} </td>
                        @if(isPaidSystem())
                            <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;">{!! formatAmount($course['coursePrice']) !!}</span></td>    
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
@endif 
@if(!empty($subscriptions))
<h3 style="font-size: 14px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('subscriptions::subscription.subscriptions_detail') }}</h3>
    <div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('subscriptions::subscription.subscription') }}</th>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('subscriptions::subscription.price') }}</th>
                    <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('subscriptions::subscription.valid_till') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;">{!! $subscription['subscriptionName'] . ' (' . __('subscriptions::subscription.'.$subscription['subscriptionPeriod']) . ')' !!} </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;">{!! formatAmount($subscription['subscriptionPrice']) !!}</span></td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;">{!! Carbon\Carbon::parse($subscription['expires_at'])->format(setting('_general.date_format') ?? 'd M Y') !!}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>    
    </div>
@endif    