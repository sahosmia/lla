<script setup>
  import { ref, reactive, computed } from "vue";
  const props = defineProps(['type','showText']);
  const { type = null, showText = false } = props;
  const spinnerStyles = computed(() => {
    let styles      = [];
    let delayTime   = 0.68359375;
    for (let index = 0; index < 8; index++) {
      delayTime -= 0.09765625;
      const animationDelay = index === 7 ? '0s' : `-${delayTime}s`;
      const transform = `rotate(${index * 45}deg)`;
      styles[index] = { transform, animationDelay };
    }
    return styles;
  });
</script>
<template>
     <li v-if="type === 'innerLoading'" class="at-userbar_loader at-inner-loaader">
      <span><i class="at-spinericon"></i></span>
    </li>
    <div v-if="type == 'msgLoading'" class="at-messages at-inner-loaader">
        <span><i class="at-spinericon"></i></span>
    </div>
    <div v-else class="at-emptyconver">
        <div class="at-chatloader at-smsloader">
          <span v-for="(style, index) in spinnerStyles" :key="`spinner_${index}`" :style="style"></span>
        </div>
        <span v-if="showText">{{$t('chatapp.search_results')}}</span>
    </div>
</template>

<style lang="scss" scoped>
.at-emptyconver{
    .at-smsloader{
       margin: 0;
       width: 40px;
       height: 40px;
       margin-bottom: 30px;
       transform: translateZ(0) scale(.4);
     }
}
.at-chatloader {
    width: 52px;
    height: 52px;
    margin: 0 0 20px;
    position: relative;
    transform-origin: 0 0;
    transform: translateZ(0) scale(0.48);
      span {
        top: 0px;
        left: 49px;
        width: 5.8px;
        height: 25px;
        display: block;
        position: absolute;
        border-radius: 1.5px;
        background: #999999;
        transform-origin: 1px 49px;
        animation: at-chatloader linear 0.78125s infinite;
    }
}
.at-messages.at-inner-loaader{
  height: auto;
  bottom: auto;
  position: relative;
  padding: 20px 0 27px;
  background: transparent;
}
.at-inner-loaader{
     span{
        width: 64px;
        height: 64px;
        display: flex;
        margin: 0 auto;
        font-size: 24px;
        line-height: 64px;
        text-align: center;
        background:#fff;
        border-radius: 40px;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(40,41,61,.04), 0 8px 16px rgba(96,97,112,.16);
     }  
      i{
        width: 24px;
        height: 24px;
        border: 3px solid #ddd;
        border-right-color: #fff;
        border-radius: 50px 50px 50px 50px;
        animation: spinericon 1s linear infinite;
     }
}
@keyframes at-chatloader {
    0% { opacity: 1 }
    100% { opacity: 0 }
}
</style>
