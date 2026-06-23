<script setup>
import { reactive, ref, onMounted, onBeforeUnmount, computed } from "vue";
import { storeToRefs } from "pinia";
import useSettingsStore from "../../stores/useSettingsStore";
import useProfileStore from "../../stores/useProfileStore";
import useTabStore from "../../stores/useTabStore";
import useEventsBus from "../../services/useEventBus";
import Avatar from "../../assets/images/avatar.png";
import { debounce } from 'lodash';
import { trans } from "laravel-vue-i18n";
const profileStore = useProfileStore();
const { profileInfo } = storeToRefs(profileStore);
const settingsStore = useSettingsStore();
const tabStore = useTabStore();
const { unreadCounts, search, activeTab } = storeToRefs(tabStore);
const { updateTabList, setSearch, setActiveTab } = tabStore;
const { settings } = storeToRefs(settingsStore);
const { emit } = useEventsBus();
const isLoadingImg = ref(true);
const searchKeyword = ref('');
const applySearch = debounce(() => updateList('isLoading', true), 500);
const urls = ref({
    private_chat: 'threads',
    contact_list: 'contacts', 
    request_list: 'friend-requests',
    friend_list: "friends", 
})
const updateList = async (loadingType, isSearching = false) => {
    setSearch(searchKeyword.value);
    let params = {
        tab: activeTab.value, 
        url: urls.value[activeTab.value], 
        loadingType,
        search : searchKeyword.value,
        isSearching
    }
    await updateTabList(params);
}

const tabTitles = computed(() => {
    return {
        private_chat: trans("chatapp.privatechat_title"),
        friend_list: trans("chatapp.friendlist_title"),
        contact_list: trans("chatapp.contactlist_title"),
        group_chat: trans("chatapp.groupchat_title"),
        post_chat: trans("chatapp.postchat_title"),
        customer_support_chat: trans("chatapp.customer_support_title"),
    };
});

const userImage = computed(() => {
    if(profileInfo.value.name){
        return profileInfo.value.photo ? profileInfo.value.photo : (settings.value.defaultAvatar ? settings.value.defaultAvatar : Avatar)
    }
    return null;
});

const tabIcons = reactive({
    contact_list: "laraguppy-users",
    friend_list: "laraguppy-user-check",
    private_chat: "laraguppy-chat",
    group_chat: "",
    post_chat: "",
    customer_support_chat: "",
});

const handleClick = (e) => {
    e.stopPropagation();
    document.querySelector(".at-chat_preview").classList.toggle("at-overlay");
};

const handleWindowClick = (e) => {
    e.stopPropagation();
    let chatPreview = document.querySelector(".at-chat_preview");
    if (chatPreview.classList.contains("at-overlay")) {
        chatPreview.classList.remove("at-overlay");
    }
};

onMounted(() => {
    window.addEventListener("click", handleWindowClick);
    const elements = document.querySelectorAll(
        ".at-sidebarhead > a, .at-sidebarhead .at-sidebarmenu li .at-opensidemenu"
    );
    elements.forEach((element) => {
        element.addEventListener("click", handleClick);
    });

    onBeforeUnmount(() => {
        elements.forEach((element) => {
            element.removeEventListener("click", handleClick);
        });
    });

});

const openSideBar = () => {
    emit('openSettings');
}

