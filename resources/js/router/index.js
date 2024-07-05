import { createRouter, createWebHistory } from "vue-router";
import store from "../store/index.js";

import Home from "../Pages/Home.vue";
import Test from "../Pages/Test.vue";
import Login from "@/Pages/Login.vue";
import Register from "@/Pages/Register.vue";

const routes = [
    {
        path: "/home",
        component: Home,
        meta:{
            middleware:"auth"
        },
    },
    {
        path: "/test",
        component: Test,
        meta:{
            middleware:"guest"
        },
    },

    {
        path: "/",
        component: Home
    },

    {
        name:"login",
        path:"/login",
        component:Login,
        meta:{
            middleware:"guest",
            title:`Login`
        }
    },
    {
        name:"register",
        path:"/register",
        component:Register,
        meta:{
            middleware:"guest",
            title:`Register`
        }
    },

];

const router =  createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    if(to.meta.middleware=="guest" || to.meta.middleware === undefined){
        next()
    }else{
        if(store.state.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router;
