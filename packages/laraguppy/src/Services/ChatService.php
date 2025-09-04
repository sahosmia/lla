<?php

namespace Amentotech\LaraGuppy\Services;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\ChatAction;
use Amentotech\LaraGuppy\Models\Thread;
use Illuminate\Contracts\Pagination\Paginator;

class ChatService
{
    public function getContacts(): Paginator|null
    {
        $search  = request()->get('search');

        $userClass = (string)config('auth.providers.users.model');
        $with = ['chatActions','chatProfile'];
        if(!empty(config('laraguppy.userinfo_relation'))){
            array_push($with, config('laraguppy.userinfo_relation'));
        }
        $user   = auth()->user();
        $search = request()->get('search');

        return (new $userClass())::when(!empty(config('laraguppy.exclude_roles')), function($roles) {
            $roles->whereHas('roles', fn ($query) => $query->whereNotIn('name', config('laraguppy.exclude_roles') ));
        })->where('id', '<>', $user->id)
            ->when($search, function ($query) use ($search) {
                if(!empty(config('laraguppy.userinfo_relation'))){
                    $query->withWhereHas(config('laraguppy.userinfo_relation'), function ($query) use ($search) {
                        $query->where(function($where) use ($search) {
                            $first  = config('laraguppy.user_first_name_column');
                            $last   = config('laraguppy.user_last_name_column');
                            $where->where($first, 'LIKE', "%{$search}%")->orWhere($last, 'LIKE', "%{$search}%");
                            if(!empty($last)){
                                $where->orWhereRaw("CONCAT($first, ' ', $last) LIKE ?", ["%{$search}%"]);
                            }  
                        });  
                    });
                } else {
                    $query->where(function($where) use ($search) {
                        $first = config('laraguppy.user_first_name_column');
                        $last = config('laraguppy.user_last_name_column');
                        $where->where($first, 'LIKE', "%{$search}%")->orWhere($last, 'LIKE', "%{$search}%");
                        if(!empty($last)){
                            $where->orWhereRaw("CONCAT($first, ' ', $last) LIKE ?", ["%{$search}%"]);
                        }  
                    });  
                }
            })
            ->when($user->hasRole('student'), function ($query) use ($user) {
                $query->whereHas('roles', fn ($query) => $query->where('name', 'tutor'));
            })
            ->when($user->hasRole('tutor'), function ($query) use ($user) {
                $query->whereHas('roles', fn ($query) => $query->where('name', 'student'));
            })
            ->whereDoesntHave('friendsFrom', fn($friend) => $friend->whereFriendStatus(ConfigurationManager::ACTIVE_STATUS)->where('user_id', $user->id))
            ->whereDoesntHave('friendsTo',   fn($friend) => $friend->whereFriendStatus(ConfigurationManager::ACTIVE_STATUS)->where('friend_id', $user->id))
            ->whereDoesntHave('invitedFriendsTo', fn($invitedTo) => $invitedTo->where('user_id', $user->id))
            ->with(
                array_merge(
                [
                    'invitedFriendsFrom' => fn($invitedFrom) => $invitedFrom->where('user_id', $user->id),
                    'invitedFriendsTo'   => fn($invitedTo) => $invitedTo->where('user_id', $user->id),
                ],
                $with)
            )
            ->paginate(config('laraguppy.per_page_records'));
    }

    function chatActionRecord($userId, $action){
        $clearChat = ChatAction::where('user_id', $userId)
                    ->where('action', $action)->first();
            return !empty($clearChat) ? $clearChat->created_at : null;
    }

    public function clearChat($userId, $threadId){
        return ChatAction::create([
            'user_id'   => $userId,
            'actionable_id' => $threadId,
            'actionable_type' => Thread::class,
            'action'          => ConfigurationManager::CLEAR_CHAT_ACTION,
        ]);
    }

    public function muteChatNotification($userId, $threadId){
        return ChatAction::firstOrCreate([
            'user_id'   => $userId,
            'actionable_id' => $threadId,
            'actionable_type' => Thread::class,
            'action'          => ConfigurationManager::NOTIFICATION_MUTE,
        ]);
    }

    public function muteAccountNotification(){
        return ChatAction::firstOrCreate([
            'user_id'   => auth()->user()->id,
            'actionable_id' => auth()->user()->id,
            'actionable_type' => (string)config('auth.providers.users.model'),
            'action'          => ConfigurationManager::NOTIFICATION_MUTE,
        ]);
    }

    public function unmuteChatNotification($userId, $threadId){
        $muteAction = ChatAction::whereUserId($userId)->where('actionable_id', $threadId)->where('actionable_type',Thread::class)->whereAction(ConfigurationManager::NOTIFICATION_MUTE);
        if ($muteAction) {
            $muteAction->delete();
        }
    }

    public function unmuteAccountNotification(){
        $muteAction = ChatAction::whereUserId(auth()->user()->id)->where('actionable_id', auth()->user()->id)->where('actionable_type',config('auth.providers.users.model'))->whereAction(ConfigurationManager::NOTIFICATION_MUTE);
        if ($muteAction) {
            $muteAction->delete();
        }
    }
}
