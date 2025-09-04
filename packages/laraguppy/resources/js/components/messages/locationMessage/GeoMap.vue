<script setup>
    import {ref, onMounted, onBeforeUnmount } from "vue";
    import "leaflet/dist/leaflet.css";
    import 'leaflet/dist/leaflet.css';
    import 'leaflet-fullscreen/dist/leaflet.fullscreen.css';
    import L from "leaflet";
    import 'leaflet-fullscreen';
    const props = defineProps(['location','msgId']);
    const { location, msgId } = props; 
    const map = ref(null);
    onMounted(() => {
        map.value = L.map(`mapContainer_${msgId}`).setView([location.latitude, location.longitude], 15);
        L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
        attribution:
            '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map.value);
        L.center = [location.latitude, location.longitude];
        L.marker([location.latitude, location.longitude]).addTo(map.value);
        L.control.fullscreen().addTo(map.value);
    });
    onBeforeUnmount(() => {
        if (map.value) {
            map.value.remove();
        }
    })
</script>
<template>
        <div :id="`mapContainer_${msgId}`"></div>
</template>
<style lang="scss">
.leaflet-container{
    top: 20px;
    left: 20px;
    z-index: 1;
    width: 400px;
    height: 200px;
    position: absolute;
    &::before{
        top: 0;
        left: 0;
        content:"";
        width: 100%;
        z-index: 999;
        height: 100%;
        position: absolute;
        border-radius: $radius;
        background: rgba(0,0,0,.5);
    }
}
.at-message-qoute_content .leaflet-container{
    left: 0;
    top: auto;
    outline: none;
    position: relative;
    width: 180px !important;
    height: 90px !important;
    border-radius: $radius;
}
.at-chat640 .leaflet-container {width: 300px!important;}
.at-chat640 .at-message-qoute_content .leaflet-container{
    width: 180px !important;
}
.at-chat420 .leaflet-container {
    width: 210px!important; 
    height: 150px!important;
}

</style>