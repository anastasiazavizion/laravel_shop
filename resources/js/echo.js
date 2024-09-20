import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
import {useToast} from "vue-toastification";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true
});


window.Echo.private('admin-channel')
    .listen('.admin.order.created', (e) => {
        const toast = useToast();
        toast("You have new order with total "+e.total);
    });
