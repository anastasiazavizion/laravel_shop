<script setup>
import { computed, useSlots } from 'vue';
const props = defineProps({
    price:{
        type:[String, Number]
    }
})
// Access slot content
const slots = useSlots();

// Compute formatted value from slot content
const formattedValue = computed(() => {
    if(props.price){
        return Number(props.price).toFixed(2);
    }else{
        // Extract content from the default slot
        const slotContent = slots.default ? slots.default()[0].children : '';
        // Ensure content is a number and format it
        return !isNaN(Number(slotContent)) ? Number(slotContent).toFixed(2) : '';
    }
});
</script>

<template>
    <span>$ {{ formattedValue }}</span>
</template>
