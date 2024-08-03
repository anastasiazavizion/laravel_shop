<script setup>
import {useStore} from "vuex";
import {onMounted, ref} from "vue";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";
const store = useStore();
const products = ref([]);
const links = ref([]);

async function getData() {
    await store.dispatch('product/wishes');
    products.value = store.getters['product/wishes'];
    links.value = store.getters['product/wishes_links'];
}
onMounted(async () => {
    await getData();
})

async function getWishes(url){
    if(url !== null){
        try {
            await store.dispatch('product/wishes', {url:url});
            products.value = store.getters['product/wishes'];
            links.value = store.getters['product/wishes_links'];
        } catch (error) {
            console.error(error);
        }
    }
}

async function deleteWishListProductFromProducts() {
    await getData();
}
</script>

<template>
    <AllProducts @delete-wishlist-product-from-products="deleteWishListProductFromProducts"  :products="products" label="Wishlist"></AllProducts>
    <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
        <a  @click.prevent="getWishes(link.url)" v-if="links.length > 3" :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"  v-html="link.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link.url ? link.url : ''"/>
    </div>
</template>
