<script setup>
    import { ref } from 'vue';
    import { trans } from 'laravel-vue-i18n';
    import useMessageStore from "../../../stores/useMessageStore";
    import { debounce } from 'lodash';
    import { storeToRefs } from 'pinia'
    const messageStore = useMessageStore();
    const { replyId } = storeToRefs(messageStore);
    const { sendMessage } = messageStore;
    const props = defineProps(['threadId']);
	const threadId = props.threadId;
    const mediaRecorder = ref(null);
    const isClassActive = ref(false);
    const notifyMsg = ref(trans('chatapp.recording_start'));
    const chunks = ref([]);
    const position = ref('-34px');
    const toggleVoiceRec = () => {
        isClassActive.value = true;
        if(mediaRecorder.value?.state == 'recording'){
            stopRecording();
        } else {
            voiceRecord();
        }
        debounceClassChange();
    }

    const debounceClassChange = debounce(() => {
        isClassActive.value = false;
    }, 2000);

    const stopRecording = () => {
        mediaRecorder.value.stop();
        notifyMsg.value = trans('chatapp.recording_stopped');
        position.value = "-34px";
    }
    const voiceRecord = () => {
        if (navigator.mediaDevices.getUserMedia) {
            const constraints = { audio: true };
            navigator.mediaDevices.getUserMedia(constraints).then( onSuccess, onError);
        } else {
            position.value = "-329px";
            notifyMsg.value = trans('chatapp.mic_connection_desc');
        }
    }

    const onSuccess = (stream) => {
        position.value = "-10px";
        notifyMsg.value = trans('chatapp.recording_start');
        mediaRecorder.value = new MediaRecorder(stream);
        mediaRecorder.value.start();
        mediaRecorder.value.onstop = function() {
        var blobData      = new Blob( chunks.value);
            blobData      = blobData.slice(0, -1, "audio/aac");
            blobData.name = "voiceNote"+Math.floor(Math.random() * 99999)+".aac";
        var reader        = new FileReader();
            reader.addEventListener("load",() => {
                const newFile = new File([reader.result], blobData.name,blobData);
                let formData = new FormData();
                    formData.append('threadId', threadId);
                    formData.append('replyId', replyId.value(threadId));
                    formData.append('messageType', 'voice');
                    formData.append('media[]', newFile);
                    formData.append("timeStamp" , new Date().getTime());
                    formData.append("isSender" , true);
                    sendMessage( formData, 'multipart/form-data' );
            }, false );
            reader.readAsArrayBuffer(blobData);
            chunks.value = [];         
        }


        mediaRecorder.value.ondataavailable = function(e) {
          chunks.value.push(e.data);
        }
    }

    const onError = (err) =>{
        console.warn('The following warning occured: ' + err);
        notifyMsg.value = trans('chatapp.mic_connection_desc');
        position.value = '-329px';
        debounceClassChange();
    }
</script>
<template>
        <div @click.prevent="toggleVoiceRec" :class="[{'at-startrecording' : mediaRecorder?.state == 'recording'}, {'at-mic_notify': isClassActive}, {'at-mic_disconnect' : position == '-329px'}]" class="at-replay_audio record">
            <h6>{{notifyMsg}} <i class="laraguppy-mic"></i></h6>
            <a href="javascript:void(0);"><i class="laraguppy-mic"></i></a>
        </div>
</template>
<style lang="scss" scoped>
.at-replay_audio{
    h6{
        gap: 5px;
        top: -65px;
        display: flex;
        @extend%border;
        font-size: 15px;
        font-weight:400;
        padding: 5px 10px;
        position: absolute;
        @extend%transition;
        white-space: nowrap;
        align-items: center;
        background: $bg-color;
        border-radius:$radius;
        transform: translateX(200%);
        box-shadow: 0 0.8px 16px rgba(0,0,0,.15);
    }
    a::after {
        top: 50%;
        left: 50%;
        opacity: 0;
        content: "";
        width: 30px;
        height: 30px;
        position: absolute;
        visibility: hidden;
        border-radius: 50px;
        margin: -15px 0 0 -15px;
        background: hsla(0,0%,100%,.7);
        animation: startrecord 1s linear infinite;
    }
}
.at-mic_disconnect h6 i:before {content: "\e9a0";}
.at-mic_notify.at-replay_audio{
    h6{transform: translateX( v-bind(position));}
}
.at-chat991{
	.at-mic_notify.at-replay_audio h6{
		transform: translateX(-80%);
	}
}
.at-startrecording a:after {
    opacity: 1;
    visibility: visible;
}
.at-replay_audio.at-startrecording a{
    color: #fff;
    border-color: $theme-color;
    background-color: $theme-color;
}
@keyframes startrecord {
    0% {opacity: 1}
    to {
        transform: scale(1.5);
        opacity: 0
    }
}
// .at-chat420{
//     .at-replay_audio > a{
//         border: 0;
//         width: auto;
//         font-size: 22px;
//         &:hover{background-color: transparent;}
//     }
//     .at-replay_audio.at-startrecording a,
//     .at-replay_audio:focus a{
//         color: #999;
//         border-color: transparent;
//         background-color: transparent;
//     }
// }
.lg-rtl .at-mic_notify.at-replay_audio h6 {
    transform: translateX(200%) ;
}
.lg-rtl  .at-replay_audio h6 {
    transform: translateX(-200%) ;
}
.at-chat640  .at-replay_audio h6 {
    transform: translateX(-50%) ;
}
.at-chat640 .lg-rtl .at-mic_notify.at-replay_audio h6 {
    transform: translateX(50%) ;
}

</style>