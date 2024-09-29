<script setup>
import {computed, onMounted, ref, watch} from "vue";
import {useStore} from "vuex";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";
import {useRoute} from "vue-router";
import LoadingButton from "@/Components/LoadingButton.vue";
import SearchForm from "@/Components/SearchForm.vue";
import {FunnelIcon} from '@heroicons/vue/24/outline'

const products = computed(() => {
    return store.getters['product/products'];
})

const links = computed(() => {
    return store.getters['product/links'];
})

const store = useStore();
const route = useRoute();
const loading = ref(true);

const filters = ref({
    search:null,
    categories:[],
    categoryName:route.params.categoryName,
});

const loadProducts = async (url = null) => {
    loading.value = true;
    await store.dispatch('product/getAll', {url:url, filters:filters.value});
    loading.value = false;
};

const categories = computed(() => {
    return store.getters['category/categories'];
})

onMounted(async () => {
    await loadProducts();
    await store.dispatch('category/getAll', {group: true});

})

watch(route, () => {
    filters.value.categoryName = route.params.categoryName;
    loadProducts();
});

const handleKeyup = (str) => {
    filters.value.search = str;
};

const handleCkbx = (id) => {
    const index = filters.value.categories.indexOf(id);
    if (index === -1) {
        filters.value.categories.push(id);
    } else {
        filters.value.categories.splice(index, 1);
    }
};

function getUrl(url) {
    if (import.meta.env.VITE_APP_ENV === 'production') {
        return url.replace(/http:/g, "https:");
    }
    return url;
}

import CategoryInfo from "@/Pages/Product/Partials/CategoryInfo.vue";
import Form from "@/Pages/Admin/Products/Partials/Form.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const showFilters = ref(false);

function applyFilters() {
    loadProducts();
}

</script>

<template>

    <div class="cursor-pointer" @click="showFilters = !showFilters" >
        <FunnelIcon  class="h-6 mr-2 filter-icon"/>
        <span class="text-lg text-slate-800">Filters</span>
    </div>

    <div v-if="showFilters" class="p-4 bg-white rounded-lg shadow-md mt-4">
        <form class="product-filter-form" @submit.prevent="applyFilters">
            <div class="mb-4">
                <CategoryInfo :checked-categories="filters.categories" :category-name="filters.categoryName ?? ''" @handle-ckbx="handleCkbx" :categories="categories"/>
            </div>

            <div class="mb-4">
                <SearchForm :value="filters.search" @handle-keyup="handleKeyup"></SearchForm>
            </div>

            <div class="mb-4">
                <PrimaryButton>Apply Filters</PrimaryButton>
            </div>

        </form>
    </div>

    <div v-if="!loading">
        <div v-if="products.length > 0">
            <AllProducts :products="products"/>
            <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
                <a @click.prevent="loadProducts(getUrl(link.url))" v-if="links.length > 3"
                   :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"
                   v-html="link.label" class="pagination-link" v-for="(link,index) in links" :key="index"
                   :href="link.url ? getUrl(link.url) : ''"/>
            </div>
        </div>
    </div>
    <div v-else>
        <LoadingButton/>
    </div>
    <div v-if="!loading && products.length === 0"><p>No products...</p></div>
</template>
