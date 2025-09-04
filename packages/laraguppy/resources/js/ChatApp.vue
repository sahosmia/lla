<script setup>
    import { ref, onMounted, onBeforeMount, watch, defineAsyncComponent} from "vue";
    import useProfileStore from "./stores/useProfileStore";
    import useSettingsStore from "./stores/useSettingsStore";
    import useTabStore from "./stores/useTabStore";
    import { storeToRefs } from "pinia";
    import Sidebar from './components/sidebar/Sidebar.vue';
    import Container from "./components/messages/messagesContainer/Container.vue";
    const AlertModals  = defineAsyncComponent(()=> import('./components/alertModals/AlertModals.vue'));

    const tabStore = useTabStore();
    const settingsStore = useSettingsStore()
    const profileStore = useProfileStore();
    const { getUnreadCounts, updateActiveThread } = tabStore;
    const { getProfileInfo } = profileStore;
    const { settings } = storeToRefs(settingsStore);
    const { getChatSettings, updateWindowWidth } = settingsStore;
    const windowWidth = ref(null);

    watch(windowWidth, () => {
        guppyAddClass();
    });

    onBeforeMount( async () => {
        getChatSettings();
        getProfileInfo();
        getUnreadCounts()
    });

    const guppyAddClass = () => {
        const width         = jQuery('.at-chat').width();
        const isRtlTrue     = settings?.isRtl ? 'wpguppy-rtl' : '';
        let customClass = '';

        const breakPoints = [
            { maxWidth : 420,   className: 'at-chat420 at-chat480 at-chat575 at-chat640 at-chat991' },
            { maxWidth : 480,   className: 'at-chat480 at-chat575 at-chat640 at-chat991' },
            { maxWidth : 575,   className: 'at-chat575 at-chat640 at-chat991' },
            { maxWidth : 640,   className: 'at-chat640 at-chat991' },
            { maxWidth : 991,   className: 'at-chat991'  },
            { maxWidth : 1080,  className: 'at-chat1080' },
            { maxWidth : 1199,  className: 'at-chat1199' },
            { maxWidth : 1440,  className: 'at-chat1440' },
            { maxWidth : 1700,  className: 'at-chat1700' },
        ];

        for (const breakpoint of breakPoints) {
            if (width <= breakpoint.maxWidth) {
                customClass += ` ${breakpoint.className}`;
                jQuery('.at-chat').attr('class', `at-user-chat at-chat ${customClass} at-messanger-chat`);
                break;
            }
        }

        if (width <= 991) {
            jQuery(document).on('click', '.at-onlineusers .at-userbar, .conversation-list .at-userbar, .at-btn-respond', function() {
                jQuery('.at-chat').addClass('at-opnchatbox');
            });

            jQuery(document).on('click', '.at-backtolist', function() {
                jQuery('.at-chat').removeClass('at-opnchatbox');
            });
        }

        jQuery(document).on('click', '.at-messanger-chat ul.at-chat_sidebar_footer li', function() {
            jQuery('ul.at-chat_sidebar_footer').css('width', '70px');
        });

        jQuery('.at-chat').addClass(isRtlTrue);
    }

    const setActiveThread = () => {
        let uri       = window.location.search.substring(1);
        let params    = new URLSearchParams(uri);
        let threadId    = params.get("thread_id");
        if(threadId?.length){
            updateActiveThread(threadId)
        }
    }

    onMounted(()=>{
        setActiveThread();
        window.addEventListener("resize", ()=>{
            windowWidth.value = jQuery('.at-chat').width();
            updateWindowWidth( windowWidth.value );
        });

        updateWindowWidth( jQuery('.at-chat').width() );
        guppyAddClass();

        // for message action dropdown menu
        jQuery(document).on("click", ".at-messageoption_btn", function (e) {
            jQuery(this).parent('.at-messageoption').toggleClass("at-messageoption_open");
        });

        jQuery(document).on('click','body',function(e) {
            jQuery('.at-messageoption').not(jQuery('.at-messageoption').has(e.target)).removeClass("at-messageoption_open");
            jQuery('.at-chat_messages').not(jQuery('.at-chat_sidebarsetting').has(e.target)).removeClass("at-chat_messagesslide");
        });
    })

