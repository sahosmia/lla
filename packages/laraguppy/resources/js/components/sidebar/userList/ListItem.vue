<script setup>
    import {ref, defineAsyncComponent, computed} from "vue";
    import RestApiManager from '../../../services/restApiManager';
    import useTabStore from "../../../stores/useTabStore";
    import useAlertModals from "../../../stores/useAlertModals";
    import useSettingsStore from "../../../stores/useSettingsStore";
    import avatar from "../../../assets/images/avatar.png"
    import { storeToRefs } from 'pinia';
    import useEventsBus from "../../../services/useEventBus";

    const scrollListEmit = defineEmits(['scrollList'])
    const ChatLoader = defineAsyncComponent(() => import('../../chatLoader/ChatLoader.vue') );
    const isLoading = ref(false);
    const isWaiting = ref(false);
    const processingId = ref('');
    const inviteStatus = ref('');
    const isLoadingImage = ref(true);
    const tabStore = useTabStore();
    const alertModals = useAlertModals();
    const { toggleModal } = alertModals;
    const { emit } = useEventsBus();
    const isOpenModal = ref(false);
    const settingsStore = useSettingsStore();
    const { 
        updateStatus, 
        updateTabList, 
    } = tabStore;
    const { tabRecord, tab } = defineProps(['tabRecord', 'tab']);
    const { loadingStatus } = storeToRefs(tabStore);
    const { settings } = storeToRefs(settingsStore);

    const inviteUser = async (userId, friendStatus) => {
        if(friendStatus == 'declined'){
            friendStatus = 'invited'
        } else {
            friendStatus = friendStatus ? friendStatus : 'invited';
        }
        if(['invited','declined'].includes(friendStatus)){
            processingId.value  = userId;
            isLoading.value     = true;
            let data            = { userId, friendStatus }
            let response        = await RestApiManager.updateRecord("friends/update", data);
            isLoading.value     = false;
            if(response?.type === 'success'){
                let statusInfo = { tab : tab, userId, status : response.data.statusText}
                updateStatus(statusInfo)
            }
            isOpenModal.value = false
        }
    }

    const statusClass = (status) => {
        switch (status) {
            case 'invited':
                return 'at-idle-btn at-sendbtn';
            case 'declined':
                return 'at-btn-resend';
            case 'invite_blocked':
                return 'at-user-blocked';
            default:
                return 'at-invitebtn';
        }
    };

    const debounce = (func, delay) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                func (...args);
            }, delay);
        };
    };

    const scrollHandler = debounce( ({ target: { clientHeight, scrollTop, scrollHeight } } ) => {
        if (scrollTop + clientHeight + 5 >= scrollHeight) {
            scrollListEmit('scrollList', 'isScrolling');
        }
    }, 250);

    const respondInvite = (user) => {
        toggleModal('respond', true )
        emit('respondInvite', user);
    }

    const startChat = async (user) => {
        let response = await RestApiManager.postRecord(`start-chat/${user.userId}`);
    }
</script>
<template>
    <ul @scroll.prevent="scrollHandler($event)" v-if="tabRecord.length">
        <li v-for="user in tabRecord" :key="user.user_id" :id="`contact_${user.userId}`" class="at-userbar">
            <figure class="at-userbar_profile" :class="{'at-shimmer':isLoadingImage}">
                <span class="at-userstatus" :class="user.isOnline ? 'online' : 'offline'"></span>
                <img @load="() => isLoadingImage = false" :class="{'at-none': isLoadingImage }" :src="user.photo ? user.photo : ( settings.defaultAvatar ? settings.defaultAvatar : avatar )" :alt="user.name">
            </figure>
            <div class="at-userbar_title">
                <h3>{{user.name}}</h3>
            </div>
            <div class="at-userbar_right">
                <span v-if="isLoading && processingId == user.userId" class="at-msgload"><i class="at-spinericon"></i></span>
                <template v-if="tab == 'contact_list'" >
                    <template v-if="settings.enableChatInvitation">
                        <a @click.prevent="inviteUser(user.userId, user.friendStatus)" href="javascript:void(0);" class="at-btn-sm" :class="[statusClass(user.friendStatus), {'at-idle-btn' : processingId == user.userId && isLoading}]">
                            <template v-if="user.friendStatus == 'declined'">
                                <i class="laraguppy-plus"></i>
                                {{$t(`chatapp.${user.friendStatus}`)}}<span class="at-infotolltip">
                                <em>{{$t('chatapp.declined_info')}}</em></span>
                            </template>
                            <template v-else-if="user.friendStatus == 'invite_blocked'">
                                <strong class="at-btn-blocked">
                                    <span class="at-infotolltip">
                                        <i class="laraguppy-block"></i>
                                        <em>{{$t('chatapp.invite_blocked_desc')}}</em>
                                    </span>
                                    {{$t('chatapp.invite_blocked')}}
                                </strong>
                            </template>
                            <template v-else>
                                {{ user.friendStatus ? $t(`chatapp.${user.friendStatus}`) : $t('chatapp.invite') }} 
                                <i v-if="user.friendStatus == 'invited'" class="laraguppy-check" />
                                <i v-else class="laraguppy-plus"></i>
                            </template>
                        </a>
                    </template>
                    <a v-else href="javascript:void(0);" @click.prevent="startChat(user)" class="at-invitebtn at-btn-sm">{{$t('chatapp.start_chat')}}</a>
                </template>   
                <a v-else href="javascript:void(0);" @click.prevent="respondInvite(user)" class="at-btn-respond at-bgsuccess">{{$t('chatapp.respond')}}</a>
            </div>
        </li>
        <ChatLoader v-if="loadingStatus({tab: 'contact_list', loadingType : 'isScrolling'})" type="innerLoading"/>
    </ul>
</template>

<style lang="scss" scoped>
.at-unknownuser{
    .at-alert_btns{
        .at-anchor{
            color: #585858;
            background: #FFF;
            padding: 7px 13px;
            border-radius: $radius;
            border: 1px solid #EAEAEA;
        }
        .at-anchor,
        .at-btn{
            min-width: auto;
            height: 36px;
            font: 600 rem(14)/em(20,14) $heading-font-family;
        }
    }
}
.at-btn-sm.at-sendbtn{
    color: #585858;
    margin: 3px 0;
    padding: 0 12px;
    font-size: 12px;
    min-width: auto;
    font-weight: 600;
    line-height: 32px;
    border-radius: 10px;
    background: transparent;
}
.at-btn-sm.at-btn-resend,
.at-btn-sm.at-invitebtn{
    margin: 3px 0;
    color: #1da1f2;
    padding: 0 12px;
    font-size: 12px;
    min-width: auto;
    font-weight: 600;
    line-height: 32px;
    border-radius: 10px;
    background: transparent;
}
.at-btn-resend,
.at-sendbtn,
.at-invitebtn {
    i {
        font-size: 20px;
        margin: 0 4px 0 0;
        display: inline-block;
    }
}
</style>
<style lang="scss">

.at-user-blocked{
    padding: 0;
    margin: 3px 0;
    background-color: transparent;
}
.at-modaldialog .at-btnlist{width: auto;}
.at-chat480{
    .at-alert{
        padding-left: 15px;
        padding-right: 15px;
    }
}
.at-userbar_right{
    gap: 8px;
    display: flex;
    align-items: center;
    .at-spinericon{
        width: 18px;
        height: 18px;
    }
}
</style>