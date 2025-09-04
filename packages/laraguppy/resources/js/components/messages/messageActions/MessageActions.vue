<script setup>
    import { ref, onMounted, onBeforeUnmount } from "vue";
    import { storeToRefs } from "pinia";
    import useSettingsStore from "../../../stores/useSettingsStore";
    import useMessageStore from "../../../stores/useMessageStore";
    import ChatManager from "../../../services/chatManager";

    const settingsStore = useSettingsStore();
    const messageStore = useMessageStore();
    const props = defineProps(['message', 'isDownload']);
    const { message, isDownload } = props;
    const { threadId, messageId } = message;
    const { 
      downloadAttachments, 
      updateReplyMsgId, 
      deleteMessage 
    } = messageStore;
    const { settings } = storeToRefs(settingsStore);
    const isDownloading = ref(false);
    const isDeleting = ref(false);

    const replyMsg = () => {
      jQuery('.at-messageoption').removeClass("at-messageoption_open");
      updateReplyMsgId( threadId, messageId);
    }

    const deleteMsg = async () => {
      isDeleting.value = true;
        await deleteMessage(messageId, threadId);
      isDeleting.value = false;
      jQuery('.at-messageoption').removeClass("at-messageoption_open");
    }

    const downloadMedia = async () => {
      jQuery('.at-messageoption').removeClass("at-messageoption_open");
        isDownloading.value = true; 
        if( message.attachments?.length && message.attachments?.length == 1 ){
          ChatManager.downloadFile(message.attachments[0].file, message.attachments[0].fileName);
        } else if(message.attachments?.length && message.attachments?.length > 1){
          downloadAttachments(message.messageId);
        }
        isDownloading.value = false; 
    }

</script>
<template>
    <div class="at-messageoption" >
    <a href="javascript:void(0);" class="at-messageoption_btn" ><i class="laraguppy-ellipsis-horizontal"></i></a>
    <ul class="at-messageoption_list">
        <li v-if="isDownload">
            <a href="javascript:void(0);" 
                :class="{'at-disable-btn': isDownloading }" 
                @click.prevent="downloadMedia()">
                <i v-if="!isDownloading" class="laraguppy-download"></i>{{$t('chatapp.download')}}
            </a>
      </li>
      <li>
        <a href="javascript:void(0);" @click="replyMsg()">
            <i class="laraguppy-chat-reply"></i>
            {{$t('chatapp.reply_message')}}
        </a>
      </li>
      <!-- for group message -->
      <template v-if="message.threadType == 'group'">
        <li v-if="message.isSender && disableDeleteMessage && settings && settings.deleteMessage" 
          @click.prevent="deleteMsg()">
          <a href="javascript:void(0);111" 
            :class="{'at-disable-btn': isDeleting }">
            <span class="at-msgload"><i class="at-spinericon"></i></span>
            <i v-if="!isDeleting" class="laraguppy-trash"></i>{{$t('chatapp.delete')}}
          </a>
        </li>
        
      </template>
      <!-- for private chat -->
      <template v-else>
        <li v-if="(message.isSender && !message.seenAt) && ( settings && settings.deleteMessage)" 
          @click.prevent="deleteMsg()">
          <a href="javascript:void(0);" 
            :class="{'at-disable-btn': isDeleting }">
            <span v-if="isDeleting" class="at-msgload"><i class="at-spinericon"></i></span>
            <i v-else class="laraguppy-trash"></i>
            {{$t('chatapp.delete')}}
          </a>
        </li>
      </template>
      
    </ul>
  </div>
</template>