import { ref, computed } from 'vue';
import { defineStore, storeToRefs } from 'pinia';
import RestApiManager from '../services/restApiManager';
import useChatStore from "./useChatStore";
import useTabStore from './useTabStore';
import ChatManager from '../services/chatManager';
import moment from "moment";
export default defineStore('useMessageStore', () => {

    const messagesList  = ref({});
    const replyMsgIds   = ref({});
    const messageInput  = ref({});

    const chatStore = () => {
        const store = useChatStore();
        const { chatInfo, isMsgChat } = storeToRefs(store);
        return {
            chatInfo,
            isMsgChat,
        }
    }

    const tabStore = () => {
        const store = useTabStore();
        const { tabList } = storeToRefs(store)
        const { updateDeliveredMsg } = store;
        return {
            tabList,
            updateDeliveredMsg
        }
    }

    const msgInput = computed(() => (threadId = '') => {
        return messageInput.value[threadId] ?? '';
    });

    const replyId = computed(()=> (threadId = '') => {
        return replyMsgIds.value[threadId] ?? '';
    });

    const disableFooter = computed(() => (threadId = '') => {
        let lastMsg = messagesList?.value[threadId]?.messages.at(-1);
        return lastMsg?.messageType == 'loading' ? true : false;
    });

    const replyMsg = computed(() => (threadId = '') => {
        const { isMsgChat } = chatStore();
        const { chatInfo } = chatStore();
        let chatKey     = isMsgChat?.value ? chatInfo.value?.threadId : threadId;
        let replyMsgId  = replyMsgIds.value[chatKey];
        return replyMsgId ? messagesList.value[chatKey]?.messages.find((message) => message.messageId == replyMsgId) : null;
    });

    const attachmentList = computed(() => (threadId) => {
        let attachments = messagesList.value[threadId]['attachments'];
        if( Object.keys(attachments).length){
            return Object.values(attachments)
        }
        return [];
    });
    
    const mediaLoading = computed(() => (threadId) => {
        return  messagesList.value[threadId]['mediaLoading'];
    });

    const loadChat = computed(() => (threadId) => {
        return messagesList.value[threadId] ? messagesList.value[threadId].isLoading : true
    });

    const mediaPages = computed(() => (threadId) => {
        return {
            totalMediaPages : messagesList.value[threadId] ? messagesList.value[threadId].totalMediaPages : 1,
            mediaPage : messagesList.value[threadId] ? messagesList.value[threadId].mediaPage : 1
        }
    });

    const setMsgInput = ({ threadId, text }) => {
        messageInput.value[threadId] = text;
    }

    const downloadAttachments = async (messageId) => {
        const response = await RestApiManager.getRecord(`download-attachments?messageId=${messageId}`);
        if(response?.type == 'success'){
            ChatManager.downloadFile(response.data.downloadUrl, response.data.fileName);
        } else if( response.data.type == "error" ) {
            alert(response.data.message_desc);
        }
    }

    const appendMsg = (_data) => {
        let data = JSON.parse(JSON.stringify(_data));
        if( data.messageType === 'text' && data.replyId ){
            data['parent'] = messagesList?.value[data.threadId].messages.find( msg => Number(msg.messageId) === Number(data.replyId) );
        }
        data['createdAt']   = new Date();
        const checkRecord   = messagesList?.value?.[data.threadId]?.messages?.findIndex(msg => Number(msg.timeStamp) === Number(data.timeStamp));
        if( checkRecord == -1 ){
            messagesList?.value[data.threadId]['messages'].push(data);
            setTimeout(() => {
                ChatManager.scrollList({behavior: 'smooth', threadId: data.threadId });
            }, 200);
        }
        return;
    }

    const addNewMessage = async (_data, eventType) => {
        let data = JSON.parse(JSON.stringify(_data));
        let checkRecord = null;
        const { chatInfo } = chatStore();

        if(eventType == 'onSent'){
            checkRecord   = messagesList?.value?.[data.threadId]?.messages?.findIndex(msg => Number(msg.timeStamp) === Number(data.timeStamp));
        } else {
            checkRecord   = messagesList?.value?.[data.threadId]?.messages?.findIndex(msg => Number(msg.messageId) === Number(data.messageId));
        }

        if( (checkRecord == -1) && messagesList?.value?.[data.threadId]?.['messages']){
            messagesList?.value[data.threadId]['messages'].push(data);
            setTimeout(() => {
                ChatManager.scrollList({behavior: 'smooth', threadId: data.threadId });
            }, 200);
        }

        if(eventType == 'onReceived'){
            await RestApiManager.postRecord('delivered-message', {thread_id : data.threadId, message_id: data.messageId, isSeen : data.threadId == chatInfo.value?.threadId })
        }
        return;
    }

    const sendMessage = async (formData, headerSettings = 'application/json') => {
        let dataValues = Object.fromEntries(formData);
        let { replyId = null , threadId } = dataValues;
        dataValues['messageType'] = dataValues.messageType == 'text' ? 'text' : 'loading';
        appendMsg(dataValues);
        setMsgInput({threadId : threadId, text :''} );
        if(replyId){
            removeReplyMsgId(threadId);
        }
        const response = await RestApiManager.sendMessage('messages', formData, headerSettings);
        if(response.type === 'success'){
            let { threadId, timeStamp } = response.data.message;
            let index = messagesList?.value[threadId]?.messages.findIndex( msg => msg.timeStamp === timeStamp );
            if (index > -1 ) {
                messagesList.value[threadId]['messages'][index] = response.data.message;
            }
            setTimeout(() => {
                ChatManager.scrollList({behavior: 'smooth', threadId });
            }, 200);
        }
    }

    const onDeletedMessage = (data) => {
        const {threadId, messageId } = data;
        let index   = messagesList.value[threadId]?.['messages'].findIndex((message) => message.messageId == messageId);
        if( index > -1 && messagesList.value?.[threadId]?.['messages']){
            messagesList.value[threadId]['messages'][index]['deletedAt'] = data.deletedAt;
        }
    }

    const deleteMessage = async (id, threadId) => {
        const response = await RestApiManager.deleteRecord(`messages/${id}`);
        if( response?.type === 'success'){
            let index   = messagesList.value[threadId]['messages'].findIndex((message) => message.messageId == id);
            messagesList.value[threadId]['messages'][index].deletedAt = new Date();
        }
        return response?.type === 'success';
    }

    const updateReplyMsgId = (threadId, msgId) => {
        replyMsgIds.value[threadId] = msgId;
    }

    const removeReplyMsgId = (threadId) => {
        if( replyMsgIds.value.hasOwnProperty(threadId) ){
            delete replyMsgIds.value[threadId];
        }
    }

    const clearedChat = (threadId) => {
        if( messagesList?.value?.[threadId]?.['messages'] ){
            messagesList.value[threadId]['messages'] = []
        }
    }

    const getAttachments = async (threadId, page) => {
        let { attachments = [], } = messagesList.value[threadId];
        messagesList.value[threadId]['mediaLoading'] = true;
        const response = await RestApiManager.getRecord(`messages?threadId=${threadId}&page=${page}&messageType=attachments`);
        messagesList.value[threadId]['mediaLoading'] = false;
        if(response?.type === 'success'){
            let { pagination, list } = response?.data;
            if(list?.length){
                messagesList.value[threadId]['attachments'] = pagination.currentPage > 1 ? [...attachments, ...list] : list;
                messagesList.value[threadId]['mediaPage'] = ++pagination.currentPage;
                messagesList.value[threadId]['totalMediaPages'] = pagination.totalPages;
            }
        }
    }

    const resetAttachments = (threadId) => {
        messagesList.value[threadId]['attachments'] = [];
        messagesList.value[threadId]['mediaPage'] = 1;
        messagesList.value[threadId]['totalMediaPages'] = 1;
    }

    const messages = computed(() => (threadId) => {
        if ( messagesList.value[threadId] ) {
            let cDate = null;
            return messagesList.value[threadId].messages.map( (message) => {
                const date = message?.createdAt ? new Date(message.createdAt).toLocaleDateString() : null;
                if (cDate !== date && message.createdAt) {
                    var currentMessageDate = moment(new Date(message.createdAt));
                    var today = moment().endOf("day");
                    let dateDifference = today.diff(currentMessageDate, "days");
  
                    if (dateDifference == 0) {
                        message.date = 'Today';
                    } else if (dateDifference == 1) {
                        message.date = 'Yesterday';
                    } else if (dateDifference > 1 && dateDifference < 7) {
                        message.date = moment(new Date(message.createdAt)).format('ddd MMMM D, YYYY');
                    } else {
                        message.date = moment(new Date(message.createdAt)).format('ddd MMMM D, YYYY');
                    }
                } else {
                    message.date = "";
                }

                cDate = date;
                message['threadId'] = threadId;
                return message;
            });
        } else {
          return [];
        }
    });

    // mutations functions
    const getMessages = async (threadType, threadId, unSeenMsgs = [], scrollTop = 0 ) => {
        const { updateDeliveredMsg } = tabStore();
        let { [threadId]: thread = { messages: [], attachments : {}, page: 0, isLoading: true, mediaPage: 1, mediaLoading: false, totalMediaPages: 1,  totalPages: 1 } } = messagesList.value;
      
        let { page, messages, totalPages } = thread;

        if(page < totalPages){
            thread = { ...thread, page: page + 1, isLoading: true };
            messagesList.value[threadId] = thread;
            let unSeen = unSeenMsgs.map((n, index) => `unseenMessages[${index}]=${n}`).join('&');

            const response = await RestApiManager.getRecord(`messages?threadType=${threadType}&threadId=${threadId}&page=${thread.page}&${unSeen}`);
            if (response.type === "success") {
                updateDeliveredMsg({ threadId, threadType })
                const {list, pagination } = response.data;
                thread = { ...thread,isLoading : false, messages: [...list, ...messages], totalPages: pagination.totalPages };
                messagesList.value[threadId] = thread;
                setTimeout(() => {
                    ChatManager.scrollList({threadId, scrollHeight: scrollTop});
                }, 200);
            }
        }
    }

    const seenAllMesseges = () => {
        messagesList.value[threadId]
    }

    const updateAttachmentList = (threadId, list) => {
        let { mediaPage, attachments = [] } = messagesList.value[threadId];
        messagesList.value[threadId]['attachments'] = [...list, ...attachments]
    }

    return {
        replyId,
        replyMsg,
        msgInput,
        loadChat,
        messages,
        mediaLoading,
        messagesList,
        disableFooter,
        attachmentList,
        mediaPages,
        clearedChat,
        getMessages,
        setMsgInput,
        sendMessage,
        addNewMessage,
        deleteMessage,
        getAttachments,
        onDeletedMessage,
        updateReplyMsgId,
        removeReplyMsgId,
        resetAttachments,
        downloadAttachments,
        updateAttachmentList
    }
})