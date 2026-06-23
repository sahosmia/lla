<script setup>
    import { ref, computed, onErrorCaptured, defineAsyncComponent } from 'vue';
    import SidebarTabs from "./SidebarTabs.vue";
    import useProfileStore from "../../stores/useProfileStore";
    import useTabStore from "../../stores/useTabStore";
    import SidebarErrorContent from './SidebarErrorContent.vue';
    import ChatLoader from '../chatLoader/ChatLoader.vue';
    const profileSettings = defineAsyncComponent( () => import('./profileSettings/profileSettings.vue'));
    const profileStore = useProfileStore();
    const { profileInfo } = storeToRefs(profileStore)
    import { storeToRefs } from 'pinia';
    const errorContent = ref(null)
    const tabStore = useTabStore();
    const { activeTab } = storeToRefs(tabStore)

    const activeTabComponent = computed(() => {
        return activeTab.value ? {
            "private_chat"  : defineAsyncComponent( () => import('./threads/PrivateList.vue')),
            "friend_list"   : defineAsyncComponent( () => import('./friendList/FriendUserList.vue') ),
            "contact_list"  : defineAsyncComponent( () => import('./userList/UserList.vue') ),
            "group_chat"    : '',
            "post_chat"     : '',
            "customer_support_chat": '',
        }[activeTab.value] : '';
    });

    onErrorCaptured((e,vm) => {
        errorContent.value= e;
    });

</script>
<template>
    <div class="at-chat_sidebar">
        <profileSettings v-if="profileInfo.name?.length"/>
        <div class="at-chat_preview">
            <Suspense>
                <SidebarTabs />
                <template #fallback>
                    Loading...
                </template>
            </Suspense>
            <div v-if="activeTab" class="at-userlist">
                <SidebarErrorContent v-if="errorContent" :error="errorContent" />
                <Suspense v-else timeout="5">
                    <template #default>
                        <component :id="activeTab" :is="activeTabComponent" />
                    </template>
                    <template #fallback>
                        <div class="at-userlist_tab active at-suspenseloader">
                            <ChatLoader />
                        </div>
                        <!-- Loading... -->
                    </template>
                </Suspense>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
.at-userlist_tab{
.at-emptyconver{
    background: #fff;
    border-radius: 0 0 20px 20px;
}
}
.at-emptyconver{
    padding: 0;
    width: 100%;
    height: 100%;
    @extend %flex;
    align-items:center;
    flex-direction: column;
    justify-content: center;
    background-color: #FAFAFA;
    img {
        display: block;
        margin-bottom: 30px;
    }
   span{
       display: block;
       color: #585858;
       font: 500 rem(18)/em(40,18) $heading-font-family;
    }
}
</style>

<style lang="scss" scoped>
    .at-overlay{
        &::v-deep(.at-opensidemenu){
            background: #f7f8fc;
            width: auto;
        }
    }
    .at-sidebarhead{
        &::v-deep(>img) {
        max-width: 50px;
        max-height: 50px;
        margin-right: 10px;
    }
    &::v-deep(>h2){
        @extend %flex;
        color: #fff;
        font-size: rem(22);
        letter-spacing: 0.5px;
        line-height: em(30,22);
    }
    &::v-deep(>a){
        color: #fff;
        font-size: 28px;
        margin-left: auto;
        display: inline-block;
    }
    }
    .at-suspenseloader{margin: 80px 0 0}
</style>

