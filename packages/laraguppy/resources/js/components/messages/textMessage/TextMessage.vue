<script setup>
    import {ref, defineAsyncComponent} from "vue";
    import { storeToRefs } from "pinia";
    const QuoteMessageList = defineAsyncComponent(()=> import('../quoteMessages/QuoteMessageList.vue'));
    const MessageActions = defineAsyncComponent(() => import( '../messageActions/MessageActions.vue'));
    import useSettingsStore from "../../../stores/useSettingsStore";
    const settingsStore = useSettingsStore();
    const props = defineProps(['message']);
    const message = props.message;
    const disableReply = ref(false);
    
    const deleteMessage = ( data) => {
        this.$emit('deleteMsgEvt', data )
    }
</script>
<template>
    <div class="at-message at-messagetext" :id="'message_'+message.messageId">
        <h5 v-if="!message.isSender && message.threadType == 'group'">{{message.name}}</h5>
        <span class="at-msgload" v-if="message.parent && !message.messageId" ><i class="at-spinericon"></i></span>
        <QuoteMessageList v-if="message.parent" :msgId="message.messageId" :message="message.parent" >
            <span v-linkify>{{message.body}}</span>
            <template v-slot:message_actions>
                <MessageActions v-if="message.messageId" :isDownload="false" :message="message" />
            </template>
        </QuoteMessageList>
        <template v-else>
            <span v-linkify>{{message.body}}</span>
            <MessageActions v-if="message.messageId" :isDownload="false" :message="message" />
            <span class="at-msgload" v-else><i class="at-spinericon"></i></span>
        </template>
  </div>
</template>
<style lang="scss">
.at-messagetext{padding: 16px 44px 16px 16px !important;}
</style>