<?php

namespace Amentotech\LaraGuppy\Http\Controllers;

use App\Http\Controllers\Controller;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Services\ThreadsService;
use Amentotech\LaraGuppy\Services\FriendsService;
use Amentotech\LaraGuppy\Services\PaginateCollection;
use Amentotech\LaraGuppy\Events\GuppyChatPrivateEvent;
use Amentotech\LaraGuppy\Http\Resources\GuppyThreadsResource;

class ThreadsController extends Controller
{

    use ApiResponser;

    /**
     * Display a listing of threads.
     */
    public function index()
    {
        $threads    =  (new ThreadsService())->getThreads();
        $threadMsgs =  (new ThreadsService())->getUnDeliveredMessages();
        if(!$threadMsgs->isEmpty()){
            foreach($threadMsgs as $thread){
                $participantIds = $thread->allParticipants->pluck('participantable_id')->toArray();
                $messageIds = $thread->messages->pluck('id');
                if( !empty($participantIds) && !$messageIds->isEmpty()) {
                    $data = [
                        'threadId'      => $thread->id,
                        'threadType'    => $thread->thread_type,
                        'messageIds'    => $messageIds,
                        'seenAt'        => false
                    ];
                    event(new GuppyChatPrivateEvent($data, $participantIds, ConfigurationManager::MessageDeliveredEvent));
                }

            }
        }

         return response()->json(
            [
                'type' => 'success', 
                'data' => new GuppyThreadsResource(PaginateCollection::paginate($threads, config('laraguppy.per_page_records')))
            ]);
    }

    /**
     * Display total friend requests and all friends.
     */
    public function unreadCount(){

        $requestsList       = (new FriendsService())->countFriendRequests();
        $privateChatList    = (new ThreadsService())->getTotalUnreadMsgs();

        return $this->success([
            'request_list' => $requestsList, 
            'private_chat' => $privateChatList
        ]);

        return response()->json(); 
    }
}
