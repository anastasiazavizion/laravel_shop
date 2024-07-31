<script setup>
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";

const products = ref([]);
const links = ref([]);
const store = useStore();

onMounted(async () => {
    await store.dispatch('product/getAll');
    products.value = store.getters['product/products'];
    links.value = store.getters['product/links'];
})

async function getProducts(url){
    if(url !== null){
        try {
            await store.dispatch('product/getAll', url);
            products.value = store.getters['product/products'];
            links.value = store.getters['product/links'];
        } catch (error) {
            console.error(error);
        }
    }
}
</script>

<template>
    <AllProducts  :products="products"/>
    <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
        <a  @click.prevent="getProducts(link.url)" v-if="links.length > 3" :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"  v-html="link.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link.url ? link.url : ''"/>
    </div>
</template>
