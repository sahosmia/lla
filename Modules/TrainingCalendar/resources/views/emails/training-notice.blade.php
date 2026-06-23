<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $notice->subject }}</title>
</head>
<body>
    <p>Hello {{ $registration->name }},</p>
    <p><strong>{{ $training->title }}</strong></p>
    <p><strong>Event:</strong> {{ $training->event_datetime?->format('M d, Y h:i A') }}</p>
    @if($notice->message)
        <p>{!! nl2br(e($notice->message)) !!}</p>
    @endif
    @if($notice->zoom_link)
        <p><strong>Zoom:</strong> <a href="{{ $notice->zoom_link }}">{{ $notice->zoom_link }}</a></p>
    @endif
    @if($notice->meet_link)
        <p><strong>Google Meet:</strong> <a href="{{ $notice->meet_link }}">{{ $notice->meet_link }}</a></p>
    @endif
    @if($notice->location)
        <p><strong>Location:</strong> {{ $notice->location }}</p>
    @endif
</body>
</html>
