<?php

namespace Amentotech\LaraGuppy\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Amentotech\LaraGuppy\Http\Resources\GuppyUserResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyFriendResource;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UnblockedByFriendEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $friend;
    public int $userId;
    public GuppyFriendResource $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct( $friend, $userId)
    {
        
        $this->friend = $friend;
        $this->userId =$userId;
        $this->message = new GuppyFriendResource($friend);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('events-'.$this->userId, $this->userId),
        ];
    }
}
