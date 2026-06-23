<?php

namespace App\Listeners;

use Nwidart\Modules\Facades\Module;

class SettingsUpdatedListener
{
    /**
     * Handle the event.
     */
    public function handle(array $eventData): void
    {
        if($eventData['section'] == '_lernen') {
            foreach($eventData['data'] as $key => $value) {
                if($key == 'payment_enabled') {
                    if($value == 'yes') {
                        if (Module::has('subscriptions') && Module::isDisabled('subscriptions')) {
                            Module::enable('subscriptions');
                        }
                    } else {
                        if (Module::has('subscriptions') && Module::isEnabled('subscriptions')) {
                            Module::disable('subscriptions');
                        }
                    }
                }
            }
        }
    }
}
