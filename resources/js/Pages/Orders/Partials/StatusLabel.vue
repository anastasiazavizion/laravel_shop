<script setup>
defineProps({
    status:Object
})
</script>

<template>
    <div class="p-1 text-white rounded-md w-24 text-center" :style="{'background-color':status.color}">
        {{status.name}}
    </div>
</template>
