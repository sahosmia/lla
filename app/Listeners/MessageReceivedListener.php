<?php

namespace App\Listeners;

use Amentotech\LaraGuppy\Services\ThreadsService;
use App\Jobs\SendDbNotificationJob;
use App\Jobs\SendNotificationJob;

class MessageReceivedListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event->eventName == 'message-received' ) {
            $threadUsers = (new ThreadsService())->getThreadParticipants($event->message->thread_id);
            foreach($threadUsers as $participant) {
                if ($participant->participantable_id != $event->message->user_id && empty($participant->participantable->is_online)) {
                    dispatch(new SendNotificationJob('newMessage', $participant->participantable, [
                        'userName'      => $participant->participantable->profile->full_name,
                        'messageSender' => $event->message->messageable->profile->full_name
                    ]));

                    dispatch(new SendDbNotificationJob('newMessage', $participant->participantable, [
                        'messageSender' => $event->message->messageable->profile->full_name
                    ]));
                }
            }
        }

    }
}
