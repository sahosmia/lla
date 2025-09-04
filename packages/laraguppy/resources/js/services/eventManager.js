import { storeToRefs } from "pinia";
import useMessageStore from "../stores/useMessageStore";
import useTabStore from "../stores/useTabStore";
import useProfileStore from "../stores/useProfileStore";
import useChatStore from "../stores/useChatStore";

import ChatManager from "./chatManager";

const EventManager = (userId) => {

    const chatStore = ()=> {
        const store = useChatStore();
        const { chatInfo } = storeToRefs(store); 
        return {
            chatInfo
        }
    }

    const messageStore = useMessageStore();
    const tabStore = useTabStore();
    const profileStore = useProfileStore();
    const { toggleIsMuted } = profileStore;
    const { profileInfo } = storeToRefs(profileStore);

    const { 
        addNewMessage, 
        onDeletedMessage, 
        clearedChat,
    } = messageStore;

    const { 
        removedRecord, 
        setThreadMuted,
        appendTabRecord, 
        respondToInvite, 
        updateFriendReq, 
        updateSlogenMsge, 
        updateUnreadCount, 
        toggleFriendStatus,
        updateDeliveredMsg, 
        updateOnlineStatus,
        requestAcceptedByFriend,
        updateActiveFriendStatus 
    } = tabStore;

    const { activeTab } = storeToRefs(tabStore);

    const sendMessage = (event) => {
        const { message } = event;
        addNewMessage(message, 'onSent');
        let data = {
            body            : message.body,
            isSender        : message.isSender,
            threadId        : message.threadId,
            threadType      : message.threadType,
            messageType     : message.messageType,
            friendStatus    : message.friendStatus,
        }
        updateSlogenMsge(data);
    };

    const receivedMessage = (event) => {
        const { chatInfo } = chatStore()
        const { message } = event;
        if(message.threadId != chatInfo.value?.threadId ){
            const tab = message.threadType == "private" ? 'private_chat' : '';
            updateUnreadCount(tab, 'increment')
        }
        message.isSender = false;
        addNewMessage(message, 'onReceived');
        updateSlogenMsge(message);
        ChatManager.playNotificationBell()
    }

    const friendRequestReceived = (event) => {
        let record = event.message;
        appendTabRecord({
            tab: "request_list",
            recordId: record.userId,
            record,
        });
        removedRecord({
            tab: "contact_list",
            recordId: record.userId,
            record,
        });
        if(activeTab.value != 'request_list'){
            updateUnreadCount('request_list', 'increment')
        }
    };

    // when sent the request to other user from his own side.
    const friendRequestSent = (event) => {
        let {email, name, phone, photo, userId} = event.message;
        appendTabRecord({
            tab:'contact_list', 
            recordId: userId, 
            record : {email, name, phone, photo, userId, friendStatus: "invited" }
        })
    };

    const requestDeclined = (event) => {
        let record = event.message;
        appendTabRecord({
            tab: "contact_list",
            recordId: record.userId,
            record,
        });
        removedRecord({
            tab: "request_list",
            recordId: record.userId,
        })
        updateUnreadCount('request_list', 'decrement')
    };

    const friendReqAccepted = (event) => {
        respondToInvite(event.message)
        updateUnreadCount('request_list', 'decrement')
    };

    const reqAcceptedByFriend = (event) => {
        requestAcceptedByFriend({...event.message, friendStatus: 'active'})
    };

    const reqDeclinedByFriend = (event) => {
        respondToInvite({...event.message, friendStatus:"declined" })
    };

    const requestBlocked = (event) => {
        respondToInvite({...event.message, friendStatus:"invite_blocked" });
        updateUnreadCount('request_list', 'decrement')
    };
    
    const reqBlockedByFriend = (event) => {
        // write code here
    };

    const onlineEvent = (event) => {
        const { userId } = event.message;
        updateOnlineStatus(userId, true)
    };

    const offlineEvent = (event) => {
        const { userId } = event.message;
        updateOnlineStatus(userId, false)
    };

    const deliveredAllMesseges = (event) => {
        let { threadId, threadType, seenAt, messageIds } = event.message
        updateDeliveredMsg({threadId, threadType, seenAt, messageIds});
    }

    const friendBlocked = (event) => {
        const { message } = event;
        updateActiveFriendStatus(message);
    }

    const blockedByFriend = (event) => {
        const { message } = event;
        updateActiveFriendStatus(message);
    }

    const unblockedFriend = (event) => {
        const { message } = event;
        updateActiveFriendStatus(message);
    }

    const unblockedByFriend = (event) => {
        const { message } = event;
        updateActiveFriendStatus(message);
    }

    const deletedMessage = (event) => {
        const { message } = event;
        onDeletedMessage(message)
    }

    const threadCleared = (event) => {
        const { threadId, threadType } = event.message
        clearedChat(threadId);
        updateSlogenMsge({threadId, threadType, messageType:null})
    }

    const toggleNotification = (event) => {
        const { isMuted } = event.message;
        toggleIsMuted(isMuted);
       
    }

    const toggleThreadNotification = (event) => {
        setThreadMuted(event.message);
    }

    window?.Echo?.private(`events-${userId}`)
    .listen('.friend-request-sent' , friendRequestSent)
    .listen('.friend-request-received' , friendRequestReceived)
    .listen('.friendship-accepted' , reqAcceptedByFriend)
    .listen('.friend-request-accepted' , friendReqAccepted)
    .listen('.friend-request-declined' , requestDeclined)
    .listen('.friendship-declined' , reqDeclinedByFriend)
    .listen('.friend-request-blocked' , requestBlocked)
    .listen('.friendship-request-blocked' , reqBlockedByFriend)
    .listen('.friend-blocked' , friendBlocked)
    .listen('.friendship-blocked' , blockedByFriend)
    .listen('.friend-unblocked' , unblockedFriend)
    .listen('.friendship-unblocked' , unblockedByFriend)
    .listen('.message-sent' , sendMessage)
    .listen('.message-received' , receivedMessage)
    .listen('.thread-cleared' , threadCleared)
    .listen('.message-deleted' , deletedMessage)
    .listen('.message-delivered' , deliveredAllMesseges)
    .listen('.toggle-notification' , toggleNotification)
    .listen('.toggle-thread-notification' , toggleThreadNotification)

    window?.Echo?.channel('events')
    .listen('.user-is-online' , onlineEvent)
    .listen('.user-is-offline' , offlineEvent);
};
export default EventManager;
