<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import {ShoppingCartIcon} from "@heroicons/vue/20/solid/index.js";
import {computed} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";

const store = useStore();

const contCartItems = computed(() => {
    return store.getters['cart/countCartItems']
})

const authenticated = computed(() => {
    return store.getters['auth/authenticated']
})

const user = computed(() => {
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
    mobile: {
        type: Boolean,
        default: false
    }
})

const routerLinkClass = computed(() => {
    if (props.mobile) {
        return 'w-full block mb-2 mt-2';
    }
    return '';
})

const emits = defineEmits(['close-dropdown']);
function closeDropdown(){
    emits('close-dropdown');
}

</script>

<template>

    <div class="sm:flex sm:gap-8 sm:justify-center sm:align-items-center">
        <router-link @click="closeDropdown" class="routerLinkClass" to="/home">Home</router-link>

        <Dropdown  v-if="(is('admin') || is('moderator')) && authenticated" :mobile="mobile" title="Products managing">
            <DropdownLink @click="closeDropdown"to="/admin/products">All Products</DropdownLink>
            <DropdownLink @click="closeDropdown" v-if="can('create product')" to="/admin/products/create">Create Product</DropdownLink>
        </Dropdown>

        <Dropdown v-if="(is('admin') || is('moderator')) && authenticated" :mobile="mobile" title="Categories managing">
            <DropdownLink @click="closeDropdown"to="/admin/categories">All Categories</DropdownLink>
            <DropdownLink @click="closeDropdown"v-if="can('create category')" to="/admin/categories/create">Create Category</DropdownLink>
        </Dropdown>

        <router-link @click="closeDropdown"v-if="authenticated" :class="routerLinkClass" :to="{name:'user.orders'}">My Orders</router-link>
        <router-link @click="closeDropdown"v-if="is('admin') && authenticated" :class="routerLinkClass" :to="{name:'admin.orders.index'}">
            Orders
        </router-link>
        <router-link @click="closeDropdown":class="routerLinkClass" :to="{name:'products.index'}">Products</router-link>
        <router-link @click="closeDropdown":class="routerLinkClass" v-if="!authenticated" to="/auth/login">Login</router-link>
        <router-link @click="closeDropdown":class="routerLinkClass" v-if="!authenticated" to="/auth/register">Register</router-link>

        <Dropdown :mobile="mobile" :title="user.name" v-if="authenticated">
            <DropdownLink @click="closeDropdown" v-if="is('admin')" :to="{name:'admin.dashboard'}">Admin panel</DropdownLink>

            <DropdownLink @click="closeDropdown":to="{name:'user.wishlist'}">
                Wishlist
            </DropdownLink>

            <DropdownLink @click="closeDropdown"@click.prevent="logout" to="#">Logout</DropdownLink>
        </Dropdown>
    </div>

    <div>
        <router-link @click="closeDropdown" :class="routerLinkClass" class="relative ml-auto" :to="{name:'cart.index'}">
            <ShoppingCartIcon :class="{'mt-4':mobile}" class="h-6"/>
            <span class="cart-product-amount">{{ contCartItems }}</span>
        </router-link>
    </div>


</template>
