import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

import store from "./store/index.js";

axios.interceptors.response.use(function (response) {
    // Any status code that lies within the range of 2xx causes this function to trigger
    // Do something with response data
    return response;
}, function (error) {
    // Any status codes that fall outside the range of 2xx cause this function to trigger
    // Do something with response error
    if(error.response && error.response.status === 401) {
        store.commit('auth/SET_USER', {});
        store.commit('auth/SET_AUTHENTICATED', false);
        window.location.href = "/login";
    }
    return Promise.reject(error);
});
