<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import {ShoppingCartIcon} from "@heroicons/vue/20/solid/index.js";
import {computed} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";

const store = useStore();

const contCartItems = computed(()=>{
    return store.getters['cart/countCartItems']
})

const authenticated = computed(()=>{
    return store.getters['auth/authenticated']
})

const user = computed(()=>{
    return store.getters['auth/user']
})

const router = useRouter();

const logout = async () => {
    try {
        await store.dispatch('auth/logout');
        await router.push('/auth/login');
    } catch (error) {
        console.error(error);
    }
};

const props = defineProps({
    mobile:{
        type:Boolean,
        default:false
    }
})

const routerLinkClass = computed(()=>{
    if(props.mobile){
        return 'w-full block mb-2 mt-2';
    }
    return '';
})
</script>

<template>
    <router-link :class="routerLinkClass" to="/home">Home</router-link>

    <div v-if="(is('admin') || is('moderator')) && authenticated">
        <Dropdown :mobile="mobile" v-if="authenticated" title="Products managing">
            <DropdownLink to="/admin/products">All Products</DropdownLink>
            <DropdownLink v-if="can('create product')" to="/admin/products/create">Create Product</DropdownLink>
        </Dropdown>

        <Dropdown :mobile="mobile"  v-if="authenticated" title="Categories managing">
            <DropdownLink to="/admin/categories">All Categories</DropdownLink>
            <DropdownLink v-if="can('create category')" to="/admin/categories/create">Create Category</DropdownLink>
        </Dropdown>
    </div>

    <router-link v-if="authenticated" :class="routerLinkClass" :to="{name:'user.orders'}">My Orders</router-link>
    <router-link v-if="is('admin') && authenticated" :class="routerLinkClass" :to="{name:'admin.orders.index'}">Orders</router-link>
    <router-link :class="routerLinkClass" :to="{name:'products.index'}">Products</router-link>
    <router-link :class="routerLinkClass" v-if="!authenticated" to="/auth/login">Login</router-link>
    <router-link :class="routerLinkClass"  v-if="!authenticated" to="/auth/register">Register</router-link>

    <Dropdown :mobile="mobile" :title="user.name" v-if="authenticated">
        <DropdownLink v-if="is('admin')" :to="{name:'admin.dashboard'}">Admin panel</DropdownLink>

        <DropdownLink :to="{name:'user.wishlist'}">
                Wishlist
        </DropdownLink>

        <DropdownLink @click.prevent="logout" to="#">Logout</DropdownLink>
    </Dropdown>

    <router-link :class="routerLinkClass" class="relative" :to="{name:'cart.index'}">
        <ShoppingCartIcon :class="{'mt-4':mobile}"  class="h-6"/>
        <span class="cart-product-amount">{{contCartItems}}</span>
    </router-link>
</template>
