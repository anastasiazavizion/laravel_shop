import './bootstrap';
import { createApp } from 'vue'
import App from "./App.vue";
import router from "./router/index.js";
import store from "./store/index.js";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import { register } from 'swiper/element/bundle';
register();

import UniversalSocialauth from 'universal-social-auth';

const options = {
    providers: {
        google: {
            clientId: '763006628274-la1sb6frp572vbhpnl66cr33m8m842lb.apps.googleusercontent.com',
            redirectUri: 'http://127.0.0.1/auth/google/callback'
        }
    }
};

const Oauth = new UniversalSocialauth(axios, options);

const app = createApp(App)
    .use(router)
    .use(store)
    .use(ZiggyVue)
    .use(LaravelPermissionToVueJS)
    .use(Toast)

app.config.globalProperties.$axios = axios;
app.config.globalProperties.$Oauth = Oauth;

app.mount('#app');
