<script setup>
const props = defineProps({
    admin:{
        type:Boolean,
        default:false
    }
})
</script>

<template>
    <thead>
    <tr>
        <th>#Id</th>
        <th>Name</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Phone</th>
        <th>City</th>
        <th>Total</th>
        <th>Date</th>
        <th>Status</th>
        <th></th>
        <th v-if="admin && can('delete order')"></th>
    </tr>
    </thead>
</template>

<style scoped>

</style>
