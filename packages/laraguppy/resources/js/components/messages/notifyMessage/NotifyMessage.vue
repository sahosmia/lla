<script setup>
    import {computed} from "vue";
    import { trans } from 'laravel-vue-i18n';
    import useChatStore from "../../../stores/useChatStore";
    import { storeToRefs } from 'pinia';
    const props = defineProps(['message']);
    const { message } = props;
    const chatStore = useChatStore();
    const { chatInfo } = storeToRefs(chatStore);
    const messageText = computed(() => {
        if( message?.threadType == 'private' ){
            let transText = message?.isSender ? 'inv_sender_msg' : 'inv_receiver_msg';
            let youText = trans('chatapp.you');
            if(chatInfo?.value?.name){
                return trans(`chatapp.${transText}`, {'sender_name' : youText, 'username' : chatInfo?.value?.name});
            }
            return '';
        }
    });
    
</script>
<template>
    <div class="at-leftgroupinfo">
        <span v-html="messageText"></span>
    </div>
</template>