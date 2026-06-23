<script setup>
    import { ref, defineAsyncComponent, onMounted } from "vue";
    import { storeToRefs } from "pinia";
    import { debounce } from "lodash";
    import useSettingsStore from "../../../stores/useSettingsStore"
    import useTabStore from "../../../stores/useTabStore"
    import useChatStore from "../../../stores/useChatStore"
    import EmptyUsersImage from "../../../assets/images/empty-users.svg"
    import avatar from "../../../assets/images/avatar.png";
    const ChatLoader = defineAsyncComponent(() => import("../../chatLoader/ChatLoader.vue"));
    import useProfileStore from "../../../stores/useProfileStore";
    const profileStore = useProfileStore();
    const { profileInfo } = storeToRefs(profileStore)
    const chatStore = useChatStore();
    const isLoadingImage = ref(true);
    const settingsStore = useSettingsStore();
    const { settings } = storeToRefs(settingsStore);
    const tabStore = useTabStore();
    const { getTabRecord, loadingStatus, search, activeTab } = storeToRefs(tabStore);
    const { updateTabList, updateFriendStatus } = tabStore;
    const { updateChatInfo } = chatStore;
    const processingId  = ref('');
    const isLoading     = ref(false);
    const updateList = async (loadingType, isSearching = false) => {
        let params = {
            tab: "friend_list",
            url: "friends",
            loadingType,
            search: search.value,
            isSearching,
        };
        await updateTabList(params);
    };

        const unblock = async (userId) => {
            processingId.value = userId;
            isLoading.value = true;
            let response = await updateFriendStatus({ 
                userId: userId, 
                friendStatus: 'active', 
                unblock: true
            });
            isLoading.value     = false;
    }

    const scrollHandler = debounce(
        ({ target: { clientHeight, scrollTop, scrollHeight } }) => {
            if (scrollTop + clientHeight + 5 >= scrollHeight) {
                updateList("isScrolling");
            }
        },
        250
    );

    const updateUserInfo = (data) => {
        updateChatInfo(data);
    };

    onMounted(() => {
        let friendRecord = getTabRecord.value("friend_list");
        if (!friendRecord.length || search.value) {
            updateList("isLoading");
        }
    });
</script>
<template>
    <div class="at-userlist_tab active">
        <template v-if="getTabRecord('friend_list').length">
            <ul class="conversation-list" @scroll.prevent="scrollHandler($event)" >
                <li @click.prevent="updateUserInfo(friend)" class="at-userbar" :class="{'at-blocked': friend.friendStatus == 'blocked' && friend.blockedBy != profileInfo.userId}" v-for="friend in getTabRecord('friend_list')" :key="friend.userId">
                    <figure
                        class="at-userbar_profile"
                        :class="{ 'at-shimmer': isLoadingImage, 'at-blockuser': friend.friendStatus == 'blocked'}"
                    >
                        <i v-if="friend.friendStatus == 'blocked'" class="laraguppy-block" ></i>
                        <span
                            class="at-userstatus"
                            :class="{
                                online: friend.isOnline,
                                offline: !friend.isOnline,
                                'at-none': isLoadingImage,
                            }"
                        ></span>
                        <img
                            @load="() => (isLoadingImage = false)"
                            :class="{ 'at-none': isLoadingImage }"
                            :src="friend.photo ? friend.photo : ( settings.defaultAvatar ? settings.defaultAvatar : avatar )"
                            :alt="friend.name"
                        />
                    </figure>
                    <div v-if="friend.name" class="at-userbar_title">
                        <h3 v-if="friend.name">{{ friend.name }}</h3>
                    </div>
                    <template v-if="friend.friendStatus == 'blocked'">
                        <div v-if="friend.blockedBy == profileInfo.userId" class="at-userbar_right">
                            <a href="javascript:void(0);" @click.prevent.stop="unblock(friend.userId)" :id="`user_${friend.userId}`" :class="{'at-disable-btn' : processingId == friend.userId && isLoading }" class="at-btn-blocked">{{$t('chatapp.unblock')}}</a>
                        </div>
                        <div v-else class="at-userbar_right">
                            <a href="javascript:void(0);" :id="`user_${friend.userId}`" :class="{'at-disable-btn' : processingId == friend.userId && isLoading }" class="at-btn-blocked">{{$t('chatapp.blocked')}}</a>
                        </div>
                    </template>
                </li>
                <ChatLoader
                    v-if="loadingStatus({
                        tab: 'friend_list',
                        loadingType: 'isScrolling',
                    })"
                    type="innerLoading"
                />
            </ul>
        </template>
        <template v-else>
            <ChatLoader
                showText="true"
                v-if="loadingStatus({
                    tab: 'friend_list',
                    loadingType: 'isLoading',
                })"
            />
            <div v-else class="at-emptyconver">
                <img :src="EmptyUsersImage" />
                <span>{{$t('chatapp.no_result_found')}}</span>
            </div>
        </template>
    </div>
</template>
<style lang="scss"></style>
