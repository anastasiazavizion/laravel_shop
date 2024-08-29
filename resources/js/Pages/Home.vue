<script setup>
import {onMounted, ref} from "vue";

const categories = ref([]);
const products = ref([]);
const store = useStore();

onMounted(async () => {
    await store.dispatch('category/getAll');
    categories.value = store.getters['category/categories'];

    await store.dispatch('product/getAll');
    products.value = store.getters['product/products'];
})
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import CategoryLabel from "@/Pages/Category/Partials/CategoryLabel.vue";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";




</script>

<template>
    <Header>Top Categories</Header>
    <div>
        <div class="grid grid-cols-2 sm:grid-cols-6 gap-4">
            <CategoryLabel :category="category" v-for="category in categories" />
        </div>
    </div>

   <div class="mt-4">
       <AllProducts label="Top Products" :products="products"/>
    </div>
</template>
