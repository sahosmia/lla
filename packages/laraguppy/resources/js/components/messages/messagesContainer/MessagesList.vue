<script setup>
    import { ref, defineAsyncComponent, onMounted, watch, watchEffect } from "vue";
    import { storeToRefs } from "pinia";
    import ChatManager from "../../../services/chatManager";
    import useChatStore from "../../../stores/useChatStore";
    import useSettingsStore from "../../../stores/useSettingsStore";
    import useMessageStore from "../../../stores/useMessageStore";
    import moment from "moment";
    import { trans } from 'laravel-vue-i18n';
    const DeleteMessage = defineAsyncComponent(() => import('../deleteMessage/DeleteMessage.vue'));
    const FileMessage = defineAsyncComponent(() => import('../fileMessage/FileMessage.vue'));
    const ImageMessage = defineAsyncComponent(() => import('../imageMessage/ImageMessage.vue'));
    const LocationMessage = defineAsyncComponent(() => import('../locationMessage/LocationMessage.vue'));
    const VideoMessage = defineAsyncComponent(() => import('../videoMessage/VideoMessage.vue'));
    const VoiceMessage = defineAsyncComponent(() => import('../voiceMessage/VoiceMessage.vue'));
    const TextMessage = defineAsyncComponent(() => import('../textMessage/TextMessage.vue'));
    const NotifyMessage = defineAsyncComponent(() => import('../notifyMessage/NotifyMessage.vue'));
    const AudioMessage = defineAsyncComponent(() => import('../audioMessage/AudioMessage.vue'));
    
    const disableReply = ref(false);
    const props = defineProps(['threadId']);
    const chatStore = useChatStore();
    const settingsStore = useSettingsStore();
    const messageStore = useMessageStore();
    const { chatInfo } = storeToRefs(chatStore);
    const { messages } = storeToRefs(messageStore);
    const { settings } = storeToRefs(settingsStore);
    const media = ref([]);
    const timeFormat = settings.value.timeFormat == '24hrs' ? 'HH:mm' : 'hh:mm a';

    const getMessageTime = (createdAt) => {
        if (createdAt) {
            let dateTime = moment(new Date(createdAt)).format(timeFormat);
            return settings.value.timeFormat == '12hrs' ? `${dateTime.replace('am', trans('chatapp.am')).replace('pm', trans('chatapp.pm'))}` : dateTime;
        }
        return null;
    }

    watch(() => props.threadId, (newValue) =>{
        setTimeout(() => {
            ChatManager.scrollList({threadId: newValue});
        }, 100);
    })

    onMounted(() => {
        ChatManager.scrollList({threadId: chatInfo.value.threadId});
    });
