import { ref, computed } from "vue";
import { defineStore, storeToRefs } from "pinia";
import RestApiManager from "../services/restApiManager";
import useChatStore from "./useChatStore";

import useMessageStore from "./useMessageStore";

export default defineStore("useTabStore", () => {
    const statusCode = ref("");
    const errorMsg = ref("");
    const activeTab = ref('');
    const activeThread = ref('');

    const messageStore = () => {
        const store = useMessageStore();
        const { messagesList } = storeToRefs(store);
        return {
            messagesList
        }
    }

    const chatStore = () => {
        const store = useChatStore();
        const { chatInfo } = storeToRefs(store);
        const { updateChatInfo } = store;
        return {
            chatInfo,
            updateChatInfo
        }
    }


    const tabData = {
        hasMore: true,
        isLoading: false,
        isScrolling: false,
        keyword: "",
        page: 0,
        record: {},
    };

    const tabList = ref({
        contact_list: JSON.parse(JSON.stringify(tabData)),
        request_list: JSON.parse(JSON.stringify(tabData)),
        friend_list: JSON.parse(JSON.stringify(tabData)),
        private_chat: JSON.parse(JSON.stringify(tabData)),
        group_chat: JSON.parse(JSON.stringify(tabData)),
        post_chat: JSON.parse(JSON.stringify(tabData)),
        customer_support_chat: JSON.parse(JSON.stringify(tabData)),
    });

    const unreadCounts = ref({
        contact_list: 0,
        request_list: 0,
        friend_list: 0,
        private_chat: 0,
        group_chat: 0,
        post_chat: 0,
        customer_support_chat: 0,
    });

    const search = ref('');

    function setActiveTab(tab) {
        activeTab.value = tab
    }

    const getTabRecord = computed(() => (tab) => {
        const hasRecord = Object.keys(tabList.value[tab]["record"]).length;
        return hasRecord ? Object.values(tabList.value[tab]["record"]) : [];
    });

    const hasMoreRecord = computed(() => (tab) => {
        return Object.values(tabList.value[tab]["hasMore"]);
    });

    const loadingStatus = computed(() => ({ tab, loadingType }) => {
        return tabList.value[tab][loadingType];
    });

    const setSearch = (value) => {
        search.value = value;
    }

    const updateActiveThread = (value) => {
        activeThread.value = value;
    }

    const getUnreadCounts = async () => {
        let response = await RestApiManager.getunreadCounts();
        
        if (response.type === "success") {
            for ( let [tab, count] of Object.entries( response.data ) ) {
                unreadCounts.value[tab] = count
            }
        }
    }

    const updateFriendReq = (data) => {
        const { updateChatInfo } = chatStore();

        if(tabList.value["request_list"]["record"][data.userId]){
            delete tabList.value["request_list"]["record"][data.userId];
        }
        
        switch (data.friendStatus) {
            case "active":
                if(!tabList.value["friend_list"]["record"][data.threadId]){
                    tabList.value["friend_list"]["record"][data.threadId] = data;
                }

                if(!tabList.value["private_chat"]["record"][`private_${data.threadId}`]){
                    tabList.value["private_chat"]["record"][`private_${data.threadId}`] = data;
                }
                
                updateChatInfo(data);
                break;
            case "declined":
                data["friendStatus"] = "";
                tabList.value["contact_list"]["record"][data.userId] = data;
                break;
            default: 
                break;
        }
    };

    const respondToInvite = (data) => { // this function used for self events
        const { updateChatInfo } = chatStore();
        switch (data.friendStatus) {
            case "active":
                if(tabList.value["request_list"]["record"][data.userId]){
                    delete tabList.value["request_list"]["record"][data.userId];
                }

                if(!tabList.value["friend_list"]["record"][data.threadId]){
                    tabList.value["friend_list"]["record"][data.threadId] = data;
                }

                if(!tabList.value["private_chat"]["record"][`private_${data.threadId}`]){
                    tabList.value["private_chat"]["record"][`private_${data.threadId}`] = data;
                }
                updateChatInfo(data);
                break;
            case "declined":
                if(tabList.value["request_list"]["record"][data.userId]){
                    delete tabList.value["request_list"]["record"][data.userId];
                }
                tabList.value["contact_list"]["record"][data.userId] = data;
                break;
            case "invite_blocked": // blocked
                if(tabList.value["request_list"]["record"][data.userId]){
                    delete tabList.value["request_list"]["record"][data.userId];
                }
                tabList.value["contact_list"]["record"][data.userId] = data;
                break;
            default:
                break;
        }
    };

    const updateActiveFriendStatus = (data) => {
        const {threadType, threadId} = data;
        const { chatInfo, updateChatInfo } = chatStore();
        let tab = threadType === "private" ? "private_chat" : "group_chat";
        let recId = `${threadType}_${threadId}`;

        if(chatInfo.value.threadId == threadId){
            updateChatInfo({...chatInfo.value, ...data})
        }
        if (tabList.value[tab]?.["record"]?.[recId]) {
            let record = {...tabList.value[tab]["record"][recId]};
            delete tabList.value[tab]["record"][recId];
            tabList.value[tab]["record"] = {
                [recId]:{...record, ...data},
                ...tabList.value[tab]["record"],
            };
        }

        if(threadType === "private" ){
            if(tabList.value["friend_list"]["record"][threadId]){
                tabList.value["friend_list"]["record"][threadId] = data;
            }
        }
    }

    const requestAcceptedByFriend = (data) => {
        let recordId = `${data.threadType}_${data.threadId}`
        if(tabList.value["contact_list"]["record"][data.userId]){
            delete tabList.value["contact_list"]["record"][data.userId];
        }

        if(!tabList.value["friend_list"]["record"][data.threadId]){
            tabList.value["friend_list"]["record"][data.threadId] = data;
        }

        if(!tabList.value["private_chat"]["record"][recordId]){
            tabList.value["private_chat"]["record"][recordId] = data;
        }
        // updateChatInfo(data);
    }

    const updateFriendStatus = async (data) => {
        let response = await RestApiManager.updateRecord(
            "friends/update",
            data
        );

        if (response.type === "success") {
            toggleFriendStatus(response.data);
            return response;
        }
    };

    // ---------- Actions -----------
    const updateStatus = ({ tab, userId, status }) => {
        tabList.value[tab].record[userId].friendStatus = status;
    }

    const updateUnreadCount = (tab, type ) => {
        if(type == 'increment'){
            ++unreadCounts.value[tab];
        } else {
            if(unreadCounts.value[tab] > 0 ){
                --unreadCounts.value[tab];
            }
        }
    }

    const toggleFriendStatus = (data) => {
        const { chatInfo } = chatStore();
        const { updateChatInfo } = chatStore();
        if (
            tabList.value["friend_list"]?.record?.hasOwnProperty(data.threadId)
        ) {
            tabList.value["friend_list"].record[data.threadId]["friendStatus"] =
                data.friendStatus;
            tabList.value["friend_list"].record[data.threadId]["blockedBy"] =
                data?.blockedBy;
        }

        if (
            tabList.value["private_chat"]?.record?.hasOwnProperty(data.threadId)
        ) {
            tabList.value["private_chat"].record[data.threadId][
                "friendStatus"
            ] = data.friendStatus;
            tabList.value["private_chat"].record[data.threadId]["blockedBy"] =
                data?.blockedBy;
        }

        if (chatInfo.value?.threadId == data.threadId) {
            let chatInfoData = chatInfo.value;
            chatInfoData.friendStatus = data.friendStatus;
            updateChatInfo(chatInfoData);
        }
    }

    // --------------- Api Actions -----------------
    const updateDeliveredMsg = ({ threadId, threadType, seenAt, messageIds }) => {
        const { messagesList } = messageStore();
        const { chatInfo } = chatStore();
        const { updateChatInfo } = chatStore();

        const tabType = threadType === "private" ? "private_chat" : "group_chat";
        const tab = tabList.value[tabType]["record"];
        const id = `${threadType}_${threadId}`;
        unreadCounts.value[tabType] -= messageIds?.length ?? 0;
        if (id in tab) {
            tab[id]["unSeenMessages"] = [];
        }


        if (chatInfo?.value?.threadId == threadId) {
            let chatInfoData = chatInfo.value;
            chatInfoData.unSeenMessages = [];
            updateChatInfo(chatInfoData);
        }

        if (messagesList?.value[threadId]?.messages?.length) {
            messagesList.value[threadId].messages = messagesList.value[threadId].messages.map((message) => {
                if(seenAt){
                    message = { ...message, seenAt: new Date(), deliveredAt: new Date()}
                } else {
                    message = { ...message, deliveredAt: new Date()}
                }
                return message;
            });
        }
    };

    const appendTabRecord = (data) => {
        const { tab, recordId, record } = data;
        if(!tabList.value[tab]?.["record"]?.[recordId]){
            tabList.value[tab]["record"][recordId] = record;
        }
    };

    const removedRecord = (data) => {
        const { tab, recordId } = data;
        delete tabList.value?.[tab]?.["record"]?.[recordId];
    };

    const updateSlogenMsge = (data) => {
        const { chatInfo } = chatStore();
        const { threadType, threadId } = data;
        let tab = threadType === "private" ? "private_chat" : "group_chat";
        let recId = `${threadType}_${threadId}`;

        if (tabList.value[tab]?.["record"]?.[recId]) {
            let record = {...tabList.value[tab]["record"][recId]};
            
            delete tabList.value[tab]["record"][recId];

            tabList.value[tab]["record"] = {
                [recId]:{...record, ...data},
                ...tabList.value[tab]["record"],
            };

            if (chatInfo?.value?.threadId != threadId) {
                let messages = tabList.value[tab]["record"][recId]["unSeenMessages"] ?? [];
                if (!messages.includes(data.messageId)) {
                    let unSeenMessages = [...messages, data.messageId];
                    tabList.value[tab]["record"][recId]["unSeenMessages"] = unSeenMessages;
                }
            }
        } else {
            tabList.value[tab]["record"] = {
                [recId]:{...data, unSeenMessages: [data.messageId]},
                ...tabList.value[tab]["record"],
            };
        }
    };

    const findKey = (obj, compareKey, returnKey, val) => {
        if (typeof obj === "object") {
          for (const key in obj) {
            if (key === compareKey && obj[key] === val) {
              return obj[returnKey];
            } else {
              const result = findKey(obj[key], compareKey, returnKey, val);
              if (result !== null) return result;
            }
          }
        }
        return null;
    };

    // for offline/Online events
    const updateOnlineStatus = (userId, isOnline) => {
        const update = (listName, userId, isOnline) => {
            let list = tabList.value[listName]?.record;

            let threadId = ["friend_list", "private_chat"].includes(listName) ? findKey(list, 'userId', 'threadId', userId) : userId;
            if (threadId) {
                if(listName == 'private_chat'){
                    threadId = `private_${threadId}`;
                }
                if(list[threadId]){
                    list[threadId].isOnline = isOnline;
                }
            }
        }

        update("friend_list", userId, isOnline);
        update("private_chat", userId, isOnline);
        update("contact_list", userId, isOnline);
    }

    async function updateTabList({
        tab,
        url,
        loadingType,
        search,
        isSearching = false,
    }) { 
        const currentTab = tabList.value[tab];
        const { updateChatInfo } = chatStore();
        if (isSearching) {
            currentTab.hasMore = true;
            currentTab.record = {};
            currentTab.page = 0;
        }

        if (currentTab.hasMore) {
            currentTab.page += 1;
            currentTab[loadingType] = true;
            let requestURL = `${url}?page=${currentTab.page}${search ? "&search=" + search?.trim() : ""}${currentTab.page == 1 && activeThread.value ? '&activeThread='+activeThread.value : ''}`;
            let response = await RestApiManager.getRecord(requestURL);
            currentTab[loadingType] = false;

            if (response.type == "success") {
                currentTab.hasMore = Object.values(response.data?.list)?.length > 0;

                console.log(currentTab.hasMore)
                currentTab.hasMore && Object.assign(currentTab.record, response.data.list);
                if(activeThread.value){
                    let data = Object.values(response.data.list);
                    let thread = data.find(item => item.threadId == activeThread.value);
                    if(thread){
                        updateChatInfo(thread);
                        activeThread.value = ''
                    }
                }
            } else {
                currentTab.hasMore = false;
                statusCode.value = response.status;
                errorMsg.value = response.errorMsg;
            }
        }
    }

    const setThreadMuted = ({ threadId, isMuted, threadType }) => {
        let tab = threadType === "private" ? "private_chat" : "group_chat";
        let recId = `${threadType}_${threadId}`;
        tabList.value[tab]["record"][recId]["isMuted"] = isMuted;
    }

    return {
        tabList,
        search,
        activeTab,
        unreadCounts,
        getTabRecord,
        activeThread,
        hasMoreRecord,
        loadingStatus,
        setSearch,
        setActiveTab,
        updateStatus,
        removedRecord,
        updateTabList,
        setThreadMuted,
        appendTabRecord,
        getUnreadCounts,
        respondToInvite,
        updateFriendReq,
        updateSlogenMsge,
        updateUnreadCount,
        updateOnlineStatus,
        toggleFriendStatus,
        updateFriendStatus,
        updateDeliveredMsg,
        updateActiveThread,
        requestAcceptedByFriend,
        updateActiveFriendStatus
    };
});
