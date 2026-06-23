<script setup>
    import {ref, defineAsyncComponent, onMounted, computed} from 'vue';
    import { storeToRefs } from 'pinia';
    import { Cropper } from 'vue-advanced-cropper';
    import 'vue-advanced-cropper/dist/style.css';
    import Avatar  from "../../../assets/images/avatar.png"
    import useProfileStore from "../../../stores/useProfileStore";
    import useSettingsStore from "../../../stores/useSettingsStore";
    import RestApiManager from '../../../services/restApiManager';
    const profileStore = useProfileStore();
    const settingsStore = useSettingsStore();
    const { setNotication } = profileStore;
    import useEventsBus from "../../../services/useEventBus";
    const {
        isMuted,
        profileInfo, 
        accountNotification 
    } = storeToRefs(profileStore)
    const { settings } = storeToRefs(settingsStore)
    const isOpenModel = ref(false);
    const isUpdating = ref(false);
    const fileUrl = ref('');
    const imgCropper = ref(null);
    const resultImg = ref(null);
    const imgFile = ref(null);
    const errorBag = ref(null);
    const isloading = ref(false);
    const isOpen = ref(false);
    const { on } = useEventsBus();
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const { updateProfileInfo } = profileStore;

    const userData = ref({
        'name': '',
        'email': '',
        'photo':'',
        'phone': '',
        'userId': '',
    });

    const uploadImage = ( event ) => {
        const { files } = event.target;
        if( files && files[0] ){
            let file = files[0]
            if (file) {
                URL.revokeObjectURL(file)
            }
            fileUrl.value     = URL.createObjectURL(file);
            isOpenModel.value = true;
        }
        event.target.value = '';
    }

    const updateInfo = async () => {
        const { name, email, phone, userId } = userData.value;
        let formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone ?? '');
        formData.append('userId', userId);
        if( imgFile.value ){
            formData.append('photo', imgFile.value);
        }
        isloading.value = true;
        let response = await updateProfileInfo(formData);
        isloading.value = false;

        if( response.type == 'error' ){
            errorBag.value = response.errors;
        }

        imgFile.value = '';
    }

    on('openSettings', (payload) => {
		isOpen.value = true;
	});

    onMounted(() => {
        if( profileInfo.value?.name ) {
            userData.value = JSON.parse(JSON.stringify(profileInfo.value));
        }
    });

    const croppedImage = () => {
        const { canvas } = imgCropper.value.getResult();
        if (canvas) {
            canvas.toBlob(blob => {
                let currentDate     = new Date();
                let timeStamp       = currentDate.getTime();
                imgFile.value       = new File([blob], `profile_${timeStamp}.jpg`, { lastModified: timeStamp } );                   
                resultImg.value     = URL.createObjectURL(blob);
            }, 'image/jpeg');
        }
        isOpenModel.value = false;
    }

    const removeImage = () =>{
        userData.value.photo = imgFile.value = resultImg.value = '';
    }

    const hasError = (value) => {
        return errorBag.value?.[value] ?? false;
    };

    const logout = async (e) => {
        e.preventDefault()
        document.getElementById('logout-form').submit();
    }

    const setNotification = async () => {
        isUpdating.value = true;
        let status = accountNotification.value == 'unmute_notifications' ? 'mute_notifications' : 'unmute_notifications'
        let response = await RestApiManager.postRecord('account-notifications',{action: status});
        isUpdating.value = false;
        if( response.type === 'success' ) {
            setNotication(response.data)
        }
    }

    const toggleSideBar = () => {
        isOpen.value = false;
    }

    const redirectUrl = computed(()=>{
        return settings.redirectUrl ? settings.redirectUrl : '/'
    });
    