</script>
<template>
    <div class="at-messages" :class="[{'at-notifymsg' : message.messageType == 'notify'},{ 'at-message_sender': message.isSender}]" :key="message.messageId" v-for="message in messages(props.threadId)" >
        <div class="at-messages-user" v-if="!message.isSender && !['notify'].includes(message.messageType)">
            <figure class="at-messages-user_img">
                <img :src="message.photo ? message.photo : ( settings.defaultAvatar ? settings.defaultAvatar : avatar )" :alt="message.name" />
            </figure>
            <h3>{{message.name}}</h3>
        </div>
        <!-- for show date message -->
        <div v-if="message.date" class="at-chatseparation" :key="message.messageId" >
            <span> {{ message.date }} </span>
        </div>
        <!-- for delete message template -->
        <template v-if="message.deletedAt">
            <!-- for group message -->
            <div v-if="( message.threadType === 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <DeleteMessage :message="message" />
            </div>
            <DeleteMessage v-else :message="message" />
        </template>

        <!-- for text message template-->
        <template v-else-if="message.messageType === 'text'">
            <!-- for group message -->
            <div v-if="(message.threadType == 'group')" class="at-grp_receiver_msg">  
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <TextMessage :message="message" :disableReply="disableReply" />
            </div>
            <TextMessage v-else :message="message" />
        </template>

        <!-- for location message template -->
        <template v-else-if="message.messageType === 'location'">
            <div v-if="(message.threadType == 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <LocationMessage :message="message" :disableReply="disableReply" />
            </div>
            <LocationMessage v-else :message="message" />
        </template>
       
        <!-- for audio message template -->
        <template v-else-if="message.messageType === 'audio'" >
            <div v-if="(message.threadType === 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <AudioMessage :message="message" :disableReply="disableReply" />
            </div>
            <AudioMessage v-else :message="message" />
        </template>

        <!-- for documents message attachments template -->
        <template v-else-if="message.messageType === 'document'" >
            <div v-if="(message.threadType === 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <FileMessage :message="message" :disableReply="disableReply" />
            </div>
            <FileMessage v-else :message="message" />
        </template>

        <!-- for image message attachments template -->
        <template v-else-if="message.messageType == 'image'" >
            <div v-if="(message.threadType === 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <ImageMessage :message="message" :disableReply="disableReply" />
            </div>
                <ImageMessage v-else :message="message" />
        </template>

        <!-- for video message attachments template -->
        <template v-else-if="message.messageType === 'video'" >
            <div v-if="(message.threadType === 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <VideoMessage :message="message" :disableReply="disableReply" />
            </div>
            <VideoMessage v-else :message="message" />
        </template>

        <!-- for voice note recording message attachments template -->
        <template v-else-if="message.messageType === 'voice'" >
            <div v-if="(message.threadType === 'group')" class="at-grp_receiver_msg">
                <img class="at-group-avatar" v-if="!message.isSender" :src="message.userAvatar" :alt="message.userName" />
                <VoiceMessage :message="message" :disableReply="disableReply" />
            </div>
            <VoiceMessage v-else :message="message" />
        </template>
       
        <!-- for notify message template -->
        <template v-else-if="message.messageType == 'notify'">
            <NotifyMessage :message="message" />
        </template>

        <!-- for loading message template -->
        <template v-else-if="message.messageType == 'loading'">
            <div class="at-message at-loadermsg">
                <i class="laraguppy-loader at-spinericon"></i>
                {{ $t('chatapp.attachments_uploading') }}
            </div>
        </template>

        <!-- for group chat display time template -->
        <span v-if="message.messageType != 'notify' && (message.threadType === 'group')" class="at-message_time"
            :class="{ 'at-seenmsg': message.isSender && message.seenAt, 'at-resmsg': message.isSender && ( message.messageSeenIds && message.messageSeenIds.length ),}" >
            {{ getMessageTime(message.createdAt) }}
        </span>

        <!-- for private chat display time template -->
        <span v-else-if="message.messageType != 'notify' && message.messageId" class="at-message_time" :class="{'at-seenmsg': message.isSender && message.seenAt,  'at-resmsg': message.isSender && (!message.seenAt && message.deliveredAt)}" >
            {{ getMessageTime(message.createdAt) }}
        </span>
    </div>
</template>
<style lang="scss" >

