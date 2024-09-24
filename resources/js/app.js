import './bootstrap';
import { createApp } from 'vue'
import App from "./App.vue";
import router from "./router/index.js";
import store from "./store/index.js";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import { Ziggy } from './ziggy';

import { register } from 'swiper/element/bundle';
register();

import UniversalSocialauth from 'universal-social-auth';

const options = {
    providers: {
        google: {
            clientId: import.meta.env.VITE_GOOGLE_CLIENT_ID,
            redirectUri: import.meta.env.VITE_GOOGLE_REDIRECT_URL
        }
    }
};

const Oauth = new UniversalSocialauth(axios, options);

const app = createApp(App)
    .use(router)
    .use(store)
    .use(Ziggy)
    .use(LaravelPermissionToVueJS)
    .use(Toast, {
        toastClassName:'custom-toast'
    })

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$Oauth = Oauth;

app.mount('#app');
