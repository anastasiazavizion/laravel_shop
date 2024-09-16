<script setup>
import {onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";

const router = useRouter();
const store = useStore();

const product = ref(null);
const route = useRoute();

const payload = {
    id: route.params.id
};

onMounted(async () => {
    await store.dispatch('product_admin/getProduct', payload);
    product.value = await store.getters['product_admin/product'];
})

</script>

<template>
    <Header v-if="product">{{product.title}}</Header>
    <Card v-if="product">
       <div class="">
           <div>SKU</div>
           <div>{{product.SKU}}</div>
       </div>
        <div class="">
            <div>Description</div>
            <div>{{product.description}}</div>
        </div>
        <div class="">
            <div>Price</div>
            <div>{{product.price}}</div>
        </div>
        <div class="">
            <div>Discount</div>
            <div>{{product.discount}}</div>
        </div>
        <div class="">
            <div>Quantity</div>
            <div>{{product.quantity}}</div>
        </div>
    </Card>
</template>

<style scoped>

</style>
