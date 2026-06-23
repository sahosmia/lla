<?php

namespace Amentotech\LaraGuppy\Http\Controllers;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Events\GuppyChatPrivateEvent;
use App\Http\Controllers\Controller;
use Amentotech\LaraGuppy\Http\Requests\ChatActionsRequest;
use Amentotech\LaraGuppy\Http\Requests\NotificationActionsRequest;
use Amentotech\LaraGuppy\Http\Resources\GuppyFriendResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyThreadResource;
use Amentotech\LaraGuppy\Services\ChatService;
use Amentotech\LaraGuppy\Services\FriendsService;
use Amentotech\LaraGuppy\Services\MessagesService;
use Amentotech\LaraGuppy\Services\ThreadsService;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Illuminate\Support\Facades\Cookie;

class ChatActionsController extends Controller
{
    use ApiResponser;

    protected ChatService $chatService;
    protected ThreadsService $threadService;

    public function __construct(ChatService $chatService, ThreadsService $threadService)
    {
        $this->chatService      = $chatService;
        $this->threadService    = $threadService;
        
    }

    public function index() {
        if (empty(Cookie::get('guppy_auth_token'))) {
            return redirect(url('/'));
        }

        $currentBroadcastingServer  = config('broadcasting.default') ?? 'reverb';
        $broadcastingSettings       = config('broadcasting.connections.'.$currentBroadcastingServer);
        $guppyAuthToken             = Cookie::get('guppy_auth_token');
        
        return view('laraguppy::messenger', compact('broadcastingSettings','guppyAuthToken'));
    }

    public function clearChat(ChatActionsRequest $request) {
        $threadId   = $request->threadId;
        $userId     = auth()->id();

        $thread  = $this->threadService->getThread($threadId);

        if( empty($thread) ) {
            return $this->error(message:'Thread not found');
        }
    
       $action = $this->chatService->clearChat($userId ,$threadId);

        if ($action) {
            event(new GuppyChatPrivateEvent(
                [
                    'threadId' => $thread->id,
                    'threadType'    => $thread->thread_type
                ], [auth()->user()?->id], ConfigurationManager::ThreadCleared)
            );
            return $this->success(message: 'Chat cleared successfully',data:null);
        }
        return $this->error(message:'Invalid action');
    }

    public function toggleAccountNotifications(NotificationActionsRequest $request) {
        $action     = $request->action;
        $userId     = auth()->user()->id;
        
        event(new GuppyChatPrivateEvent(['isMuted' => $action === ConfigurationManager::NOTIFICATION_MUTE], [$userId], ConfigurationManager::AccountNotificationEvent));

        if ($action === ConfigurationManager::NOTIFICATION_MUTE) {
            $this->chatService->muteAccountNotification();
            return $this->success(data:ConfigurationManager::NOTIFICATION_MUTE, message: 'Notifications muted successfully');
        }

        if ($action === ConfigurationManager::NOTIFICATION_UNMUTE) {
            $this->chatService->unmuteAccountNotification();
            return $this->success(data:ConfigurationManager::NOTIFICATION_UNMUTE, message: 'Notifications unmuted successfully');
        }

        return $this->error(message:'Invalid action');
    }
    
    public function toggleChatNotifications(NotificationActionsRequest $request, $threadId) {
        $action     = $request->action;
        $threadType = $request->threadType;
        $userId     = auth()->user()->id;
        
        event(new GuppyChatPrivateEvent(
            [ 
                'threadId' => $threadId, 
                'threadType' => $threadType, 
                'isMuted' => $action === ConfigurationManager::NOTIFICATION_MUTE
            ], [$userId], ConfigurationManager::ThreadNotificationEvent));

        if ($action === ConfigurationManager::NOTIFICATION_MUTE) {
            $this->chatService->muteChatNotification($userId, $threadId);
            return $this->success(data:ConfigurationManager::NOTIFICATION_MUTE, message: 'Notifications muted successfully');
        }

        if ($action === ConfigurationManager::NOTIFICATION_UNMUTE) {
            $this->chatService->unmuteChatNotification($userId, $threadId);
            return $this->success(data:ConfigurationManager::NOTIFICATION_UNMUTE, message: 'Notifications unmuted successfully');
        }
    
        return $this->error(message:'Invalid action');
    }

    public function startChat($userId) {
        if (empty(config('laraguppy.enable_chat_invitation'))) {
            $privateThread = (new ThreadsService)->findPrivateThread($userId, auth()->user()->id);
            $thread = $privateThread?->thread; 
            
            if (empty($thread)) {
                $thread = (new FriendsService)->makeDirectFriend(auth()->user()->id, $userId);
                $message = (new MessagesService)->storeMessage(
                    [
                        'thread_id'          => $thread->id,
                        'message_type'       => ConfigurationManager::MESSAGE_NOTIFY,
                        'messageable_id'     => auth()->user()->id,
                        'messageable_type'   => config('auth.providers.users.model'),
                    ]
                );

                (new MessagesService)->storeNotification($message, ConfigurationManager::NOTIFY_ACCEPT_FRIEND);

                $friend  = (new FriendsService)->getFriend($userId);
                $friend->thread_id = $thread->id;
                
                event(new GuppyChatPrivateEvent(new GuppyFriendResource($friend), [auth()->user()?->id], ConfigurationManager::FriendRequestAcceptedEvent));
                event(new GuppyChatPrivateEvent(new GuppyFriendResource(new GuppyFriendResource(auth()->user())), [$userId], ConfigurationManager::FriendshipAcceptedEvent));

            }

            return $this->success(new GuppyThreadResource($thread));
        }
        return $this->error(message:'Invalid action');
    }
}
