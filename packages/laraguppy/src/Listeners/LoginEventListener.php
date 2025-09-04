<?php

namespace Amentotech\LaraGuppy\Listeners;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Events\GuppyChatPublicEvent;
use Amentotech\LaraGuppy\Http\Resources\GuppyUserResource;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Cookie;
use IlluminateAuthEventsLogout;
use Illuminate\Support\Facades\Log;

class LoginEventListener
{

    /**
     * Handle the event.
     *
     * @param  \IlluminateAuthEventsLogout  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->tokens()->whereName('GuppyChat')->delete();
        $token = $event->user->createToken('GuppyChat')->plainTextToken;
        Cookie::queue('guppy_auth_token', $token, 60 * 24 * 30);
        broadcast(new GuppyChatPublicEvent(new GuppyUserResource($event->user), ConfigurationManager::UserOnlineEvent))
        ->toOthers();
    }
}
