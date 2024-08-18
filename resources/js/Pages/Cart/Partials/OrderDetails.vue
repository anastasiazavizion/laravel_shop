<script setup>
import ThankYouDetails from "@/Pages/Cart/Partials/ThankYouDetails.vue";
defineProps({
    order:Object
})
</script>

<template>
    <p class="text-lg font-bold">Order Info</p>
    <ThankYouDetails label="Total">{{order.total}}</ThankYouDetails>
    <ThankYouDetails label="Status">{{order.status.name}}</ThankYouDetails>
</template>
