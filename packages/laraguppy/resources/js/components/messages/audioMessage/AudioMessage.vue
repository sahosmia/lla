<script setup>
    import {ref, defineAsyncComponent} from "vue";
    const QuoteMessageList = defineAsyncComponent(() => import('../quoteMessages/QuoteMessageList.vue'));
	const MessageActions = defineAsyncComponent(() => import('../messageActions/MessageActions.vue'));
    const props = defineProps(['message']);
    const { message } = props;
</script>
<template>
  <div class="at-message at-audiosendfile" :id="`'message_'${message.messageId}`">
    <h5 v-if="!message.isSender && message.threadType == 'group'">{{message.name}}</h5>
	<span class="at-msgload" v-if="message.parent && !message.messageId" ><i class="at-spinericon"></i></span>
    <QuoteMessageList :message="message.parent" :msgId="message.messageId" v-if="message.parent">
      <div class="at-sendfile">
        <i class="laraguppy-music-01"></i>
        <span v-if="message.attachments && message.attachments[0]">{{message.attachments[0].file}}<em>{{message.attachments[0].fileSize}}</em></span>
      </div>
     	<template v-slot:message_actions>
			<MessageActions v-if="message.messageId" :isDownload="true" :message="message" />
		</template>
    </QuoteMessageList>
    <div v-else class="at-sendfile">
      	<i class="laraguppy-music-01"></i>
      	<span v-if="message.attachments && message.attachments[0]">{{message.attachments[0].fileName}}<em>{{message.attachments[0].fileSize}}</em></span>
	  	<MessageActions v-if="message.messageId" :isDownload="true" :message="message" />
		<span class="at-msgload" v-else><i class="at-spinericon"></i></span>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.at-sendfile{
	display: flex;
	align-items: center;
	border-radius: $radius;
	background-color: $bg-color;
	padding: 11px 44px 11px 20px;
	> i{
		flex: none;
		font-size: 24px;
		line-height: 20px;
		margin-right: 20px;
	}
	> span{
		font-size: rem(15);
		line-height: em(20,15);
		letter-spacing: 0.01em;
		word-break: break-word;
		em{
			display: block;
			color: $text-color;
			font-style: normal;
			font-size: rem(13);
			text-align: left;
		}
	}
	.at-messageoption{
		top: 28px;
		right: 36px;
	}

}
</style>