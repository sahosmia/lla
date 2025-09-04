<?php

namespace Amentotech\LaraGuppy\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuppySettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'maxFileUploads'	    => ini_get("max_file_uploads"),
            'enableTabs'            => config('laraguppy.enable_tabs') ?? ['contact_list', 'friend_list', 'private_chat'],
            'defaultActiveTab'      => config('laraguppy.default_active_tab') ?? 'contact_list',
            'reportUser'            => config('laraguppy.report_user') ?? true,
            'reportingReasons'      => config('laraguppy.reporting_reasons') ?? ['Inappropriate Content', 'Spam', 'Privacy violates', 'Others' ],
            'defaultAvatar'         => config('laraguppy.default_avatar_url') ?? asset('images/default-user.jpg'),
            'deleteMessage'         => config('laraguppy.delete_message') ?? true,
            'clearChat'             => config('laraguppy.clear_chat') ?? true,
            'timeFormat'            => config('laraguppy.time_format') ?? '12hrs',
            'locationSharing'       => config('laraguppy.location_sharing') ?? false,
            'emojiSharing'          => config('laraguppy.emoji_sharing') ?? true,
            'voiceSharing'          => config('laraguppy.voice_sharing') ?? true,
            'imageSize'             => config('laraguppy.image_size') ?? 5000,
            'imageExt'              => config('laraguppy.image_ext') ?? ['.jpg','.png'],
            'audioSize'             => config('laraguppy.audio_file_size') ?? 1000,
            'audioExt'              => config('laraguppy.audio_file_ext') ?? ['.mp3','.wav'],
            'videoSize'             => config('laraguppy.video_file_size') ?? 1000,
            'videoExt'              => config('laraguppy.video_file_ext') ?? ['.mp4','.flv','.3gp'],
            'documentSize'          => config('laraguppy.document_file_size') ?? 1000,
            'documentExt'           => config('laraguppy.document_file_ext') ?? ['.pdf','.doc','.txt'],
            'notificationBellUrl'   => config('laraguppy.notification_bell_url') ?? '',
            'enableChatInvitation'  => config('laraguppy.enable_chat_invitation') ?? '',
            'isRtl'                 => config('laraguppy.enable_rtl') == 'yes',
            'redirectUrl'           => config('laraguppy.redirect_url') ?? '/',
        ];
    }
}
