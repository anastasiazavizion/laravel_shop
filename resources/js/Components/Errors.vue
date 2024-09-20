<script setup>
defineProps({
    errors:Array
})
</script>
<template>
<div class="error" v-for="error in errors">
    {{error}}
</div>
</template>
