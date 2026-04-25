<?php

namespace Amentotech\LaraGuppy\Http\Controllers;

use Amentotech\LaraGuppy\Models\Friend;
use App\Http\Controllers\Controller;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Services\ThreadsService;
use Amentotech\LaraGuppy\Services\FriendsService;
use Amentotech\LaraGuppy\Services\MessagesService;
use Amentotech\LaraGuppy\Services\PaginateCollection;
use Amentotech\LaraGuppy\Events\GuppyChatPrivateEvent;
use Amentotech\LaraGuppy\Http\Requests\FriendStoreRequest;
use Amentotech\LaraGuppy\Http\Resources\GuppyUserResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyFriendResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyFriendsResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyRequestsResource;

class FriendsController extends Controller {
    use ApiResponser;

    /**
     * Display a listing of friends.
     */
    public function index() {
        $friends = [];
        $friends = ((new FriendsService())->getFriends());
        
        return response()->json([
            'type' => 'success',
            'data' => new GuppyFriendsResource(PaginateCollection::paginate($friends, config('laraguppy.per_page_records')))
        ]);
    }

    /**
     * Display a listing of blocked friends.
     */
    public function blocked() {
        $friends = ((new FriendsService())->getBlockedFriends());

        return response()->json([
            'type'      => 'success',
            'data'   => new GuppyFriendsResource(PaginateCollection::paginate($friends, config('laraguppy.per_page_records')))
        ]);
    }

    /**
     * Display a listing of friend requests.
     */
    public function requests() {
      
        $friendRequests = (new FriendsService())->getFriendRequests();
        return response()->json(['type' => 'success', 'data' => new GuppyRequestsResource($friendRequests)]);
    }

    /**
     * Update friend status
     */
    public function update(FriendStoreRequest $request) {

        return match ($request->friendStatus) {
            'invited'           => $this->sendFriendRequest($request->userId),
            'active'            => $this->makeFriend($request->userId, $request->unblock),
            'declined'          => $this->declineFriendRequest($request->userId),
            'blocked'           => $this->blockFriend($request->userId),
            'unblocked'         => $this->unBlockFriend($request->userId),
            'invite_blocked'    => $this->inviteBlockFriend($request->userId),
            'invite_unblocked'  => $this->inviteUnblockFriend($request->userId, $request->unblock)
        };
    }

    private function inviteBlockFriend($userId)
    {
        $blockedInvite = (new FriendsService())->blockedInviteFriend($userId);

        if (empty($blockedInvite)) {
            return $this->error(__('laraguppy::chatapp.friend_not_exists'));
        }

        $user   = (new FriendsService())->getInviteBlockedFriend($userId);

        event(new GuppyChatPrivateEvent(new GuppyUserResource($user), [auth()->user()->id], ConfigurationManager::FriendRequestBlockedEvent));
        event(new GuppyChatPrivateEvent(new GuppyUserResource(auth()->user()), [$userId], ConfigurationManager::FriendshipRequestBlockedEvent));

        return $this->success(new GuppyUserResource($user), __('laraguppy::chatapp.friend_blocked'));
    }

    private function inviteUnblockFriend($userId, $unblock)
    {
        Friend::withoutGlobalScopes()->where('user_id', $userId)->where('friend_id', $unblock)
                ->where('friend_status', ConfigurationManager::INVITE_BLOCKED_STATUS)->delete();
        return $this->success('',  __('laraguppy::chatapp.friend_unblocked'));
    }

    /**
     * Send friend request
     */
    private function sendFriendRequest($friendId) {
        if (!empty(config('laraguppy.enable_chat_invitation'))) {
        
            if((new FriendsService)->friendExists($friendId, auth()->user()->id)){   
                return $this->error(__('laraguppy::chatapp.request_blocked'));
            }
            $friend = (new FriendsService())->sendFriendRequest($friendId);
            $user   = (new FriendsService())->getFriend($friendId);

            event(new GuppyChatPrivateEvent(new GuppyUserResource($user), [auth()->user()?->id], ConfigurationManager::FriendRequestSentEvent));
            event(new GuppyChatPrivateEvent(new GuppyUserResource($friend->user), [$friendId], ConfigurationManager::FriendRequestReceivedEvent));

            return $this->success(['statusText' => ConfigurationManager::INVITED_STATUS], __('laraguppy::chatapp.friend_request_sent'));
        }
        return $this->error(message:'Invalid action');
    }

