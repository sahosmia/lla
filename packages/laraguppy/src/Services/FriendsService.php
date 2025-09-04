<?php

namespace Amentotech\LaraGuppy\Services;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\Friend;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Illuminate\Database\Eloquent\Collection;

class FriendsService {
    use ApiResponser;
    /**
     * Get friends list
     */
    public function getFriends(): Collection|null {
        $search  = request()->get('search');
        $blockedFriends = auth()->user()->blockedFriends(search: $search);

        if(!empty($blockedFriends)){
            return auth()->user()->friends($search)->merge($blockedFriends);
        }
        return  auth()->user()->friends($search);
    }

    /**
     * Get blocked friends list
     */
    public function getBlockedFriends() {
        $search  = request()->get('search');

        return auth()->user()->blockedFriends(search: $search);
    }

    /**
     * Get friend requests
     */
    public function getFriendRequests() {
        $search  = request()->get('search');
        return auth()->user()->invitedFriendsFrom($search)->paginate(config('laraguppy.per_page_records'));
    }


    /**
     * Send friend request
     */
    public function sendFriendRequest($friendId) {
        return Friend::withoutGlobalScopes()->updateOrCreate(
            ['user_id' => auth()->user()->id, 'friend_id' => $friendId],
            ['user_id' => auth()->user()->id, 'friend_id' => $friendId, 'friend_status' => ConfigurationManager::INVITED_STATUS]
        );

    }

    /**
     * Send friend request
     */
    public function addFriendToList($fromId, $friendId) {
        return Friend::withoutGlobalScopes()->updateOrCreate(
            ['user_id' => $fromId, 'friend_id' => $friendId],
            ['user_id' => $fromId, 'friend_id' => $friendId, 'friend_status' => ConfigurationManager::ACTIVE_STATUS]
        );
    }

        /**
     * Accept friend request
     */
    public function acceptFriendRequest($friendId) {
        return Friend::withoutGlobalScopes()->whereFriendId(auth()->user()->id)->whereUserId($friendId)->whereFriendStatus(ConfigurationManager::INVITED_STATUS)->update(['friend_status' => ConfigurationManager::ACTIVE_STATUS]);
    }

    public function declineFriendRequest($friendId) {
        return Friend::withoutGlobalScopes()->whereFriendId(auth()->user()->id)->whereUserId($friendId)->whereFriendStatus(ConfigurationManager::INVITED_STATUS)->delete();
    }

    /**
     * Block a friend
     */
    public function blockFriend($friend) {
        $friend->friend_status = ConfigurationManager::BLOCKED_STATUS;
        $friend->blocked_by = auth()->user()->id;
        $friend->save();
    }

    /**
     * Unblock a friend
     */
    public function unBlockFriend($friend) {
        $friend->friend_status = ConfigurationManager::ACTIVE_STATUS;
        $friend->blocked_by = null;
        $friend->save();
    }

    /**
     * Get a friend
     */
    public function getFriend($userId) {
        $friend = auth()->user()->friends(id: $userId)->first();
        if (!$friend) {
            $friend = auth()->user()->friendsTo()->wherePivot('friend_id', $userId)->first();
        }
        return $friend;
    }

// New functions
    public function blockedInviteFriend($userId)
    { 
        return Friend::withoutGlobalScopes()
        ->whereUserId($userId)->whereFriendId(auth()->user()->id)
        ->whereFriendStatus(ConfigurationManager::INVITED_STATUS)
        ->update(['friend_status' => ConfigurationManager::INVITE_BLOCKED_STATUS, 'blocked_by' => auth()->user()->id]);
    }
    
// End new functions

    /**
     *Get friend of
     */
    public function getFriendOf($userId){
        return auth()->user()->acceptedFriendsFrom()->first()->get();
    }


    /**
     * Get a blocked friend
     */
    public function geBlockedFriend($userId) {
        return auth()->user()->blockedFriends(id: $userId)->first();
    }


     /**
     * Get a invite blocked friend
     */
    public function getInviteBlockedFriend($userId) {
        return auth()->user()->blockedInviteFriend(id: $userId);
    }

    /**
     * Get a friend request
     */
    public function getFriendRequest($friendId) {
        return auth()->user()->invitedFriendsFrom()->whereUserId($friendId)->get()->first();
    }

    /**
     * Check if a friend request is a valid requset
     */
    public function friendExists($friendId, $userId)
    {
        return Friend::select('id')
                        ->withoutGlobalScopes()->whereUserId($userId)->whereFriendId($friendId)
                        ->where(fn($where) => $where->where('friend_id', $userId)->orWhere('user_id', $friendId))
                        ->whereIn('friend_status', [ConfigurationManager::ACTIVE_STATUS,ConfigurationManager::BLOCKED_STATUS,ConfigurationManager::INVITE_BLOCKED_STATUS])
                        ->exists();
    }

    /**
     * Get a total friend request
     */
    public function countFriendRequests() {
        return auth()->user()->invitedFriendsFrom()->count(); 
    }

    /**
     * Get a friend list
     */
    public function countFriendsList(){
        return auth()->user()->friends()->count();
    }

    /**
     * Add Friend
     */

    public function makeDirectFriend($from, $to){
        (new FriendsService)->addFriendToList($from, $to);
        $thread = (new ThreadsService)->createThread();
        (new ThreadsService)->addThreadParticipants($thread->id, $from, $to);
        return $thread;
    }

}