</script>
<template>
    <div class="at-chat">
        <Sidebar />
        <Container />
        <AlertModals />
    </div>
</template>
   <style lang="scss" >
   .wpguppy-chat-app{@extend%transition;}
    .tk-themesidebar {
        & + .wpguppy-chat-app{
            padding-left: 300px;
        }
        &.tk-menufold + .wpguppy-chat-app{
            padding-left: 80px;
        }
    }
   body{
        color: $primary-color;
        font: 400 rem(14)/em(26,14) $body-font-family;
    }
    h1{font: 700 rem(36)/em(42,36) $heading-font-family;}
    h2{font: 700 rem(28)/em(36,28) $heading-font-family;}
    h3{font: 700 rem(24)/em(32,24) $heading-font-family;}
    h4{font: 700 rem(18)/em(26,18) $heading-font-family;}
    h5{font: 700 rem(16)/em(24,16) $heading-font-family;}
    h6{font: 700 rem(14)/em(22,14) $heading-font-family;}
    h1,h2,h3,h4,h5,h6{color: $primary-color;}h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color: $primary-color; }

    .at-messagewrap{
        display: flex;
        outline: none;
        overflow-y: auto;
		// min-height: 280px;
		overflow-x: hidden;
        padding:10px 10px 0;
        scrollbar-width: thin;
        flex-direction: column;
        &::-webkit-scrollbar-track{
            width: 5px;
            opacity: 0;
            visibility: hidden;
            background-color: transparent;
        }
        &::-webkit-scrollbar{
            margin: 0;
            width: 5px;
            opacity: 0;
            visibility: hidden;
            background: transparent;
        }
        &::-webkit-scrollbar-thumb{
            margin: 0;
            width: 5px;
            opacity: 0;
            height: 25px;
            visibility: hidden;
            border-radius: 60px;
            background-color:$theme-color;
        }
        &:hover{
        &::-webkit-scrollbar-thumb{
            opacity: 1;
            visibility: visible;
            }
        }
}
.at-idle-btn{pointer-events: none;}
.at-placeholder{color: $text-color;}
.at-insidearrow{padding-right: 39px;}
.at-chat_sidebarsettingarea{height: calc(100vh - 214px);}
.at-chat_sidebarsettingcontent{
    padding: 20px;
    h4{
        color: #000;
        font: 500 rem(16)/em(24,16) $heading-font-family;
        margin: 0 0 16px;
    }
    > a{
        gap: 5px;
        display: flex;
        min-height: 40px;
        color: #585858;
        padding: 7px 12px;
        align-items: center;
        border-radius: 10px;
        background: #F7F7F8;
        font: 500 rem(14)/em(20,14) $heading-font-family;
        &:hover{
            color: #585858;
        }
        & + a{
            margin-top: 16px;
        }
        i{
            font-size: 16px;
            &.laraguppy-alert{
                font-size: 20px;
            }
            &.laraguppy-block{font-size: 18px;}
        }
    }
    &.at-p-0{
        > h4{padding: 30px 30px 10px}
    }
    .at-themeform{padding-top: 10px}
    .at-btnlist{
        margin: 0;
        li{
            padding: 0;
            width: 100%;
        }
    }
    &:last-child{padding-bottom: 0}
    .at-chat_sidebarsettingcontent.at-group_user{padding: 30px 0;}
    ~ .at-chat_sidebarsettingcontent{border-top: 1px solid rgba(#ddd,0.7);}
    .at-disable-btn{
        display: flex;
        align-items: center;
        background: transparent;
        &:before {
            content: "";
            width: 20px;
            height: 20px;
            transition: none;
            margin-right: 10px;
            border-radius: 50%;
            display: inline-flex;
            border: 3px solid #ddd;
            border-right-color: transparent;
            animation: spinericon 2s linear infinite;
        }
    }
}
@-webkit-keyframes spinericon{
	0%{
		-webkit-transform:rotate(0deg);
		transform:rotate(0deg)
	}
	to{
		-webkit-transform:rotate(1turn);
		transform:rotate(1turn)
	}
}
@keyframes spinericon{
	0%{
		-webkit-transform:rotate(0deg);
		transform:rotate(0deg)
	}
	to{
		-webkit-transform:rotate(1turn);
		transform:rotate(1turn)
	}
}
.at-userlist .at-chat_sidebarsettingtitle{width: 100%;}
.at-chat_sidebarsettingtitle{
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    > a{
        color: #585858;
        font-size: 14px;
        display: inline-flex;
    }
}
.at-msgload i{
    width: 20px;
    height: 20px;
    display: block;
    line-height: 20px;
    border: 3px solid #ddd;
    border-right-color: #f7f7f7;
    border-radius: 50px 50px 50px 50px;
    animation: spinericon 1s linear infinite;
}
.at-userstatus{
font-size: rem(14);
line-height: em(26,14);
letter-spacing: 0.01em;
display: inline-flex;
vertical-align: middle;
align-items: center;
&:before{
	margin: 0;
	width: 8px;
	content: "";
	height: 8px;
	border-radius: 50px;
	display: inline-block;
	outline: 2px solid #fff;
    }
}
.at-none,
.none{display: none !important;}
.at-btn-block{width: 100%;}
// popups styling
// croppie styling start
.vue-advanced-cropper{margin: 0 auto;}
.vue-advanced-cropper__image{
    top: 50% !important;
    left: 50% !important;
    width: 600px !important;
    height: 500px !important;
    transform: translate(-50%, -50%) !important;
}
.at-modal{
    top: 0;
    left: 0;
    outline: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
    display: none;
    overflow: hidden;
    overflow-y: auto;
    position: fixed;
    @extend %transition;
       &:before {
           top: 0;
           left: 0;
           z-index: -1;
           content: "";
           width: 100vw;
           height: 100vh;
           position: fixed;
           background-color: rgba(0,0,0,.5);
     }
     &_title{
        padding: 0 20px 20px;
        margin: 0 -20px;
        border-bottom: 1px solid #EAEAEA;
     }
}
.at-chat480{
    .at-modal{
        padding-left: 10px;
        padding-right: 10px;
    }
    .at-alert_btns{
        flex-wrap: wrap;
        .at-btn_action.at-btn, .at-btn_action,
        .at-guppy-removemodal{
            width: 100%;
        }
    }
}
.at-modaldialog{
    width: 100%;
    margin: auto;
    display: flex;
    padding: 30px;
    max-width: 460px;
    position: relative;
    align-items: center;
    @extend %transition;
    .at-alert{
        max-width: initial;
        width: 100%;
    }
}
.at-form-group .at-btnlist {
    padding: 0;
    width: auto;
    margin-top: 12px;
}
.at-fadin {opacity: 1;}
.at-fadin.at-modalopen{display: flex;}

.at-alert{
    width: 100%;
    padding: 20px;
    max-width: 400px;
    border-radius: $radius;
    background-color: #fff;
    filter: drop-shadow(0 2px 4px rgba(40,41,61,.04)) drop-shadow(0 8px 16px rgba(96,97,112,.16));
    h2{
        gap: 20px;
        display: flex;
        color: #000000;
        margin: 0 0 10px;
        align-items: center;
        font: 600 rem(16)/em(24,16) $heading-font-family;
        .at-guppy-removemodal{
            width: 24px;
            height: 24px;
            display: flex;
            font-size: 22px;
            cursor: pointer;
            color: #CDCDCD;
            margin-left: auto;
            align-items: center;
            justify-content: center;
        }
    }
    p{
        margin: 0;
        text-align: left;
        color: rgba($color: #585858, $alpha: 0.8);
        font: 400 rem(14)/em(20,14) $heading-font-family;
    }
    > .at-themeform{margin-top: 20px;}
    &_btns{
        gap: 10px;
        display: flex;
        margin-top: 20px;
        align-items: center;
        justify-content: flex-end;
        .at-guppy-removemodal{
            padding: 7px 13px;
            background: #FFF;
            border-radius: $radius;
            border: 1px solid #EAEAEA;
            font: 600 rem(14)/em(20,14) $heading-font-family;
        }
        & > a{
            > i{
                top: 15px;
                right: 15px;
                font-size: 25px;
                position: absolute;
            }
        }
    }
    .at-formtitle{text-align: left;}
}
.at-btn{
    &_action.at-btn,
    &_action{
        min-width: auto;
        padding: 8px 14px;
        background: #F04438;
        height: inherit;
        font: 600 rem(14)/em(20,14) $heading-font-family;
    }
}
// croppie styling end
.at-btnlist{
    @extend %flex;
    margin: -5px;
    justify-content: flex-end;
    li{
        padding: 5px;
        list-style: none;
    }
    .at-btn{
        width: 100%;
        height: 52px;
        min-width: auto;
    }
}

.at-chat_mutenotify{
    @extend %flex;
    align-items: center;
    input{
        display: none;
        &:checked{
            + label{
                color: $text-color;
                i{
                    color: $text-color;
                    background-color: $bg-color;
                    &::before{content: "\ea10";}
                }
            }
        }
    }
    label{
        margin: 0;
        width: 100%;
        @extend %flex;
        cursor: pointer;
        align-items: center;
        letter-spacing: 0.5px;
        color: $primary-color;
        font: 700 rem(16)/em(26,16) $heading-font-family;
        span{
            flex: auto;
            height: 48px;
            @extend %flex;
            padding-right: 20px;
            align-items: center;
        }
        i{
            flex: none;
            width: 48px;
            height: 48px;
            @extend %flex;
            color: #fff;
            font-size: 27px;
            border-radius: 3px;
            align-items: center;
            justify-content: center;
            background-color: $theme-color;
        }
    }
}
.at-dropboximg{
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
    &:hover{
        .at-btn{transform: translateY(0);}
    }
    img{
        height: 100%;
        border-radius: 10px;
    }
    .at-btn{
        left: 0;
        bottom: 0;
        width: 100%;
        min-width: initial;
        position: absolute;
        transform: translateY(100%);
        border-radius: 0 0 10px 10px;
    }
}
.at-popuptitle{
    width: 100%;
    display: flex;
    padding: 19px 30px;
    align-items: center;
    background: $primary-color;
    border-radius: 10px 10px 0px 0px;
    box-shadow: inset 0px -1px 1px rgba(255, 255, 255, 0.3);
    + *{padding: 30px;}
    h2{
        color: #fff;
        font-weight: 700;
        font-size: rem(20);
        letter-spacing: 0.5px;
        line-height: em(30,20);
    }
    > a{
        color: #fff;
        font-size: 28px;
        display: inline-flex;
        margin: 0 -4px 0 auto;
    }
}
.at-popupcontent{
    background-color: #fff;
    border-radius: 10px 10px 0px 0px;
    .at-form-control{height: 50px;}
    .at-dropbox label{max-width: 225px;}
}
.at-creategrouplist{
    width: 100%;
    max-height: 250px;
    .at-grouplist{padding-bottom: 0;}
    .at-groupuserbar{padding: 0;}
}
.at-groupuserbar_content{
    width: 100%;
    display: flex;
    cursor: pointer;
    margin-bottom: 0;
    align-items: center;
    padding: 10px 14px 10px 52px;
    .at-groupuserbar_title{
        em{
            overflow: hidden;
			white-space: nowrap;
            letter-spacing: 0.5px;
			text-overflow: ellipsis;
            font: normal 700 rem(14)/em(24,14) $heading-font-family;
        }
    }
}
.at-dropcontentholder{
    padding: 20px;
    text-align: left;
}
.at-dropboxuploader{
    @extend %flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;
}
.at-dropcontent{
    width: 100%;
    display: flex;
    flex-flow: wrap row;
    align-items: center;
    img{
        flex: none;
        margin-right: 10px;
        border-radius: 10px;
    }
    .at-removedrop{
        font-size: 20px;
        color: #EF4444;
        margin-left: auto;
    }
}
.at-droptitle{
    flex: auto;
    > span{
        display: block;
        letter-spacing: 0.5px;
        font: 500 rem(14)/em(22,14) $heading-font-family;
    }
}
.at-progressbarholder{
    height: 3px;
    margin-top: 10px;
    position: relative;
}
.at-progressbar{
    width: 100%;
    background-color: $bg-color;
}
.at-progressbar,
.at-progressbar_fill{
    top: 0;
    left: 0;
    height: 3px;
    position: absolute;
    border-radius: 60px;
}
.at-progressbar_fill{
    @extend %transition;
    background-color: $theme-color;
}
.at-send{
    width: 40px;
    height: 40px;
    @extend %flex;
    color: #fff;
    font-size: 19px;
    margin-left: 10px;
    border-radius: 20px;
    align-items: center;
    &:hover{color: #fff;}
    justify-content: center;
    background: $whatsapp-color;
}
@media (max-width:480px){
    .at-alert, .at-popuptitle + *{
        padding-left: 15px;
        padding-right: 15px;
    }
}
@media (max-width:420px){
    .at-btnlist li{width: 100%;}
}
</style>
<!--------------Global__Styling----------------->
<style lang="scss" >
//<!------------Base------------>
ul{margin-bottom: 0;}
iframe {border: none;}
button { border: none;}
ul ul{ margin-left: 20px;}
body{margin: 0 !important;}
ol ol { margin-left: 20px;}
dl dd { margin-left: 20px;}
blockquote{margin-bottom: 0;}
p ins { color: $primary-color;}
img {height: auto;max-width: 100%;}
.wp-caption.alignnone { width: 100%;}
figure {margin-bottom: 0;position:relative;}
address { font-style: italic;margin-bottom: 0;}
li {display: list-item;list-style: disc inside none;}
a,a:hover{outline: none;color: $anchor-color;text-decoration: none;}
*,*::after,*::before{margin: 0px;padding: 0px;box-sizing: border-box;}
p {margin: 0 0 20px;letter-spacing: normal;line-height: em(22px,14px);}
ol {float: none;padding-left: 15px;list-style: decimal;& li {width: 100%;list-style: decimal;}}
//<!------------------- Buttons--------------------->
.at-sendmsg{
    gap: 5px;
    color: #fff;
    display: flex;
    text-align: center;
    padding: 8px 16px;
    align-items: center;
    justify-content: center;
    border-radius: $radius;
    background-color: $theme-color;
    font: 600 rem(14)/em(20,14) $heading-font-family;
    &:hover, &:focus{color: #fff;}
    i{font-size: 18px}
}
.at-btn{
    @extend %flex;
    z-index: 0;
    height: 44px;
    color: #fff;
    padding: 0 20px;
    cursor: pointer;
    min-width: 160px;
    overflow: hidden;
    position: relative;
    align-items: center;
    @extend %transition;
    border-radius: $radius;
    letter-spacing: 0.01em;
    justify-content: center;
    background-color: $theme-color;
    font: 700 16px $heading-font-family;
    &:hover{&:before{opacity: 0.1;}}
    &:hover,&:focus{outline: none;color: #fff;}
    &[disabled]{pointer-events: none;color: $primary-color;background-color: #ddd;}
    &:before{display: none !important}
}
.at-btn-respond,
.at-btn-resend,
.at-btn-blocked,
.at-btn-sm{
    @extend %flex;
    margin: 3px 0;
    color: #fff;
    padding: 7px 12px;
    min-width: 80px;
    position: relative;
    @extend %transition;
    align-items: center;
    background: #22C55E;
    border-radius: $radius;
    justify-content: center;
    font: 600 rem(12)/em(18,12) $heading-font-family;
    &:hover{color: #fff;}
}
.at-btn-resend{
    width: auto;
    min-width: auto;
    padding: 7px 12px;
    display: flex;
    align-items: center;
    color: #2E90FA !important;
    background-color: transparent;
    font: 600 12px/18px $heading-font-family;
    i{display: block;}
}
.at-infotolltip{
    position:relative;
    margin-right: 4px;
    i{
        display: block;
        font-size: 20px;
        line-height: inherit;
        &:hover{& + em{opacity: 1;visibility: visible;transform: scale(1);}}
    }
    em{
        right: 0;
        opacity: 0;
        bottom:100%;
        width: 178px;
        color: #fff;
        padding:5px 12px;
        position:absolute;
        visibility: hidden;
        margin-bottom: 18px;
        @extend %transition;
        transform: scale(0.5);
        letter-spacing: 0.5px;
        background: $primary-color;
        border-radius: 4px 4px 0 4px;
        font: 700 14px/22px $heading-font-family;
        &:after{
            width: 0;
            right: 0;
            height: 0;
            top: 100%;
            content: "";
            position: absolute;
            border-top: 8px solid $primary-color;
            border-left: 10px solid transparent;
        }
    }
}
.at-btn-blocked{
    color: #F04438;
    padding: 7px 12px;
    background-color: transparent;
    &:hover{
        color: #F04438;
    }
}
.at-btn-respond{background-color: $theme-color;}
.at-btnv2{
    color: #585858;
    background-color: #fff;
    border: 1px solid #EAEAEA;
    font: 600 rem(14)/em(20,14) $heading-font-family;
    &:hover,&:focus{color: #585858;background-color: $bg-color;}
}
.at-anchor {
  color: #999;
  display: inline-flex;
  letter-spacing: 0.01em;
  justify-content: center;
  font: 700 1rem/1.5em "Urbanist", sans-serif;
   &:hover{color: #999;}
}
.at-disabled {
  cursor: default;
  background: #F7F7F8;
  color: rgba($color: #585858, $alpha: 0.5) !important;
  &:hover{color: #999;}
}
.at-danger {color: #EF4444 !important;}
.at-bgdanger {background-color: #EF4444 !important;}
.at-bgsuccess {background-color: #22C55E !important;}
//<!----------------- Form --------------------->
.at-form-group-wrap{@extend %flex;}
.at-form-group{
    width: 100%;
    padding: 8px;
	position:relative;
    align-items: center;
    &:last-child{margin-bottom: 0;}
    .at-btnlist{
        .at-btn{
            height: 36px;
            width: auto;
            font: 600 rem(14)/em(20,14) $heading-font-family;
        }
    }
    .at-popupbtnarea{padding-top: 10px;}
    &:first-child{.at-form__section{padding: 0;margin-top: -5px;}}
}
.at-form-group-half{width: 50%;}
.at-form-group-3half{width: calc(100% / 3);}
.at-formtitle{
    display: block;
    margin: 0 0 4px;
    color: #585858;
    letter-spacing: 0.5px;
    font: 500 rem(14)/em(20,14) $heading-font-family;
}
.at-important{&:after{content: '*';color: #EF4444;}}
.at-form-control,
input[type="url"],input[type="tel"],input[type="week"],input[type="time"],input[type="date"],
input[type="search"],input[type="password"],input[type="datetime"],input[type="datetime-local"],
input[type="text"],input[type="month"],input[type="email"],input[type="color"],input[type="number"],
select,.uneditable-input{
    width: 100%;
    height: 40px;
    padding: 0 12px;
    @extend %border;
    color: #585858;
    border-radius: $radius;
    background-clip: unset;
    letter-spacing: 0.01em;
    caret-color: #585858;
    font: 400 rem(14)/em(20,14) $body-font-family;
    &::placeholder{color: #585858;}
    &:focus{box-shadow: unset;}
}
input[type=number] {-moz-appearance:textfield;}
textarea.at-form-control{resize: none;height: 126px;display: block;padding-top: 10px;}
input:focus,.select select:focus,
.at-form-control:focus {
    outline: none;
	color: #585858;
	border-color: #EAEAEA;
	box-shadow:none !important;
	-webkit-box-shadow:none !important;
}
.at-select{
    width: 100%;
    @extend %flex;
    position:relative;
    align-items: center;
    &:before {
        right: 12px;
        z-index: 1;
        content: "\e924";
        font-size: 20px;
        color: #585858;
        position: absolute;
        pointer-events: none;
        font-family: "wpguppy";
    }
    & select{
        width: 100%;
        appearance:none;
        padding-right:40px;
        -moz-appearance:none;
        -webkit-appearance:none;
        &:focus{outline: 0;}
    }
    .at-form-control{
        padding-right: 40px;
        .at-placeholder{
            display: block;
            color: #585858;
            font: 400 rem(14)/em(20,14) $body-font-family;
            padding: 9px 0;
        }
    }
}
.at-explain-form{
    flex: auto;
    width: auto;
    margin: 12px -12px 0;
    padding: 20px 20px 20px;
    border-top: 1px solid #EAEAEA;
    border-bottom: 1px solid #EAEAEA;
    background: rgba(5, 18, 55, 0.02);
}
label{color: #666;display: block;font-weight: 400;margin-bottom: 10px;}
form p span i {top: 13px;left: 16px;color: #474747;position: absolute;}
.at-form-control:disabled, .at-form-control[readonly]{background-color: $bg-color;}
.at-themeform{fieldset{border: 0;margin: -8px;}&__wrap{@extend %flex;}&__btn{margin-top: 10px;}}
input::-webkit-outer-spin-button,input::-webkit-inner-spin-button {margin: 0;-webkit-appearance: none;}
.at-seenmsg:before{
     color: #17B26A;
}
.at-resmsg:before,
.at-seenmsg:before {
    content: "\e927"!important;
}
.conversation-list{
    & .at-userbar_profile{
        width: 28px;
        height: 28px;
        border-radius: 50px;
        margin-right: 12px;
    }
    & .at-userbar_title{
        h3{
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
        }
    }
    & .at-userbar_right{
        gap: 2px;
        display: flex;
        align-items: center;
        flex-direction: column;
        .at-notify{
            padding: 4px;
            min-width: 20px;
            font-size: 10px;
            letter-spacing: 0.2px;
        }
    }
}
.at-sidebarmenu{
    li{
        a{
            width: 100%;
            & .at-sidebar-content{
                display: flex;
                align-items: center;
                padding-right: 10px;
                justify-content: space-between;
            }
        }
        a.at-notify-alert{
            position: relative;
            &::after{
                top: 14px;
                width: 5px;
                left: 55px;
                height: 5px;
                content: "";
                position: absolute;
                border-radius: 50%;
                background: #EF4444;
            }
        }
    }
}
.at-theme_tooltip {
    z-index: 999;
    color: #999;
    display: flex;
    flex-wrap: wrap;
    font-size: 14px;
    max-width: 348px;
    padding: 8px 12px;
    line-height: 22px;
    border-radius: 5px;
    visibility: hidden;
    background: #fff;
    align-items: center;
    box-shadow: 0px 4px 9px 0px rgba(27, 35, 41, 0.05);
    filter: drop-shadow(0 16px 36px rgba(6, 61, 60, 0.10));
}
.at-shimmer {
    overflow: hidden;
    position: relative;
    background: #ebebea;
    & > *{
        z-index: 1;
        position: relative;
    }
    &:after{
        left: 0px;
        right: 0px;
        top: 0px;
        height: 100%;
        content: "";
        position: absolute;
        animation-duration: 2s;
        --tw-translate-x: -100%;
        background-repeat: no-repeat;
        animation-iteration-count: infinite;
        -webkit-transform: translateX(-100%);
        animation-name: react-loading-skeleton;
        animation-timing-function: ease-in-out;
        background: linear-gradient(90deg, #ebebea, #fbfbfa, #ebebea);
    }
}
@keyframes react-loading-skeleton {
    100% {
        transform: translateX(100%);
    }
}
.at-dropdown {
    left: 0;
    top: 100%;
    margin: 0;
    width: 100%;
    z-index: 99;
    padding: 8px;
    display: none;
    overflow: hidden;
    background: #fff;
    border-radius: $radius;
    position: absolute;
    max-height: 200px;
    overflow-y: auto;
    flex-direction: column;
    font: 500 rem(14)/em(20,14) $heading-font-family;
    box-shadow: 0px 20px 24px -4px rgba(16, 24, 40, 0.08), 0px 8px 8px -4px rgba(16, 24, 40, 0.03);
    & li {
        line-height: inherit;
        list-style-type: none;
        outline: none
    }
    & a {
        margin: 0;
        display: flex;
        cursor: pointer;
        color: #0a0f26;
        font-weight: 500;
        align-items: center;
        padding: 10px 8px;
        border-radius: $radius;
        transition: all .3s ease-in-out;
        &:hover {
            background-color: #f7f7f7!important
        }
        &:focus {
            outline: none!important
        }
    }
}
.at-dropbox {
    width: 100%;
    padding: 20px;
    border-radius: 4px;
    align-items: center;
    flex-direction: column;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    border: 1.5px dashed #DDDDDD;
    & label {
        cursor: copy;
        max-width: 120px;
        margin: 10px 0 0;
        letter-spacing: 0.5px;
        color: #0A0F26;
        font: 500 0.875rem / 1.7142857143em "Urbanist", sans-serif;
    }
    &empty{
        border: 0;
        margin-top: 10px;
        min-height: 200px;
        border-radius: $radius;
        background-color: #F7F7F8;
        & > i,
        & .at-dropboxuploader > i {
            margin: 0;
            padding: 0;
            color: #ddd;
            background-color: transparent;
            font-size: 10px;
        }
        & i {
            font-size: 38px;
        }
    }
    & > i,
    & .at-dropboxuploader > i {
        font-size: 46px;
        display: inline-block;
        color: rgba($color: #585858, $alpha: 0.5);
    }
    & label {
        cursor: initial;
        max-width: 100%;
        text-align: center;
        color: rgba($color: #585858, $alpha: 0.6);
        font: 600 rem(16)/em(24,16) $body-font-family;
    }
}
.at-sendfile span em{
    display: block;
    color: $text-color;
    font-style: normal;
    font-size: rem(13);
    text-align: left;
}
.at-togglebtn{
    margin-left: auto;
    & input{
        display: none;
        visibility: hidden;
        &:checked+label{
            background: #000;
            &:after{
                left: calc(100% - 18px);
            }
        }
    }
    & label{
        width: 36px;
        display: block;
        margin: 0;
        padding: 2px;
        height: 20px;
        cursor: pointer;
        position: relative;
        border-radius: 100px;
        background: #EAEAEA;
        @extend %transition;
        &:hover{
            background: #585858;
        }
        &::after{
            top: 2px;
            left: 2px;
            content: '';
            width: 16px;
            height: 16px;
            position: absolute;
            border-radius: 50%;
            @extend %transition;
            background-color: #fff;
            box-shadow: 0px 1px 3px 0px rgba(16, 24, 40, 0.10), 0px 1px 2px 0px rgba(16, 24, 40, 0.06);
        }
    }
}
.at-mute i {
    &:before{
        content: '\e94a';
    }
}
.at-rightswitcharea{
    gap: 10px;
    width: 100%;
    display: flex;
    cursor: pointer;
    padding: 7px 12px;
    align-items: center;
    background: #F7F7F8;
    border-radius: $radius;
    i{
        margin: 0;
        width: 26px;
        height: 26px;
        display: flex;
        font-size: 16px;
        background: #FFF;
        align-items: center;
        color: #585858;
        border-radius: 50px;
        justify-content: center;
    }
    & > span{
        color: #585858;
        font: 500 rem(14)/em(20,14) $body-font-family;
    }
}
.at-del-msg{
    display: flex;
    text-align: left;
    overflow: hidden;
    align-items: center;
    text-overflow: ellipsis;
    color: rgba($color: #000000, $alpha: 0.7);
    font: 400 rem(14)/em(20,14) $body-font-family;
    i{
        font-size: 20px;
        margin-right: 4px;
    }
}
.fslightbox-source{border-radius: $radius;}
.fslightbox-toolbar{border-radius: 0 0 0 $radius;}
.fslightbox-slide-btn{border-radius: $radius;}
.at-message{
    .fslightbox-slide-number-container span{color: #fff;}
}
</style>
