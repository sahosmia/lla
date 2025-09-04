<script setup>
    import { defineAsyncComponent, onMounted, ref, watch } from "vue";
    import { storeToRefs } from "pinia";
    import ChatManager from "../../../services/chatManager";
	import useChatStore from "../../../stores/useChatStore";
	import useMessageStore from "../../../stores/useMessageStore";
	import ChatLoader from "../../chatLoader/ChatLoader.vue"
    const MessagesList = defineAsyncComponent(() => import('./MessagesList.vue'));
    const msgSection = ref(null);
    const lastScrollTop = ref(0);
    const chatStore = useChatStore();
    const messageStore = useMessageStore();
	const { messages, loadChat } = storeToRefs(messageStore);
    const { chatInfo} = storeToRefs(chatStore);
    const { getMessages } = messageStore;

    const scrollHandler = (e) => {
        let scrollTop = e.currentTarget.scrollTop;
        let scrollHeight = msgSection.value ? msgSection.value.scrollHeight : 0;
        lastScrollTop.value = scrollHeight - scrollTop;
        const top = Math.round(scrollTop) === 0;
        if (top && messages.value(chatInfo.value?.threadId)?.length) {
            if ( scrollHeight > e.currentTarget.offsetHeight ) {
                getMessages(chatInfo.value.threadType, chatInfo.value.threadId, [], lastScrollTop.value);
            }
        }
    }

</script>
<template>
    <div class="at-view-messages">
        <ChatLoader v-if="chatInfo && loadChat(chatInfo.threadId) && !( messages(chatInfo.threadId) && messages(chatInfo.threadId).length)"/>
        <template v-if="messages(chatInfo.threadId).length">
            <div :id="'message-wrap_' + chatInfo.threadId" ref="msgSection" class="at-messagewrap" @scroll="scrollHandler($event)">
				<ChatLoader type="msgLoading" v-if="loadChat(chatInfo.threadId)"/>
				<MessagesList :threadId="chatInfo.threadId"/>
            </div>
        </template>
    </div>
</template>
<style lang="scss" scoped>
.at-view-messages{
    height: 100vh;
    display: flex;
    overflow: hidden;
    flex-direction: column;
    justify-content: flex-end;
    .at-empty-conversation{
        height: 100vh;   
        display: flex;
        overflow: hidden;
        align-items: center;
        justify-content: center;
    }
    .at-messagewrap{
		.at-alert {margin: auto;}
           .at-userbar_loader{
                height: auto;
                margin: 0 auto;
                position:relative;
                padding: 20px 0 30px;
                background:transparent;
                width: calc(100% - 80px);
         }
    }
	.at-chatloader {
		margin: 0;
		width: 40px;
        height: 40px;
        transform: translateZ(0) scale(.4);
    }
}
.at-sendfile.at-sendfile_qoute{
	i{
		margin-right: 10px;
		font-size: 0.875rem;
	}
	span{
		overflow: hidden;
		font-size: 0.75rem;
		display: -webkit-box;
		-webkit-line-clamp: 1;
		text-overflow: ellipsis;
		line-height: 1.3333333333em;
		-webkit-box-orient: vertical;
	}
}
.at-message-qoute .at-sendfile{
		span{
			overflow: hidden;
			font-size: rem(12);
			display: -webkit-box;
			-webkit-line-clamp: 1;
			line-height: em(16,12);
			text-overflow: ellipsis;
			-webkit-box-orient: vertical;
		}
		i{
			font-size: rem(14);
			margin-right: 10px;
	 }
}

.at-messagemap{
	max-width: 480px;
	.at-message{width: 100%;}
	&.at-messagemapquote{width: 480px;}
}
.at-autoreplay{
	left: 0;
	z-index: 8;
	width: 100%;
	bottom: 100%;
	display: flex;
	position: absolute;
	padding-left: 20px;
	padding-bottom: 10px;
	background: $bg-color;
	box-shadow: inset 0px -1px 0px #EEEEEE;
	    span{
	        margin: 10px;
	        @extend %border;
	        cursor: pointer;
	        padding:6px 20px;
	        background: #fff;
	        font-size: rem(15);
	        line-height: em(28);
	        border-radius: 60px;
	        display: inline-block;
	        @extend %themeboxshadow;
     }
}
.at-messagev1{height: calc(100vh - 200px);}
.at-deletemsg{
	.at-message{
		padding-right: 20px;
		@extend %border;
		color: $text-color;
		i{margin-right: 5px;font-size: 18px;vertical-align: text-top;}
	}
}
.at-msgemojy{margin-left: 7px;}
.at-spinericon{
	color: $text-color !important;
	animation: spinericon 1s linear infinite;
	-webkit-animation: spinericon 1s linear infinite;
}
.at-messagequote.at-message_imgs{
	padding: 5px;
	margin: -5px;
	border-radius: 3px;
	display: inline-flex;
	background-color: #F7F7F7;
	li{
		padding: 5px;
		figure{max-width: 50px;}
	}
}
.at-messagemap.at-messagemap-quote{
	width: 100%;
	padding: 10px;
	max-width: 200px;
	border-radius: 3px;
	background: #F7F7F7;
	+ .at-messageoption{
		right: auto;
		left: 190px;
	}
	.at-locationmap{height: 90px;}
}
.at-message_video-quote{
	padding: 10px;
	border-radius: 3px;
    display: inline-block;
	background-color: #f7f7f7;
	.at-message_video{
		max-width: 180px;
		.at-video i {
			width: 30px;
			height: 30px;
			font-size: 14px;
		}
	}
	+ .at-messageoption{
		right: auto;
		left: 180px;
		.at-messageoption_btn{color: #fff;}
	}
}
.at-message-qoute{
	display: flex;
	min-width: 25px;
	margin: 0 0 10px;
	position:relative;
	align-items:center;
	.at-messageoption{
		&::before{
            display: none;
        }
	}
	.at-message_imgs{
		margin: -5px;
		 li{padding:5px;}
		 figure{
			height: 100%;
			max-width: 50px;
			max-height: 50px;
			span{font-size: rem(16px);}
		}
	}
	&:before{
		min-width: 25px;
		text-align: left;
		content: "\e94a";
		color: $text-color;
		font-size: rem(16);
		font-family: 'icomoon';
	}
	& > span,
	&_content{
		display: block;
		font-size: 12px;
		line-height: 28px;	
		letter-spacing: 0.5px;
		border-radius: $radius;
		background-color: $bg-color;
		padding: 10px 39px 10px 14px;
		.at-sendfile{padding: 4px 0;}
	}
}
.at-msg_imgarrowreply{
	width: auto;
	position: relative;
	padding-right: 14px;
	.at-messageoption{
		top: 50%;
		right: 29px;
		transform: translateY(-50%);
	}
	.at-messageoption_btn{color: #fff;}
}
.at-loadermsg{
	.at-message{
		display: flex;
		color: $text-color;
		align-items: center;
	}
	i {
		font-size: 24px;
		margin-right: 10px;
		display: inline-block;
	}
	.at-message_time:before{content: none;}
}
.at-message .at-messageoption{
	transform: scale(0);
    transition: all .3s ease-in-out;
}
.at-uploadoption_open .at-uploadoption{@extend %flex;}
.at-messages.at-loadermsg .at-spinericon{border-right-color: transparent;}
.at-message:hover .at-msg_imgarrowreply .at-messageoption{transform: translateY(-50%) scale(1);}
.at-message:hover .at-messageoption, .at-messageoption.at-messageoption_open{display: block; transform: scale(1);}
</style>