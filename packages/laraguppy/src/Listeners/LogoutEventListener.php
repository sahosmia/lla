<?php

namespace Amentotech\LaraGuppy\Listeners;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Events\GuppyChatPublicEvent;
use Amentotech\LaraGuppy\Http\Resources\GuppyUserResource;
use Illuminate\Auth\Events\Logout;
use IlluminateAuthEventsLogout;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class LogoutEventListener
{

    /**
     * Handle the event.
     *
     * @param  \IlluminateAuthEventsLogout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        Cache::forget('user-online-'. $event->user->id);
        Cookie::queue('guppy_auth_token', '', -1);
        broadcast(new GuppyChatPublicEvent(new GuppyUserResource($event->user), ConfigurationManager::UserOfflineEvent))
        ->toOthers();
    }
}
