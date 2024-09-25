<script setup>
import Details from "@/Components/Details.vue";

defineProps({
    order:Object
})
</script>

<template>
    <p class="text-lg font-bold">User Info</p>
    <Details label="Name">{{order.name}}</Details>
    <Details label="Lastname">{{order.lastname}}</Details>
    <Details label="Phone">{{order.phone}}</Details>
    <Details label="Email">{{order.email}}</Details>
    <Details label="City">{{order.city}}</Details>
    <Details label="Address">{{order.address}}</Details>
</template>
