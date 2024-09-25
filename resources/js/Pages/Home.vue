<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";

import Header from "@/Components/Header.vue";
import CategoryLabel from "@/Pages/Category/Partials/CategoryLabel.vue";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";
import LoadingButton from "@/Components/LoadingButton.vue";

const categories = computed(()=>{
    return store.getters['category/categories'];
})

const products = computed(()=>{
    return store.getters['product/products'];
})

const store = useStore();
const loading = ref(true);

onMounted(async () => {
    loading.value = true;
    await store.dispatch('category/getAll');
    await store.dispatch('product/getAll');
    loading.value = false;

})

</script>

<template>
    <div v-if="!loading">
        <Header>Top Categories</Header>
        <div>
            <div class="grid grid-cols-2 sm:grid-cols-6 gap-4">
                <CategoryLabel :category="category" v-for="category in categories" />
            </div>
        </div>

        <div class="mt-4">
            <AllProducts label="Top Products" :products="products"/>
        </div>
    </div>
    <div v-else>
        <LoadingButton/>
    </div>
</template>
