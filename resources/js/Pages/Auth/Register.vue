<script setup>
import {useStore} from 'vuex'
import { ref } from 'vue'
import {useRouter} from "vue-router";

import Card from '@/Components/Card.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Header from "@/Components/Header.vue";
import Errors from "@/Components/Errors.vue";

const form = ref({
    name: "",
    lastname: "",
    password: "",
    password_confirmation: "",
    phone: "",
    email: "",
    birthday:""
});

const errors = ref([]);
const router = useRouter();
const store = useStore();

const register = async () => {
    axios.post('/register', form.value)
        .then(async function (response) {
            await store.dispatch('auth/login');
            await router.push('/admin/dashboard');
        })
        .catch(function (error) {
            if(error.response.status === 422){
                errors.value = error.response.data.errors;
            }
        });
};

</script>
<template>
    <Header>Register</Header>
    <Card>
        <form @submit.prevent="register">
            <div>
                <label>Name</label>
                <input type="text" v-model="form.name" name="name" id="name" class="form-control">
                <Errors :errors="errors.name"/>
            </div>

            <div>
                <label>Lastname</label>
                <input type="text" v-model="form.lastname" name="lastname" id="lastname" class="form-control">
                <Errors :errors="errors.lastname"/>
            </div>

            <div>
                <label>Birthday</label>
                <input type="text" v-model="form.birthday" name="birthday" id="birthday" class="form-control">
                <Errors :errors="errors.birthday"/>
            </div>

            <div>
                <label>Phone</label>
                <input type="text" v-model="form.phone" name="phone" id="phone" class="form-control">
                <Errors :errors="errors.phone"/>
            </div>

            <div>
                <label>Email</label>
                <input type="email" v-model="form.email" name="email" id="email" class="form-control">
                <Errors :errors="errors.email"/>
            </div>

            <div>
                <label>Password</label>
                <input type="password" v-model="form.password" name="password" id="password" class="form-control">
                <Errors :errors="errors.password"/>
            </div>

            <div>
                <label>Confirm Password</label>
                <input type="password" v-model="form.password_confirmation" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton type="submit">Register</PrimaryButton>
            </div>
        </form>
    </Card>
</template>
