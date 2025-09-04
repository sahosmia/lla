<?php

namespace Amentotech\LaraGuppy\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Amentotech\LaraGuppy\Models\Message;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Amentotech\LaraGuppy\Models\SeenMessage;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Services\ChatService;
use Illuminate\Pagination\LengthAwarePaginator;
use Amentotech\LaraGuppy\Http\Controllers\MessageController;

class MessagesService
{
    use ApiResponser;

    /**
     * Get message
     */
    public function getMessage($id)
    {
        return Message::find($id);
    }

    /**
     * Get messages
     */
    public function getMessages($threadId)
    {
        $clearedAt = (new ChatService)->chatActionRecord(auth()->user()->id, ConfigurationManager::CLEAR_CHAT_ACTION);
        $relations = ['chatProfile'];
        if(!empty(config('laraguppy.userinfo_relation'))){
            $relations[]= config('laraguppy.userinfo_relation');
        }
        return Message::withTrashed()
            ->with(['messageable' => function($query) use ($relations){
                $query->with($relations);
            }, 'attachments', 'thread.allParticipants', 'parentMessage', 'notification', 'delivered', 'read' => function($query){
            $query->whereNot('seen_by', auth()->user()->id)->whereNotNull('seen_at');
        },])->whereThreadId($threadId)->orderBy('id','desc')
            ->when(!empty($clearedAt), function ($query) use ($clearedAt){
                $query->where('created_at', '>', $clearedAt);
        })
        ->get();
    }

    /**
     * Get filtered messages
     */
    public function getFilteredMessages($threadId){
        return  Message::whereThreadId($threadId)->whereNot('message_type', 'notify')->whereNot('messageable_id', auth()->user()->id)->get();
    }

    /**
     * send custom message
     */
    public function sendMessage($to, $from, $body){
        $thread = (new ThreadsService)->findPrivateThread($to, $from);
        $threadId = $thread?->thread_id;

        // participants
        if(empty($threadId)){
            $thread = (new FriendsService)->makeDirectFriend($from, $to);
            $threadId = $thread?->id;
        }

        $message = $this->storeMessage(
            [
                'thread_id'          => $threadId,
                'body'               => $body,
                'messageable_id'     => $from,
                'messageable_type'   => config('auth.providers.users.model'),
                'message_type'       => 'text',
                'parent_message_id'  => null,
            ]
        );
        
        
    return (new MessageController)->sendText($message);

    }

    /**
     * Seen all messages
     */
    public function seenAllMessages($threadId, $messagesIds)
    {
        $data = [];
        foreach($messagesIds as $id){
            $data[] = [
                'thread_id'     => $threadId,
                'message_id'    => $id,
                'seen_by'       => auth()->user()->id,
                'seen_at'       => Carbon::now(),
            ];
        }
        $messages = SeenMessage::upsert($data, ['thread_id', 'message_id', 'seen_by']);
        
    }

    /**
     * Seen all messages
     */
    public function deliveredAllMessages($threads)
    {
        $data = [];
        foreach($threads as $thread){
            $threadId = $thread->id;
            $messageIds = $thread->messages->pluck('id');
            foreach($messageIds as $id){
                $data[] = [
                    'thread_id'     => $threadId,
                    'message_id'    => $id,
                    'seen_by'       => auth()->user()->id,
                    'seen_at'       => null,
                ];
            }
        }

        if(!empty($data)){
            $messages = SeenMessage::upsert($data, ['thread_id', 'message_id', 'seen_by']);
        }
    }

    /**
     * Delivered message
     */
    public function deliveredMessage($data)
    {
        SeenMessage::firstOrCreate($data);
    }

    /**
     * Get all seen message
     */
    public function getSeenMessages($threadId, $messagesIds = [])
    {

        $messages = Message::whereThreadId($threadId);
        if(!empty($messagesIds)){
            $messages = $messages->whereIn('id',$messagesIds);
        }
        return $messages = $messages->whereNot('message_type', 'notify')->withWhereHas('read')->get();
    }
    /**
    * Send a message
    */
    public function storeMessage($data)
    {
        return Message::create($data);
    }

    /**
     * Send images
     */
    public function sendImages($request, $message)
    {
        if($request->hasFile('media')){
        
            foreach($request->file('media') as $media){
                if(!$media->isValid()){
                    return $this->error(__('laraguppy::chatapp.invalid_photo'));
                }
                
                $uniqueId   = uniqid();
                $photoName  = $uniqueId. '.' .$media->extension();
                $photoThumbnaiName = $uniqueId. '-150x150.' .$media->extension();
                
                $media->storeAs('laraguppy/images/', $photoName, getStorageDisk());
                $media->storeAs('laraguppy/images/', $photoThumbnaiName, getStorageDisk());

                (new MessagesService)->addAttachment($message, [
                    'attachments' => 
                    [
                        'file'       => 'laraguppy/images/'. $photoName,
                        'fileName'   =>  $photoName,
                        'fileSize'   => $media->getSize(),
                        'fileType'   => ConfigurationManager::MESSAGE_IMAGE,
                        'mimeType'   => $media->getClientMimeType(),
                        'thumbnail'  => 'laraguppy/images/'. $photoThumbnaiName,
                    ]
                ]);
            }
         }

    }
    
