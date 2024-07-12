<script setup>
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
const store = useStore();

import axios from "axios";


onMounted(async () => {
    const response = await axios.get('/user');
})


</script>

<template>
    <Header>Admin panel</Header>

</template>

<style scoped>

</style>
