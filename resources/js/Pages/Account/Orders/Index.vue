<script setup>
import OrdersList from "@/Pages/Orders/Partials/OrdersList.vue";
import {computed} from "vue";
import {useStore} from "vuex";
const store = useStore();

const user = computed(()=>{
    return store.getters['auth/user'];
})

console.log(user.value);


</script>

<template>
    <OrdersList :user="user"/>
</template>