.at-notifymsg{justify-content: flex-end;}
.at-message {
	margin:0;
    padding: 16px;
	max-width: 75%;
	font-size: 15px;
    line-height: 28px;
	border-radius: 12px;
	position: relative;
	letter-spacing: 0.5px;
	display: inline-block;
	word-break: break-word;
    background: #EAEAEA;
    img{vertical-align: middle;}
    span{
        display: block;
        text-align: start;
        white-space: pre-line;
        color: rgba($color: #000000, $alpha: 0.7);
        font: 400 rem(14)/em(20,14) $body-font-family;
        &.vjs-laraguppy-placeholder{
            font-size: 30px;
        }
    }
    .at-message_time{margin-top: 0;}
    .at-message-qoute_content {
        padding: 10px 44px 10px 14px;
        background-color: #f7f7f7;
        > span{
            overflow: hidden;
            font-size: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            text-overflow: ellipsis;
            -webkit-box-orient: vertical;
        }
    }
	&_time{
		width: 100%;
        gap: 4px;
		display: flex;
        align-items: center;
		margin-top: 6px;
		font-size: rem(12);
		color: rgba($color: #585858, $alpha: 0.6);
		line-height: em(18,12);
	}
	&_imgs{
		@extend %flex;
		list-style: none;
		+ .at-messageoption{
			top: 26px;
			right: 32px;
			> a{color: #fff;}
		}
		li{
			list-style-type: none;
		}
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
			img{
                margin: 0;
                height: 100%;
                object-fit: cover;
                border-radius: $radius;
           }
			span{
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				color: #fff;
				display: flex;
				position:absolute;
			    align-items: center;
				border-radius: $radius;
			    justify-content: center;
				font: 700 rem(26)/em(30,26) $heading-font-family;
				background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
			}
		}
	}
	&_sender{
		text-align: right;
	    justify-content: flex-end;
		.at-message{
			text-align: right;
            background: #E5EBF9;
		}
		& .at-message_time {
            justify-content: flex-end;
			&:before{
				font-size: 20px !important;
				content: "\e91e";
				line-height: 20px;
				display: inline-block;
				font-family: 'wpguppy';
				vertical-align: middle;
			}
		}
		& .at-messageoption_list{
			right: 0;
			left: auto;
		}
		.at-message-qoute{justify-content: flex-end;}
	}
	&_video{
		> a{
			display: flex;
			img{border-radius: 3px;}
		}
		.at-video i{
			width: 58px;
    		height: 58px;
    		font-size: 22px;
		}
		+ .at-messageoption {
			top: 30px;
			right: 36px;
			> a{color: #fff;}
		}
	}
    .at-message-qoute .at-message-qoute_content .at-message_imgs li{display: block;}
    &:hover{
        .at-messageoption_btn{
            opacity: 1;
            visibility: visible;
        }
    } 
}
.at-messagetext{
    .at-message-qoute{margin-right: -28px;}
}
.at-messageoption_btn{
    opacity: 0;
    z-index: 999;
    visibility: hidden;
    position: relative;
    @extend %transition;
}
.at-messages{
    float: left;
	width: 100%;
    display: flex;
	padding: 12px 10px;
	position: relative;
	flex-direction: column;
	align-items: flex-start;
	& + .at-messages:last-child{
        padding-bottom: 15px;
        .at-messageoption_list{
		 top: auto;
		 bottom: 100%;
	    }
    }
    > img{
        border-radius: 50%;
        vertical-align: top;
        margin: 0 14px 5px 0;
    	   ~.at-message_time{padding-left: 57px;}
    }
}
.at-chat480 .at-messages{
    padding-left: 0;
    padding-right: 0;
}
.at-message.at-loadermsg{
    display: flex;
    align-items: center;
    color: rgba($color: #000000, $alpha: 0.7);
    font: 400 rem(14)/em(20,14) $body-font-family;
    i{
        display: block;
        font-size: 20px;
        margin-right: 4px;
        animation: spinericon 3s linear infinite;
    }
}
.at-messageoption_list{
    & .at-msgload{
        top: auto;
        left: 20px;
        bottom: 4px;
        width: 18px;
        height: 18px;
        position: static;
        margin: 0 10px 0 0;
        & .at-spinericon{
            width: 100%;
            height: 100%;
        }
    }
}
.at-msgload {
    top: 50%;
    left: -30px;
    margin-top: -10px;
    position: absolute;
}
.at-messageoption_list{
    li + li{margin-top: 3px;}
}
.at-message_sender{align-items: flex-end;}
.at-chatseparation {
    width: 100%;
    display: flex;
    text-align: center;
    position: relative;
    align-items: center;
    margin-bottom: 24px;
    justify-content: center;
    &:before {
        left: 0;
        width: 100%;
        content: "";
        height: 1px;
        position: absolute;
        background-color: #EAEAEA;
    }
    span {
        color: #585858;
        padding: 1px 7px;
        border-radius: 6px;
        position: relative;
        background-color: #fff;
        border: 1px solid #EAEAEA;
        font: 500 rem(12)/em(18,12) $body-font-family;
        box-shadow: 0px 1px 2px 0px rgba(16, 24, 40, 0.05);
        &:after{
            top: 0;
            right: -11px;
            width: 10px;
            content: "";
            height: 100%;
            position: absolute;
            background-color: #FAFAFA;
        }
        &:before{
            top: 0;
            left: -11px;
            width: 10px;
            content: "";
            height: 100%;
            position: absolute;
            background-color: #FAFAFA;
        }
    }
}
.at-emptyuserlist{
	width: 100%;
	height: 100%;
    padding-bottom: 90px;
	.at-emptyconver{
		height: 100%;
		width: 100%;
	}
}
.at-dropdownholder{
	.at-form-control{
		display: flex;
		cursor: pointer;
		align-items: center;
	}
}
.at-sendpdffile{
    .at-messageoption{
        top: 28px;
        right: 36px;
    }
}
.at-messageoption{
    top: 10px;
    right: 16px;
	position: absolute;
	&_btn{
		display: block;
		font-size: 18px;
		color: #585858;
		&:hover{color: #585858;}
	}
	&_open{
		z-index: 999;
		.at-messageoption_list{display: block;}
	}
	&_list, .at-dropdown{
		left: 0;
        margin: 0;
	    top: 100%;
        width: 100%;
	    z-index: 99;
	    width: 240px;
        padding: 8px;
	    display: none;
	    overflow: hidden;
        list-style: none;
	    position: absolute;
	    background: #fff;
	    border-radius: $radius;
	    @extend %themeboxshadow;
	    flex-direction: column;
	    font: 500 rem(14)/em(20,14) $heading-font-family;
	    &.at-uploadoption_open{@extend %flex;}
        li{
            line-height: inherit;
            list-style-type: none;
        }
	    a{
            margin: 0;
            display: flex;
            cursor: pointer;
            color: #585858;
            padding: 10px 8px;
            align-items:center;
            @extend %transition;
            border-radius: $radius;
            background: #fff!important;
            font: 500 rem(14)/em(20,14) $heading-font-family;
            &:hover{background-color: #F7F7F8!important;}
		    i{
                width: 20px;
                font-size: rem(18);
                margin-right: 10px;
                text-align: center;
                display: inline-block;
            }
	    }
	}
}
.at-locationmap >.at-messageoption>.at-messageoption_btn {color: #fff;}
.at-leftgroupinfo{
	width: 100%;
	display: flex;
    align-items:center;
	text-align: center;
    flex-direction: column;
    justify-content: center;
	span:not(.at-message_time){
        display: block;
		padding:10px 16px;
		border-radius: $radius;
		color: $text-color;
		letter-spacing: 0.5px;
		background-color:#fff;
		border: 1px solid #EAEAEA;
        box-shadow: 0px 1px 2px 0px rgba(16, 24, 40, 0.05);
		    q{
			  font-weight: 700;
			  color: $text-color;
		 }
	}
}
.at-leftgroupinfo+.at-message_time {
    text-align: center;
    align-self: center;
       &::before{display: none;}
}
.at-chat480{
    .at-sendfile{
        padding-left: 15px;
        padding-right: 39px;
        .at-messageoption{right: 31px;}
    }
    .at-message, .at-alert{
        padding-left: 15px;
        padding-right: 15px;
    }
    .at-message-qoute_content{
        .at-sendfile{
            padding-left: 0;
            padding-right: 0;
        }
    }
    .at-messageoption{right: 11px;}
    .at-insidearrow{padding-right: 34px;}
    .at-msg_imgarrowreply .at-messageoption{right: 29px;}
    .at-chatfloat{
        right: 9px;
        bottom: 9px;
    }
    .at-floatchat{
        right: 10px;
        width: 300px;
    }
    .at-floatchat ~ .at-floatchat{
        margin-right: 0;
        transform: translateX(0);
    }
    .at-replay_message .at-message-qoute_content{
        .at-sendfile{
           padding-left: 14px;
           padding-right: 14px;
        }
    }
    & .at-alert{
        .at-modal_title{
            margin: 0 -15px;
            padding: 0 15px 20px;
        }
        .at-explain-form{
            margin: 12px -7px 0;
        }
    }
}
.at-chat420{
    .at-sendfile{
        align-items: flex-start;
         > i{margin: 0 0 5px;}
    }
    .at-message_imgs{
        margin: -5px;
          li{padding: 5px;}
          figure{max-width: 115px;}
    }
    .at-messageoption {
        &_list{
            right: 0;
            top: 39px;
            left: auto;
        }
    }
    .at-msg_imgarrowreply .at-messageoption{right: 24px;}
    .at-messagemap .at-messageoption_list{right: -60px !important;}
}
.leaflet-bar, .leaflet-control span{
    text-align: center;
    display: inline-block;
}
.at-messages-user{
    gap: 10px;
    display: flex;
    margin-bottom: 2px;
    align-items: center;
    h3{
        margin: 0;
        overflow: hidden;
        color: #585858;
        text-overflow: ellipsis;
        font: 400 rem(14)/em(20,14) $body-font-family;
    }
    &_img{
        border-radius: 50%;
        img{
            display: block;
            width: 24px;
            height: 24px;
            object-fit: cover;
            border-radius: 50%;
        }
    }
    & ~ .at-message{
        margin-left: 34px;
        &_time{margin-left: 34px;}
    }
}
.at-chat420{
    .at-messages-user ~ .at-message,
    .at-messages-user ~ .at-message_time{margin: 0;}
    .at-messages-user{
        margin-bottom: 10px;
    }
}

.lg-rtl .at-message_sender .at-sendfile > i{
    margin-right: 0;
    margin-left: 20px;
}
.lg-rtl  .at-sendfile > i {
    margin-left: 20px;
    margin-right: 0;
}
// .lg-rtl .at-messages-user ~ .at-message {
//     margin-right: 34px; 
//     margin-left: 0;
// }
// .lg-rtl .at-messages.at-message_sender .at-sendpdffile .at-messageoption {
//     left: 36px;
//     right: auto;
// }
// .lg-rtl .at-messages.at-message_sender .at-audio-area .at-messageoption {
//     right: auto;
//     left: 16px;
//     top: 3px;
// }
// .lg-rtl .at-sendfile .at-messageoption {
//     top: 28px;
//     left: 36px;
//     right: auto;
// }

</style>