</script>
<template>
    <div id="setting" class="at-usersetting" :class="{'at-usersetting_open': isOpen}">
        <div class="at-profile_setting">
            <div class="at-profile_setting_close">
                <a href="javascript:void(0);" @click.prevent="toggleSideBar"><i class="laraguppy-multiply"></i> </a>
            </div>
            <form enctype="multipart/form-data" class="at-themeform">
                <fieldset>
                    <div class="at-form-group">
                        <div class="at-upload_box">
                            <div class="at-viewuploadimg">
                                <img v-if="resultImg" :src="resultImg" :alt="profileInfo.name" class="mCS_img_loaded">
                                <img v-else :src="userData.photo ? userData.photo : ( settings.defaultAvatar ? settings.defaultAvatar : Avatar)" :alt="profileInfo.name" class="mCS_img_loaded">
                                <div class="at-uploadarea">
                                    <div class="at-btnareasetting">
                                        <label for="dropbox" class="at-uploadbtn"> <i class="laraguppy-edit"></i> </label>
                                        <button @click.prevent="removeImage()" v-if="userData.photo || resultImg" class="at-btnplain"> <span class="laraguppy-trash"></span></button>
                                    </div>
                                </div>
                            </div>
                            <input @change="uploadImage" type="file" accept=".jpg,.png,.jpeg,.gif" id="dropbox" name="dropbox">
                        </div>
                        <div class="at-profile_name">
                            <h3>{{profileInfo.name}}</h3>
                        </div>
                    </div>
                    <div class="at-chat_sidebarsettingtitle at-form-group"><h2>{{$t('chatapp.profile_settings')}}</h2></div>
                    <div class="at-form-group-wrap">
                        <div class="at-form-group" :class="{ 'at-invalid' : hasError('name') }">
                            <label class="at-formtitle at-important">{{$t('chatapp.full_name')}}</label>
                            <input type="text" v-model="userData.name" :placeholder="$t('chatapp.your_name')" class="at-form-control">
                            <span class="at-error-info" v-if="hasError('name')">{{hasError('name')}}</span>
                        </div>
                        <div class="at-form-group" :class="{ 'at-invalid' : hasError('email') }">
                            <label class="at-formtitle at-important">{{$t('chatapp.email')}}</label>
                            <input type="email" v-model="userData.email" :placeholder="$t('chatapp.your_email')" class="at-form-control">
                            <span class="at-error-info" v-if="hasError('email')">{{errorBag.email}}</span>
                        </div>
                        <div class="at-form-group" :class="{ 'at-invalid' : hasError('phone') }">
                            <label class="at-formtitle">{{$t('chatapp.phone')}}</label>
                            <input type="text" v-model="userData.phone" :placeholder="$t('chatapp.your_phone')" class="at-form-control">
                            <span class="at-error-info" v-if="hasError('phone')">{{errorBag.phone}}</span>
                        </div>
                        <div class="at-settingbtns at-form-group">
                            <label class="at-formtitle">{{$t('chatapp.mute_alert')}}</label>
                            <!-- <div class="at-rightswitcharea at-mute" @click.prevent="setNotification()"> -->
                            <div class="at-rightswitcharea" :class="{'at-mute': isMuted}">
                                <i class="laraguppy-volume"></i>
                                <span>{{ $t('chatapp.mute') }}</span>
                                <div class="at-togglebtn">
                                    <input type="checkbox" id="switch" @change="setNotification" :checked="isMuted"/>
                                    <label for="switch"></label>
                                </div>
                            </div>
                        </div>
                        <div class="at-form-group">
                            <button class="at-btn at-btn-block" :class="{'at-disabled' : isloading}" @click.prevent="updateInfo"> 
                                <span v-if="isloading" class="at-msgload"><i class="at-spinericon"></i></span>
                                {{$t('chatapp.save_changes')}} 
                            </button>
                        </div>
                    </div>
                </fieldset>
            </form>
            <form id="logout-form" action="logout" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="csrf">
            </form>
            <div class="at-logout">
                <a :href="redirectUrl">
                    <i class="laraguppy-arrow-turn-left"></i>
                    <span>{{$t('chatapp.back')}}</span>
                </a>
                <a href="javascript:void(0);" @click.prevent="logout">
                    <i class="laraguppy-exit"></i>
                    <span>{{$t('chatapp.logout')}}</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Crop Profile image popup -->
    <div id="image_crop" class="at-modal at-cropping-popup" :class="{'at-modalopen at-fadin' : isOpenModel}">
        <div class="at-modaldialog"> 
            <div class="at-alert">
                <cropper ref="imgCropper" class="cropper" :src="fileUrl" default-boundaries="fill" minWidth="300" minHeight="300"/>
                <div class="at-form-group">
                    <ul class="at-btnlist">
                        <li><a href="javascript:void(0);" @click.prevent="croppedImage()" class="at-btn">{{$t('chatapp.crop')}}</a></li>
                        <li><a href="javascript:void(0);" id="cancel_croping" @click.prevent="() => isOpenModel = false" class="at-btn at-btnv2">{{$t('chatapp.cancel')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss">
.at-usersetting{
    z-index: 10;
    height: 100%;
    position: absolute;
    @extend %transition;
    width: calc(100% + 1px);
    background-color: #fff;
    transform: translate(-150%, 0);
    border-radius: 0 20px 20px 0;
    box-shadow: 0px 24px 48px -12px rgba(16, 24, 40, 0.18);
    &_open{
        transform: translate(0, 0);
    }
}
.at-cropping-popup{
    & .at-modaldialog {max-width: 700px;}
    .at-btnlist li{
        width: 50%;
    }
}
.cropper{
    width: 100%;
    height:460px;
    overflow: hidden;
    border-radius: $radius;
    background-color: #000;
    .vue-advanced-cropper__image{object-fit: contain;}
}
.at-profile{
    &_setting{
        width: 100%;
        height: 100%;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        .at-themeform{
            padding: 20px;
            overflow: hidden;
            overflow-y: auto;
            height: calc(100vh - 185px);
            &::-webkit-scrollbar-track {
                width: 5px;
                opacity: 0;
                visibility: hidden;
                background-color: transparent;
            }
            &::-webkit-scrollbar {
                margin: 0;
                width: 5px;
                opacity: 0;
                visibility: hidden;
                background: transparent;
            }
            &::-webkit-scrollbar-thumb {
                margin: 0;
                width: 5px;
                opacity: 0;
                height: 25px;
                visibility: hidden;
                border-radius: 60px;
                background-color: $theme-color;
            }
            &:hover {
                &::-webkit-scrollbar-thumb {
                    opacity: 1;
                    visibility: visible;
                }
            }
        }
        .at-btn{
            width: auto;
            height: auto;
            min-width: auto;
            padding: 8px 18px;
            font: 600 rem(14)/em(20,14) $body-font-family;
        }
        &_close{
            width: 100%;
            display: flex;
            padding: 20px 20px 0;
            justify-content: flex-end;
            a{
                display: block;
                color: #585858;
                font-size: rem(28);
                line-height: em(28,28);
                i{display: block;}
            }
        }
    }
    &_name{
        text-align: center;
        margin-top: 10px;
        h3{
            margin: 0;
            font: 500 rem(16)/em(24,16) $body-font-family;
        }
    }
}
.at-chat_sidebarsettingtitle{
    width: auto !important;
    margin: 12px -20px 0;
    padding: 20px 28px 8px !important;
    border-top: 1px solid #EAEAEA;
    h2{
        margin: 0;
        color: #000;
        font-size: 16px;
        font-weight: 500;
        line-height: 24px;
    }
}
.at-invalid{
    input{border-color: #F04438;}
}
.at-error-info{
    display: block;
    margin: 4px 0 0;
    color: #F04438;
    font: 400 rem(12)/em(18,12) $body-font-family;
}
.at-logout{
    flex: auto;
    padding: 8px;
    margin: auto 0 0;
    border-top: 1px solid #EAEAEA;
    a{
        gap: 10px;
        padding: 8px;
        display: flex;
        cursor: pointer;
        color: #585858;
        align-items: center;
        @extend %transition;
        border-radius: $radius;
        font: 500 rem(14)/em(20,14) $body-font-family;
        &:hover{
            background-color: #F7F7F8;
        }
        i{
            display: block;
            font-size: 24px;
        }
    }

}
.at-form-group .at-upload_box {
    display: flex;
    align-items: center;
    justify-content: center;
    input{display: none;}
    svg {
        top: 0;
        left: 0;
        right: 0;
        z-index: -1;
        width: 100%;
        height: 100%;
        margin: auto;
        padding: 0 1px;
        stroke: #ddd;
        fill: transparent;
        overflow: visible;
        position: absolute;
        rect{
            rx: 10px;
            stroke-width: 1px;
            stroke-dasharray: 10,10;
        }
    }
}
.at-viewuploadimg {
    display: flex;
    position: relative;
    align-items: center;
    justify-content: center;
    &:hover{
        .at-btnplain{
            transform: scale(1);
        }
    }
    .at-btnareasetting{
        gap: 10px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        .at-btn.at-btnsm {
            margin: 0;
            height: 32px;
            cursor: copy;
            color: #fff;
            padding: 0 5px;
            font-size: 12px;
            min-width: 115px;
            font-weight: 700;
            max-width: 180px;
            line-height: 20px;
            font: 500 14px/24px;
            letter-spacing: .5px;
            background: #22c55e;
        }
    } 
    .at-btnplain {
        top: 0;
        left: 0;
        padding: 0;
        z-index: 0;
        width: 100%;
        height: 100%;
        display: flex;
        cursor: pointer;
        border-radius: 50%;
        position: absolute;
        @extend %transition;
        align-items: center;
        transform: scale(0);
        justify-content: center;
        color: #ef4444!important;
        background: rgba(0, 0, 0, 0.5);
    }
    img {
        padding: 2px;
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        background-color: #EAEAEA;
    }
}
.at-chat480 .at-form-group{
    .at-upload_box{
        .at-btnareasetting{
            align-items: flex-start;
            flex-direction: column;
        }
    }
}
.at-chat_profile{
    button{
        gap: 8px;
        & .at-spinericon{
            width: 18px;
            height: 18px;
        }
    }
}
.at-chat1700{
    .at-form-group .at-upload_box{
        & .at-viewuploadimg{
            flex-direction: column;
        }
    }
}
.at-chat1199{
    .at-form-group .at-upload_box{
        & .at-viewuploadimg{
            flex-direction: column;
        }
    }
}
.at-chat1080{
    .at-chat_sidebar{
        max-width: 100%;
    }
    .at-form-group .at-upload_box{
        & .at-viewuploadimg{
            flex-direction: column;
        }
    }
}
</style>
<style lang="scss" >
.at-settingbtns{
    .at-formtitle{
        color: #000;
        margin: 0 0 16px;
        font: 500 rem(16)/em(24,16) $body-font-family;
    }
}
.at-uploadbtn{
    right: 0;
    bottom: 0;
    margin: 0;
    width: 20px;
    height: 20px;
    z-index: 9;
    cursor: pointer;
    font-size: 14px;
    color: #585858;
    position: absolute;
    display: flex;
    background: #FFF;
    align-items: center;
    border-radius: 100px;
    justify-content: center;
    box-shadow: 0px 1px 2px 0px rgba(16, 24, 40, 0.05);
}
</style>