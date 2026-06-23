<?php

namespace Amentotech\LaraGuppy\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GuppyChatPublicEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public mixed $message;
    public string $eventName;
    // public GuppyUserResource $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(mixed $message, string $eventName)
    {
        $this->message      = $message;
        $this->eventName    = $eventName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn():array
    {
        return [
            new Channel('events')
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return $this->eventName;
    }
}
