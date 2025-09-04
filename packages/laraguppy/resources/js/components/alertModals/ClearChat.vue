<script setup>
    import { ref } from 'vue';
    import { storeToRefs } from 'pinia';
    import useEventsBus from "../../services/useEventBus";
    import useAlertModals from "../../stores/useAlertModals";
    import useChatStore from "../../stores/useChatStore";
    import useMessageStore from "../../stores/useMessageStore";
    import RestApiManager from "../../services/restApiManager";

    const isloading = ref(false);
    const { emit } = useEventsBus();
    const alertModals = useAlertModals();
    const { toggleModal } = alertModals
    const chatStore = useChatStore();
    const { chatInfo } = storeToRefs(chatStore);
    const messageStore = useMessageStore();
    const { clearedChat } = messageStore;

    const clearChat = async () => {
        isloading.value = true;
        let response = await RestApiManager.postRecord('clear-chat',{threadId : chatInfo.value?.threadId});
        isloading.value = false;
        if( response.type == 'success' ){
            clearedChat(chatInfo.value?.threadId);
            emit('closeSidebar')
            toggleModal('clearChat', false);
        }
    }
</script>
<template>
    <div id="clearchat" class="at-modal at-invitepopup at-modalopen at-fadin">
        <div class="at-modaldialog">
            <div class="at-alert">
                <h2>{{ $t('chatapp.clear_chat') }} <i @click.prevent="toggleModal('clearChat', false)" class="at-guppy-removemodal laraguppy-multiply"></i> </h2>
                <p>{{ $t('chatapp.clear_chat_desc') }}</p>
                <div class="at-alert_btns">
                    <a href="javascript:void(0);" @click.prevent="toggleModal('clearChat', false)" class="at-anchor at-guppy-removemodal" :class="{'at-disabled' : isloading }">
                        {{ $t('chatapp.not_right_now') }}
                    </a>
                    <a href="javascript:void(0);" @click.prevent="clearChat()" :class="{'at-disabled' : isloading }" class="at-btn at-btn_action">
                        <span v-if="isloading" class="at-msgload"><i class="at-spinericon"></i></span>
                        {{$t('chatapp.clear_chat_button')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>