</script>
<template>
    <div class="at-sidebarhead">
        <div class="at-sidebarmenu">
            <div class="at-sidebarmenu_user">
                <div class="at-user_information">
                    <figure :class="{'at-shimmer': isLoadingImg}">
                        <img :src="userImage" @load="() => isLoadingImg = false" :alt="profileInfo.name" :class="{'at-none': isLoadingImg}">
                    </figure>
                    <h5>{{profileInfo.name}}</h5>
                </div>
                <div class="at-sidebarmenu_option">
                    <a @click.prevent="openSideBar()" class="at-sidebarmenu_option_btn" href="javascript:void(0);">
                        <i class="laraguppy-user-setting"></i>
                    </a>
                </div>                
            </div>
            <div class="at-sidebarhead_search">
                <div class="at-form-group">
                    <i class="laraguppy-search-03"></i>
                    <input type="search" @input="applySearch" v-model.trim="searchKeyword" class="at-form-control" :placeholder="$t('chatapp.search_here')">
                </div>
            </div>
        </div>
        <div class="at-chat-tab">
            <template v-for="(tab,index) in settings.enableTabs" :key="index">
                <div :id="tab">
                    <a @click.prevent="setActiveTab(tab)" href="javascript:void(0);" :class="{'active' : activeTab == tab} ">
                        <i :class="tabIcons[tab]"></i>
                        <div class="at-chat-tab_tooltip">
                            <h6>
                                {{tabTitles[tab]}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="5" viewBox="0 0 14 5" fill="none">
                                    <path d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"/>
                                </svg>
                            </h6>
                            <em class="at-userchat_tab-noti at-notify" v-if="tab == 'contact_list' && unreadCounts['request_list'] > 0" >{{unreadCounts['request_list'] >= 100 ? "+99" : unreadCounts['request_list']}}</em>
                            <em class="at-userchat_tab-noti at-notify" v-else-if="unreadCounts[tab] > 0" >{{unreadCounts[tab] >= 100 ? "+99" : unreadCounts[tab]}}</em>
                        </div>
                    </a>
                </div>
            </template>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.at-sidebarmenu {
    &_user{
        display: flex;
        align-items: center;
    }
    &_option{
        margin-left: auto;
        &_btn{
            color: #585858;
            font-size: 20px;
            line-height: 20px;
            i{
                display: block;
            }
        }
        &_list{
            right: 0;
            gap: 2px;
            z-index: 999;
            display: flex;
            padding: 8px;
            width: 250px;
            list-style: none;
            flex-wrap: wrap;
            position: absolute;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 20px 24px -4px rgba(16, 24, 40, 0.08), 0px 8px 8px -4px rgba(16, 24, 40, 0.03);
            // display: none;
            li{
                width: 100%;
                box-shadow: none;
                list-style-type: none;
                a{
                    gap: 10px;
                    display: flex;
                    color: #585858;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 20px;
                    padding: 10px 8px;
                    border-radius: 10px;
                    align-items: center;
                    transition: all 0.3s ease-in-out;
                    i{
                        font-size: 20px;
                        line-height: 20px;
                    }
                    &:hover{
                        background-color: #F7F7F8;
                    }
                }
            }
        }
    }
}
.at-logoutoption{
    &:before{
        left: -8px;
        height: 1px;
        content: "";
        margin: 8px 0;
        display: block;
        position: relative;
        background: #EAEAEA;
        width: calc(100% + 16px);
    }
}
.at-chat-tab{
    display: flex;
    margin: 0 -18px;
    width: calc(100% + 36px);
    &::v-deep(>div){flex: auto;}
    &_tooltip{
        h6{
            left: 50%;
            z-index: 9;
            opacity: 0;
            bottom: 100%;
            color: #FFF;
            font-size: 12px;
            font-weight: 500;
            line-height: 18px;
            padding: 8px 12px;
            position: absolute;
            visibility: hidden;
            border-radius: 10px;
            background: #070611;
            @extend %transition;
            white-space: nowrap;
            transform: translate(-50%, 0);
            box-shadow: 4px 8px 48px -8px rgba(99, 115, 146, 0.12);
            svg{
                top: 100%;
                left: 50%;
                margin-left: -7px;
                position: absolute;
            }
        }
    }
    &::v-deep(i) {
        color: #585858;
        margin-left: 0;
        display: block;
        font-size: 20px;
        line-height: 20px;
    }
    &::v-deep(li a h6) {
        margin: 0;
        flex: none;
        font-size: 16px;
        font-weight: 600;
        line-height: 19px;
        letter-spacing: 0.5px;
        display: inline-flex;
        text-transform: inherit;
    }
    &::v-deep(a) {
        min-height: 50px;
        position: relative;
        justify-content: center;
        & >  .at-chat-tab-shape{
            top: 0;
            left: -10px;
            opacity: 0;
            visibility: hidden;
            position: absolute;
            & ~ .at-chat-tab-shape{
                left: auto;
                right: -10px;
            }
        }
        &:hover{
            .at-chat-tab_tooltip{
                h6{
                    opacity: 1;
                    visibility: visible;
                }
            }
        }
    }
    &::v-deep(a.active) {
        color: #2E90FA;
        i{
            color: #2E90FA;
            &.laraguppy-chat:before{
                content: "\e98d";
            }
            &.laraguppy-user-check:before{
                content: "\e98c";
            }
            &.laraguppy-users:before{
                content: "\e98e";
            }
        }
    }
}
</style>
<style lang="scss">
.at-chat_preview {
    display: flex;
    flex-wrap: wrap;
}
.at-userlist_tab ul {
    overflow: auto;
    &::-webkit-scrollbar-track {
        width: 5px;
        opacity: 0;
        visibility: hidden;
        background-color: transparent;
    }
    &::-webkit-scrollbar {
        margin: 0;
        width: 5px;
        opacity: 0;
        visibility: hidden;
        background: transparent;
    }
    &::-webkit-scrollbar-thumb {
        margin: 0;
        width: 5px;
        opacity: 0;
        height: 25px;
        visibility: hidden;
        border-radius: 60px;
        background-color: $theme-color;
    }
    &:hover {
        &::-webkit-scrollbar-thumb {
            opacity: 1;
            visibility: visible;
        }
    }
}
.at-userbar {
    display: flex;
    cursor: pointer;
    padding: 12px 18px;
    align-items: center;
    @extend %transition;
    &.active,
    &:hover {
        background: #F7F7F8;
        .at-btn-sm.at-btn-resend,
        .at-invitebtn.at-btn-sm{
            background-color: #D1E9FF;
        }
        .at-btn-blocked,
        .at-user-blocked{
            background-color: #FEE4E2;
        }
    }
    &.active {
        .at-disabled {
            background-color: #fff;
        }
    }
    &_profile {
        flex: none;
        width: 28px;
        height: 28px;
        margin-right: 10px;
        img {
            width: 28px;
            height: 28px;
            display: block;
            object-fit: cover;
        }
    }
    &_title {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        h3 {
            margin: 0;
            overflow: hidden;
            font-weight: 500;
            font-size: rem(14);
            white-space: nowrap;
            letter-spacing: 0.5px;
            line-height: em(20, 14);
            text-overflow: ellipsis;
            color: rgba($color: #000000, $alpha: 0.7);
        }
        > span {
            gap: 4px;
            display: flex;
            overflow: hidden;
            align-items: center;
            color: #585858;
            font-size: rem(12);
            white-space: nowrap;
            letter-spacing: 0.01em;
            line-height: em(18, 12);
            text-overflow: ellipsis;
            opacity: 0.8;
            i {
                color: #7A7A7A;
                font-size: rem(12);
                display: inline-block;
                vertical-align: middle;
                line-height: em(12, 12);
            }
        }
    }
    &_right {
        flex: none;
        padding-left: 10px;
        margin-left: auto;
        & > span {
            opacity: 0.6;
            display: block;
            color: #585858;
            font-size: rem(12);
            line-height: em(18, 12);
        }
    }
    &:hover {
        .at-disabled {
            background-color: #fff;
        }
    }
    &_loader {
        bottom: 0;
        height: 134px;
        display: flex;
        position: absolute;
        align-items: center;
        border: 0 !important;
        justify-content: center;
        width: calc(100% - 76px) !important;
        background: linear-gradient(
            180deg,
            rgba(255, 255, 255, 0) 0%,
            #ffffff 59.37%
        );
        .at-spinericon {
            display: block;
            line-height: 64px;
        }
        span {
            width: 64px;
            height: 64px;
            display: flex;
            font-size: 24px;
            line-height: 64px;
            text-align: center;
            align-items: center;
            border-radius: 40px;
            background: #ffffff;
            @extend %themeboxshadow;
            justify-content: center;
        }
    }
}
.at-userbar_profile {
    &.at-shimmer{
        border-radius: 50%;
        & .at-userstatus{display:none;}
    }
    img {
        width: 100%;
        height: 28px;
        display: block;
        margin: 0 auto;
        object-fit: cover;
        border-radius: 50px;
    }
    .at-userstatus {
        right: 0;
        bottom: 0;
        z-index: 0;
        position: absolute;
        &:before{
            width: 6px;
            height: 6px;
        }
    }
}
.at-chat480 {
    .at-chat_sidebar_footer a {
        font-size: 20px;
        .at-notify {
            padding: 0 6px;
            font-size: 10px;
            line-height: 1.7em;
        }
    }
    .at-userbar {
        .at-userbar_right {
            margin-left: auto;
            padding-left: 20px;
        }
        .at-userbar_title {
            margin-left: 15px;
            h3 {
                line-height: 21px;
                font-size: 15px;
            }
            span {
                line-height: 22px;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                width: 100%;
                display: block;
            }
        }
    }
    .at-userbar_right {
        margin: 0;
        padding: 0;
    }
    .at-userinfo {
        padding-left: 8px;
        padding-right: 15px;
    }
    .at-userlist {
        .at-userbar_profile {
            margin-right: 0;
        }
    }
    .at-userbar_title {
        padding:0;
    }
}
.at-userchat_tab-noti.at-notify{
    top: 0;
    left: 50%;
    margin: 4px 0 0;
    padding: 2px 5px;
    min-width: 20px;
    position: absolute;
    border: 2px solid #F7F7F8;
    font-size: 10px;
}
</style>
