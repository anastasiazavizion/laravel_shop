<script setup>
import {onMounted, ref, watch} from "vue";
import {useStore} from "vuex";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";
import {useRoute} from "vue-router";
import LoadingButton from "@/Components/LoadingButton.vue";

const products = ref([]);
const links = ref([]);
const store = useStore();
const route = useRoute();
const loading = ref(true);

const loadProducts = async (url = null) => {
    const categoryName = route.params.categoryName || null;
    await store.dispatch('product/getAll', { url, categoryName });
    products.value = await store.getters['product/products'];
    links.value = await store.getters['product/links'];
    loading.value = false;
};

onMounted(() => {
    loadProducts();
});

watch(route, () => {
    loadProducts();
});
</script>

<template>
    <div v-if="!loading">
        <div v-if="products.length > 0">
            <AllProducts  :products="products"/>
            <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
                <a  @click.prevent="loadProducts(link.url)" v-if="links.length > 3" :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"  v-html="link.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link.url ? link.url : ''"/>
            </div>
        </div>
    </div>
    <div v-else>
        <LoadingButton/>
    </div>
    <div v-if="!loading && products.length === 0"><p>No products...</p></div>
</template>
