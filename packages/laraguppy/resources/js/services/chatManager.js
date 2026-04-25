import {nextTick} from "vue";
import useSettingsStore from "../stores/useSettingsStore";
import { storeToRefs } from "pinia";
import notificationBell from "../assets/media/notification-bell.wav";
export default class ChatManager {
    static scrollList({ behavior = null, threadId, scrollHeight = 0 }) {
        nextTick(() => {
            let containerId = document.getElementById('message-wrap_' + threadId);
            
            if(containerId){
                if(scrollHeight !== 0 || !behavior){
                    if (containerId) {
                        containerId.scrollTop = (containerId.scrollHeight+100) - scrollHeight;
                    }
                } else {
                    const lastMessage = containerId.lastElementChild;
                    if (lastMessage) {
                        lastMessage.scrollIntoView({ behavior: behavior ?? 'smooth', block: 'end' });
                    }
                }
            }
        });
    }

    static downloadFile( file, fileName){
        var a = document.createElement('a');
        a.href = file;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
    
    static playNotificationBell(){
        let settingsStore = useSettingsStore();
        let { settings } = storeToRefs(settingsStore);
        let bellSrc = settings.value.notificationBellUrl?.length ? settings.value.notificationBellUrl : notificationBell;
        if( bellSrc ){
            var audio = document.createElement("audio");
            audio.autoplay = true;
            audio.load()
            audio.addEventListener("load", ()=> { audio.play(); }, true);
            audio.src = bellSrc;
        }
    }
}
