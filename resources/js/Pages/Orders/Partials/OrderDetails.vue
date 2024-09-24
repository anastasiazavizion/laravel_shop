<script setup>
import ThankYouDetails from "@/Pages/Cart/Partials/ThankYouDetails.vue";
import StatusLabel from "@/Pages/Orders/Partials/StatusLabel.vue";
const props = defineProps({
    order:Object
})

console.log(props.order);


</script>

<template>
    <p class="text-lg font-bold">Order Info</p>
    <ThankYouDetails label="Total">{{order.total}}</ThankYouDetails>
    <ThankYouDetails label="Status">
      <StatusLabel :status="order.status"/>
    </ThankYouDetails>
</template>
