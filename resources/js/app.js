import './bootstrap';
import { createApp } from 'vue'
import App from "./App.vue";
import router from "./router/index.js";
import store from "./store/index.js";
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import { register } from 'swiper/element/bundle';
register();

createApp(App)
    .use(router)
    .use(store)
    .use(LaravelPermissionToVueJS)
    .use(Toast)
    .mount('#app')
