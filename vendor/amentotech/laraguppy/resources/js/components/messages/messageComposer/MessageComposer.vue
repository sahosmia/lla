<script setup>
    import {ref, onMounted, computed, defineProps, watch} from "vue";
    import { storeToRefs } from "pinia";
    import { VuemojiPicker } from 'vuemoji-picker'
    import { Picker } from 'emoji-picker-element';
    import { trans } from 'laravel-vue-i18n';
    import useSettingsStore from "../../../stores/useSettingsStore";
    import useMessageStore from "../../../stores/useMessageStore";
    import useChatStore from "../../../stores/useChatStore";
    import useProfileStore from "../../../stores/useProfileStore";
    import useAlertModals from "../../../stores/useAlertModals";
	
	const picker = new Picker();
    const style = document.createElement('style');
    style.textContent = `.search-wrapper input{
                        border-radius: 4px !important;
                    }
                    .tabpanel {
                        scrollbar-width: thin;
                        &::-webkit-scrollbar-track{
                            width: 4px;
                            background-color: transparent;
                        }
                        &::-webkit-scrollbar{
                            margin: 0;
                            width: 4px;
                            background: transparent;
                        }
                        &::-webkit-scrollbar-thumb{
                            margin: 0;
                            width: 4px;
                            height: 30px;
                            border-radius: 60px;
                            background-color: #F15A24  !important;
                        }
                    }
                    .picker .nav-button[aria-selected="true"]{
                        background: #d9d9d9;
                    }`
    picker.shadowRoot.appendChild(style);
    import CloseIcon from "./resources/close.png";
    import EmojiIcon from "./resources/emoji.png";
    import VoiceMessage from "./SendVoiceMessage.vue";
    import MediaMessage from './SendMediaMessage.vue';
	import ReplyMessage from "../quoteMessages/ReplyMessage.vue";
	
    const settingsStore = useSettingsStore();
    const chatStore = useChatStore();
    const messageStore = useMessageStore();
    const { settings, windowWidth } = storeToRefs(settingsStore);
    const { chatInfo } = storeToRefs(chatStore);
    const { replyId, msgInput, replyMsg, disableFooter, loadChat } = storeToRefs(messageStore);
	const isTyping = ref(false);
	const typingText = ref(false);
    const { sendMessage, setMsgInput }  = messageStore; 
    const isShow = ref(false);
    const props = defineProps(['threadId']);
    const threadId = computed(() =>  props.threadId)

	const alertModals = useAlertModals();
	const profileStore = useProfileStore();

	const { profileInfo } = storeToRefs( profileStore );
	const { toggleModal } = alertModals;
	const channel = window.Echo?.channel(`events`)
	const unblockButtonText = computed(() => {
		let btn = `<a href="javascript:;" id="unblock-user" >${trans('chatapp.unblock_now')} </a>`;
		return trans('chatapp.blocked_user_msg', { 'unblock_button' : btn})
	});

	onMounted(()=>{
		window?.Echo?.private(`thread-${threadId.value}`)
		.listenForWhisper('typing', (e) => {
			isTyping.value = e.typing;
			typingText.value = trans('chatapp.user_typing', {'name': e.name})
		});
	});

	onMounted(()=>{
		jQuery(document).on('click', '#unblock-user',function(){
			toggleModal('blockFriend', true)
		});
	})

    const inputText = computed({
        get() {
            return msgInput.value(threadId.value) ?? '';
        },
        set(text) {
            setMsgInput({threadId : threadId.value, text})
        }
    });

	watch(() => inputText.value, ( newValue) =>{
		setTimeout( () => {
			typingUserText(newValue, threadId.value)
		}, 300)
	});

	watch(() => threadId.value, ( oldValue, newValue) =>{
		typingUserText('',oldValue)
		typingUserText('',newValue)
	});

	const typingUserText = (text, threadId) => {
		window?.Echo?.private(`thread-${threadId}`)
		.whisper('typing', {
			typing: !!text,
			name: profileInfo.value.shortName,
		});
	}

    onMounted(() => {
        let activeTab   = null;
        const v3Groups  = document.querySelector('.v3-groups');
        if(v3Groups){
            v3Groups.addEventListener('click', function(event) {
                if (event.target.tagName !== 'IMG') {
                    return;
                }
                if (activeTab) {
                    activeTab.parentElement.parentElement.classList.remove('at-active');
                }
                activeTab = event.target;
                activeTab.parentElement.parentElement.classList.add('at-active');
            });
        }
    });

    function onSelectEmoji(emoji) {
      inputText.value += emoji.unicode;
    }

    picker.addEventListener('emoji-click', event => {
        onSelectEmoji(event.detail);
    });

    const toggleEmoji = () => {
        jQuery('.at-emoji').append(picker)
        isShow.value = !isShow.value
    }

    const sendTextMessage = () => {
        if(inputText.value){
            let formData    = new FormData();
            formData.append("timeStamp" , new Date().getTime());
            formData.append('threadId', threadId.value);
            formData.append('body', inputText.value);
            formData.append('messageType', 'text');
            formData.append("isSender" , true);

            if(replyId.value(threadId.value)){
                formData.append('replyId', replyId.value(threadId.value));
            }

            sendMessage(formData);
            isShow.value = false;
        }
    }

	const handleKeyDown = (event) => {
      	const keyCode = event.which || event.keyCode;
		if (keyCode === 13 && !event.shiftKey) {
			event.preventDefault();
			sendTextMessage();
		}
    }
