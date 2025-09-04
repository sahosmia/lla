<script setup>
    import { ref, defineAsyncComponent } from "vue";
    const QuoteMessageList = defineAsyncComponent(() => import('../quoteMessages/QuoteMessageList.vue'));
    const MessageAction = defineAsyncComponent(() => import('../messageActions/MessageActions.vue'));
    import { VideoPlayer } from '@videojs-player/vue';
    import 'video.js/dist/video-js.css';
    
    const props = defineProps(['message']);
    const { message } = props;

</script>
<template>
    <div class="at-message at-video-message">
        <h5 v-if="!message.isSender && (message?.threadType === 'group')">{{message?.name}}</h5>
        <QuoteMessageList :message="message.parent" :msgId="message.messageId" v-if="message.parent">
            <VideoPlayer :src="message?.attachments[0]?.file" controls :loop="false" />
            <template v-slot:message_actions>
                <MessageAction v-if="message.messageId" :isDownload="true" :message="message" />
            </template>
        </QuoteMessageList>
        <VideoPlayer v-else :src="message?.attachments[0]?.file" controls :loop="false" />
        <MessageAction v-if="message.messageId" :isDownload="true" :message="message" />
    </div>
</template>
<style lang="scss" >
.video-js{
    border-radius: $radius;
    align-items: center;
    justify-content: center;
    display: flex!important;
    overflow: hidden;
    span{
        display: inline;
        color: #fff;
        line-height: initial;
        white-space: normal;
        font-size: inherit !important;
    }
    .vjs-play-control{
        .vjs-icon-placeholder{
            font-size: inherit;
        }
    }
    .vjs-tech{
        opacity: .5;
        object-fit: cover;
    }
    .vjs-big-play-button{
        top: auto!important;
        border: 0!important;
        left: auto!important;
        margin: 0 !important;
        width: 58px!important;
        height: 58px!important;
        line-height: 58px!important;
        border-radius: 50%!important;
        position: relative!important;
          .vjs-icon-placeholder:before {
              width: 58px;
              height: 58px;
              display: grid;
              color: black;
              content: "\f101";
              border-radius: 50%;
              place-items: center;
              background: white;
              border: none !important;
        }
   }
   .vjs-playback-rate.vjs-hidden{display: block !important;}
}
.v-video-player{
    width: 400px;
    height: 200px;
}
.vjs-has-started .vjs-big-play-button{display: none;}
.vjs-playing.video-js .vjs-tech{opacity: 1 !important;}
.video-js.vjs-paused .vjs-big-play-button{display: block;}
.video-js.vjs-ended .vjs-big-play-button{display: block!important;}
.at-video-message{
    .at-message-qoute{
        .at-message-qoute_content{
            padding: 10px 10px 10px 14px;
        }
        .at-messageoption{
            display: none;
        }
    }
    .at-messageoption {
        top: 30px;
        right: 36px;
        &_btn{
            color: #fff !important;
        }
    }
}
.at-video-message .at-messageoption_btn{
    color: #585858 !important;
}
.at-chat575{
    .at-chat_messages{
        & .at-video-message{
            & .video-js.v-video-player{
                width: 300px;
                height: 150px;
            }
        }
    }
}
.at-chat480{
    .at-chat_messages{
        & .at-message{
            max-width: 100%;
        }
        & .at-video-message{
            max-width: 100%;
            & .video-js.v-video-player{
                width: 280px;
                height: 150px;
            }
        }
    }
}
.at-chat420{
    .at-chat_messages{
        & .at-video-message{
            & .video-js.v-video-player{
                width: 220px;
                height: 150px;
            }
        }
    }
}

// .at-video{
//     width: 100%;
//     height: 100%;
//     @extend %flex;
//     position: absolute;
//     align-items: center;
//     justify-content: center;
//     &:before{
//         top: 0;
//         left: 0;
//         content: '';
//         width: 100%;
//         height: 100%;
//         position: absolute;
//         border-radius: 5px;
//         background-color: rgba(#000,0.5);
//         background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
//     }
//     i{
//         width: 38px;
//         height: 38px;
//         color: #000;
//         @extend %flex;
//         font-size: 16px;
//         position: relative;
//         align-items: center;
//         border-radius: 60px;
//         background: #FFFFFF;
//         justify-content: center;
//     }
// }
</style>
