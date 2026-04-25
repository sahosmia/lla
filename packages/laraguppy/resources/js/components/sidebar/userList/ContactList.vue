<script setup>
    import {ref, defineAsyncComponent, onMounted} from "vue";
    import { storeToRefs } from 'pinia';
    import useTabStore from "../../../stores/useTabStore";
    import EmptyUsersImage from "../../../assets/images/empty-users.svg"
    const ListItem = defineAsyncComponent(() => import('./ListItem.vue'));
    const ChatLoader = defineAsyncComponent(() => import('../../chatLoader/ChatLoader.vue') );
    const tabStore = useTabStore();
    const searchKeyword = ref('');
    const { 
        getTabRecord, 
        loadingStatus, 
        hasMoreRecord, 
        search 
    }   = storeToRefs(tabStore);
    const { updateTabList } = tabStore

    const updateList = async (loadingType, isSearching = false) => {
        let params = {
            tab: 'contact_list', 
            url: 'contacts', 
            loadingType,
            search : search.value,
            isSearching
        }
        await updateTabList(params);
    }
    onMounted(() => {
        let record = getTabRecord.value('contact_list');
        if(hasMoreRecord.value('contact_list') || search.value?.length){
            updateList(record?.length ? 'isScrolling' : 'isLoading' );
        }
    });

</script>
<template>
    <div class="at-userlist_tab active">
        <template v-if="getTabRecord('contact_list').length">
            <ListItem @scroll-list="updateList" :tabRecord="getTabRecord('contact_list')" tab="contact_list" />
            <ChatLoader v-if="loadingStatus({tab: 'contact_list', loadingType : 'isLoading'})"/>
        </template>
        <template v-else>
            <ChatLoader showText="true" v-if="loadingStatus({tab: 'contact_list', loadingType : 'isLoading'})"/>
            <div v-else class="at-emptyconver">
                <img :src="EmptyUsersImage" />
                <span>{{$t('chatapp.no_result_found')}}</span>
            </div>
        </template>
    </div>
</template>