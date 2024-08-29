<script setup>
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import OrderTableRow from "@/Pages/Admin/Orders/Partials/OrderTableRow.vue";
import OrderTableHeader from "@/Pages/Admin/Orders/Partials/OrderTableHeader.vue";
import Card from "@/Components/Card.vue";
import ProductLink from "@/Pages/Admin/Products/Partials/ProductLink.vue";

const route = useRoute();
const store = useStore();
const order = ref(null);

onMounted(async () => {
    const id = route.params.id;
    await store.dispatch('order_admin/getOrder', {id:id});
    order.value = await store.getters['order_admin/order'];
})
</script>

<template>
<div v-if="order">
    <Header>Order #{{order.id}}</Header>

    <table class="w-full">
        <OrderTableHeader/>
        <tbody>
        <OrderTableRow :order="order"/>
        </tbody>
    </table>

    <Card class="mt-4">
       <Header>Orders Products</Header>
        <div :key="product.id" v-for="product in order.products">
            <div class="flex justify-between mb-4">
                <div><ProductLink :product="product"/></div>
                <div>{{product.quantity}}</div>
                <div>{{product.single_price}}</div>
            </div>
        </div>
    </Card>

    <Card class="mt-4">
        <Header>Orders Transaction</Header>
        <div class="flex justify-between mb-4">
            <div>{{order.transaction.payment_system}}</div>
            <div>{{order.transaction.status}}</div>
        </div>
    </Card>

</div>
</template>
