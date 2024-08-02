<script setup>
import Header from "@/Components/Header.vue";
import Price from "@/Components/Price.vue";
import {useStore} from "vuex";

const props = defineProps({
    products:Array,
    label:String
})

const store = useStore();

const label = props.label ?? 'Products';

function productUrl(product){
    return {name:'products.show', params:{id:product.id}};
}

async function addToCart(product) {
    await store.dispatch('cart/addToCart', product);
}

</script>

<template>
    <Header>{{label}}</Header>
    <div v-if="products" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div v-for="product in products" class="bg-white rounded-lg shadow-lg overflow-hidden dark:bg-gray-700">
            <div>
                <router-link :to="productUrl(product)"><img class="object-cover h-64 w-full" :src="product.thumbnail_url" :alt="product.title" /></router-link>
            </div>
            <div class="flex flex-col gap-1 mt-4 px-4">
                <h2 class="h-16 text-lg font-semibold text-gray-800">
                    <router-link :to="productUrl(product)">{{product.title}}</router-link>
                </h2>
                <span class="font-semibold text-gray-800"><Price>{{product.price}}</Price></span>
            </div>
            <div class="mt-4 p-4 border-t border-gray-200">
                <button @click="addToCart(product)" class="btn btn-style">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
    <div v-else>No products...</div>
</template>
