<script setup>
    import { ref, onMounted } from 'vue';
    import { storeToRefs } from 'pinia';
    import useChatStore from "../../stores/useChatStore";
    import useSettingsStore from "../../stores/useSettingsStore";
    import useAlertModals from "../../stores/useAlertModals";
    import RestApiManager from "../../services/restApiManager";

    const chatStore = useChatStore();
    const settingsStore = useSettingsStore();
     const alertModals = useAlertModals();
    const { chatInfo } = storeToRefs(chatStore);
    const { settings } = storeToRefs(settingsStore);
    const { toggleModal } = alertModals;
    const description = ref('');
    const isLoading = ref(false);
    const reason = ref('');
    
    const reportChat = async ()=> {
        isLoading.value = true;
        let response = await RestApiManager.postRecord("report-user", { 
            threadId: chatInfo.value.threadId, 
            userId: chatInfo.value.userId, 
            reason: reason.value, 
            description: description.value, 
        });
        isLoading.value = false;
        if(response.type == 'success'){
            toggleModal('report', false )
        }
    }

    onMounted(() => {
        jQuery(document).on('click','.at-dropdownholder .at-form-control',function(e){
            jQuery(this).next().slideToggle()
        })
        
        jQuery(document).on('click','.at-dropdown li',function(e){
            jQuery(this).closest('.at-dropdownholder').children().children('span').removeClass()
            jQuery(this).closest('ul').slideUp()
        })
    })

</script>
<template>
     <div id="reportchat" class="at-modal at-modalopen at-fadin">
        <div class="at-modaldialog">
            <div class="at-alert">
                <div class="at-modal_title">
                    <h2>{{ $t('chatapp.report_heading',{'username': chatInfo.threadType == 'private' || chatInfo.chatType == 'post' ? chatInfo.name : chatInfo.groupTitle}) }} <i @click.prevent="toggleModal('report', false )" class="at-guppy-removemodal laraguppy-multiply"></i></h2>
                    <p>{{$t('chatapp.report_desc')}}</p>
                </div>
                <form class="at-themeform">
                    <fieldset>
                        <div class="at-form-group-wrap">
                            <div class="at-form-group">
                                <label class="at-formtitle at-important">{{$t('chatapp.report_title')}}</label>
                                <div class="at-select at-dropdownholder">
                                    <div class="at-form-control"><span class="at-placeholder">{{reason ? reason : $t('chatapp.report_reason')}}</span></div>
                                    <ul class="at-dropdown" v-if="settings.reportingReasons">
                                        <li 
                                          v-for="(val, index) in settings.reportingReasons" 
                                          @click="reason = val" :key="index">
                                          <a href="javascript:void(0);">{{val}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="at-form-group at-explain-form">
                                <label class="at-formtitle at-important">{{$t('chatapp.issue_desc')}}</label>
                                <textarea 
                                  class="at-form-control" 
                                  v-model.trim="description" 
                                  :placeholder="$t('chatapp.add_desc')">
                                </textarea>
                            </div>
                            <div class="at-form-group">
                                <ul class="at-btnlist">
                                    <li><a href="javascript:void(0);" @click.prevent="toggleModal('report', false )" class="at-btn at-btnv2 at-guppy-removemodal">{{$t('chatapp.cancel_now')}}</a></li>
                                    <li><a  href="javascript:void(0);"  @click.prevent="reportChat()" :class="{'at-disable-btn' : isLoading }"  class="at-btn at-btn_action">{{$t('chatapp.report_submit')}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</template>