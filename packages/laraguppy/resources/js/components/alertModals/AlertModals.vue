<script setup>
    import { ref } from "vue";
    import { storeToRefs } from "pinia";
    import useAlertModals from "../../stores/useAlertModals"
    import BlockUserModal from "./BlockUserModal.vue";
    import ClearChat from "./ClearChat.vue";
    import ReportUserModal from "./ReportUserModal.vue"
    import RespondToInvite from "./RespondToInvite.vue";
    import useEventsBus from "../../services/useEventBus";
    const { on } = useEventsBus();
    const user = ref(null);
    const alertModals = useAlertModals();
    const { toggleModal } = alertModals;
    const { isInviteModal, isBlockModal, isClearChatModal, isReportModal, isRespondInvite } = storeToRefs(alertModals);

    on('respondInvite', (payload) => {
        user.value = payload;
    });
</script>
<template>
    <div>
        <BlockUserModal v-if="isBlockModal" />
        <ClearChat v-if="isClearChatModal" />
        <ReportUserModal v-if="isReportModal" />
        <RespondToInvite v-if="isRespondInvite" :user="user"/>

    </div>
</template>