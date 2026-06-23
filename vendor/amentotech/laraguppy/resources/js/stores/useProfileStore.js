import { ref, computed } from 'vue';
import { defineStore } from 'pinia';
import RestApiManager from '../services/restApiManager';
import EventManager from '../services/eventManager';
export default defineStore('useProfileStore', () => {
    const profileInfo   = ref({});
    const accountNotification = ref('unmute_notifications');
    const isMuted = ref(false);

    const getProfileInfo = async () => {
        let response = await RestApiManager.getRecord('guppy-user');
        if( response.type === 'success' ) {
            isMuted.value = response.user.isMuted
            profileInfo.value = response.user;
            EventManager(response.user.userId);
        }
    }

    const updateProfileInfo = async (data) => {
        let response = await RestApiManager.postRecord('guppy-user', data, 'multipart/form-data');
        if( response.type === 'success' ) {
            profileInfo.value = response.data;
            return { type : 'success' };
        } else if(response.type === 'error' && response?.errors){
            return response; 
        }
    }

    const setNotication = (action) => {
        accountNotification.value = action;
    }
    
    const toggleIsMuted = (action) => {
        isMuted.value = action;
    }

    return {
        isMuted,
        profileInfo,
        accountNotification,
        toggleIsMuted,
        getProfileInfo,
        setNotication,
        updateProfileInfo,
    }
})