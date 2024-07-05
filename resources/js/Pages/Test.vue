<script setup>
import { mapActions } from 'vuex'
import { computed } from 'vue'
import store from "@/store/index.js";

const user = computed(() => this.$store.state.auth.user);

const { signOut } = mapActions(['logout']);


const logout = async () => {
    try {
        const { data } = await axios.post('/logout');
        signOut();
        this.$router.push({ name: "login" });
    } catch (error) {
        console.error(error);
    }
};

const my = (()=>{
    console.log('my аука');

    axios.get('/api/my').then((response)=>{
        console.log(response);
    })
})

</script>


<template>
    <h1>I'm here to test!</h1>

    <button @click="my">My</button>
</template>

<style scoped>

</style>
