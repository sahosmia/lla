<?php

namespace Amentotech\LaraGuppy;

class ConfigurationManager
{
    const MESSAGES_TABLE                      = 'messages';
    const GP_USERS_TABLE                      = 'gp_users';
    const FRIENDS_TABLE                       = 'friends';
    const GROUPS_TABLE                        = 'groups';
    const CHAT_ACTIONS_TABLE                  = 'chat_actions';
    const GROUP_MEMBERS_TABLE                 = 'group_members';
    const GUEST_ACCOUNTS_TABLE                = 'guest_accounts';
    const ATTACHMENTS_TABLE                   = 'attachments';
    const THREADS_TABLE                       = 'threads';
    const PARTICIPANTS_TABLE                  = 'thread_participants';
    const THREAD_DETAILS_TABLE                = 'thread_details';
    const NOTIFICATIONS_TABLE                 = 'notifications';
    const SEEN_MESSAGES_TABLE                 = 'seen_messages';

    const INVITED_STATUS                      = 'invited';
    const ACTIVE_STATUS                       = 'active';
    const DECLINED_STATUS                     = 'declined';
    const BLOCKED_STATUS                      = 'blocked';
    const UNBLOCKED_STATUS                    = 'unblocked';
    const INVITE_BLOCKED_STATUS               = 'invite_blocked';
    const INVITE_UNBLOCKED_STATUS             = 'invite_unblocked';
    


    const MESSAGE_TEXT                          = 'text';
    const MESSAGE_AUDIO                         = 'audio';
    const MESSAGE_VIDEO                         = 'video';
    const MESSAGE_IMAGE                         = 'image';
    const MESSAGE_DOCUMENT                      = 'document';
    const MESSAGE_VOICE                         = 'voice';
    const MESSAGE_LOCATION                      = 'location';
    const MESSAGE_NOTIFY                        = 'notify';

    const NOTIFY_ACCEPT_FRIEND                  = 'accept_friend';
    const NOTIFY_BLOCK_FRIEND                   = 'block_friend';

    const PRIVATE                               = 'private';
    const GROUP                                 = 'group';

    const CLEAR_CHAT_ACTION                     = 'clear_chat';
    const MUTE_ALL_NOTIFICATIONS                = 'mute_all_notifications';
    const MUTE_SPECIFIC_NOTIFICATIONS           = 'mute_specific_notifications';

    const NOTIFICATION_MUTE                     = 'mute_notifications';
    const NOTIFICATION_UNMUTE                   = 'unmute_notifications';

    const FriendRequestSentEvent                = 'friend-request-sent';
    const FriendRequestReceivedEvent            = 'friend-request-received';
    const FriendRequestAcceptedEvent            = 'friend-request-accepted';
    const FriendshipAcceptedEvent               = 'friendship-accepted';
    const FriendRequestDeclinedEvent            = 'friend-request-declined';
    const FriendshipDeclinedEvent               = 'friendship-declined';
    const FriendRequestBlockedEvent             = 'friend-request-blocked';
    const FriendshipRequestBlockedEvent         = 'friendship-request-blocked';
    const FriendBlockedEvent                    = 'friend-blocked';
    const FriendshipBlockedEvent                = 'friendship-blocked';
    const FriendUnblockedEvent                  = 'friend-unblocked';
    const FriendshipUnblockedEvent              = 'friendship-unblocked';
    const ThreadCleared                         = 'thread-cleared';
    const MessageSentEvent                      = 'message-sent';
    const MessageReceivedEvent                  = 'message-received';
    const MessagesSeenEvent                     = 'messages-seen';
    const MessageDeliveredEvent                 = 'message-delivered';
    const MessageDeletedEvent                   = 'message-deleted';
    const UserOnlineEvent                       = 'user-is-online';
    const UserOfflineEvent                      = 'user-is-offline';
    const AccountNotificationEvent              = 'toggle-notification';
    const ThreadNotificationEvent               = 'toggle-thread-notification';
    
}
