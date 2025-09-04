<script setup>
    import {ref} from "vue";
    const props = defineProps(['audioSource', 'messageId']);
    const { audioSource, messageId } = props;
    const playIcon = ref(`
           <svg width="14" height="19" viewBox="0 0 14 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0.5L14 9.5L0 18.5V0.5Z" fill="#1570EF"/>
            </svg>
        `);
    const pauseIcon = ref(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#3D3132">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        `);
    const soundIcon = ref(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#3D3132">
                <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd" />
            </svg>
        `);
    const muteIcon = ref(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#3D3132">
                <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM12.293 7.293a1 1 0 011.414 0L15 8.586l1.293-1.293a1 1 0 111.414 1.414L16.414 10l1.293 1.293a1 1 0 01-1.414 1.414L15 11.414l-1.293 1.293a1 1 0 01-1.414-1.414L13.586 10l-1.293-1.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        `);

    const toggleAudio = () => {
        let playerButton = document.querySelector('#player-button_'+messageId);
        let audio = document.getElementById('recorded_voice_'+messageId);
        if (audio.paused) {
          audio.play();
          playerButton.innerHTML = pauseIcon.value;
        } else {
          audio.pause();
          playerButton.innerHTML = playIcon.value;
        }
    }
    const audioEnded = () => {
        let playerButton = document.querySelector('#player-button'+'_'+messageId);
        playerButton.innerHTML = playIcon.value;
    }
    const changeSeek = () => {
        let timeline = document.getElementById('timeline_'+messageId);
        let audio = document.getElementById('recorded_voice_'+messageId);
        const time = (timeline.value * audio.duration) / 100;
        audio.currentTime = time;
    }
    const changeTimelinePosition = () => {
        let audio = document.getElementById('recorded_voice_'+messageId);
        let timeline = document.getElementById('timeline_'+messageId);
        const percentagePosition = (100*audio.currentTime) / audio.duration;
        timeline.style.backgroundSize = `${percentagePosition}% 100%`;
        timeline.value = percentagePosition;
    }
    const toggleSound = () => {
        let audio = document.getElementById('recorded_voice_'+messageId);
        let soundButton = document.getElementById('sound-button_'+messageId);
        audio.muted = !audio.muted;
        soundButton.innerHTML = audio.muted ? muteIcon.value : soundIcon.value;
    }
    
</script> 
<template>
    <div class="audio-player">
        <audio :id="'recorded_voice_'+messageId" @ended="audioEnded()" @timeupdate="changeTimelinePosition()" 
        :src="audioSource"></audio>
        <div class="controls">
            <a href="javascript:void(0);" @click.prevent="toggleAudio()" :id="'player-button_'+messageId" class="player-button">
                <svg width="14" height="19" viewBox="0 0 14 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0.5L14 9.5L0 18.5V0.5Z" fill="#1570EF"/>
                </svg>
            </a>
            <input type="range" @change="changeSeek" :id="'timeline_'+messageId" class="timeline" max="100" value="0">
            <a href="javascript:void(0);" :id="'sound-button_'+messageId" @click.prevent="toggleSound()" class="sound-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#3D3132">
                    <path fill-rule="evenodd" d="M9.383 3.076A1 1 0 0110 4v12a1 1 0 01-1.707.707L4.586 13H2a1 1 0 01-1-1V8a1 1 0 011-1h2.586l3.707-3.707a1 1 0 011.09-.217zM14.657 2.929a1 1 0 011.414 0A9.972 9.972 0 0119 10a9.972 9.972 0 01-2.929 7.071 1 1 0 01-1.414-1.414A7.971 7.971 0 0017 10c0-2.21-.894-4.208-2.343-5.657a1 1 0 010-1.414zm-2.829 2.828a1 1 0 011.415 0A5.983 5.983 0 0115 10a5.984 5.984 0 01-1.757 4.243 1 1 0 01-1.415-1.415A3.984 3.984 0 0013 10a3.983 3.983 0 00-1.172-2.828 1 1 0 010-1.415z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</template>
<style>
.audio-player {
  --player-button-width: 3em;
  --sound-button-width: 2em;
  --space: .5em;
  width: 100%;
  height: auto;
}

.icon-container {
  width: 100%;
  height: 100%;
  background-color: #DE5E97;
  color: #fff;
  display: flex;
  justify-content: center;
  align-items: center;
}

.audio-icon {
   width: 90%;
   height: 90%;
}

.controls {
  display: flex;
  flex-direction: row;
  align-items: center;
  width: 100%;
  margin-top: 0;
}

.controls .player-button {
  background-color: transparent !important;
  border: 0;
  width: 30px;
  height: 40px;
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
}

.controls .timeline {
  -webkit-appearance: none;
  width: calc(100% - (var(--player-button-width) + var(--sound-button-width) + var(--space)));
  background-color: #ddd;
  height: 6px;
  border-radius: 5px;
  background-size: 0% 100%;
   background-image: linear-gradient(#1570EF, #1570EF);
  background-repeat: no-repeat;
  margin-right: var(--space);
}

.controls .timeline::-webkit-slider-thumb {
  -webkit-appearance: none;
  width: 21px;
  height: 21px;
  border-radius: 50%;
  cursor: pointer;
  opacity: 1;
  transition: all .1s;
  background: #FFFFFF;
  border: 1.5px solid #DDDDDD;
  box-shadow: 0px 2px 4px rgba(40, 41, 61, 0.04), 0px 8px 16px rgba(96, 97, 112, 0.16);
}

.controls .timeline::-moz-range-thumb {
  -webkit-appearance: none;
  width: 21px;
  height: 21px;
  border-radius: 50%;
  cursor: pointer;
  opacity: 1;
  transition: all .1s;
  background: #FFFFFF;
  border: 1.5px solid #DDDDDD;
  box-shadow: 0px 2px 4px rgba(40, 41, 61, 0.04), 0px 8px 16px rgba(96, 97, 112, 0.16);
}

.controls .timeline::-ms-thumb {
  -webkit-appearance: none;
  width: 21px;
  height: 21px;
  border-radius: 50%;
  cursor: pointer;
  opacity: 1;
  transition: all .1s;
  background: #FFFFFF;
  border: 1.5px solid #DDDDDD;
  box-shadow: 0px 2px 4px rgba(40, 41, 61, 0.04), 0px 8px 16px rgba(96, 97, 112, 0.16);
}

.controls .timeline::-webkit-slider-thumb:hover {
  background-color: #fff;
   border: 1.5px solid #DDDDDD;
}

.controls .timeline:hover::-webkit-slider-thumb {
  opacity: 1;
}

.controls .timeline::-moz-range-thumb:hover {
  background-color: #fff;
   border: 1.5px solid #DDDDDD;
}

.controls .timeline:hover::-moz-range-thumb {
  opacity: 1;
}

.controls .timeline::-ms-thumb:hover {
  background-color: #fff;
   border: 1.5px solid #DDDDDD;
}

.controls .timeline:hover::-ms-thumb {
  opacity: 1;
}

.controls .timeline::-webkit-slider-runnable-track {
  -webkit-appearance: none;
  box-shadow: none;
  border: none;
  background: transparent;
}

.controls .timeline::-moz-range-track {
  -webkit-appearance: none;
  box-shadow: none;
  border: none;
  background: transparent;
}

.controls .timeline::-ms-track {
  -webkit-appearance: none;
  box-shadow: none;
  border: none;
  background: transparent;
}

.controls .sound-button {
  background-color: transparent !important;
  border: 0;
  width: var(--sound-button-width);
  height: var(--sound-button-width);
  cursor: pointer;
  padding: 0;
  display: flex;
  align-items: center;
}
.controls .sound-button svg {
  fill: #1570EF;
  width: 20px;

}

.controls  .player-button svg {
  fill: #1570EF;
  width:30px;
}
</style>