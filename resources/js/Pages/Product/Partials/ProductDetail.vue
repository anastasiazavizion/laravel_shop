<script setup>
defineProps({
    label:{
        type:String,
        default:''
    }
})
</script>

<template>
    <div :class="{'grid grid-cols-2':label}">
        <div v-if="label" class="font-bold text-gray-700 pr-2">{{label}}:</div>
        <div class="text-gray-600 dark:text-gray-300"><slot></slot></div>
    </div>
</template>
