<?php

namespace Amentotech\LaraGuppy\Http\Controllers;

use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Amentotech\LaraGuppy\Models\Thread;
use App\Http\Controllers\Controller;
use Amentotech\LaraGuppy\Traits\ApiResponser;
use Amentotech\LaraGuppy\ConfigurationManager;
use Amentotech\LaraGuppy\Services\ThreadsService;
use Amentotech\LaraGuppy\Services\MessagesService;
use Amentotech\LaraGuppy\Services\PaginateCollection;
use Amentotech\LaraGuppy\Events\GuppyChatPrivateEvent;
use Amentotech\LaraGuppy\Http\Resources\GuppyMessageResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyMessagesResource;
use Amentotech\LaraGuppy\Http\Resources\GuppyAttachmentsResource;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class MessageController extends Controller
{
    use ApiResponser;
    

    /**
     * Display a list of messages/attachments.
     */
    public function index(Request $request)
    {
        $threadId           = $request->threadId;
        $unSeenMessages     = $request->unseenMessages;
        $threadType         = $request->threadType;
        $messagetype        = $request->messageType;

        if(! (new ThreadsService)->threadExists($threadId)) 
        {
            return $this->error(__('laraguppy::chatapp.conversation_not_exists'));
        }
        
        if($messagetype == 'attachments'){
           return  $this->getAttachments($request->threadId);
        }

        if(!empty($unSeenMessages)){
            (new MessagesService)->seenAllMessages($threadId, $unSeenMessages);
            
            $participants = (new ThreadsService)->getThreadParticipants($threadId);
            $participantIds = $participants->pluck('participantable_id')->toArray();

            if( !empty($participantIds) ) {
                $data = [
                    'threadId'      => $threadId,
                    'threadType'    => $threadType,
                    'messageIds'    => $unSeenMessages,
                    'seenAt'        =>  Carbon::now()
                ];
    
                event(new GuppyChatPrivateEvent($data, $participantIds, ConfigurationManager::MessageDeliveredEvent));
            }
        }
        $messages = (new MessagesService)->getMessages($threadId);
        return response()->json([
            'type' => 'success', 
            'data' => new GuppyMessagesResource(PaginateCollection::paginate($messages, config('laraguppy.per_page_records'))),
        ]);
    }


    /**
     * Get all attachments
     */
    public function getAttachments($threadId){
        $threadAttachments      = (new ThreadsService)->getAttachments($threadId);

        return response()->json(['type' => 'success', 'data' => new GuppyAttachmentsResource($threadAttachments)]);
    }

    /**
     * Store a message.
     */
    public function store(Request $request)
    {
        $message = (new MessagesService)->storeMessage(
                [
                    'thread_id'          => $request->threadId,
                    'body'               => $request->body,
                    'messageable_id'     => auth()->user()->id,
                    'messageable_type'   => config('auth.providers.users.model'),
                    'message_type'       => $request->messageType,
                    'parent_message_id'  => $request->replyId,
                ]
            );
         
        $message->timeStamp = $request->timeStamp;

        return match($request->messageType) {
            ConfigurationManager::MESSAGE_TEXT => $this->sendText($message),
            ConfigurationManager::MESSAGE_IMAGE => $this->sendImages($request, $message),
            ConfigurationManager::MESSAGE_VIDEO => $this->sendVideos($request, $message),
            ConfigurationManager::MESSAGE_AUDIO => $this->sendAudios($request, $message),
            ConfigurationManager::MESSAGE_DOCUMENT => $this->sendDocuments($request, $message),
            ConfigurationManager::MESSAGE_VOICE => $this->sendVoice($request, $message),
            ConfigurationManager::MESSAGE_LOCATION => $this->sendLocation($request, $message),
        };

    }

    /**
     * Send text message
     */
    public function sendText($textMessage)
    {
        
        $message = $textMessage->load('thread.participants');
       
        $participantIds =  $message->thread?->participants?->pluck('participantable_id')->toArray();

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));

        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }

        return $this->success(['message' => new GuppyMessageResource($message) ], __('laraguppy::chatapp.message_sent'));
    }


    /**
     * Send images
     */
    public function sendImages($request, $image)
    {
        $message = $image->load('thread.participants');

        $participantIds =  $message->thread?->participants?->pluck('participantable_id')->toArray();

        (new MessagesService)->sendImages($request, $message);

        $message =  new GuppyMessageResource($message->load('attachments'));

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));
      
        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }

        return $this->success(['message' => $message ], __('laraguppy::chatapp.photo_sent'));
    }

    /**
     * Send videos
     */
    public function sendVideos($request, $video)
    {
        $message = $video->load('thread.participants');

        $participantIds =  $message->thread?->participants?->pluck('participantable_id')->toArray();

        (new MessagesService)->sendVideos($request, $message);
       
        $message =  new GuppyMessageResource($message->load('attachments'));

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));
      
        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }

        return $this->success(['message' => $message ], __('laraguppy::chatapp.video_sent'));
    }

     /**
     * Send documents
     */
    public function sendDocuments($request, $document)
    {
        $message = $document->load('thread.participants');

        $participantIds =  $message->thread?->participants?->pluck('participantable_id')->toArray();

        (new MessagesService)->sendDocuments($request, $message);

        $message =  new GuppyMessageResource($message->load('attachments'));

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));
      
        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }

        return $this->success(['message' => $message ], __('laraguppy::chatapp.document_sent'));
    }

    /**
     * Send audios
     */
    public function sendAudios($request, $audio)
    {
        $message = $audio->load('thread.participants');

        $participantIds =  $message->thread?->participants?->pluck('participantable_id')->toArray();

        (new MessagesService)->sendAudios($request, $message);
        
        $message =  new GuppyMessageResource($message->load('attachments'));

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));
      
        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }


        return $this->success(['message' => $message ], __('laraguppy::chatapp.audio_sent'));

    }

    /**
     * Send voice
     */
    public function sendVoice($request, $voice)
    {
        $message = $voice->load('thread.participants');

        $participantIds =  $message->thread?->participants?->pluck('participantable_id')->toArray();

       (new MessagesService)->sendVoice($request, $message);

        $message =  new GuppyMessageResource($message->load('attachments'));

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));
      
        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }
        
         return $this->success(['message' => $message ], __('laraguppy::chatapp.voice_sent'));
    }


    /**
     * Send location
     */
    public function sendLocation($request, $location)
    {
        (new MessagesService)->addAttachment($location, ['attachments' => [
            'latitude'   => $request->latitude,
            'longitude'   => $request->longitude,
        ]]);
        $message = $location->load('thread.participants', 'attachments');
        $participantIds =  $location->thread?->participants?->pluck('participantable_id')->toArray();
        $message =  new GuppyMessageResource($message);

        event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), [auth()->user()->id], ConfigurationManager::MessageSentEvent));
      
        if( !empty($participantIds) )  {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageReceivedEvent));
        }

     return $this->success(['message' => $message ], __('laraguppy::chatapp.location_sent'));

    }

    /**
     * Delete a message
     */
    public function destroy(string $id)
    {
        $message = (new MessagesService)->deleteMessage($id);

        if (!$message) {
            return $this->error(__('laraguppy::chatapp.message_not_found'), 404);
        }
        
        $participants   = (new ThreadsService)->getThreadParticipants($message->thread_id); 
        $participantIds = $participants->pluck('participantable_id')->toArray(); 
        
        if( !empty($participantIds) ) {
            event(new GuppyChatPrivateEvent(new GuppyMessageResource($message), $participantIds, ConfigurationManager::MessageDeletedEvent));
        }
    
       return $this->success([], __('laraguppy::chatapp.message_deleted'));
    }

    /**
     * DeliveredMessage all messages
     */
    public function deliveredMessage(Request $request)
    {
        (new MessagesService)->deliveredMessage([
            'thread_id'  => $request->thread_id,
            'message_id' => $request->message_id,
            'seen_by'    => auth()->user()->id,
            'seen_at'    => $request->isSeen ?  Carbon::now() : null
        ]);
        
        $thread         = Thread::find($request->thread_id);
        $participants = $thread?->participants;
        $participantIds = $participants->pluck('participantable_id')->toArray();

        if( !empty($participantIds) ) {
            $data = [
                'threadId'      => $request->thread_id,
                'threadType'    => $thread->thread_type,
                'messageIds'    => [$request->message_id],
                'seenAt'        => $request->isSeen ?  Carbon::now() : null
            ];
            
            event(new GuppyChatPrivateEvent($data, $participantIds, ConfigurationManager::MessageDeliveredEvent));
        }

        return $this->success([], __('laraguppy::chatapp.messages_seen'));
    }

    /**
     * Download Attachment Zip
     */

    public function downloadAllAttachments($threadId)
    {
        try {
            $threadAttachments = (new ThreadsService)->getAllAttachments($threadId);
            $zip_file = 'attachments.zip';
            $zip      = new ZipArchive();
            $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

            foreach ($threadAttachments as $attachment) {
                $attachments = $attachment->attachments;
                $filePath = storage_path('app/public/' . $attachments['file']);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($attachments['file']));
                } else {
                    return response()->json(['error' => 'File not found'], 404);
                }
            }
            $zip->close();
            $zip_dir_file_name = public_path('attachments.zip');
            return response()->download(
                $zip_dir_file_name, 
                'panels.zip', 
                array('Content-Type: application/octet-stream', 'Content-Length:'.filesize($zip_dir_file_name))
            )->deleteFileAfterSend(true);
            
        } catch (FileNotFoundException $e) {
            return response()->json(['error' => 'Thread not found'], 404);
        }
    }

}
