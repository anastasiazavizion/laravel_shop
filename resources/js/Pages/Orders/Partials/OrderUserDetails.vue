<script setup>
import ThankYouDetails from "@/Pages/Cart/Partials/ThankYouDetails.vue";
defineProps({
    order:Object
})
</script>

<template>
    <p class="text-lg font-bold">User Info</p>
    <ThankYouDetails label="Name">{{order.name}}</ThankYouDetails>
    <ThankYouDetails label="Lastname">{{order.lastname}}</ThankYouDetails>
    <ThankYouDetails label="Phone">{{order.phone}}</ThankYouDetails>
    <ThankYouDetails label="Email">{{order.email}}</ThankYouDetails>
    <ThankYouDetails label="City">{{order.city}}</ThankYouDetails>
    <ThankYouDetails label="Address">{{order.address}}</ThankYouDetails>
</template>