<style lang="scss" >
.at-notify{
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 8px;
    margin-left: auto;
    line-height: 12px;
    border-radius:60px;
    text-align: center;
    font-style: normal;
    display: inline-block;
    background-color: #FD306E;
}
.at-overlay{
    position: unset;
     .at-sidebarhead{width: 260px;}
     &::before{
        top: 0;
        left: 0;
        z-index: 1;
        content: "";
        width: 100%;
        height: 100%;
        position: absolute;
        @extend%transition;
        background-color: rgba(0, 0, 0, 0.3);
    }
}
.at-userlist{
    width: 100%;
    display: flex;
    flex-direction: column;
    height: calc(100vh - 225px);
    &_tab{
        height: 100%;
        display: flex;
        flex-direction: column;
	ul{
        margin: 0;
        padding:0;
		width: 100%;
		height: 100%;
        list-style: none;
	}
	li{
		width: 100%;
		list-style-type: none;
  	   }
    }
    .at-emptyconver{
	    span{font: 500 rem(14)/em(20,14) $heading-font-family;}
    }
}
.at-user_information{
    gap: 8px;
    flex: none;
    display: flex;
    align-items: center;
    &>figure{
        border-radius: 50%;
    }
    img{
        flex: none;
        width: 34px;
        display: block;
        height: 34px;
        border-radius: 50%;
    }
      h5{
        margin: 0;
        width: 120px;
        font-size: 14px;
        overflow: hidden;
        font-weight: 500;
        line-height: 20px;
        white-space: nowrap;
        letter-spacing: .5px;
        text-overflow: ellipsis;
        text-transform: capitalize;
    }
}
.at-chat-tab{
    margin: 0;
    padding: 0;
    width: 100%;
      li{
         flex: none;
         display: flex;
         align-items: center;
         list-style-type: none;
         box-shadow: inset 0 -1px 0 #eee;
    }
      a{
         width: 100%;
         display: flex;
         align-items: center;
    }
}
.at-sidebarhead{
    width: 100%;
    padding: 18px 18px 0;
    border-bottom: 1px solid #EAEAEA;
    .at-chat_sidebarsettingarea {
	     padding-bottom: 30px;
	     height: calc(100vh - 180px);
   }
   &_search{
       padding: 0;
        width: 100%;
        @extend %flex;
        margin-top: 14px;
        position:relative;
        h3{
            width: 100%;
            display: flex;
            margin: 0 0 10px;
            align-items:center;
            font-size: rem(18);
            letter-spacing: 0.5px;
            line-height: em(26,18);
            a{
                margin-left: auto;
                font-size: rem(14);
                color: $anchor-color;
                display: inline-block;
                line-height: em(22,14);
            }
	    }
        .at-form-group{
            padding:0;
            display: flex;
            position: relative;
            align-items: center;
            i{
                left: 12px;
                color: #999;
                font-size: 18px;
                position:absolute;
            }
            input{
                border: 0;
                width: 100%;
                font-size: 14px;
                padding-left:38px;
                border-radius: 10px;
                background: #fff;
            }
        }
    }
    .at-chat_profilesettingopen{transform: translateX(0);}
}
.at-sidebarmenu{
    padding: 14px;
    border-radius: $radius;
    background-color: #F7F7F8;
}
.at-chat_profile {padding: 20px;}
.at-blocked{
    opacity: 0.6;
    pointer-events: none;
}
.at-blockuser{
	position:relative;
    &.at-shimmer{
        i{display: none;}
    }
	& > i{
		top: -4px;
		left: -4px;
		z-index: 1;
		color: #EF4444;
		position: absolute;
		font-size: rem(14);
		display: inline-block;
		line-height: em(14,14);
		vertical-align: middle;
		&:after{
			top: 1px;
			left: 1px;
			width: 85%;
			height: 85%;
			z-index: -1;
			content: "";
			position:absolute;
			border-radius: 50%;
			background-color:#fff;
		}
	}
}
.away{&:before{background-color:#EAB308 !important;}}
.online{&:before{background-color:#22C55E !important;}}
.offline{&:before{background-color:$text-color !important;}}
.at-chat1440  {
    .at-chat_sidebar{
        flex: 0 0 480px;
        max-width: 480px;
        -ms-flex: 0 0 480px;
    }
}
.at-chat1199 {
    .at-chat_sidebar{
        flex: 0 0 430px;
        max-width: 430px;
        -ms-flex: 0 0 430px;
    }
}
.at-chat1080 {
    .at-chat_sidebar {
        flex: 0 0 350px;
        max-width: 350px;
        -ms-flex: 0 0 350px;
    }
}
.at-chat991 {
    .at-chat_sidebar{
        flex: 0 0 100%;
        max-width: 100%;
        -ms-flex: 0 0 100%;
    }
}
.at-chat991.at-opnchatbox .at-chat_sidebar {display: none;}
</style>
