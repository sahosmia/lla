<script setup>
    import {ref, defineAsyncComponent, onMounted} from "vue";
    import { storeToRefs } from 'pinia';
    import { debounce } from 'lodash';
    import useSettingsStore from "../../../stores/useSettingsStore";
    import useTabStore from "../../../stores/useTabStore";
    import useChatStore from "../../../stores/useChatStore";
    import EmptyChatImage from "../../../assets/images/empty-chat.svg"
    const ChatLoader = defineAsyncComponent(() => import('../../chatLoader/ChatLoader.vue') );
    import avatar from "../../../assets/images/avatar.png";
    const tabStore = useTabStore();
    const chatStore = useChatStore();
    const settingsStore = useSettingsStore();
    const { getTabRecord, loadingStatus, activeTab, search } = storeToRefs( tabStore );
    const { updateTabList } = tabStore;
    const { settings } = storeToRefs( settingsStore );
    const { chatInfo } = storeToRefs( chatStore );
    const { getMessageTime } = settingsStore;
    const { updateChatInfo } = chatStore;
    const isLoadingImage = ref([]);
  
    const updateList = async (loadingType, isSearching = false) => {
        let params = {
            tab: 'private_chat', 
            url: 'threads', 
            loadingType,
            search : search.value,
            isSearching
        }
        await updateTabList(params);
    }

    const scrollHandler = debounce( ({ target: { clientHeight, scrollTop, scrollHeight } } ) => {
        if (scrollTop + clientHeight + 5 >= scrollHeight) {
            updateList('isScrolling');
        }
    }, 250);

    const updateUserInfo = (data) => {
        updateChatInfo(data)
    }

    const notifyMessage = () => {
        return '';
    }

    onMounted(() => {
        let chatRecord = getTabRecord.value('private_chat');
        if( !chatRecord.length || search.value) {
            updateList('isLoading', search.value?.length > 0);
        }
    });

</script>
<template>
    <div id="messages" class="at-userlist_tab active">
        <template v-if="getTabRecord('private_chat').length">
            <ul class="conversation-list" id="private_thread_list" @scroll.prevent="scrollHandler($event)">
                <li @click.prevent="updateUserInfo(friend)" v-for="( friend ) in getTabRecord('private_chat')" :key="friend.threadId" :class="{'active' : chatInfo.threadId === friend.threadId}" class="at-userbar">
                    <figure class="at-userbar_profile" :class="{'at-blockuser' : friend.friendStatus == 'blocked', 'at-shimmer': !isLoadingImage.includes(friend.threadId) }">
                        <i v-if="friend.friendStatus == 'blocked'" class="laraguppy-block"></i>
                        <span v-else class="at-userstatus" :class="{ 'online': friend.isOnline, 'offline': !friend.isOnline, 'at-none': !isLoadingImage.includes(friend.threadId) }"></span>
                        <img @load="() => isLoadingImage.push(friend.threadId)" :class="{'at-none': !isLoadingImage.includes(friend.threadId) }" :src="friend.photo ? friend.photo : ( settings.defaultAvatar ? settings.defaultAvatar : avatar )" :alt="friend.name">
                    </figure>
                    <div v-if="friend.name" class="at-userbar_title">
                        <h3 v-if="friend.name">{{friend.name}}</h3>
                        <!-- when clear chat is false -->
                        <template v-if="!friend.clearChat">
                            <span v-if="friend.deletedAt"><i class="laraguppy-block"></i>{{$t('chatapp.deleted_message')}}</span>	
                            <span v-else-if="friend.messageType === 'text' ">{{friend.body}}</span>
                            <span v-else-if="['document','audio','video','image'].includes(friend.messageType)"><i class="laraguppy-file-01"></i>{{friend.isSender ? $t('chatapp.you_sent_attachment') : $t('chatapp.sent_you_attachment') }}</span>
                            <span v-else-if="friend.messageType === 'location' "><i class="laraguppy-location"></i>{{friend.isSender ? $t('chatapp.you_sent_location') : $t('chatapp.sent_you_location') }}</span>
                            <span v-else-if="friend.messageType === 'voice' "><i class="laraguppy-mic"></i>{{friend.isSender ? $t('chatapp.you_sent_voice_note') : $t('chatapp.sent_you_voice_note') }}</span>	
                            <!-- for notify messages  -->
                            <span v-if="friend.messageType === 'notify'"> 
                                <span v-html="notifyMessage(friend)"></span>
                            </span>
                        </template>
                    </div>
                    <div class="at-userbar_right">
                        <em class="at-notify" v-if="friend.unSeenMessages?.length > 0">
                            {{friend.unSeenMessages.length > 99 ? '99+' : friend.unSeenMessages.length}}
                        </em>
                        <span>{{getMessageTime(friend.createdAt)}}</span>
                    </div>
                </li>
                <ChatLoader v-if="loadingStatus({tab: 'private_chat', loadingType : 'isScrolling'})" type="innerLoading"/>
            </ul>
        </template>
        <template v-else>
            <ChatLoader showText="true" v-if="loadingStatus({tab: 'private_chat', loadingType : 'isLoading'})"/>
            <div v-else class="at-emptyconver">
                <img :src="EmptyChatImage" />
                <span>{{$t('chatapp.no_result_found')}}</span>
            </div>
        </template>
    </div>
</template>