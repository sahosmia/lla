<script setup>
    import { computed, ref, defineAsyncComponent, onErrorCaptured } from "vue";
    import { storeToRefs } from 'pinia';
    import useTabStore from "../../../stores/useTabStore";
    const tabStore = useTabStore();
    const { unreadCounts } = storeToRefs(tabStore);
    const activeTab = ref('contacts');
    const errorContent = ref('');

    onErrorCaptured((e) => {
        errorContent.value= e;
    });
    const activeTabComponent = computed(() => {
        return activeTab.value ? {
            "contacts"  : defineAsyncComponent( () => import('./ContactList.vue') ), 
            "requests"  : defineAsyncComponent( () => import('./RequestList.vue') ), 
        }[activeTab.value] : '';
    });

</script>
<template>
    <div id="userlist" class="at-userlist_tab active">
        <div class="at-userchat_tab">
            <a href="javascript:void(0);" @click.prevent="activeTab = 'contacts'" :class="{'at-tabactive' : activeTab == 'contacts' }">
                <i class="laraguppy-user"></i>
                <span>{{$t('chatapp.contacts')}}<svg width="14" height="5" viewBox="0 0 14 5" fill="none"><path d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span>
            </a>
            <a href="javascript:void(0);" @click.prevent="activeTab = 'requests'" :class="{'at-tabactive' : activeTab == 'requests' }">
                <i class="laraguppy-user-request"></i>
                <span>{{$t('chatapp.requests')}}<svg width="14" height="5" viewBox="0 0 14 5" fill="none"><path d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span>
                <em class="at-notify" v-if="unreadCounts.request_list">{{unreadCounts.request_list}}</em>
            </a>
        </div>
        <keep-alive>
            <component :id="activeTab" :is="activeTabComponent" />
        </keep-alive>
    </div>
</template>
<style lang="scss" scoped>
.at-userlist_tab{
    .at-emptyconver {
        width: 100%;
        z-index: -2;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        text-align: center;
        background: #fff;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }
    .at-userlist_tab{
        width: 100%;
        height: calc(100vh - 160px);
    }
} 
.at-userchat_tab{
    width: 100%;
    display: flex;
    align-items: center;
    box-shadow: inset 0 -1px 0 #eee;
    & + .at-userlist_tab{
        height: calc(100vh - 280px);
    }
    .at-tabactive {
        background: #fff;
        box-shadow: inset 1px -3px 0 -1px #2E90FA !important;
   }
    i{
        color: #999;
        font-size: 20px;
        font-weight: 400;
        margin-right: 12px;
    }
    a.at-tabactive{
        i{color: #0a0f26;}
    }
    a {
        width: 100%;
        display: flex;
        max-width: 50%;
        position: relative;
        text-align: center;
        padding: 17px 10px;
        align-items: center;
        justify-content: center;
        color: var(--secguppycolor);
        font: 600 16px/32px var(--primchatfont);
        &:hover{
            span{
                opacity: 1;
                visibility: visible;
            }
        }
        .at-notify{
            top: 50%;
            left: 50%;
            height: 20px;
            display: flex;
            margin: 4px 0 0;
            padding: 2px 5px;
            min-width: 20px;
            font-size: 10px;
            margin-top: -18px;
            position: absolute;
            align-items: center;
            justify-content: center;
            border: 2px solid #F7F7F8;
        }
        & > span {
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
}
</style>