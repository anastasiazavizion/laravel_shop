<script setup>
defineProps({
    product:Object
})
const emits = defineEmits(['add-to-cart']);

</script>

<template>
    <button v-if="product.in_stock" @click="emits('add-to-cart', product)" class="btn btn-style">
        Add to Cart
    </button>
    <div v-else>
        <span class="bg-yellow-400 p-2 rounded-md text-white d-inline">Not in stock</span>
    </div>
</template>

<style scoped>

</style>
