<script setup>
    import { ref } from "vue";
    import { storeToRefs } from 'pinia';
    import useChatStore from "../../stores/useChatStore";
    import useAlertModals from "../../stores/useAlertModals";
    import useTabStore from "../../stores/useTabStore";
    import useEventsBus from "../../services/useEventBus";

    const tabStore = useTabStore();
    const chatStore = useChatStore();
    const alertModals = useAlertModals();
    const { chatInfo } = storeToRefs(chatStore);
    const { updateFriendStatus } = tabStore;
    const { updateChatInfo } = chatStore;
    const { toggleModal } = alertModals;
    const isOpenModel = ref(false);
    const isloading = ref(false);
    const { emit } = useEventsBus();

    const toggleBlockUser = async () => {
        let status = chatInfo.value.friendStatus == 'active' ? 'blocked' : 'active';
        isloading.value = true;
        let response = await updateFriendStatus({ 
            userId          : chatInfo.value.userId, 
            friendStatus    : status, 
            unblock         : status == 'active' ? true : false
        });
        isloading.value = false;

        if(response.type == 'success'){
            updateChatInfo(response.data);
            emit('closeSidebar')
            toggleModal('blockFriend', false );
        }
    }
</script>
<template>
    <div id="blockuser" class="at-modal at-modalopen at-fadin">
        <div class="at-modaldialog">
            <div class="at-alert">
                <h2>{{chatInfo.friendStatus ? $t('chatapp.unblock_user_heading', {'username' : chatInfo.name}) : $t('chatapp.block_user_title' ,{'username': chatInfo.name}) }} <i @click.prevent="toggleModal('blockFriend', false )" class="at-guppy-removemodal laraguppy-multiply"></i></h2>
                <p>{{ chatInfo.friendStatus ? $t('chatapp.unblock_user_desc') : $t('chatapp.block_user_desc')}}</p>
                <div class="at-alert_btns">
                    <a @click.prevent="toggleModal('blockFriend', false )" href="javascript:void(0);" class="at-anchor at-guppy-removemodal">
                        {{$t('chatapp.not_right_now')}}
                    </a>
                    <a href="javascript:void(0);" @click.prevent="toggleBlockUser()" :class="{'at-disable-btn' : isloading }" class="at-btn at-btn_action">
                        {{ chatInfo?.friendStatus === 'blocked' ? $t('chatapp.unblock_button') : $t('chatapp.block_button')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>