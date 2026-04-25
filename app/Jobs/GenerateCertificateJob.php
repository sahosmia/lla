<?php

namespace App\Jobs;

use App\Services\BookingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new job instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $template_id = $this->booking->slot?->meta_data['template_id'] ?? null;
        $meeting_type = $this->booking->slot?->meta_data['meeting_type'] ?? '';
        $student_id = $this->booking?->booker?->id;
       
        $wildcard_data = [
            'tutor_name' => $this->booking?->bookee?->profile?->full_name ?? '',
            'student_name' => $this->booking?->booker?->profile?->full_name,
            'gender' => !empty($this->booking?->booker?->profile?->gender) ? ucfirst($this->booking?->booker?->profile?->gender) : '',
            'tutor_tagline' => $this->booking?->bookee?->profile?->tagline,
            'issued_by' => $this->booking?->bookee?->profile?->full_name,
            'platform_name' => setting('_general.site_name'),
            'platform_email' => setting('_general.site_email'),
            'meeting_platform' => $meeting_type,
            'subject_name' => $this->booking->orderItem->title,
            'subject_group_name' => $this->booking->orderItem->options['subject_group'] ?? '',
            'session_date' => $this->booking->slot->start_time->format('d-m-Y'),
            'session_time' => $this->booking->slot->start_time->format('h:i A'),
            'issue_date' =>  now()->format(setting('_general.date_format') ?? 'F j, Y'),
            'student_email' => $this->booking->booker->email,
            'tutor_email' => $this->booking->bookee->email,
            'session_fee' => $this->booking->slot->session_fee ? formatAmount($this->booking->slot->session_fee) : '',            
        ];

        generate_certificate(template_id: $template_id, generated_for_type: 'App\Models\User', generated_for_id: $student_id, wildcard_data: $wildcard_data);
    }
}
