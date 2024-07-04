import { createRouter, createWebHistory } from "vue-router";

import Home from "../Pages/Home.vue";
import Test from "../Pages/Test.vue";

const routes = [
    {
        path: "/home",
        component: Home,
    },
    {
        path: "/test",
        component: Test
    },
    {
        path: "/",
        component: Home
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
