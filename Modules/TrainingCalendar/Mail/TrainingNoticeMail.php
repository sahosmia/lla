<?php

namespace Modules\TrainingCalendar\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\TrainingCalendar\Models\TrainingCalendar;
use Modules\TrainingCalendar\Models\TrainingNotice;
use Modules\TrainingCalendar\Models\TrainingRegistration;

class TrainingNoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TrainingCalendar $training,
        public TrainingNotice $notice,
        public TrainingRegistration $registration,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->notice->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'trainingcalendar::emails.training-notice',
        );
    }
}
