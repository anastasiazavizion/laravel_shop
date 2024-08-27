<script setup>
import {onMounted, ref, watch} from "vue";
import {useStore} from "vuex";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";
import {useRoute} from "vue-router";

const products = ref([]);
const links = ref([]);
const store = useStore();
const route = useRoute();

const loadProducts = async (url = null) => {
    const categoryName = route.params.categoryName || null;
    await store.dispatch('product/getAll', { url, categoryName });
    products.value = store.getters['product/products'];
    links.value = store.getters['product/links'];
};

onMounted(() => {
    loadProducts();
});

watch(route, () => {
    loadProducts();
});
</script>

<template>
    <AllProducts  :products="products"/>
    <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
        <a  @click.prevent="loadProducts(link.url)" v-if="links.length > 3" :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"  v-html="link.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link.url ? link.url : ''"/>
    </div>
</template>
