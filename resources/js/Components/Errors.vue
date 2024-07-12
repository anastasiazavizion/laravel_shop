<script setup>
defineProps({
    errors:Array
})
</script>
<template>
<div class="text-red-600 font-bold" v-for="error in errors">
    {{error}}
</div>
</template>
