<script setup>
    import {ref, defineAsyncComponent, onMounted} from "vue";
    import { storeToRefs } from 'pinia';
    import useTabStore from "../../../stores/useTabStore";
    import EmptyUsersImage from "../../../assets/images/empty-users.svg"
    import { debounce } from 'lodash';
    const ListItem = defineAsyncComponent(() => import('./ListItem.vue'));
    const ChatLoader = defineAsyncComponent(() => import('../../chatLoader/ChatLoader.vue') );
    const tabStore = useTabStore();
    const { getTabRecord, loadingStatus, tabList, search } = storeToRefs(tabStore);
    const { updateTabList } = tabStore;
    
    const updateList = () => {
        let params = {
            tab: 'request_list', 
            url: 'friend-requests', 
            loadingType: 'isLoading',
            search : search.value
        }
        updateTabList(params);
    }

    onMounted(() => {
        if(!getTabRecord.value('request_list').length){
            updateList();
        }
    });
</script>
<template>
    <div class="at-userlist_tab active">
        <template v-if="getTabRecord('request_list').length">
            <ListItem :tabRecord="getTabRecord('request_list')" />
            <ChatLoader v-if="loadingStatus({tab: 'request_list', loadingType : 'isLoading'})" type="inner"/>
        </template> 
        <template v-else>
            <ChatLoader showText="true" v-if="loadingStatus({tab: 'request_list', loadingType : 'isLoading'})" type="inner"/>
            <div v-else class="at-emptyconver">
                <img :src="EmptyUsersImage" />
                <span>{{$t('chatapp.no_result_found')}}</span>
            </div>
        </template>
    </div>
</template>