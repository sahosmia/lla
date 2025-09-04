<script setup>
    import { ref } from "vue";
    import useAlertModals from "../../stores/useAlertModals";
    import useTabStore from "../../stores/useTabStore";
    import RestApiManager from "../../services/restApiManager";

    const { user } = defineProps(['user']);
    const inviteStatus = ref('');
    const isloading = ref(false);
    const alertModals = useAlertModals();
    const { toggleModal } = alertModals
    const tabStore = useTabStore();
    const { updateFriendReq } = tabStore;

    const respondToInvite = async (friendStatus) => {
        if(['active', 'declined'].includes(friendStatus)){
            inviteStatus.value  = friendStatus;
            isloading.value     = true;
            let data            = { userId :user.userId, friendStatus }
            let response        = await RestApiManager.updateRecord("friends/update", data);
            isloading.value     = false;
            if(response.type === 'success'){
                updateFriendReq(response.data);
                toggleModal('respond', false);
            }
        }
    }
    
</script>
<template>
    <div id="accept_invite" class="at-modal at-invitepopup at-modalopen at-fadin">
        <div class="at-modaldialog"> 
            <div class="at-unknownuser">
                <div class="at-alert">
                    <h2>{{user?.name}}
                        <i @click.prevent="toggleModal('respond', false )" class="at-guppy-removemodal laraguppy-multiply"></i>
                    </h2>
                    <p>{{$t('chatapp.invitation_desc')}}</p>
                    <div class="at-alert_btns">
                        <a 
                            href="javascript:void(0);" 
                            class="at-btn at-bgdanger" 
                            :class="{'at-disable-btn' : isloading && inviteStatus == 'declined' }"
                            @click.prevent="respondToInvite('declined')"
                            >
                            {{$t('chatapp.decline')}}
                        </a>
                        <a  href="javascript:void(0);" 
                            @click.prevent="respondToInvite('active')" 
                            class="at-btn at-bgsuccess"
                            :class="{'at-disable-btn' : isloading && inviteStatus == 'active' }"
                        >
                            {{$t('chatapp.accept')}}
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>