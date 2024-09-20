<script setup>
defineProps({
    category:Object
})
</script>
<template>
    <router-link class="border border-slate-300 p-2 rounded-md text-center shadow-md flex items-center justify-center  leading-4"  :to="{name:'products.category', params:{categoryName:category.slug}}">{{category.name}}</router-link>
</template>
