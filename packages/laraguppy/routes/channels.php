<?php

use Illuminate\Support\Facades\Broadcast;
use Amentotech\LaraGuppy\Services\ThreadsService;

Broadcast::channel('events-{id}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('thread-{id}', function ($user, $threadId) {
    return (new ThreadsService)->threadExists($threadId);
});

Broadcast::channel('events', function (){
    return true;
});