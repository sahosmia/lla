<?php

namespace App\Jobs;

use App\Facades\Cart;
use App\Models\SlotBooking;
use App\Services\BookingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveBookingReservationJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Queueable, SerializesModels;

    public $bookingId;

    /**
     * Create a new job instance.
     */
    public function __construct($bookingId)
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Execute the job.
     */
    public function handle(BookingService $bookingService): void
    {
        $booking = $bookingService->getBookingById($this->bookingId);
        if (!empty($booking) && $booking?->status == 'reserved'){
            $bookingService->updateSessionSlot($booking->slot, ['total_booked' => $booking->slot->total_booked - 1]);
            $bookingService->deleteBooking($booking);

            Cart::remove(
                cartableId: $this->bookingId, 
                cartableType: SlotBooking::class, 
                userId: $booking->student_id
            );
        }
    }
}
