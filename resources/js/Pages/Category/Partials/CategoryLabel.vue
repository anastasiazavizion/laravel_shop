<script setup>
defineProps({
    category:Object
})
</script>
<template>
    <router-link class="border border-slate-300 p-2 rounded-md text-center shadow-md"  :to="{name:'products.category', params:{categoryName:category.slug}}">{{category.name}}</router-link>
</template>
