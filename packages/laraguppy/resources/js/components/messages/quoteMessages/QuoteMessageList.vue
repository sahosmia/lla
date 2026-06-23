<script setup>
    import {ref, computed} from "vue";
    import FsLightbox from "fslightbox-vue/v3";
    import GeoMap from '../locationMessage/GeoMap.vue';
    import AudioPlayer from "../voiceMessage/AudioPlayer.vue";
    import { VideoPlayer } from '@videojs-player/vue';
    import _ from "lodash"
    import 'video.js/dist/video-js.css';
    const props = defineProps(['message', 'msgId']);
    const { message, msgId } = props;
    const { attachments } = message;
    const showImages = ref(1);
    const toggler = ref(false);
    
    const previewImage = () => {
        toggler.value = !toggler.value
    }

    const sources = computed(() => {
        if(message.messageType == 'image'){
            return _.map(message?.attachments, 'file');
        }
        return [];
    });

</script>
<template>
    <div> 
        <div class="at-message-qoute">
            <div class="at-message-qoute_content">
                <ul v-if="message.messageType == 'image'" class="at-message_imgs at-messagequote">
                    <li v-for="(image, index) in attachments.slice(0,showImages)" :key="index+ '_' + Math.floor(Math.random() * 99999999)" @click="previewImage()">
                        <figure>
                            <img :src="image.thumbnail" :alt="image.fileName" class="mCS_img_loaded">
                            <span v-if="message.attachments.length > showImages && index == (showImages-1)"> +{{ message.attachments.length - showImages}}</span>
                        </figure>
                    </li>
                    <Teleport to="body">
                        <FsLightbox :toggler="toggler" :sources="sources" />
                    </Teleport>
                </ul>
                <VideoPlayer v-if="message.messageType == 'video'"
                    :src="attachments?.[0]?.file"
                    controls
                    :loop="false"
                    :volume="0.6"
                />
                <div class="at-sendfile" v-if="message.messageType == 'audio'">
                    <i class="laraguppy-music-01"></i>
                    <span>{{attachments?.[0]?.fileName}}<em>{{attachments[0].fileSize}}</em></span>
                </div>
                <div class="at-sendfile" v-if="message.messageType == 'document'">
                    <i class="laraguppy-file-01"></i>
                    <span>{{attachments?.[0]?.name}}<em>{{attachments[0]?.fileSize}}</em></span>
                </div>
                <template v-else-if="message.messageType == 'voice'">
                    <AudioPlayer :messageId="message.messageId+'_reply'" :audioSource="attachments[0].file" />
                </template>
                <template v-else-if="message.messageType == 'location'">
                    <GeoMap :location="message.location" :msgId="`${msgId}_${message.messageId}`"/>
                </template>
                <span v-else>{{message.body}}</span> 
            </div>
            <slot name="message_actions"></slot>
        </div>
      <slot></slot>
    </div> 
</template>