</script>
<template>
        <div v-if="chatInfo.friendStatus === 'blocked' && chatInfo.blockedBy != profileInfo.userId" class="at-chatblockuser" >
          	<span>{{$t('chatapp.you_are_blocked')}}</span>
        </div>
		<div v-else-if="chatInfo.friendStatus == 'blocked' && chatInfo.blockedBy == profileInfo.userId" class="at-chatblockuser" >
          	<span v-html="unblockButtonText"></span>
        </div>
		<div v-else class="at-replay" :class="{'at-replay_disable' : disableFooter( props.threadId ) || loadChat(props.threadId) }">
			<ReplyMessage v-if="replyMsg(props.threadId)" />
			<span v-if="isTyping">{{typingText}}</span>
			<textarea class="at-replay_input" cols="5" @keydown.enter.prevent="handleKeyDown" :id="`input-text-message-${chatInfo.threadId}`" v-model.trim="inputText" name="replay" :placeholder="$t('chatapp.type_message')"></textarea>
			<div class="at-replay_content">
				<MediaMessage :threadId="props.threadId"/>
				<div class="at-replay_msg">
					<template v-if="settings.emojiSharing">
						<a @click.prevent="toggleEmoji" href="javascript:void(0);">
							<img :src="isShow ? CloseIcon : EmojiIcon" alt="img description">
						</a>
						<div v-show="isShow" class="at-emoji"></div>
					</template>
					<template v-if="windowWidth <= 768">
						<a v-if="inputText" href="javascript:void(0)" @click.prevent="sendTextMessage()" class="at-sendmsg"><i class="laraguppy-send-up-02"></i></a>
						<VoiceMessage v-else :threadId="threadId"/>
					</template>
					<template v-else>
						<VoiceMessage :threadId="threadId"/>
						<a href="javascript:void(0)" @click.prevent="sendTextMessage()" class="at-sendmsg">Send<i class="laraguppy-send-up-02"></i></a>
					</template>
				</div>
			</div>
		</div>
</template>

