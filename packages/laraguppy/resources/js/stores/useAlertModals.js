import { ref } from 'vue';
import { defineStore } from 'pinia';

export default defineStore('useAlertModals', () => {
    const isInviteModal = ref({});
    const isBlockModal  = ref('');
    const isClearChatModal = ref('');
    const isReportModal  = ref('');
    const isRespondInvite  = ref('');

    const toggleModal = ( popUp, value ) => {
        switch(popUp){
            case 'blockFriend':
                isBlockModal.value = value;
                break;
            case 'acceptInvite':
                isInviteModal.value = value;
                break;
            case 'clearChat':
                isClearChatModal.value = value;
                break;
            case 'report':
                isReportModal.value = value;
                break;
            case 'respond':
                isRespondInvite.value = value;
                break;
        }
    }


    return { 
        isBlockModal, 
        isReportModal,
        isInviteModal,
        isClearChatModal,
        isRespondInvite,
        toggleModal
    }
})