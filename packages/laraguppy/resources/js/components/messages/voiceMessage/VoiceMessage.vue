<script setup>
import { ref, defineAsyncComponent } from "vue";
import AudioPlayer from "./AudioPlayer.vue"; 
const props = defineProps(['message']);
const { message } = props;
const disableReply = ref(false);
const MessageAction = defineAsyncComponent(() => import('../messageActions/MessageActions.vue'));
const QuoteMessageList = defineAsyncComponent(()=> import('../quoteMessages/QuoteMessageList.vue'));

</script>
<template>
    <div class="at-message at-audio-area" :id="'message_'+message.messageId">
        <h5 v-if="!message.isSender && (message?.threadType == 'group')">{{message.name}}</h5>
        <QuoteMessageList :message="message?.replyMessage" :msgId="message.messageId" v-if="message?.replyMessage">
            <div class="ready-player-1">
                <AudioPlayer :messageId="message.messageId" :audioSource="message.attachments[0]?.file" />
            </div>
            <template v-slot:message_actions v-if="!disableReply">
                <MessageAction v-if="message.messageId" :isDownload="true" :message="message" />
            </template>
        </QuoteMessageList>
        <div v-else class="ready-player-1">
            <AudioPlayer :messageId="message.messageId" :audioSource="message.attachments[0]?.file" />
            <MessageAction v-if="message.messageId" :isDownload="true" :message="message" />
        </div>
    </div>
</template>
<style>
    .vueAudioBetter{
        margin: 0 !important;
        padding: 0 !important;
        width: 330px !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        overflow: visible !important;
        background-image: none !important;
    }
    .at-message_sender .at-grp_receiver_msg>.at-message>.ready-player-1>.vueAudioBetter,
    .at-messages > .at-message > .ready-player-1 > .vueAudioBetter{
        margin: 0 24px 0 0 !important;
    }
    .operate > span:not(.iconfont){
        color: var(--terguppycolor) !important;
        line-height: 30px;
        font-size: 13px !important;
        padding-left: 20px !important;
    }
    .iconfont{
        color: var(--primguppycolor) !important;
        top: 0 !important;
        left: 0 !important;
        font-size: 20px !important;
    }
    .iconfont.icon-notificationforbidfill,
    .iconfont.icon-notificationfill{line-height: 20px;}
    .iconfont.icon-notificationforbidfill,
    .iconfont.icon-notificationfill{padding-left: 10px !important;}
    /* rtl */
    .wpguppy-rtl .at-message_sender .at-grp_receiver_msg>.at-message>.ready-player-1>.vueAudioBetter,
    .wpguppy-rtl .at-messages > .at-message > .ready-player-1 > .vueAudioBetter{margin: 0 0 0 24px !important;}
    .wpguppy-rtl .operate > span:not(.iconfont){
        padding-left: 0 !important;
        padding-right: 20px !important;
    }
    .wpguppy-rtl .iconfont{
        left: 0 !important;
        right: auto !important;
    }
    .wpguppy-rtl .operate{
        display: flex;
        padding-right: 0;
        padding-left: 10px;
        align-items: center;
    }
    .wpguppy-rtl .operate .iconfont + .iconfont{padding-right: 5px;}
    .wpguppy-rtl .iconfont.icon-notificationforbidfill,
    .wpguppy-rtl .iconfont.icon-notificationfill{
        padding-left: 0 !important;
        padding-right: 10px !important;
    }
    .wpguppy-rtl .at-messages:not(.at-message_sender) .at-chat-msg-220 .at-messageoption_list{
        right: auto;
        left: 100%;
        margin-right: 0;
        margin-left: -30px;
    }

    .lg-rtl .at-message.at-audio-area{
        direction: ltr;
    }
    .lg-rtl .controls .sound-button{
        justify-content: flex-end;
    }
</style>
