<script setup>
import StatusLabel from "@/Pages/Orders/Partials/StatusLabel.vue";
import Price from "@/Components/Price.vue";
import Details from "@/Components/Details.vue";
const props = defineProps({
    order:Object
})
</script>

<template>
    <p class="text-lg font-bold">Order Info</p>
    <Details label="Total"><Price>{{order.total}}</Price></Details>
    <Details label="Status">
      <StatusLabel :status="order.status"/>
    </Details>
</template>
