import { createRouter, createWebHistory } from "vue-router";
import store from "../store/index.js";

import Home from "../Pages/Home.vue";
import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import Dashboard from "@/Pages/Admin/Dashboard.vue";
import Products from "@/Pages/Admin/Products/Index.vue";
import Categories from "@/Pages/Admin/Categories/Index.vue";
import CategoriesCreate from "@/Pages/Admin/Categories/Create.vue";

const routes = [
    {
        path: "/home",
        component: Home,
        meta:{
            middleware:"auth"
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
        name:"admin.dashboard",
        path:"/admin/dashboard",
        component:Dashboard,
        meta:{
            middleware:"auth",
            title:`Dashboard`
        }
    },
    {
        name:"admin.products",
        path:"/admin/products",
        component:Products,
        meta:{
            middleware:"auth",
            title:`Products`
        }
    },
    {
        name:"admin.categories",
        path:"/admin/categories",
        component:Categories,
        meta:{
            middleware:"auth",
            title:`Categories`
        }
    },

    {
        name:"admin.categories.create",
        path:"/admin/categories/create",
        component:CategoriesCreate,
        meta:{
            middleware:"auth",
            title:`Category create`
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
        if(store.getters['auth/authenticated']){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router;
