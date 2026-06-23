<?php

namespace Amentotech\LaraGuppy\Services;

use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Models\ChatAction;
use Amentotech\LaraGuppy\Models\Participant;
use Amentotech\LaraGuppy\Models\Thread;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ThreadsService
{
    /**
    * Create a thread
    */
    public function createThread(): Thread
    {
        return Thread::create(['thread_type' => ConfigurationManager::PRIVATE]);
    }

    /**
     * Get threads list
     */
    public function getThreads() {
        $userId         = auth()->user()->id;        
        $clearedAt      = ChatAction::where('user_id', auth()->user()->id)->where('action', ConfigurationManager::CLEAR_CHAT_ACTION)->first()?->created_at;
        $activeThread   = request()->get('activeThread');
        $threads        = auth()->user()->threads();
        if(!empty($activeThread)){
            $threads = $threads->orderByRaw(config('laraguppy.db_prefix')."threads.id !=".$activeThread);;
        }
        $threads = $threads->with([
            'messages' => function($query) {
                $query->WhereDoesntHave('read');
                $query->select('id', 'thread_id', 'messageable_id');
                $query->whereNot('messageable_id', auth()->user()->id)->whereNot('message_type', 'notify');
            }, 
            'latestMessage' => function($query) use ($clearedAt) {
                if ($clearedAt) {
                    $query->where('created_at', '>', $clearedAt);
                }
            },
            'readMessages',
            'chatActions' => function($query){
                $query->whereUserId(auth()->user()->id)->whereAction(ConfigurationManager::NOTIFICATION_MUTE);
            }
        ])->withWhereHas('allParticipants' , function($query){
            $with = ['user','user.chatActions','user.chatProfile'];
            if(!empty(config('laraguppy.userinfo_relation'))){
                array_push($with, "user.".config('laraguppy.userinfo_relation'));
            }
            if (!empty(request()->get('search'))) {
                $searchName     = request()->get('search');
                $query->whereHas('user.'.config('laraguppy.userinfo_relation'), function ($q) use ($searchName) {
                    $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$searchName}%")
                    ->orWhere('first_name', 'LIKE', "%{$searchName}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchName}%");
                });
            }
            $query->with($with)->whereNot('participantable_id', auth()->user()->id);
        })
        ->latest('updated_at')
        ->get();              
        $threads    = $threads->map(function ($thread) {
            $thread->isMutedSpecific = $thread->chatActions->map(function($action){ 
                return $action->user_id == auth()->user()->id && $action->action == ConfigurationManager::NOTIFICATION_MUTE;
            })->first();
            return $thread;
        });

        return $threads;
    }

    public function getUnDeliveredMessages(){
        $deliveredThreadMsgs = auth()->user()->threads()
        ->with([
            'messages'=> function($query) {
                $query->whereDoesntHave('delivered');
                $query->select('id', 'thread_id', 'messageable_id');
            },
            'allParticipants'
        ])->get(); 
       
        if(!$deliveredThreadMsgs->isEmpty()){
            (new MessagesService)->deliveredAllMessages($deliveredThreadMsgs);
        }
        return $deliveredThreadMsgs;
    }

    public function findPrivateThread($to, $from){
        return Participant::select('thread_id')
            ->withWhereHas('thread', fn($query) => $query->whereThreadType(ConfigurationManager::PRIVATE))
            ->where('participantable_id', $to)
            ->orWhere('participantable_id', $from)
            ->groupBy('thread_id')
            ->havingRaw('COUNT(DISTINCT participantable_id) = 2')
            ->first();
    }

    /**
     * Get thread
     * @param int $threadId
     */
    public function getThread($threadId) {
        return Thread::find($threadId);
    }

    
    /**
     * get thread participants
     */
    public function getThreadParticipants($thread_id) {
        return Participant::where('thread_id', $thread_id)->get();
    }
    
    /**
     * Check if a thread exists
     */
    public function threadExists($threadId){
        return auth()->user()->threads()->whereThreadId($threadId)->exists();
    }

    /**
    * Add thread participants
    */
    public function addThreadParticipants($threadId, $ownerId, $userId)
    {
       Participant::create(
            [
                'participantable_id'     => $ownerId,
                'participantable_type'   => config('auth.providers.users.model'), 
                'thread_id'              => $threadId,  
            ],
        );

        Participant::create(
        [
                'participantable_id'     => $userId, 
                'participantable_type'   => config('auth.providers.users.model'), 
                'thread_id'              => $threadId, 
                'role'                   => 'user', 
            ],
        );
    }

    /**
     * Get thread attachments with pagination
     */
    public function getAttachments($threadId)
    {
        return Thread::find($threadId)->attachments()->paginate(config('laraguppy.per_page_records'));
    }
    /**
     * Get all thread attachments
     */
    public function getAllAttachments($threadId)
    {
        return Thread::find($threadId)->attachments()->get();
    }

    /**
     * Process attachments
     */
    public function processAttachments($attachments)
    {
        $processedaAttachments = null;
        foreach($attachments as $attachment){
            if(!empty($attachment->attachments) && is_array($attachment->attachments)){
                foreach ($attachment->attachments as $index => $a){

                    if(!empty($a['file'])){
                        $a['file'] = Storage::url($a['file']);
                    }

                    if(!empty($a['thumbnail'])){
                        $a['thumbnail'] = Storage::url($a['thumbnail']);
                    }

                    $processedaAttachments[$attachment->message_id."_".$index] = $a;
                } 
            }
        }

        return $processedaAttachments;
    }

    public function getPrivateThreadOfParticipant($userId): ?Thread{
       return auth()->user()->threads()->whereThreadType(ConfigurationManager::PRIVATE)
                ->whereHas( 'allParticipants', function($query) use ($userId){ 
                    $query->where('participantable_id', $userId);
                })->first();
    }

    /**
     * Update private thread participants
     */
    public function updatePriveThreadParticipants($userId, $status): bool
    {
       $thread = $this->getPrivateThreadOfParticipant($userId);

       if (empty($thread)) {
            return false;
       }

       $thread->participants()->update(['blocked_by' => $status == ConfigurationManager::BLOCKED_STATUS ? auth()->user()->id : null] );
       $thread->allParticipants()->update(['participant_status' => $status]);
        
        return true;
    }

    public function getTotalUnreadMsgs()
    {
        $threads    = auth()->user()->threads()
        ->with(['messages' => function($query) {
            $query->WhereDoesntHave('read');
            $query->select('id', 'thread_id', 'messageable_id');
            $query->whereNot('messageable_id', auth()->user()->id)->whereNot('message_type', 'notify');
        }, 'readMessages'])
        ->withWhereHas('participants.user')
        ->latest('updated_at')
        ->get();
        $total = 0;
        foreach($threads as $thread){
            $total += $thread->messages->diff($thread->readMessages)->pluck('id')->count();
        }
       return $total;
    }
}
