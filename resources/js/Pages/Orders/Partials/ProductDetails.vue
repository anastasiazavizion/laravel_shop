<script setup>
import Price from "@/Components/Price.vue";

defineProps({
    order:Object
})
function productTotalPrice(product){
    return product.single_price * product.quantity;
}

function productUrl(product){
    return '/products/'+product.id;
}
</script>

<template>
    <p class="text-lg font-bold">Product details</p>
    <table class="w-full">
        <thead>
        <tr>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <tr :key="product.id" v-for="product in order.products">
            <td>
                <router-link :to="productUrl(product)">
                    <img class="w-24" :src="product.thumbnail_url" :alt="product.name">
                </router-link>
            </td>
            <td>{{product.quantity}}</td>
            <td><Price>{{product.single_price}}</Price></td>
            <td><Price>{{productTotalPrice(product)}}</Price></td>
        </tr>
        </tbody>
    </table>
</template>
