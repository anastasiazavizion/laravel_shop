<script setup>
defineProps({
    product:Object
})
</script>

<template>
    <router-link :to="{name:'admin.products.show', params:{id:product.id}}">{{product.title}}</router-link>
</template>
