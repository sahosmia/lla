<script setup>
    import { ref, onMounted } from "vue";
    import useSettingsStore from "../../../stores/useSettingsStore";
    import useMessageStore from "../../../stores/useMessageStore";
    import { storeToRefs } from "pinia"
    const props = defineProps(['threadId']);
	const threadId = props.threadId;
    const settingStore = useSettingsStore();
    const { settings } = storeToRefs(settingStore);
    const atReplayUpload = ref(null);
    const messageStore = useMessageStore();
    const { replyId } = storeToRefs(messageStore);
    const { sendMessage } = messageStore;

    onMounted(() => {
      atReplayUpload.value = document.querySelector('.at-replay_upload');
      document.body.addEventListener('click', handleClickOutside);
    });

    const handleClickOutside = (e) => {
      if (atReplayUpload.value && !atReplayUpload.value.contains(e.target)) {
        atReplayUpload.value.classList.remove('at-uploadoption_open');
      }
    };

    const toogleMenu = () => {
        atReplayUpload.value.classList.toggle('at-uploadoption_open');
    }

    const fileUpload = (e, type) => {
        let formData    = new FormData();
        let files       = e.target.files;
        let setting     = settings.value;
        if(files.length > Number(setting.maxFileUploads)){
            alert('file upload limit error');
            e.target.value = '';
            return ;
        }

        for ( let [key, file] of Object.entries( files ) ) {
            let fileExt =  file.name.split('.').pop();
                fileExt = fileExt ? fileExt.toLowerCase() : '';
            let allowFileSize = setting[type+'Size']*1024;
            let fileSize = file.size;

            if( setting[type+'Ext'].includes('.'+fileExt) && fileSize <= allowFileSize){
                formData.append('media[]', file);
            } else {
                alert('invalid_input_file');
                e.target.value = '';
                return;
            }
        }
        formData.append("timeStamp" , new Date().getTime());
        formData.append('replyId', replyId.value(threadId));
        formData.append('threadId', threadId);
        formData.append('messageType', type);
        formData.append("isSender" , true);
        sendMessage(formData, 'multipart/form-data');
        toogleMenu();
        e.target.value = '';
    }

    const sendLocation = () => {
        if( navigator.geolocation ) {
            navigator.geolocation.getCurrentPosition((position) => {
                let currentDate = new Date();
                let timestamp   = currentDate.getTime();
                let formData    = new FormData();
                formData.append('threadId',     threadId);
                formData.append('messageType', 'location');
                formData.append('latitude',     position.coords.latitude);
                formData.append('longitude',    position.coords.longitude);
                formData.append("timeStamp" , timestamp);
                formData.append("isSender" , true);
                sendMessage(formData);
            }, 
            (error) => {
                console.error(error.message);
            });
        } else {
            alert('geolocation_error_txt')
        }
        toogleMenu();
    }
</script>
<template>
    <div class="at-replay_upload">
        <ul class="at-uploadoption">
            <li>
                <input type="file" id="videoupload" :accept="settings?.videoExt.join(',')" @change="fileUpload($event, 'video')">
                <label for="videoupload"><i class="laraguppy-video"></i><span> {{$t('chatapp.video')}}<svg data-v-d3ab8c73="" xmlns="http://www.w3.org/2000/svg" width="14" height="5" viewBox="0 0 14 5" fill="none"><path data-v-d3ab8c73="" d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span></label>
            </li>
            <li>
                <input type="file" id="audioupload" :accept="settings?.audioExt.join(',')" @change="fileUpload($event, 'audio')">
                <label for="audioupload"><i class="laraguppy-music-02"></i><span>{{$t('chatapp.audio')}}<svg data-v-d3ab8c73="" xmlns="http://www.w3.org/2000/svg" width="14" height="5" viewBox="0 0 14 5" fill="none"><path data-v-d3ab8c73="" d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span></label>
            </li>
            <li>
                <input type="file" id="photoupload" multiple="multiple" :accept="settings?.imageExt.join(',')" @change="fileUpload($event, 'image')">
                <label for="photoupload"><i class="laraguppy-image"></i><span>{{$t('chatapp.photo')}}<svg data-v-d3ab8c73="" xmlns="http://www.w3.org/2000/svg" width="14" height="5" viewBox="0 0 14 5" fill="none"><path data-v-d3ab8c73="" d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span></label>
            </li>
            <li>
                <input type="file" id="fileupload" :accept="settings?.documentExt.join(',')" @change="fileUpload($event, 'document')">
                <label for="fileupload"><i class="laraguppy-file-01"></i><span>{{$t('chatapp.document')}}<svg data-v-d3ab8c73="" xmlns="http://www.w3.org/2000/svg" width="14" height="5" viewBox="0 0 14 5" fill="none"><path data-v-d3ab8c73="" d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span></label>
            </li>
            <li><a href="javascript:void(0);" @click.prevent="sendLocation"><i class="laraguppy-location"></i><span>{{$t('chatapp.location')}}<svg data-v-d3ab8c73="" xmlns="http://www.w3.org/2000/svg" width="14" height="5" viewBox="0 0 14 5" fill="none"><path data-v-d3ab8c73="" d="M4.5423 4.17642C5.73661 5.27452 8.26339 5.27453 9.4577 4.17642L14 0H0L4.5423 4.17642Z" fill="#070611"></path></svg></span></a></li>
        </ul>
    </div>
</template>
<style lang="scss">
.at-uploadoption{
    gap: 3px;
    margin: 0;
    padding: 0;
    display: flex;
    list-style: none;
	li{
        line-height: inherit;
        list-style-type: none;
    }
    input[type="file"]{display: none;}
    a, label{
        margin: 0;
        width: 36px;
        height: 36px;
        display: flex;
        cursor: pointer;
        font-weight: 500;
        align-items:center;
        @extend %transition;
        justify-content: center;
        position: relative;
        border-radius: $radius;
        color: rgba($color: #585858, $alpha: 0.7);
        &:hover{
            color: #585858;
            background-color: #F7F7F8;
            span{
                opacity: 1;
                visibility: visible;
            }
        }
        span{
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
            @extend %transition;
            border-radius: 10px;
            background: #070611;
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
        i{
            width: auto;
            font-size: rem(24);
            text-align: center;
            line-height: em(24,24);
            display: block;
        }
    }
}
.at-chat420{
     .at-replay_upload > a{
        border: 0;
        width: auto;
        font-size: 22px;
        &:hover{background-color: transparent;}
    }
    .at-uploadoption{
        gap: 0;
        a,
        label{
            width: 32px;
            height: 32px;
            i{
                font-size: rem(18);
                line-height: em(18,18);
            }
        }
    }
}
</style>