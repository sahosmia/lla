<script setup>
    import {ref} from "vue";
    const props = defineProps(['message']);
    const message = props;
</script>
<template>
    <div class="at-message at-deletemsg">
        <h5 v-if="!message.isSender && message.threadType == 'group'">{{message.name}}</h5>
        <div class="at-del-msg"><i class="laraguppy-block"></i> {{$t('chatapp.deleted_message')}}</div>
    </div>
</template>