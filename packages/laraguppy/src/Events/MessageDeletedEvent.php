<?php

namespace Amentotech\LaraGuppy\Events;

use Amentotech\LaraGuppy\Http\Resources\GuppyMessageResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageDeletedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public int $userId;
    
    /**
     * Create a new event instance.
     */
    public function __construct($message, $id)
    {
        $this->userId   = $id;
        $this->message  = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('events-'.$this->userId),
        ];
    }
}