    /**
     * Send videos
     */
    public function sendVideos($request, $message)
    {
        if($request->hasFile('media')){

            $videos = [];

            foreach($request->file('media') as $media){
                if(!$media->isValid()){
                    return $this->error(__('laraguppy::chatapp.invalid_video'));
                }
                
                $uniqueId = uniqid();
                $videoName = $uniqueId. '.' .$media->extension();
                
                $media->storeAs('laraguppy/videos/', $videoName, getStorageDisk());

                $videos =  
                    [
                        'file'       => 'laraguppy/videos/'. $videoName,
                        'fileName'   =>  $videoName,
                        'fileSize'   => $media->getSize(),
                        'fileType'   => ConfigurationManager::MESSAGE_VIDEO,
                        'mimeType'   => $media->getClientMimeType(),
                    ];
                if(!empty($videos)){
                    (new MessagesService)->addAttachment($message, ['attachments' => $videos]);
                    
                }
            }
        }
    }

    /**
     * Send documents
     */
    public function sendDocuments($request, $message)
    {
        if($request->hasFile('media')){
            $documents = [];
            foreach($request->file('media') as $media){
                if(!$media->isValid()){
                    return $this->error(__('laraguppy::chatapp.invalid_document'));
                }
                
                $documentName = $media->getClientOriginalName();

                $extension = $media->extension();

                $file = [
                    'path'  => 'public/laraguppy/documents/',
                    'fileName'  => $documentName,
                    'extension'  => $extension,
                ];

                $documentName = (new MessagesService)->getUniqueFileName($file);
                $media->storeAs('laraguppy/documents/', $documentName, getStorageDisk());

                $documents =  [
                    'file'       => 'laraguppy/documents/'. $documentName,
                    'fileName'   =>  $documentName,
                    'fileSize'   => $media->getSize(),
                    'fileType'   => ConfigurationManager::MESSAGE_DOCUMENT,
                    'mimeType'   => $media->getClientMimeType(),
                ];

                if(!empty($documents)){
                    (new MessagesService)->addAttachment($message, ['attachments' => $documents]);
                    
                }
            }
         }
    }

    /**
     * Send audios
     */
    public function sendAudios($request, $message)
    {
        if($request->hasFile('media')){
            $audios = [];
            foreach($request->file('media') as $media){
                if(!$media->isValid()){
                    return $this->error(__('laraguppy::chatapp.invalid_audio'));
                }
                
                $audioName = $media->getClientOriginalName();
                $extension = $media->extension();

                $file = [
                    'path'  => 'public/laraguppy/audio/',
                    'fileName'  => $audioName,
                    'extension'  => $extension,
                ];

                $audioName = (new MessagesService)->getUniqueFileName($file);
                $media->storeAs('laraguppy/audio/', $audioName, getStorageDisk());
            
                $audios = [
                    'file'       => 'laraguppy/audio/'. $audioName,
                    'fileName'   => $audioName,
                    'fileSize'   => $media->getSize(),
                    'fileType'   => ConfigurationManager::MESSAGE_AUDIO,
                    'mimeType'   => $media->getClientMimeType(),
                ];

                if(!empty($audios)){
                    (new MessagesService)->addAttachment($message, ['attachments' => $audios]);
                    
                }
            }
           
        }
    }

    /**
     * Send voice
     */
    public function sendVoice($request, $message)
    {
        if($request->hasFile('media')){
            $voices = [];
            foreach($request->file('media') as $media){
                if(!$media->isValid()){
                    return $this->error(__('laraguppy::chatapp.invalid_voice'));
                }
                
                $voiceName               = uniqid(). '.' .$media->extension();
                $media->storeAs('laraguppy/voice/', $voiceName, getStorageDisk());
                $voices = [
                    'file' => 'laraguppy/voice/'. $voiceName,
                    'fileName'   => $voiceName,
                    'fileSize'   => $media->getSize(),
                    'fileType'   => ConfigurationManager::MESSAGE_VOICE,
                    'mimeType'   => $media->getClientMimeType(),
                ];
                if(!empty($voices)){
                    (new MessagesService)->addAttachment($message, ['attachments' => $voices]);
                }
            }
           
         }
    }

    /**
    * Add attachment
    */
    public function addAttachment($message, $attachment)
    {
        return $message->attachments()->create($attachment);
    }
    /**
    * Send notification
    */
    public function storeNotification($message, $notificationType)
    {
        return $message->notification()->create([
            'notification_type' => $notificationType,
            'notificationable_id' => auth()->user()->id,
            'notificationable_type' => auth()->user()::class,
        ]);
    }
    
    /**
     * Get unique document name
     */
    public function getUniqueFileName($file, $counter = 0){
        if(!Storage::disk('local')->exists($file['path'].$file['fileName'])){
            return $file['fileName'];
        }
        $file['fileName'] = Str::replace('-'.$counter.'.'.$file['extension'], '.'.$file['extension'], $file['fileName']);
        $file['fileName'] = Str::replace('.'.$file['extension'], '-'.++$counter.'.'.$file['extension'], $file['fileName']);
        return $this->getUniqueFileName($file, $counter);

    }

    /**
     * Custom pagination for array
     */
    public function paginate($items)
    {
        $page = Paginator::resolveCurrentPage() ?? 1;
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, 5), $items->count(), 5, $page);
    }

    /**
     * Delete a message
     */
    public function deleteMessage($messageId){
        $message = Message::whereMessageableId(auth()->user()->id)->whereId($messageId)->first();
        if ($message) {
            $message->delete();
            return $message;
        }
        return null; 
    }  
}
