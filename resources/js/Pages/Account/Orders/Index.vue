<script setup>
import OrdersList from "@/Pages/Orders/Partials/OrdersList.vue";
import {computed, ref} from "vue";
import {useStore} from "vuex";
const store = useStore();

const user = computed(()=>{
    return store.getters['auth/user'];
})
</script>
<template>
    <OrdersList :user="user"/>
</template>
