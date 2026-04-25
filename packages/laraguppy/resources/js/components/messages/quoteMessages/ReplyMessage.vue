<script setup>
    import {ref, computed} from "vue";
    import { storeToRefs } from "pinia";
    import useMessageStore from "../../../stores/useMessageStore";

    const showImages = ref(1);
    const messageStore = useMessageStore();
    const { removeReplyMsgId } = messageStore;
    const { replyMsg } = storeToRefs( messageStore );
    const message = computed(()=> replyMsg.value());

</script>
<template>
    <div class="at-replay_message">
        <div class="at-message-qoute">
            <div class="at-message-qoute_content">
                    <div v-if="message.messageType === 'text'" class="at-sendfile">
                        <span>{{message.body}}</span>
                    </div>
                    <!-- 3 for voiceNote -->
                    <div v-else-if="message.messageType == 'voice'" class="at-sendfile"> 
                        <i class="laraguppy-mic"></i>
                        <span>{{$t('chatapp.voice_note')}}</span>
                    </div>
                    <!-- 2 for location -->
                    <div v-else-if="message.messageType == 'location'" class="at-sendfile"> 
                        <i class="laraguppy-location"></i>
                        <span>{{$t('chatapp.map_location')}}</span>
                    </div>

                    <div class="at-sendfile" v-if="message.messageType == 'video'">
                        <i class="laraguppy-play"></i>
                        <span>{{message.attachments[0].fileName}}</span>
                    </div>
                    <ul v-if="message.messageType == 'image'" class="at-message_imgs">
                        <li v-for="( image, index ) in message.attachments.slice(0,showImages)" :key="index+ '_' + Math.floor(Math.random() * 9999)">
                        <figure>
                            <img :src="image.thumbnail" alt="attachment image" />
                            <span v-if="message.attachments.length > showImages && index == (showImages-1)"> +{{message.attachments.length-showImages}}</span>
                        </figure>
                        </li>
                    </ul>
                    <div class="at-sendfile" v-if="message.messageType == 'audio'">
                        <i class="laraguppy-music-01"></i>
                        <span>{{message.attachments[0].fileName}}</span>
                    </div>
                    <div class="at-sendfile" v-if="message.messageType == 'document'">
                        <i class="laraguppy-file-01"></i>
                        <span>{{message.attachments[0].fileName}}</span>
                    </div>
            </div>
            <span class="at-remove-quotes" @click.prevent="removeReplyMsgId(message.threadId)"> <i class="laraguppy-multiply" /> </span>
        </div>
    </div>
</template>

<style lang="scss" module>
    .at-chat575{
        .at-replay_message {
            margin-left: 0;
            margin-right: 0;
        }
    } 
    .at-chat480{
        .at-replay_message {
            padding-left: 15px;
            padding-right: 15px;
        }
    }
    .at-replay_message{
        max-height: 108px;
    }
</style>