import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

import store from "./store/index.js";

import { useToast } from "vue-toastification";

const toast = useToast();

axios.interceptors.response.use(function (response) {

    if(response.data.message){
        if(response.status === 200){
            toast.success(response.data.message, {
                timeout: 3000
            });
        }

        if(response.status === 500){
            toast.error(response.data.message, {
                timeout: 3000
            });
        }
    }

    // Any status code that lies within the range of 2xx causes this function to trigger
    // Do something with response data
    return response;
}, function (error) {
    // Any status codes that fall outside the range of 2xx cause this function to trigger
    // Do something with response error
    if(error.response && error.response.status === 401) {
        store.commit('auth/SET_USER', {});
        store.commit('auth/SET_AUTHENTICATED', false);
        window.location.href = "/auth/login";
    }
    return Promise.reject(error);
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

//import './echo';
