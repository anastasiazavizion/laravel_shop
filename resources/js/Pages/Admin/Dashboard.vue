<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
const store = useStore();
import loadTelegramWidget from '../../hooks/telegramWidget.js';

const user = ref(null);

onMounted(async () => {
    loadTelegramWidget();
    await store.dispatch('user/getUser');
    user.value = computed(()=>{
        return store.getters['user/user'];
    })
})
</script>

<template>
    <Header>Admin panel</Header>
    <div v-if="is('admin') && (user && !user.telegram_id)" id="telegram-widget-container"></div>
</template>
