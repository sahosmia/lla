import { ref, inject } from 'vue';
import { defineStore } from 'pinia';
import moment from "moment";
import { trans } from 'laravel-vue-i18n';
import RestApiManager from "../services/restApiManager";
import useTabStore from './useTabStore';
export default defineStore('useSettingsStore', () => {
    const axios         = inject('axios');
    const settings      = ref({});
    const windowWidth   = ref('');

    const tabStore = () => {
        const store = useTabStore();
        const { setActiveTab } = store;
        return { setActiveTab }
    }

    const getChatSettings = async () => {
        const { setActiveTab } = tabStore();
        let result = await RestApiManager.getRecord('chatapp-settings');
        if(result.type == 'success'){
            settings.value  = result.data;
            setActiveTab(result.data.defaultActiveTab);
        }
    }

    const updateWindowWidth = (width) => {
        windowWidth.value = width;
    }

    const getMessageTime = (createdAt) => {
        if (createdAt) {
            const timeFormat    = settings.value.timeFormat == '24hrs' ? 'HH:mm' : 'hh:mm a';
            let dateTime        = moment(new Date(createdAt)).format(timeFormat);
            return settings.value.timeFormat == '12hrs' ? `${dateTime.replace('am', trans('chatapp.am')).replace('pm', trans('chatapp.pm'))}` : dateTime;
        }
        return null;
    }

    return { 
        settings, 
        windowWidth, 
        getMessageTime,
        getChatSettings,
        updateWindowWidth
    }
})