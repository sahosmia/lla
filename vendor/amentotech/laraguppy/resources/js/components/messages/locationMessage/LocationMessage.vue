<script setup>
    import {ref, defineAsyncComponent } from "vue";
    const MessageActions = defineAsyncComponent(() => import( '../messageActions/MessageActions.vue'));
    const QuoteMessageList  = defineAsyncComponent(()=> import('../quoteMessages/QuoteMessageList.vue'));
    const props = defineProps(['message']);
    const { message } =  props;
    import GeoMap from './GeoMap.vue';
</script>
<template>
    <div class="at-message at-locationmap">
        <h5 v-if="!message?.isSender && (message?.threadType == 'group')">{{message?.name}}</h5>
        <span class="at-msgload" v-if="message.parent && !message.messageId" ><i class="at-spinericon"></i></span>
        <QuoteMessageList :message="message.parent" :msgId="message.messageId" :threadId="message.threadId" v-if="message.parent">
            <GeoMap :location="message.location"/>
            <template v-slot:message_actions>
                <MessageActions v-if="message.messageId" :isDownload="false" :message="message" />
            </template>
        </QuoteMessageList>
        <GeoMap :location="message.location" :msgId="message.messageId"/>
        <MessageActions v-if="message.messageId" :isDownload="false" :message="message" />
        <span class="at-msgload" v-else><i class="at-spinericon"></i></span>
    </div>
</template>
<style lang="scss" scoped>
.at-locationmap{
    width: 100%;
    height: 238px;
    max-height: 100%;
    max-width: 440px;
    .at-messageoption{
        top: 25px;
        right: 25px;
    }
    & > div{
        border-radius: $radius;
    }
}
.at-chat640 .at-locationmap{width: 340px;}
.at-chat480{
    .at-locationmap + .at-messageoption{right: 81px;}
}
.at-chat640 .at-locationmap {
    width: 100%;
}

</style>