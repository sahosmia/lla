import { ref, computed } from 'vue';
import { defineStore } from 'pinia';


export default defineStore('useChatStore', () => {
    const chatInfo      = ref({});
    const isMsgChat     = ref(true);

    const isActiveChat = computed(() => {
        return Object.keys(chatInfo.value).length ? true : false;
    });

    const updateChatInfo = (data) => {
        chatInfo.value = data;
    }

    return {
        isMsgChat,
        chatInfo,
        isActiveChat,
        updateChatInfo,
    }
});