<script setup>
defineProps({
    images:Array
})
</script>

<template>
    <swiper-container navigation="true" loop="true">
        <swiper-slide navigation v-for="image in images">
            <img :src="image"  alt="">
        </swiper-slide>
    </swiper-container>
</template>

<style scoped>

</style>
