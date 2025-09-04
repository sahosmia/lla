<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\GoogleCalender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteGoogleCalendarEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public User $user;
    public ?string $eventId;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, ?string $eventId)
    {
        $this->user = $user;
        $this->eventId = $eventId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!empty($this->eventId)) {
            (new GoogleCalender($this->user))->deleteEvent($this->eventId);
        }
    }
}
