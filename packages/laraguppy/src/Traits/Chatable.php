<?php

namespace Amentotech\LaraGuppy\Traits;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\ChatAction;
use Amentotech\LaraGuppy\Models\GpUser;
use Amentotech\LaraGuppy\Models\Thread;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;

trait Chatable {

    public function getIsOnlineAttribute() {
        return Cache::has('user-online-' . $this->id);
    }

    protected function profileRelations ()
    {
        $with = ['chatProfile'];
        if(!empty(config('laraguppy.userinfo_relation'))){
            array_push($with, config('laraguppy.userinfo_relation'));
        }
        
        return $with;
    }

    protected function searchQuery( &$query, $search)
    {
        if(!empty(config('laraguppy.userinfo_relation'))){
            $query->withWhereHas(config('laraguppy.userinfo_relation'), function ($query) use ($search) {
                $query->where(function($where) use ($search) {
                    $where->where(config('laraguppy.user_first_name_column'), 'LIKE', "%{$search}%");
                    if(!empty(config('laraguppy.user_last_name_column'))){
                        $where->orWhere(config('laraguppy.user_last_name_column'), 'LIKE', "%{$search}%");
                    }  
                });  
            });
        } else {
            $query->where(function($where) use ($search) {
                $where->where(config('laraguppy.user_first_name_column'), 'LIKE', "%{$search}%");
                if(!empty(config('laraguppy.user_last_name_column'))){
                    $where->orWhere(config('laraguppy.user_last_name_column'), 'LIKE', "%{$search}%");
                }  
            });  
        }
    }

    public function friendsTo(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.providers.users.model'), config('laraguppy.db_prefix') . ConfigurationManager::FRIENDS_TABLE, 'user_id', 'friend_id')
            ->withoutGlobalScopes()
            ->with($this->profileRelations())
            ->withPivot('friend_status')
            ->withTimestamps();
    }

    public function friendsFrom(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.providers.users.model'), config('laraguppy.db_prefix') . ConfigurationManager::FRIENDS_TABLE, 'friend_id', 'user_id')
            ->withoutGlobalScopes()
            ->with($this->profileRelations())
            ->withPivot('friend_status')
            ->withTimestamps();
    }

    public function invitedFriendsTo(): BelongsToMany
    {
        return $this->friendsTo()
            ->with($this->profileRelations())
            ->withPivot('friend_id', 'friend_status')
            ->wherePivot('friend_status', [ConfigurationManager::INVITED_STATUS]);
    }

    public function invitedFriendsFrom($search = null): BelongsToMany
    {
        return $this->friendsFrom()
            ->with($this->profileRelations())
            ->with(array_merge($this->profileRelations(),['chatActions']))
            ->withPivot('friend_id', 'friend_status')
            ->when(!empty($search), function ($query) use ($search) {
                $this->searchQuery($query, $search);
            })
            ->wherePivotIn('friend_status', [ConfigurationManager::INVITED_STATUS]);
    }

    public function acceptedFriendsTo($search = null ,$loadRelations = true, $id = null) {
        
        return $this->friendsTo()
            ->when($loadRelations, function ($query) {
                $query->with( array_merge($this->profileRelations(), ['threads' => function($query){
                    $query->whereHas('allParticipants', fn($participent)=> $participent->select('id')->where('participantable_id', auth()->user()->id));
                },'chatActions']));
            })
            ->when($id, function($query) use ($id){
                $query->whereUserId($id);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $this->searchQuery($query, $search);
            })
            ->wherePivot('friend_status', ConfigurationManager::ACTIVE_STATUS); 
    }

    public function acceptedFriendsFrom($search = null, $loadRelations = true, $id = null) {

        return $this->friendsFrom()
            ->when($loadRelations, function ($query) {
                $query->with( array_merge($this->profileRelations(), ['threads' => function($query){
                    $query->whereHas('allParticipants', fn($participent)=> $participent->select('id')->where('participantable_id', auth()->user()->id));
                },'chatActions']));
            })
            ->when($id, function($query) use ($id){
                $query->whereUserId($id);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $this->searchQuery($query, $search);
            })
            ->wherePivot('friend_status', ConfigurationManager::ACTIVE_STATUS);
    }

    public function blockedFriendsTo($id = null, $search = null) {
        return $this->friendsTo()
            ->whereNotNull('blocked_by')
            ->withPivot('friend_status', 'blocked_by')
            ->when($id, function ($query) use ($id) {
                $query->whereFriendId($id);
            })
            ->when($search, function($query) use ($search){
                $this->searchQuery($query, $search);
            })
            ->wherePivotIn('friend_status', [ConfigurationManager::BLOCKED_STATUS]);  
    }

    public function blockedInviteFriend($id = null) {
        return $this->friendsFrom()->whereUserId($id)->whereFriendId(auth()->user()->id)->first();
    }

    public function blockedFriendsFrom($id = null, $search = null) {
        return $this->friendsFrom()
            ->with($this->profileRelations())
            ->whereNotNull('blocked_by')
            ->withPivot('friend_status', 'blocked_by')
            ->when($id, function ($query) use ($id) {
                $query->whereUserId($id);
            })
            ->when($search, function($query) use ($search){
                $this->searchQuery($query, $search);
            })
            ->wherePivotIn('friend_status', [ConfigurationManager::BLOCKED_STATUS]);
    }

    public function friends($search = null, $loadRelations = true, $id = null) {
       return $this->acceptedFriendsFrom($search, $loadRelations, $id)->get()
       ->merge($this->acceptedFriendsTo($search, $loadRelations, $id)->get());
    }

    public function blockedFriends($id = null, $search = null) {
        return $this->blockedFriendsTo($id, $search)->get()->merge($this->blockedFriendsFrom($id, $search)->get());
    }

    public function chatProfile(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(GpUser::class);
    }

    /**
     * Thread relationship.
     *
     * @return BelongsToMany
     *
     * @codeCoverageIgnore
     */
    public function threads() {
        return $this->belongsToMany(
            Thread::class,
            config('laraguppy.db_prefix') . ConfigurationManager::PARTICIPANTS_TABLE,
            'participantable_id',
            'thread_id'
        )
        ->whereNull(config('laraguppy.db_prefix') . ConfigurationManager::PARTICIPANTS_TABLE . '.deleted_at')
        ->withTimestamps();
    }

    /**
     * Get all of the chatActions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function chatActions(): MorphMany
    {
        return $this->morphMany(ChatAction::class, 'actionable');
    }
}