<style lang="scss" scoped>
.at-replay_content{
    margin-top: 3px;
    position: relative;
}
.at-replay_msg{
    > a{
        img{
            width: 14px;
            height: 14px;
        }
    }
    > input{
        height: 100%;
        font-size: 15px;
        min-height: 60px;
        padding-left: 78px;
    }
}
.at-emoji{
        right: 10px;
        z-index: 2;
        bottom: 99%;
        position: absolute;
        border-radius: 3px;
        .nav-button {opacity:0.4!important;} 
        .v3-search input{border: 1px solid #d9d9d9;}
        .v3-search input:focus{border: 1px solid #cccccc;}
        .nav-emoji.emoji:hover, .nav-emoji.emoji.at-active{opacity: 1!important;}
        .tabpanel{
            &::-webkit-scrollbar-track{
                width: 4px;
                background-color: transparent;
            }
            &::-webkit-scrollbar{
                margin: 0;
                width: 4px;
                background: transparent;
            }
            &::-webkit-scrollbar-thumb{
                margin: 0;
                width: 4px;
                height: 30px;
                border-radius: 60px;
                background-color:$theme-color;
           }
      }
 }
.at-chat420{
.at-sendmsg{ 
    width: auto;
    right: 20px;
    color: #999;
    line-height: 1;
    font-size: 20px;
    position: absolute;
    background-color: transparent;
}
.at-replay_msg input{border-radius: $radius;}
.at-floatchat_content .at-replay_msg input{padding-right: 52px;}
.at-replay_msg > a:not(.at-sendmsg) + input {padding-right: 68px;}
.at-whatsappchat .at-replay_msg > a:not(.at-sendmsg) {right: 60px;}    
.at-floatchat_content .at-replay_msg > a:not(.at-sendmsg) {right: 21px;}
}
.at-chat420{
    .at-replay_msg{
        > input{
            padding-left: 70px;
            padding-right: 48px;
        }
    }
}
</style>
<style lang="scss" >

	.at-replay{
		margin-top: auto;
		position:relative;
		padding: 10px 16px 16px;
		background-color:#fff;
		.at-replay_input{
			border: 0;
			width: 100%;
			height: 50px;
			resize: none;
			outline: none;
			display: block;
			color: #585858;
			padding: 14px 0;
			box-shadow: none;
			font: 400 rem(14)/em(20,14) $body-font-family;
			scrollbar-width: thin;
			&::placeholder{
				color: rgba($color: #000000, $alpha: 0.4);
			}
		}
		&_content{
			display: flex;
			align-items:center;
		}
		&_message{
			margin: 0 0 10px;
			padding: 10px 20px;
			border-radius: 10px;
			background-color: $bg-color;
			.at-message-qoute .at-sendfile{background-color: #fff;}
			.at-remove-quotes{
				padding: 0;
				cursor: pointer;
				font-size: 30px;
				color: #999999;
				margin-left: auto;
			}
			.at-message-qoute_content{
				padding: 14px;
				background: #fff;
				border-radius: $radius;
			}
			.at-message_video{
				width: 200px;
				.at-video i{
					width: 30px;
					height: 30px;
					font-size: 14px;
				}
			}
			.at-message-qoute_content-map{
				width: 100%;
				.at-messagemap{max-width: 220px;}
			}
		}
		&_msg {
			gap: 10px;
			display: flex;
			position:relative;
			margin-left: auto;
			align-items:center;
			padding: 0 0 0 10px;
			input {
				width: 100%;
				height: 60px;
				border-radius: $radius;
			}
			& > a:not(.at-sendmsg){
				width: 36px;
				height: 36px;
				display: flex;
				border-radius: 8px;
				align-items: center;
				background: #F7F7F8;
				justify-content: center;
				img{display: block;}
				& + input{padding-left: 78px;}
			}
		}
		&_audio,
		&_upload{
			flex: none;
			position: relative;
			& > a{
				width: 36px;
				display: block;
				text-align:center;
				line-height: 34px;
				font-size: rem(18);
				color: #585858;
				@extend %transition;
				border-radius: 8px;
				border: 1px solid #EAEAEA;
				&:hover{color: #585858;}
				i{
					display: block;
					line-height: inherit;
				}
			}
		}
		&_audio{
			&:focus{
				& a{
					color: #fff;
					border-color:$theme-color;
					background-color: $theme-color;
				}
			}
		}
		.at-message-qoute{
			margin: 0;
		}
	}
	.at-message-qoute{
		display: flex;
		min-width: 25px;
		position: relative;
		align-items: center;
		margin: 0 0 10px;
		&:before{
			min-width: 25px;
			text-align: left;
			content: "\e988";
			color: #999;
			font-size: 1rem;
			font-family: "wpguppy";
		}
	}
	.at-message-qoute > span,
	.at-message-qoute_content {
		display: block;
		font-size: 12px;
		line-height: 28px;
		letter-spacing: 0.5px;
		border-radius: $radius;
		background-color: #F7F7F7;
		padding: 10px 39px 10px 14px;
	}
	.at-message-qoute > span,
	.at-message-qoute_content {
		display: block;
		font-size: 12px;
		line-height: 28px;
		letter-spacing: 0.5px;
		border-radius: $radius;
		background-color: #F7F7F7;
		padding: 10px 39px 10px 14px;
	}
	.at-sendfile {
		display: flex;
		align-items: center;
		border-radius: $radius;
		background-color: #F7F7F7;
		padding: 11px 44px 11px 20px;
	}
	.at-message-qoute > span .at-sendfile, .at-message-qoute_content .at-sendfile {
		padding: 2px 0;
	}
	.at-sendfile > i {
		flex: none;
		font-size: 24px;
		line-height: 20px;
		margin-right: 20px;
	}
	.at-message-qoute .at-sendfile i {
		font-size: 0.875rem;
		margin-right: 10px;
	}
	.at-sendfile span {
		font-size: 0.9375rem;
		line-height: 1.3333333333em;
		letter-spacing: 0.01em;
		word-break: break-word;
	}
	.at-message-qoute .at-sendfile span {
		overflow: hidden;
		font-size: 0.75rem;
		display: -webkit-box;
		-webkit-line-clamp: 1;
		line-height: 1.3333333333em;
		text-overflow: ellipsis;
		-webkit-box-orient: vertical;
	}
	.at-replay_message .at-remove-quotes {
		padding: 0;
		cursor: pointer;
		font-size: 30px;
		color: #999999;
		margin-left: auto;
	}
	.at-chat480{
		.at-locationmap + .at-messageoption{right: 81px;}
	}
	.at-chatblockuser{
		display: flex;
		min-height: 108px;
		align-items: center;
		padding: 0 10px 10px;
		justify-content: center;
		span{
			z-index: 9;
			display: block;
			background: #fff;
			padding: 10px 16px;
			text-align: center;
			border-radius: $radius;
			letter-spacing: .5px;
			color: rgb(153, 153, 153);
			font: 400 15px/28px $body_font_family;
			background-color: #fff;
			border: 1px solid #EAEAEA;
			box-shadow: 0px 1px 2px 0px rgba(16, 24, 40, 0.05);
		}
	}
.lg-rtl .at-emoji {
	left: 10px;
	right: auto;
}
.lg-rtl .at-remove-quotes {
	margin-left: 0;
	margin-right: auto;
}
</style>