    /**
     * Make friend
     */
    private function makeFriend($userId, $status) {
        if ($status) {
            return $this->unBlockFriend($userId);
        }

        return $this->acceptFriendRequest($userId);
    }


    /**
     * Accept a friend request
     */
    private function acceptFriendRequest($userId) {
        $friendRequest = (new FriendsService())->getFriendRequest($userId);

        if (!$friendRequest) {
            return $this->error(__('laraguppy::chatapp.friend_request_not_exists'));
        }

        (new FriendsService())->acceptFriendRequest($userId);

        $thread = (new ThreadsService())->createThread();

        (new ThreadsService())->addThreadParticipants($thread->id, auth()->user()->id, $userId);


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
        
        event(new GuppyChatPrivateEvent(new GuppyFriendResource($friend), [auth()->user()?->id], ConfigurationManager::FriendRequestAcceptedEvent));
        event(new GuppyChatPrivateEvent(new GuppyFriendResource(new GuppyFriendResource(auth()->user())), [$userId], ConfigurationManager::FriendshipAcceptedEvent));

        return $this->success(new GuppyFriendResource($friend), __('laraguppy::chatapp.friend_request_accepted'));
    }

    /**
     * Decline a friend request
     */
    private function declineFriendRequest($userId) {
        $friend = (new FriendsService())->getFriendRequest($userId);

        if (!$friend) {
            return $this->error(__('laraguppy::chatapp.friend_request_not_exists'));
        }

        (new FriendsService())->declineFriendRequest($userId);
        
        event(new GuppyChatPrivateEvent(new GuppyUserResource($friend), [auth()->user()?->id], ConfigurationManager::FriendRequestDeclinedEvent));
        event(new GuppyChatPrivateEvent(new GuppyUserResource(auth()->user()), [$userId], ConfigurationManager::FriendshipDeclinedEvent));

        return $this->success(new GuppyFriendResource($friend), __('laraguppy::chatapp.friend_request_declined'));
    }

    /**
     * Block a friend
     */
    private function blockFriend($userId) {
        
        $friend = (new FriendsService())->getFriend($userId);
 
        if (!$friend) {
            return $this->error(__('laraguppy::chatapp.friend_not_exists'));
        }

        (new FriendsService())->blockFriend($friend->pivot);

        (new ThreadsService)->updatePriveThreadParticipants($userId, ConfigurationManager::BLOCKED_STATUS);

        event(new GuppyChatPrivateEvent(new GuppyFriendResource($friend), [auth()->user()?->id], ConfigurationManager::FriendBlockedEvent));
        event(new GuppyChatPrivateEvent(new GuppyFriendResource($friend), [$userId], ConfigurationManager::FriendshipBlockedEvent));

        return $this->success(new GuppyFriendResource($friend), __('laraguppy::chatapp.friend_blocked'));
    }

    /**
     * Unblock a blocked friend
     */
    private function unBlockFriend($userId) {
      
        $blockedFriend = (new FriendsService())->geBlockedFriend($userId);

        if (!$blockedFriend) {
            return $this->error(__('laraguppy::chatapp.blocked_friend_not_exists'));
        }

        (new FriendsService())->unBlockFriend($blockedFriend->pivot);

        $threadUpdated = (new ThreadsService)->updatePriveThreadParticipants($userId, ConfigurationManager::ACTIVE_STATUS);
        if (!empty($threadUpdated)) {
            event(new GuppyChatPrivateEvent(new GuppyFriendResource($blockedFriend), [auth()->user()->id], ConfigurationManager::FriendUnblockedEvent));
            event(new GuppyChatPrivateEvent(new GuppyFriendResource($blockedFriend), [$userId], ConfigurationManager::FriendshipUnblockedEvent));
        

            return $this->success(new GuppyFriendResource($blockedFriend), __('laraguppy::chatapp.friend_unblocked'));
        }
        return $this->success(new GuppyUserResource($blockedFriend), __('laraguppy::chatapp.invite_unblocked'));
    }

}