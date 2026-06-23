<script setup>
    import {ref, defineAsyncComponent} from "vue";
    const QuoteMessageList = defineAsyncComponent(() => import('../quoteMessages/QuoteMessageList.vue'));
    const MessageActions = defineAsyncComponent(() => import( '../messageActions/MessageActions.vue'));

    const props = defineProps(['message']);
    const { message } = props;
</script>
<template>
    <div class="at-message at-sendpdffile" :id="'message_'+message.messageId">
        <h5 v-if="!message.isSender && message.threadType === 'group'">{{message.name}}</h5>
        <span class="at-msgload" v-if="message.parent && !message.messageId" ><i class="at-spinericon"></i></span>
        <QuoteMessageList :message="message.replyMessage" :msgId="message.messageId" v-if="message.replyMessage">
            <div class="at-sendfile">
                <i class="laraguppy-file-01"></i>
                <span v-if="message.attachments">{{message.attachments[0]?.fileName}}<em>{{message.attachments[0]?.fileSize}}</em></span>
            </div>
            <template v-slot:message_actions>
                <MessageActions v-if="message.messageId" :isDownload="false" :message="message" />
            </template>
        </QuoteMessageList>
        <div v-else class="at-sendfile">
            <i class="laraguppy-file-01"></i>
            <span v-if="message.attachments">{{message.attachments[0]?.fileName}}<em>{{message.attachments[0]?.fileSize}}</em></span>
            <MessageActions v-if="message.messageId" :isDownload="false" :message="message" />
            <span class="at-msgload" v-else><i class="at-spinericon"></i></span>
        </div>
    </div>
</template>