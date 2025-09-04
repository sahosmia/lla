<script setup>
	import { ref, defineAsyncComponent, onMounted, computed } from 'vue';
	import useChatStore from "../../../stores/useChatStore";
	import useSettingsStore from "../../../stores/useSettingsStore";
    import { storeToRefs } from "pinia";
	import { debounce } from 'lodash';
    const SidebarSettings = defineAsyncComponent(() => import("./SidebarSettings.vue"));
	import useEventsBus from "../../../services/useEventBus";
	import avatar from "../../../assets/images/avatar.png";
	const chatStore = useChatStore();
    const settingsStore = useSettingsStore();
    const { chatInfo } = storeToRefs(chatStore);
    const { settings } = storeToRefs( settingsStore );
	const isShow = ref(false);
	const close = debounce(() => isShow.value = false, 200);
	const isLoadingImage = ref(true);
	const {on} = useEventsBus();

	const toggleSidebar = () => {
		if( isShow.value ){
			jQuery(document).find(".at-chat_sidebarsetting").removeClass("at-chat_sidebarsettingopen");
		}

		if(isShow.value){
			close();
		} else {
			isShow.value = true;
		}
	}

	on('closeSideBar', (payload) => {
		toggleSidebar();
	});

	onMounted(() => {
		jQuery(document).on('click','body',function(e) {
			
			
			if( jQuery('.at-chat_sidebarsetting').not(jQuery('.at-chat_sidebarsetting').has(e.target))?.length && 
				!jQuery('.at-userinfo_settings').has(e.target)?.length && 
				!jQuery(e.target).closest('#clearchat, #blockuser', '.at-mute-thread').length &&
				!jQuery('.at-lightbox-container').has(e.target)?.length
			){
				toggleSidebar()
			}
		});
	});

	const userImage = computed(() => {
		return chatInfo.value.photo ? chatInfo.value.photo : ( settings.value.defaultAvatar ? settings.value.defaultAvatar : avatar )
	});

</script>

<template>
    <div class="at-userinfo">
        <div class="at-userinfo_title">
            <a href="javascript:void(0);" class="at-backtolist"><i class="laraguppy-left"></i></a>
            <figure class="at-userinfo_title_img" :class="{'at-shimmer':isLoadingImage}">
				<span class="at-userstatus" :class="chatInfo.isOnline ? 'online' : 'offline' "></span>
                <img @load="() => isLoadingImage = false" :class="{'at-none':isLoadingImage}" :src="userImage" :alt="chatInfo.name">
            </figure>
            <div class="at-userinfo_title_name">
                <h3>{{chatInfo.name}}</h3>
                <span class="">{{$t(`chatapp.${chatInfo.isOnline ? 'online' : 'offline'}`)}}</span>
            </div>
        </div>
        <div class="at-userinfo_settings">
            <a href="javascript:void(0);" @click.prevent="toggleSidebar"><i class="laraguppy-sliders-horizontal-01"></i></a>
        </div>
		<SidebarSettings v-if="isShow" @closeSidebar="toggleSidebar"/>
    </div>
</template>
<style lang="scss" scoped>
.at-userinfo{
	display: flex;
	padding: 16px 20px;
	align-items:center;
	background-color:#fff;
	box-shadow: inset 0px -1px 0px #EEEEEE;
	&_title{
		display: flex;
		align-items:center;
		.at-userstatus{
			color: rgba($color: #585858, $alpha: 0.8);
			font: 400 rem(12)/em(18,12) $heading-font-family;
			&:before{
				width: 6px;
				height: 6px;
				outline: none;
				margin-right: 5px;
			}
		}
		> a{
			color: #000;
			display: none;
			font-size: 22px;
			line-height: 0.8;
			margin-right: 15px;
		}
		&_img{
			max-width: 28px;
			margin-right: 15px;
			position: relative;
			img{
				width: 100%;
				height: 28px;
				display: block;
				object-fit: cover;
				border-radius: 50%;
			}
			.at-userstatus {
				position: absolute;
				right: 1px;
				bottom: 1px;
				&:before{
					margin: 0;
					border: 1px solid #fff;
				}
			}
		}
		&_name{
			@extend %flex;
			flex-direction: column;
			h3{
				margin: 0;
				width: 100%;
				color: #000;
				font-weight: 400;
				overflow: hidden;
				font-size: rem(16);
				display: -webkit-box;
				-webkit-line-clamp: 1;
				line-height: em(24,16);
				text-overflow: ellipsis;
				-webkit-box-orient: vertical;
			}
			span{
				margin: 0;
				opacity: 0.8;
				color: #585858;
				white-space: nowrap;
				font-size: rem(12);
				line-height: em(18,12);
				span{
					&:not(:last-child){
						&::after{content: ',';
					}
				}
			}
		}
	}
}
&_settings{
	margin-left: auto;
	  a{
		color: #000;
		width: rem(42);
		display: block;
		font-size: 24px;
		text-align: center;
		line-height: em(38);
	    }
    }
}
.at-chat991 {
	.at-userinfo {
		padding-left: 13px;
		&_title > a{
			display: block;
		}
	}
}
.at-chat640 {
	.at-userinfo_title_name p span{
		&:nth-last-child(2) {display: none;}	
	}
}
.at-chat575 {
	.at-userinfo_title_name p span{
		&:nth-last-child(3) {display: none;}
	}
}
.at-chat480 {
	.at-userinfo_title_name p span{
        &:nth-last-child(4) {display: none;}
	}
	.at-userinfo_title > a {margin-right: 10px;}
}
.lg-rtl  .at-userinfo_title_img {
    margin-left: 15px;
    margin-right: 0;
}

</style>