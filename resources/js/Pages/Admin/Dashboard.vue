<script setup>
import {computed, nextTick, onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import loadTelegramWidget from "@/hooks/telegramWidget.js";
const store = useStore();

const user = ref(null);

onMounted(async () => {
    await store.dispatch('user/getUser');
    user.value = await computed(()=>{
        return store.getters['user/user'];
    })
    await nextTick();
    loadTelegramWidget();
})
</script>

<template>
    <Header>Admin panel</Header>
    <div v-if="is('admin') && (user && !user.telegram_id)" id="telegram-widget-container"></div>
    <div>
        Info
    </div>
</template>
