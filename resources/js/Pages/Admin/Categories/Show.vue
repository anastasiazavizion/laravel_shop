<script setup>
import {onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
const router = useRouter();
const store = useStore();
const category = ref(null);
const route = useRoute();
const payload = {
    id: route.params.id
};
onMounted(async () => {
    await store.dispatch('category/getCategory', payload);
    category.value = await store.getters['category/category'];
})
</script>

<template>
    <Header v-if="category">{{category.name}}</Header>
    <Card>
       Category info...
    </Card>
</template>
