<?php

namespace App\Jobs;

use App\Services\BookingService;
use App\Services\GoogleCalender;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateGoogleCalendarEventJob implements ShouldQueue
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
        $eventResponse = (new GoogleCalender($this->booking->booker))->createEvent([
            'title'         => $this->booking->orderItem->title . " " . $this->booking->tutor->full_name,
            'description'   => $this->booking->slot->description,
            'start_time'    => Carbon::parse($this->booking->start_time)->setTimezone(getUserTimezone($this->booking->booker))->toIso8601String(),
            'end_time'      => Carbon::parse($this->booking->end_time)->setTimezone(getUserTimezone($this->booking->booker))->toIso8601String()
        ]);
        $bookingMeta             = $this->booking->meta_data;
        $bookingMeta['event_id'] = $eventResponse['data']->id ?? null;
        (new BookingService())->updateBooking($this->booking, [ 'meta_data' => $bookingMeta ]);

        if (empty($this->booking->slot['meta_data']['event_id'])) {
            $eventResponse = (new GoogleCalender($this->booking->bookee))->createEvent([
                'title'         => ($this->booking->orderItem->options['group_name'] . " " ?? '') . $this->booking->orderItem->title,
                'description'   => $this->booking->slot->description,
                'start_time'    => Carbon::parse($this->booking->start_time)->setTimezone(getUserTimezone($this->booking->bookee))->toIso8601String(),
                'end_time'      => Carbon::parse($this->booking->end_time)->setTimezone(getUserTimezone($this->booking->bookee))->toIso8601String()
            ]);
            $slotMeta               = $this->booking->slot->meta_data;
            $slotMeta['event_id']   = $eventResponse['data']->id ?? null;
            (new BookingService())->updateSessionSlot($this->booking->slot, [ 'meta_data' => $slotMeta ]);
        }
    }
}
