<template>
    <Header>Login</Header>
   <Card>
       <form @submit.prevent="login" method="post">
           <div>
               <label for="email">Email</label>
               <input type="text" v-model="auth.email" name="email" id="email">
               <Errors :errors="errors.email"/>
           </div>
           <div>
               <label for="password">Password</label>
               <input type="password" v-model="auth.password" name="password" id="password">
           </div>

           <div><PrimaryButton type="submit">Login</PrimaryButton></div>

           <div v-if="errorsAuth" class="text-red-600 font-bold">
               Something is wrong...
           </div>
       </form>
   </Card>
</template>

<script setup>
import {mapActions, useStore} from 'vuex'
import {ref} from "vue";
import {useRouter} from "vue-router";
import Errors from "@/Components/Errors.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";

const router = useRouter();
const store = useStore();

const auth = ref({
    email: "",
    password: ""
});
const errors = ref([]);
const errorsAuth = ref(false);

const login = async () => {
    errorsAuth.value = false;
    errors.value = [];
    try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/login', auth.value);
        await store.dispatch('auth/login');
        router.push('/admin/dashboard');
    } catch (error) {
        if (error.response && (error.response.status === 422)) {
            errors.value = error.response.data.errors;
        }else if(error.response.status === 401){
            errorsAuth.value = true;
        }else {
            console.error('An error occurred during the login process:', error);
        }
    }
};
</script>
