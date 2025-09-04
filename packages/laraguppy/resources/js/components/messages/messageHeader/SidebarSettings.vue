<script setup>
    import { ref, onMounted, onUnmounted, computed} from "vue";
    import _ from "lodash"
    import { storeToRefs } from 'pinia';
    import FsLightbox from "fslightbox-vue/v3";
    import FileIcon from "./resources/file.jpg";
    import AudioIcon from "./resources/audio.jpg";
    import VideoIcon from "./resources/video.jpg";
    import useTabStore from "../../../stores/useTabStore";
    import avatar from "../../../assets/images/avatar.png";
    import ChatManager from "../../../services/chatManager";
    import useChatStore from "../../../stores/useChatStore";
    import ChatLoader from "../../chatLoader/ChatLoader.vue";
    import useAlertModals from "../../../stores/useAlertModals";
    import useMessageStore from "../../../stores/useMessageStore";
    import useProfileStore from "../../../stores/useProfileStore";
    import RestApiManager from "../../../services/restApiManager";
    import useSettingsStore from "../../../stores/useSettingsStore";
    
    const messageStore = useMessageStore();
    const { getAttachments, resetAttachments } = messageStore;
    const { 
        attachmentList, 
        mediaLoading, 
        mediaPages
    } = storeToRefs(messageStore);
    const tabStore = useTabStore();
    const { setThreadMuted } = tabStore
    const profileStore = useProfileStore();
    const { profileInfo } = storeToRefs( profileStore );
    const alertModals = useAlertModals();
    const chatStore = useChatStore();
    const settingsStore = useSettingsStore();
    const emit = defineEmits(['closeSidebar']);
    const { settings } = storeToRefs(settingsStore);
    const groupMembers = ref([]);
    const attachments = ref([]);
    const isloading = ref(false);
    const isUpdating = ref(false);
    const { chatInfo } = storeToRefs(chatStore);
    const { toggleModal } = alertModals;
    const slide = ref(1);
    const toggler = ref(false);
    const getUserRole = ref('');

    const fileName = computed(() => {
        return chatInfo.value?.threadType == 'private' ? chatInfo.value.name?.toLowerCase()?.split(' ').join('-') : ''
    });

    const isMediaLoading = computed(() => {
        return mediaLoading.value( chatInfo?.value?.threadId )
    });

    const totalPages = computed(() => {
        const { totalMediaPages } = mediaPages.value( chatInfo?.value?.threadId )
        return totalMediaPages;
    });

    const mediaPage = computed(() => {
        const { mediaPage } = mediaPages.value( chatInfo?.value?.threadId )
        return mediaPage;
    });

    const meidaAttachments = computed(() => {
        if(chatInfo?.value?.threadId){
            return attachmentList.value(chatInfo.value.threadId);
        }
        return []
    });

    const userImage = computed(() => {
		return chatInfo.value.photo ? chatInfo.value.photo : ( settings.value.defaultAvatar ? settings.value.defaultAvatar : avatar )
	});

    const sources = computed(() => {
        if(chatInfo?.value?.threadId){
            let files = attachmentList.value(chatInfo.value.threadId);
            return _.map( _.filter(files, obj => ['image', 'video'].includes(obj.fileType) ), 'file');
        }
        return []
    });
    
    onUnmounted(() => {
        resetAttachments(chatInfo?.value?.threadId);
    })

    onMounted(() => {
        toggleSidebar();
        getAttachments(chatInfo.value?.threadId, 1)
    });

    const toggleSidebar = () => {
        setTimeout(()=>{
            jQuery(document).find(".at-chat_sidebarsetting").addClass("at-chat_sidebarsettingopen");
        }, 0)
    }

    const downloadFile = ({file, fileName}) => {
        ChatManager.downloadFile(file, fileName)
    }

    const downloadAll = async () => {
        isloading.value = true;
        let response = await RestApiManager.downloadAttachments(chatInfo.value?.threadId);
        isloading.value = false;
        if(response && typeof response == 'object'){
            ChatManager.downloadFile(URL.createObjectURL(response),  `${fileName.value}.zip`);
        }
    }

    const muteNotification = async () => {
        isUpdating.value = true;
        let status = chatInfo.value.isMuted ?  'unmute_notifications' : 'mute_notifications';
        let response = await RestApiManager.postRecord(`chat-notifications/${chatInfo.value.threadId}`,{action: status, threadType : chatInfo.value.threadType});
        isUpdating.value = false;
        if( response.type === 'success' ) {
            const { threadId, isMuted, threadType } = chatInfo.value || {};
            setThreadMuted({ threadId, isMuted : response.data == 'mute_notifications' , threadType });
        }
    }

    const previewImage = (file) => {
        let index = sources.value.findIndex(item => item == file);
        if( index > -1){
            slide.value = index+1;
        }
        toggler.value = !toggler.value;
    }
  
