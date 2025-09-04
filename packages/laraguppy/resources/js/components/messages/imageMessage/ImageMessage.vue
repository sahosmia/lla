<script setup>
    import {ref, defineAsyncComponent, computed} from "vue";
    import FsLightbox from "fslightbox-vue/v3";
    import _ from "lodash"
    const MessageActions = defineAsyncComponent(() => import( '../messageActions/MessageActions.vue'));
    const QuoteMessageList = defineAsyncComponent(()=> import('../quoteMessages/QuoteMessageList.vue'));
    const props     = defineProps(['message']);
    const message   = props.message;
    const totalImg = ref(message?.attachments?.length ?? 0);
    const maxShowImg = ref(4);
    const slide = ref(1);
    const toggler = ref(false);
    
    const previewImage = (number) => {
        toggler.value = !toggler.value;
        slide.value = number
    }

    const images = computed(() => {
        return message?.attachments?.filter((item, index) => index < maxShowImg.value);
    });

    const sources = computed(() => {
        return _.map(message?.attachments, 'file');
    });

    const listClass = computed(() => {
        let total = message?.attachments?.length ?? 0 ;
        return  total < 5 ? `at-attachment_${total}`: `at-attachment_all`;
    });

</script>
<template>
    <div class="at-message at-message_gallery" :id="'message_'+message.messageId">
        <h5 v-if="!message.isSender && message.threadType == 'group'">{{message.name}}</h5>
        <span class="at-msgload" v-if="message.parent && !message.messageId" ><i class="at-spinericon"></i></span>
        <QuoteMessageList :message="message.parent" :msgId="message.messageId" :threadId="message.threadId" v-if="message.parent">
            <ul class="at-message_imgs">
                <li v-for="( image, index ) in message?.attachments" :key="index" @click="previewImage(index)">
                    <figure> 
                        <img :src="image.file" :alt="image.fileName" />
                        <span v-if="totalImg > maxShowImg && index == (maxShowImg-1)"> +{{totalImg-maxShowImg}}</span>
                    </figure>
                </li>
            </ul>
            <template v-slot:message_actions>
                <MessageActions v-if="message.messageId" :isDownload="true" :message="message" />
            </template>
        </QuoteMessageList>
        <template v-else>
            <ul class="at-message_imgs" :class="listClass">
                <li v-for="( image, index ) in images" :key="index+ '_' + Math.floor(Math.random() * 999)" @click="previewImage(index+1)">
                    <figure>
                    <img :src="image?.thumbnail" alt="attachment image" />
                    <span v-if="totalImg > maxShowImg && index == (maxShowImg-1)"> +{{totalImg-maxShowImg}}</span>
                    </figure>
                </li>
            </ul>
            <MessageActions v-if="message.messageId" :isDownload="true" :message="message" />
            <span class="at-msgload" v-else><i class="at-spinericon"></i></span>
        </template>
        <Teleport to="body">
            <FsLightbox :slide="slide" :toggler="toggler" :sources="sources" :showThumbsOnMount="true" />
        </Teleport>
    </div>
</template>
<style lang="scss" scoped>
.at-message_gallery {
    .at-message-qoute{
        .at-messageoption{
            &::before{
                display: none;
            }
        }
    }
    .at-message_imgs {
        flex-wrap: nowrap;
        figure{
            margin: 0;
            width: 104px;
            height: 104px;
            display: flex;
            border-radius: $radius;
            position: relative;
            align-items: center;
            background: #f7f7f7;
            justify-content: center;
            border: 2px solid #fff;
        }
        li {
            margin: 0;
            flex: none;
            padding: 0;
            list-style-type: none;
        }
        &.at-attachment{
            &_2,
            &_3,
            &_4,
            &_all{
                li{
                    &:nth-child(2){
                        margin: 30px 0px 0px -74px;
                    }
                    &:nth-child(3){
                        margin: 10px 0px 0px -74px;
                    }
                    &:nth-child(4){
                        margin: 50px 0 0 -74px;
                    }
                }
                & + .at-messageoption{
                    top: 76px;
                    right: 23px;
                }
            }
            &_2{
                & + .at-messageoption{
                    top: 56px;
                    right: 22px;
                }
            }
            &_3{
                & + .at-messageoption{
                    top: 36px;
                    right: 22px;
                }
            }
            &_1{
                & + .at-messageoption{
                    top: 26px;
                    right: 22px;
                }
            }
        }
        img {
            margin: 0;
            width: 100%;
            height: 100%;
            max-width: 100%;
            cursor: pointer;
            max-height: 100%;
            object-fit: cover;
            border-radius: $radius;
        }
   }
    .at-messageoption{
        z-index: 1;
        &:before {
            content: "";
            top: -8px;
            z-index: -1;
            right: -4px;
            width: 100px;
            height: 50px;
            opacity: 0;
            visibility: hidden;
            position: absolute;
            @extend %transition;
            pointer-events: none;
            border-radius: $radius $radius 0 0;
            background: linear-gradient(180deg,rgba(0,0,0,.5) 0,transparent 98%,transparent 99%);
        }
    }
    &:hover{
        .at-messageoption{
            &::before{
                opacity: 1;
                visibility: visible;
            }
        }
    }
}
// .at-chat575{
//     .at-message_imgs{
//         li{
//             &:nth-last-child(2){display: none;}
//         }
//     }
// }
.at-chat480 .at-message_imgs {
    // li:nth-last-child(3) {display: none;}
    .at-message_imgs + .at-messageoption {right: 31px;}
} 
.at-chat420 .at-message_imgs{
    margin: -5px;
    li {padding: 5px;} 
    figure {max-width: 115px;}
    .at-message-qoute .at-message_imgs{
    figure {max-width: 39px;}
    }
} 

</style>