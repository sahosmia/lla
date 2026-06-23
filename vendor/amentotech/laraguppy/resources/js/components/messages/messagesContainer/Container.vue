<script setup>
    import {ref, defineAsyncComponent, watch} from "vue";
    import { storeToRefs } from 'pinia';
    import useChatStore from "../../../stores/useChatStore";
    import useMessageStore from "../../../stores/useMessageStore";
    import useProfileStore from "../../../stores/useProfileStore";
	import ChatManager from "../../../services/chatManager";
    import Header from '../messageHeader/Header.vue';
    import MessageWrapper from './MessageWrapper.vue';
    import MessageComposer from '../messageComposer/MessageComposer.vue';
    import avatar from "../../../assets/images/avatar.png";
    const isLoadingMedia = ref(true);
    const chatStore = useChatStore();
    const messageStore = useMessageStore();
    const profileStore = useProfileStore();
    const { messages } = storeToRefs(messageStore);
    const { profileInfo } = storeToRefs(profileStore);
	const { getMessages } = messageStore;
    const { isActiveChat, chatInfo } = storeToRefs(chatStore);
	watch(() => chatInfo.value, (newValue) => {
      if (Object.keys(newValue).length) {
            if (!messages.value(newValue.threadId).length) {
                getMessages(newValue.threadType, newValue.threadId, newValue?.unSeenMessages ?? []);
            }
        }
    });
</script>
<template>
    <div class="at-chat_messages">
        <template v-if="isActiveChat">
            <Header />
            <MessageWrapper/>
            <MessageComposer :threadId="chatInfo.threadId"/>
        </template>
        <div v-else-if="profileInfo.shortName" class="at-empty-conversation">
            <figure class="at-empty-conversation_img" :class="{'at-shimmer':isLoadingMedia}" >
                <span class="at-empty-conversation_status"></span>
                <img @load="() => isLoadingMedia = false" :class="{'at-none':isLoadingMedia}" :src="profileInfo.photo ? profileInfo.photo : avatar" :alt="profileInfo.name" />
            </figure>
            <div class="at-empty-conversation_info">
                <h3>{{$t('chatapp.welcome', {'name' : profileInfo.shortName})}}</h3>
                <span>{{$t('chatapp.welcome_desc')}}</span>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
.at-empty-conversation{
    padding: 50px;
    display: flex;
    margin: 0 auto;
    max-width: 660px;
    flex-wrap: wrap;
    justify-content: center;
    &_img{
        width: 120px;
        height: 120px;
        margin: 0 0 30px;
        border-radius: 14998.501px;
        &.at-shimmer .at-empty-conversation_status{
            display: none;
        }
        img{
            width: 120px;
            height: 120px;
            display: block;
            background-color: #fff;
            object-fit: cover;
            border: 7.2px solid #FFF;
            border-radius: 14998.501px;
            box-shadow: 0px 20px 24px -4px rgba(16, 24, 40, 0.08), 0px 8px 8px -4px rgba(16, 24, 40, 0.03);
        }
    }
    &_status{
        content: '';
        right: 6.284px;
        bottom: 6.286px;
        width: 25.714px;
        height: 25.714px;
        background: #17B26A;
        border-radius: 428.572px;
        position: absolute !important;
        border: 4.286px solid #FFF;
    }
    &_info{
        width: 100%;
        text-align: center;
        h3{
            margin: 0;
            color: #585858;
            text-align: center;
            font: 600 rem(30)/em(38,30) $body-font-family;
        }
        span{
            display: block;
            margin-top: 30px;
            color: #585858;
            font: 400 rem(20)/em(30,20) $body-font-family;
        }
    }
}
.at-chat_messages.at-chat_messagesslide {
    flex: 0 0 calc(72% - 300px);
	max-width: calc(72% - 300px);
	-ms-flex: 0 0 calc(72% - 300px);
}
.at-userstatus {
    font-size: 14px;
    line-height: 26px;
    align-items: center;
    display: inline-flex;
    letter-spacing: .01em;
    vertical-align: middle;
}
.at-chat{
    padding: 20px;
    display: flex;
	flex: 0 0 100%;
	max-width: 100%;
	overflow: hidden;
	position: relative;
	-ms-flex: 0 0 100%;
	-webkit-box-flex: 0;
    background: #fafafa;
	height: 100vh;
    &_sidebar{
        flex: 0 0 20%;
        max-width: 20%;
        -ms-flex: 0 0 20%;
        position:relative;
        -webkit-box-flex: 0;
        background-color: #fff;
        border-radius: 20px 0 0 20px;
        border-right: 1px solid #EAEAEA;
        &_footer{
            bottom:0;
            width: 100%;
            display: flex;
            position:absolute;
            line-height: em(30,14);
            justify-content: space-around;
            background-color: $primary-color;
            li{
                display: flex;
                padding:18px 15px;
                align-items:center;
                list-style-type: none;
            }
            a{
                color: #fff;
                position:relative;
                font-size: rem(24);
                display: inline-block;
                &.active{color: $theme-color;}
                .at-notify{
                    top: -10px;
                    left: 100%;
                    position: absolute;
                    margin-left: -10px;
                    pointer-events:none;
                    font-family: $body-font-family;
                    box-shadow: 0 0 0 3px $primary-color;
                    -webkit-box-shadow: 0 0 0 3px $primary-color;
                }
            }
        }
    }
    &_messages{
        display: flex;
        flex: 0 0 80%;
        max-width: 80%;
        position: relative;
        -ms-flex: 0 0 80%;
        @extend %transition;  
        -webkit-box-flex: 0;
        flex-direction: column;
        justify-content: center;
        background-color: #f7f7f7;
        height: calc(100vh - 40px);
        border-radius:0 20px 20px 0;
        overflow: hidden;
    }
    &991{
        .at-chat_sidebar{
            border-radius: 20px;
            border: 0;
        }
        .at-usersetting,
        .at-chat_messages{border-radius: 20px;}
    }
}

