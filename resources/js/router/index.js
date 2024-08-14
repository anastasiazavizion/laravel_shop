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

import AdminLayout from "@/Layouts/AdminLayout.vue";
import GeneralLayout from "@/Layouts/GeneralLayout.vue";
import AuthLayout from "@/Layouts/AuthLayout.vue";


import ProductsShow from "@/Pages/Product/Show.vue";
import ProductsIndex from "@/Pages/Product/Index.vue";

import Cart from "@/Pages/Cart/Index.vue";
import Wishlist from "@/Pages/Account/WishList.vue";
import Checkout from "@/Pages/Cart/Checkout.vue";


const routes = [
    {
        path: '/admin',
        component: AdminLayout,
        children:[
            {
                name:"admin.dashboard",
                path:"dashboard",
                component:Dashboard,
                meta:{
                    middleware:["admin"],
                    title:`Dashboard`
                }
            },
            {
                name:"admin.products",
                path:"products",
                component:Products,
                meta:{
                    middleware:["auth"],
                    title:`Products`
                }
            },
            {
                name:"admin.categories",
                path:"categories",
                component:Categories,
                meta:{
                    middleware:["auth"],
                    title:`Categories`
                }
            },

            {
                name:"admin.categories.show",
                path:"categories/:id",
                component:ShowCategory,
                meta:{
                    middleware:["auth"],
                    title:`Category`
                }
            },

            {
                name:"admin.categories.edit",
                path:"categories/:id/edit",
                component:EditCategory,
                meta:{
                    middleware:["auth", "can:edit category"],
                    title:`Category`
                }
            },

            {
                name:"admin.categories.create",
                path:"categories/create",
                component:CategoriesCreate,
                meta:{
                    middleware:["auth", "can:create category"],
                    title:`Category create`
                }
            },

            {
                name:"admin.products.show",
                path:"products/:id",
                component:ShowProduct,
                meta:{
                    middleware:["auth"],
                    title:`Product`
                }
            },
            {
                name:"admin.products.edit",
                path:"products/:id/edit",
                component:EditProduct,
                meta:{
                    middleware:["auth", "can:edit product"],
                    title:`Product`
                }
            },

            {
                name:"admin.products.create",
                path:"products/create",
                component:ProductsCreate,
                meta:{
                    middleware:["auth", "can:create product"],
                    title:`Product create`
                }
            },

        ]
    },

    {
        component:AuthLayout,
        path: '/auth',
        children: [
            {
                name:"login",
                path:"login",
                component:Login,
                meta:{
                    middleware:"guest",
                    title:`Login`
                }
            },

            {
                name:"register",
                path:"register",
                component:Register,
                meta:{
                    middleware:"guest",
                    title:`Register`
                }
            }
        ]

    },

    {
        path: '/',
        component: GeneralLayout,
        children: [
            {
                path: '',
                component: Home
            },
            {
                path: '/home',
                component: Home,
                meta: {

                },
            },

            {
                path: '/cart',
                component: Cart,
                name:'cart.index',
            },

            {
                path: 'checkout',
                component: Checkout,
                name:'checkout.index',
            },


            {
                path: '/products/:id',
                component: ProductsShow,
                name:'products.show',
            },

            {
                path: '/products',
                component: ProductsIndex,
                name:'products.index',
            },
        ],
    },
    {
        path: '/account',
        meta:{
            middleware:["auth"]
        },
        component: GeneralLayout,
        children: [
            {
                path: 'wishlist',
                component: Wishlist
            },
        ],
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
