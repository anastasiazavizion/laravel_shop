<script setup>
import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";
import AllProducts from "@/Pages/Product/Partials/AllProducts.vue";
import LoadingButton from "@/Components/LoadingButton.vue";
const store = useStore();
const loading = ref(true);

const products = computed(()=>{
    return  store.getters['product/wishes'];
})

const links = computed(()=>{
    return  store.getters['product/wishes_links'];
})

async function getData(url) {
    loading.value = true;
    await store.dispatch('product/wishes', {url:url});
    loading.value = false;
}

onMounted(async () => {
    await getData();
})

async function deleteWishListProductFromProducts() {
    await getData();
}
</script>

<template>


   <div v-if="!loading">
       <AllProducts @delete-wishlist-product-from-products="deleteWishListProductFromProducts"  :products="products" label="Wishlist"></AllProducts>
       <div class="mt-8 flex gap-1 flex-wrap sm:flex-none" v-if="links.length > 3">
           <a  @click.prevent="getData(link?.url)" :class="{'pagination-link-active':link?.active, 'opacity-25':!link?.url, 'bg-white': !link?.active}"  v-html="link?.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link?.url ? link?.url : ''"/>
       </div>
   </div>
    <div v-else>
        <LoadingButton/>
    </div>
</template>
