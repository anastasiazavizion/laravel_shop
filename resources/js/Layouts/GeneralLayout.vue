<script setup>
import {useStore} from "vuex";
const store = useStore();
import {useRouter} from "vue-router";
import {computed, ref} from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
const router = useRouter();

const logout = async () => {
    try {
        await store.dispatch('auth/logout');
        await router.push('/auth/login');
    } catch (error) {
        console.error(error);
    }
};
const user = computed(()=>{
    return store.getters['auth/user']
})

const contCartItems = computed(()=>{
    return store.getters['cart/countCartItems']
})


const authenticated = computed(()=>{
    return store.getters['auth/authenticated']
})
const showingNavigationDropdown = ref(false);

import {ShoppingCartIcon} from "@heroicons/vue/20/solid";


</script>

<template>
    <div>
        <div class="min-h-screen">
            <nav class="bg-black text-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex justify-center items-center">
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center sm:justify-center">
                                <router-link  to="/home">Home</router-link>
                                <router-link  :to="{name:'products.index'}">Products</router-link>
                                <router-link v-if="!authenticated" to="/auth/login">Login</router-link>
                                <router-link  v-if="!authenticated" to="/auth/register">Register</router-link>
                                <Dropdown :title="user.name" v-if="authenticated">
                                    <DropdownLink>
                                        <router-link to="/account/wishlist">Wishlist</router-link>
                                    </DropdownLink>
                                    <DropdownLink  @click.prevent="logout" to="#">Logout</DropdownLink>
                                </Dropdown>

                                <router-link class="relative" :to="{name:'cart.index'}"><ShoppingCartIcon class="h-6"/>
                                 <span class="cart-product-amount">{{contCartItems}}</span>
                                </router-link>

                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-white focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <router-link to="/home">Home</router-link>
                    </div>
                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                <!--                                {{ $page.props.auth.user.name }}-->
                            </div>
                            <div class="font-medium  text-gray-500"><!--{{ $page.props.auth.user.email }}--></div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a v-if="authenticated" @click.prevent="logout" href="/logout">Logout</a>
                            <router-link v-if="!authenticated" to="/auth/login">Login</router-link>
                        </div>
                    </div>
                </div>
            </nav>
            <main class="container mx-auto p-4 max-w-7xl">
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>
