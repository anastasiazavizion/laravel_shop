<script setup>
import {useRoute} from "vue-router";
import Header from "@/Components/Header.vue";
import OrderInfo from "@/Pages/Orders/Partials/OrderInfo.vue";
const route = useRoute();
</script>
<template>
    <Header>Order #{{route.params.id}}</Header>
    <OrderInfo/>
</template>