.at-opnchatbox{
	.at-userinfo{display: flex !important;}
	.at-emptyconver{display: none !important;}
	.at-messagewrap, .at-replay{display: block !important;}
}
.at-chat1440  {
    .at-chat_messages{
       flex: 0 0 calc(100% - 480px);
       max-width: calc(100% - 480px);
       -ms-flex: 0 0 calc(100% - 480px);
    }
}
.at-chat1199 {
    .at-chat_messages {
        flex: 0 0 calc(100% - 430px);
        max-width: calc(100% - 430px);
        -ms-flex: 0 0 calc(100% - 430px);
    }
    .at-chatsidebar_float{max-width: 480px;}
}
.at-chat1080 {
    .at-chat_messages {
        flex: 0 0 calc(100% - 350px);
        max-width: calc(100% - 350px);
        -ms-flex: 0 0 calc(100% - 350px);
    }
}
.at-chat991 {
    .at-chat_messages {
        display: none;
        flex: 0 0 100%;
        max-width: 100%;
        -ms-flex: 0 0 100%;
    }
    .at-userinfo_title > a{display: block;}
    &.at-opnchatbox{
        .at-chat_messages{display: flex;}
    }
    .at-userinfo{padding-left: 13px;}
    .at-chat{
        > .at-chat_sidebarsetting{
            .at-chat_sidebarsettingarea {
                padding-bottom: 20px;
                height: calc(100vh - 91px);
            }
        }
    }
    .at-floatchat{right: 20px;}
}
.at-chat991.at-opnchatbox .at-chat_messages {display: flex;}


</style>
<style>
.lg-rtl .at-chat_sidebar {
    border-radius: 0 20px 20px 0;
    border-left: 1px solid #EAEAEA;
    border-right: 0;
}
.lg-rtl .conversation-list .at-userbar_profile {
    margin-left: 12px;
    margin-right: 0;
}

.lg-rtl  .at-usersetting {
    transform: translate(150%);
}
.lg-rtl .at-usersetting_open.at-usersetting {
    transform: translate(0%);
}
.lg-rtl .at-chat_sidebar {
    border-radius: 0 20px 20px 0;
    border-left: 1px solid #EAEAEA;
    border-right: 0;
}
.lg-rtl .at-chat_messages{
    border-radius: 20px 0 0 20px;
}
.lg-rtl .at-sidebarmenu_option {
    margin-left: 0;
    margin-right: auto;
}
.lg-rtl .at-userbar_right {
    flex: none;
    padding-left: 0;
    margin-left: 0;
    margin-right: auto;
    padding-right: 10px;
}

.lg-rtl .tk-sidetooglearea {
    padding: 15px 15px 15px 25px;
}
.lg-rtl .conversation-list .at-userbar_profile {
    margin-left: 12px;
    margin-right: 0;
}
.lg-rtl .at-userbar_profile {
    margin-right: 0;
    margin-left: 12px;
}
.lg-rtl .at-alert h2 .at-guppy-removemodal {
    margin-left: 0;
    margin-right: auto;
}
.lg-rtl  .at-togglebtn {
    margin-left: 0;
    margin-right: auto;
}
.lg-rtl  .at-notify {
    margin-right: auto;
    margin-left: 0;
}
.lg-rtl  .at-replay_msg {
    margin-left: 0;
    margin-right: auto;
}
.lg-rtl  .at-userinfo_settings {
    margin-left: 0 ;
    margin-right: auto;
}
.lg-rtl .at-messageoption_list a i, .lg-rtl .at-messageoption .at-dropdown a i {
  margin-left: 10px;
  margin-right: 0;
}
.lg-rtl .at-locationmap .at-message_sender .at-messageoption_list {
    left: auto;
    right: 0;
}
.lg-rtl .at-messageoption_list, .lg-rtl .at-messageoption .at-dropdown {
    right: 0;
    left: auto;
}
.lg-rtl .at-message_sender .at-messageoption_list {
    left: 0;
    right: auto;
}
.lg-rtl .at-chat991 .at-chat_sidebar {
    border-radius: 20px;
    border-left: 0;
    border-right: 0;
}
.lg-rtl .at-chat991 .at-chat_messages {
    border-radius:  20px;
}
.lg-rtl .at-chat991 .at-userinfo_title > a{
    margin-right: 0;
    margin-left: 15px;
}
.lg-rtl .at-chat991 .at-userinfo_title > a i:before {
    content: "\e95b";
}
.lg-rtl  .at-chat480 .at-userbar .at-userbar_right {
    margin-left: 0;
    padding-left: 0;
    margin-right: auto;
    padding-right: 20px;
}
.lg-rtl .at-chat640  .at-messages.at-message_sender .at-messageoption .at-messageoption_list {
    left: auto !important;
    right: -30px !important;
}
</style>