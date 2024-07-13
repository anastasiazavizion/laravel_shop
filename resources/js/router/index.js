import { createRouter, createWebHistory } from "vue-router";
import store from "../store/index.js";

import Home from "../Pages/Home.vue";
import Login from "@/Pages/Auth/Login.vue";
import Register from "@/Pages/Auth/Register.vue";
import Dashboard from "@/Pages/Admin/Dashboard.vue";
import Products from "@/Pages/Admin/Products/Index.vue";
import Categories from "@/Pages/Admin/Categories/Index.vue";
import ShowCategory from "@/Pages/Admin/Categories/Show.vue";
import EditCategory from "@/Pages/Admin/Categories/Edit.vue";
import CategoriesCreate from "@/Pages/Admin/Categories/Create.vue";

import ShowProduct from "@/Pages/Admin/Products/Show.vue";
import EditProduct from "@/Pages/Admin/Products/Edit.vue";
import ProductsCreate from "@/Pages/Admin/Products/Create.vue";

const routes = [
    {
        path: "/home",
        component: Home,
        meta:{
            middleware:["auth"],
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
            middleware:["admin"],
            title:`Dashboard`
        }
    },
    {
        name:"admin.products",
        path:"/admin/products",
        component:Products,
        meta:{
            middleware:["auth"],
            title:`Products`
        }
    },
    {
        name:"admin.categories",
        path:"/admin/categories",
        component:Categories,
        meta:{
            middleware:["auth"],
            title:`Categories`
        }
    },

    {
        name:"admin.categories.show",
        path:"/admin/categories/:id",
        component:ShowCategory,
        meta:{
            middleware:["auth"],
            title:`Category`
        }
    },

    {
        name:"admin.categories.edit",
        path:"/admin/categories/:id/edit",
        component:EditCategory,
        meta:{
            middleware:["auth", "can:edit category"],
            title:`Category`
        }
    },

    {
        name:"admin.categories.create",
        path:"/admin/categories/create",
        component:CategoriesCreate,
        meta:{
            middleware:["auth", "can:create category"],
            title:`Category create`
        }
    },

    {
        name:"admin.products.show",
        path:"/admin/products/:id",
        component:ShowProduct,
        meta:{
            middleware:["auth"],
            title:`Product`
        }
    },
    {
        name:"admin.products.edit",
        path:"/admin/products/:id/edit",
        component:EditProduct,
        meta:{
            middleware:["auth", "can:edit product"],
            title:`Product`
        }
    },

    {
        name:"admin.products.create",
        path:"/admin/products/create",
        component:ProductsCreate,
        meta:{
            middleware:["auth", "can:create product"],
            title:`Product create`
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
    const middleware = to.meta.middleware;
    const permissions = window.Laravel.jsPermissions;
    const roles = permissions['roles'];
    const permission = permissions['permissions'];
    if(middleware === "guest" || middleware === undefined){
        next()
    }else{
        let allow = true;
        for(let rule of middleware){
            if(rule.includes('can:')){
                allow = permission.includes(rule.replace('can:',''));
            }else if(rule === 'auth'){
                allow = store.getters['auth/authenticated'];
            }else{
                allow = roles.includes(rule);
            }
            if(!allow){
                break;
            }
        }
        if(allow){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router;
