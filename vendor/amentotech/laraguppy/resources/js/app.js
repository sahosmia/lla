import { createApp } from 'vue';
import  ChatApp  from './ChatApp.vue';
import { i18nVue } from 'laravel-vue-i18n';
import axios from 'axios'
import VueAxios from 'vue-axios'
import { createPinia } from 'pinia';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Vue3linkify from "vue-3-linkify";
import "./assets/icons.css";
import "./assets/fonts.css";
const pinia = createPinia()
const app = createApp(ChatApp);
app.use(pinia)
app.use(Vue3linkify)
app.use(VueAxios, axios);
axios.interceptors.response.use(function (response) {
    return response.data;
  }, function (error) {
    return Promise.reject(error);
});

app.provide('axios', app.config.globalProperties.axios);

async function inializeApp() {
    const langs = import.meta.glob('../../lang/*.json');
    await langs[`../../lang/php_en.json`]().then(( lang ) => {
        app.use(i18nVue, {
            resolve: async () =>{
                return lang;
            }
        }).mount('#chat-app')
    });
}

window.Pusher = Pusher;
const driver = window?.pusherConfig?.driver;

if(  ['reverb', 'pusher'].includes(driver) ){
    let settings = {
        broadcaster: driver,
        key: window.pusherConfig.key,
        cluster: window.pusherConfig?.options?.cluster ?? '',
        forceTLS: window.pusherConfig.options.scheme === 'https',
        auth: {
            endpoint: '/api/broadcasting/auth',
            headers: {
                Authorization: 'Bearer ' + window.guppy_auth_token,
                Accept: "application/json",
                'Access-Control-Allow-Credentials': true
            },
        },
    }

    if( driver == 'reverb'){
        settings = {
            ...settings,
            wsHost: window.pusherConfig.options.host,
            wsPort: window.pusherConfig.options.port,
            wssPort: window.pusherConfig.options.port,
            enabledTransports: ['ws', 'wss'],
        }
    }

    window.Echo = new Echo(settings);
}

inializeApp();