</script>
<template>
    <div class="at-chat_sidebarsetting">
        <div class="at-chat_sidebarsetting_head">
            <a href="javascript:void(0);" class="at-closesidebar" @click.prevent="emit('closeSidebar')"><i class="laraguppy-multiply"></i></a>
        </div>
         <figure class="at-userinfo_title_img">
            <div class="at-userprofile_img">
                <img :src="userImage" :alt="chatInfo.name">
                <span class="at-userstatus" :class="{ 'online': chatInfo.isOnline, 'offline': !chatInfo.isOnline }"></span>
            </div>
            <figcaption><h4>{{chatInfo.name}}</h4></figcaption>
        </figure>
        <div class="at-chat_sidebarsettingarea">
            <div v-if="chatInfo.groupDetail && chatInfo.groupDetail.groupDescription" class="at-chat_sidebarsettingcontent">
                <p class="at-groupdescription">{{chatInfo.groupDetail.groupDescription}}</p>
            </div>
            <div v-if="!chatInfo.memberDisable && Number(chatInfo.threadType) != 'guest'" class="at-chat_sidebarsettingcontent">
                <h4>{{$t('chatapp.action')}}</h4>
                <!-- for groupChat -->
                <template v-if="chatInfo.chatType == 'group' && ( getUserRole == 1 || getUserRole == 2 ) && !chatInfo.memberDisable " >
                    <a @click.prevent="editGroup()" guppy-data-target="#creategroup" href="javascript:void(0);" >{{TRANS.edit_group}}</a>
                </template>
               
                <div class="at-rightswitcharea" :class="{'at-mute': chatInfo.isMuted}">
                    <i class="laraguppy-volume"></i>
                    <span>{{$t('chatapp.mute')}}</span>
                    <div class="at-togglebtn">
                        <input class="at-mute-thread" type="checkbox" @change="muteNotification" :checked="chatInfo.isMuted" id="mute-thread">
                        <label for="mute-thread"></label>
                    </div>
                </div>
            </div>
            <div v-if="chatInfo.threadType == 'group' && !chatInfo.memberDisable" class="at-chat_sidebarsettingcontent at-chatgroup-sidebar">
                <div class="at-chatgroup-title">
                    <h4>{{$t('chatapp.group_users')}}</h4>
                </div>
                <template v-if="groupMembers.length">
                    <ul id="memberList" class="at-grouplist at-groupmember-list">
                        <li class="at-groupuserbar at-groupuserbarvtwo" v-for="(member, index) in groupMembers" v-show=" index < showMemberRecord" :key="index+'_'+Math.floor(Math.random() * 1000)">
                            <figure class="at-groupuserbar_profile">
                                <img :src="member.userAvatar" :alt="member.userName" >
                            </figure>
                            <div class="at-groupuserbar_title">
                                <h3>{{member.userName}}</h3>
                            </div>
                            <span class="at-group-user-status" v-if="member.groupRole === 1" >{{$t('chatapp.owner')}}</span>
                            <span class="at-group-user-status" v-else-if="member.groupRole === 2">{{$t('chatapp.admin')}}</span>
                        </li>
                        <li class="at-groupuserbar at-showmore" v-if="groupMembers.length >= showMemberRecord" @click.prevent="showMoreRec(showMemberRecord)"><a href="javascript:void()" id="loadMore">{{$t('chatapp.load_more')}}</a></li>
                    </ul>
                </template>
            </div>
            <div class="at-chat_sidebarsettingcontent">
                <h4>{{$t('chatapp.privacy_settings')}}</h4>
                <a href="javascript:void(0);" v-if="settings.clearChat" @click.prevent="toggleModal('clearChat', true )" >
                    <i class="laraguppy-chat-delete"></i>
                    {{$t('chatapp.clear_chat')}}
                </a>
                <template v-if="chatInfo.threadType == 'private'">
                    <a v-if="chatInfo.friendStatus == 'blocked' && chatInfo.blockedBy == profileInfo.userId" @click.prevent="toggleModal('blockFriend', true )" href="javascript:void(0);" class="at-danger">
                        <i class="laraguppy-block"></i>
                        {{ chatInfo.friendStatus === 'blocked' ? $t('chatapp.unblock_user') : $t('chatapp.block_user') }}
                    </a>
                    <a v-else-if="chatInfo.friendStatus == 'active'" @click.prevent="toggleModal('blockFriend', true )" href="javascript:void(0);" class="at-danger">
                        <i class="laraguppy-block"></i>
                        {{ $t('chatapp.block_user') }}
                    </a>
                </template>

                <template v-else-if="chatInfo.threadType == 'group'">
                    <a href="javascript:void(0);" v-if="chatInfo.memberDisable" class="at-danger" guppy-data-target="#deletegroup">{{$t('chatapp.delete_group_txt')}}</a>
                    <a href="javascript:void(0);" v-else-if="!isBPGroup" class="at-danger" guppy-data-target="#leavegroup">{{$t('chatapp.leave_group_txt')}}</a>
                    <a href="javascript:void(0);" class="at-danger" v-if="isAllowReportOption" guppy-data-target="#reportchat">{{$t('chatapp.report_group')}}</a>
                </template>
                
            </div>
            <div class="at-gallerylistwrap">
                <h4>{{$t('chatapp.shared_files')}}</h4>
                <a v-if="attachmentList(chatInfo.threadId).length" @click="downloadAll()" href="javascript:void(0);" class="at-imgdownloader">
                    <span v-if="isloading" class="at-msgload"><i class="at-spinericon"></i></span>
                    {{$t('chatapp.download_all')}}
                    <i class="laraguppy-download"></i>
                </a>
                <ChatLoader v-if="isMediaLoading && !meidaAttachments.length" type="innerLoading"/>
                <ul v-else-if="meidaAttachments.length" class="at-gallerylist">
                    <li v-for="(file, index) in meidaAttachments" :key="index">
                    <div class="at-messageoption" >
                        <a href="javascript:void(0);" class="at-messageoption_btn" ><i class="laraguppy-ellipsis-horizontal"></i></a>
                        <ul class="at-messageoption_list">
                            <li v-if="['image', 'video'].includes(file.fileType)">
                                <a href="javascript:void(0);" @click.prevent="previewImage(file.file)">
                                    <i class="laraguppy-activity-01"></i>
                                    {{$t('chatapp.view')}}
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" @click.prevent="downloadFile(file)">
                                    <i class="laraguppy-download"></i>
                                    {{$t('chatapp.download')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                 
                        <a href="javascript:void(0);">
                            <img v-if="file.fileType === 'image'" :src="file.thumbnail" alt="attachment image" />
                            <img v-else-if="file.fileType === 'document'" :src="FileIcon" alt="attachment file" />
                            <img v-else-if="file.fileType === 'video'" :src="VideoIcon" alt="attachment video" />
                            <img v-else-if="file.fileType === 'audio'" :src="AudioIcon" alt="attachment audio" />
                            <img v-else-if="file.fileType === 'voice'" :src="AudioIcon" alt="attachment audio" />
                        </a>
                    </li>
                    <li v-if="totalPages > 1 &&  mediaPage <= totalPages" class="at-loadmorecontent">
                        <a href="javascript:void(0);" @click.prevent="getAttachments(chatInfo.threadId, mediaPage)" :class="{'at-disable-btn' : isMediaLoading }"  class="at-btn">{{$t('chatapp.load_more')}}</a>
                    </li>
                </ul>
                <div v-else class="at-dropbox at-dropboxempty">
                    <i class="laraguppy-image"></i>
                    <label>{{$t('chatapp.no_attachments')}}</label>
                </div>
            </div>
        </div>
        <Teleport to="body">
            <div class="at-lightbox-container">
                <FsLightbox :slide="slide" :toggler="toggler" :sources="sources" :showThumbsOnMount="true" />
            </div>
        </Teleport>
    </div>
</template>
<style lang="scss" scoped>
.at-chat_sidebarsettingarea{
    overflow: auto;
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
        background-color:  #1570EF ;
    }
    .at-chat_sidebarsettingcontent:first-child{padding-top: 0;}
}
.at-gallerylist{
    margin: -5px;
    @extend %flex;
    list-style: none;
    padding: 20px 0 0;
    & > li{
        padding: 5px;
        width: 33.333%;
        list-style-type: none;
        position: relative;
        &:nth-child(3n+3){
            .at-messageoption{
                &_list{
                    right: 0;
                    margin: 0;
                    left: auto;
                }
            }    
        }
        .at-messageoption{
            top: 10px;
            right: 10px;
            a{
                height: auto;
                background: transparent;
                i{
                    display: block;
                }
            }
            &_list{
                left: -90px;
                width: 190px;
            }
        }
        &:hover{
            .at-messageoption_btn{
                opacity: 1;
                visibility: visible;
            }
        }
        &.at-loadmorecontent{
            width: 100%;
            .at-btn{
                width: auto;
                height: auto;
                min-width: auto;
                margin: 0 auto;
                padding: 8px 18px;
                background-color: $theme-color;
                font: 600 rem(14)/em(20,14) $body-font-family;
            }
        }
        & > a{
            height: 50px;
            display: flex;
            position: relative;
            align-items: center;
            background-color: #F7F7F8;
            border-radius: 5px;
            justify-content: center;
            img{
                height: 50px;
                object-fit: cover;
                border-radius: 5px;
            }
        }
    }
}
.at-chatsidebar_float .at-chatloader span {
      left: 49px;
      top: 0px;
      width: 4.8px;
      height: 24px;
      display: block;
      position: absolute;
      border-radius: 1.5px;
      transform-origin: 1px 44px;
      background: var(--terguppycolor);
      animation: at-chatloader linear 0.78125s infinite;
      -webkit-animation: at-chatloader linear 0.78125s infinite;
  }
.at-groupuserbar{
    display: flex;
	cursor: pointer;
	align-items:center;
	padding: 10px 30px;
	@extend %transition;
    input{
        display: none;
        &:checked + label{
            &::after{visibility: visible;}
        }
    }
    &_content::after {
        content: "";
        left: 14px;
        width: 24px;
        height: 24px;
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        line-height: 21px;
        text-align: center;
        border-radius: 3px;
        position: absolute;
        font-family: "icomoon";
        border: 1.5px solid #ddd;
    }
    input[type=checkbox]:checked+.at-groupuserbar_content:after {
    content: "";
    background: #22c55e;
    border-color: #22c55e;
    }
    input:checked + label::after {visibility: visible;}
	&_profile{
		flex: none;
		width: 100%;
        max-width: 30px;
        margin-right: 10px;
		img{display: block;}
	}
	&_title{
        overflow: hidden;
        padding-right: 10px;
		white-space: nowrap;
		text-overflow: ellipsis;
		h3{
            margin: 0;
            overflow: hidden;
			font-size: rem(14);
			white-space: nowrap;
            letter-spacing: 0.5px;
            line-height: em(24,14);
			text-overflow: ellipsis;
		}
		span{
            display: block;
			overflow: hidden;
			font-size: rem(14);
			white-space: nowrap;
			line-height: em(26,14);
			letter-spacing: 0.01em;
			text-overflow: ellipsis;
			i{
				font-size: rem(16);
				color: $text-color;
				margin-right: 5px;
				display: inline-block;
				vertical-align: middle;
				line-height: em(22,16);
			}
		}
	}
	&_right{
		flex: none;
		text-align: right;
		margin-left: auto;
		padding-left: 10px;
		& >span{
			display: block;
			font-size: rem(14);
			color: $text-color;
			line-height: em(24,14);
		}
	}
	&:hover{
		.at-disabled{background-color:#fff;}
        .at-remove {
            opacity: 1;
            visibility: visible;
        }
	}
}
input[type=checkbox]:checked+.at-groupuserbar_content .at-makeadmin {
    opacity: 1;
    visibility: visible;
    display: inline-flex;
}
.at-group_list {
    .at-groupuserbar{
        &_title{padding-right: 0;}
        &_profile img{border-radius: 50%;}
    }
}
.at-groupuser{
&_img{
	img{
		max-width: 30px;
		& + img{
			margin-top: -10px;
			margin-left: auto;
		}
	}
}
&_twoplus{
	display: flex;
	flex-wrap: wrap;
	column-gap: 4px;
	justify-content: center;
	.at-notify{
		padding: 0;
		width: 20px;
		font-size: 15px;
		font-weight: 700;
		margin-top: 5.5px;
		line-height: 20px;
		background: #6366f1;
	}
	img{
		max-width: 20px;
		&:nth-child(n + 3){margin-top: 5.5px;}
	    }
    }
}
.at-remove{
    opacity: 0;
    line-height: 1;
    font-size: 20px;
    color: #EF4444;
    margin-left: auto;
    visibility: hidden;
    @extend %transition;
    &:hover{color: #EF4444;}
}
.at-chat_sidebarsetting{
    top: 0;
    right: 0;
    width: 100%;
    z-index: 12;
    height: 100%;
    flex: 0 0 330px;
    max-width: 330px;
    position: absolute;
    @extend %transition;
    background: #FFFFFF;
    transform: translateX(100%);
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.05);
    &_head{
        padding: 16px 20px;
    }
    .at-userinfo_title_img{
        display: flex;
        flex-wrap: wrap;
        padding: 0 20px 20px;
        justify-content: center;
        img{
            width: 60px;
            height: 60px;
            display: block;
            object-fit: cover;
            border-radius: 50%;
        }
        figcaption{
            text-align: center;
            width: 100%;
            h4{
                margin: 0;
                font: 500 rem(16)/em(24,16) $body-font-family;
            }
        }
    }
}
.at-chat420{
    .at-chat_sidebarsetting{
        max-width: 100%;
    }
}
.at-userprofile_img{
    margin: 0 0 10px;
    position: relative;
    .at-userstatus{
        right: 2.14px;
        bottom: 2.14px;
        position: absolute;
        &:before{
            width: 12.857px;
            height: 12.857px;
            border: 2.143px solid #FFF;
        }
    }
}
.at-closesidebar{
    display: block;
    color: #585858;
    font-size: 28px;
    line-height: 28px;
    i{
        display: block;
    }
}
.at-gallerylistwrap{
    padding: 10px 20px 20px;
    border-top: 1px solid #E8E8E8;
    h4{
        margin: 0;
        color: #000;
        font: 500 rem(16)/em(24,16) $body-font-family;
    }
    a.at-imgdownloader{
        & .at-msgload{
            position: unset;
            margin: 0 8px 0 0;
        }
    }
}
.at-chat_sidebarsettingopen{transform: translateX(0);}
.at-grouplist{padding-bottom: 20px;}
.at-chat991 .at-chat > .at-chat_sidebarsetting .at-chat_sidebarsettingarea {
  padding-bottom: 20px;
  height: calc(100vh - 91px);
}
.at-chat480{
    .at-groupuser_twoplus{
        padding-left: 15px;
        padding-right: 15px;
    }
}
.at-imgdownloader{
    display: flex;
    outline: none;
    color: #585858;
    margin-top: 10px;
    padding: 8px 16px;
    align-items: center;
    border-radius: 10px;
    text-decoration: none;
    background: #F7F7F8;
    font: 500 rem(14)/em(20,14) $body-font-family;
    & > i{
        font-size: rem(24px);
        margin-left: auto;
    }
}
.at-alert{
    a.at-anchor{
        background: transparent;
    }
    & .at-msgload{
        margin-right: 8px;
    }
}
.lg-rtl .at-chat_sidebarsetting {
    left: 0;
    right: auto;
    transform: translateX(-100%);
}
.lg-rtl .at-chat_sidebarsetting.at-chat_sidebarsettingopen{
    transform: translateX(0);
}
.lg-rtl .at-chat_sidebarsetting .at-userinfo_title_img figcaption{
    margin: 0 !important;
}
.lg-rtl .at-imgdownloader > i {
    margin-left: 0;
    margin-right: auto;
}
.lg-rtl .at-lightbox-container .fslightbox-toolbar {
    right: auto;
    left: 0;
}
.lg-rtl .at-gallerylist > li .at-messageoption_list {
    right: auto;
    left: 0;
}



</style>
