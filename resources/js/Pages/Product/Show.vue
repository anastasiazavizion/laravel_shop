<script setup>
import Header from "@/Components/Header.vue";
import {computed, onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import {useStore} from "vuex";
import Price from "@/Components/Price.vue";
import ProductDetail from "@/Pages/Product/Partials/ProductDetail.vue";
import Slider from "@/Components/Slider.vue";
import CategoryLabel from "@/Pages/Category/Partials/CategoryLabel.vue";
import WishList from "@/Pages/Product/Partials/WishListButtons.vue";
import BuyButton from "@/Pages/Product/Partials/BuyButton.vue";

const product = ref(null);
const images = ref(null);
const route = useRoute();
const store = useStore();

const payload = {
    id: route.params.id
};

onMounted(async () => {
    await store.dispatch('product/getProduct', payload);
    const productData = await store.getters['product/product'];
    product.value = productData.data;
    images.value = productData.gallery;
})

async function addToCart(product) {
    await store.dispatch('cart/addToCart', product);
}


</script>
<template>
        <div v-if="product" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
               <Slider :images="images"/>
            </div>
            <div>
                <div>
                    <div class="flex justify-between">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{product.title}}</h2>
                        <WishList :product="product"></WishList>
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <ProductDetail label="SKU">{{product.SKU}}</ProductDetail>
                        <ProductDetail label="Quantity">{{product.quantity}}</ProductDetail>
                        <ProductDetail label="Categories">
                            <div class="grid grid-cols-2 gap-4">
                                <CategoryLabel :category="category" v-for="category in product.categories" />
                            </div>
                        </ProductDetail>
                        <ProductDetail v-if="product.description">{{product.description}}</ProductDetail>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-2">
                        <div  class="font-bold text-gray-700 pr-2">Price <Price>{{product.final_price}}</Price></div>
                        <BuyButton :product="product" @addToCart="addToCart"></BuyButton>
                    </div>
                </div>

            </div>

        </div>
</template>
