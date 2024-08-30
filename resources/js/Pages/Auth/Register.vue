<script setup>
import {useStore} from 'vuex'
import {computed, onMounted, ref} from 'vue'
import {useRouter} from "vue-router";

import Card from '@/Components/Card.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Header from "@/Components/Header.vue";
import Errors from "@/Components/Errors.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

const router = useRouter();
const store = useStore();

onMounted(async () => {
    await store.dispatch('auth/clearErrors');
})

const form = ref({
    name: "",
    lastname: "",
    password: "",
    password_confirmation: "",
    phone: "",
    email: "",
    birthday:""
});

const errors = computed(()=>{
    return store.getters['auth/errors'];
})

const register = async () => {
    await store.dispatch('auth/register', form.value);
    if(!errors.value){
        await router.push('/');
    }
};

</script>
<template>
    <Header>Register</Header>
    <Card>
        <form @submit.prevent="register">
            <div>
                <label>Name</label>
                <input type="text" v-model="form.name" name="name" id="name" class="form-control">
                <Errors v-if="errors" :errors="errors.name"/>
            </div>

            <div>
                <label>Lastname</label>
                <input type="text" v-model="form.lastname" name="lastname" id="lastname" class="form-control">
                <Errors v-if="errors" :errors="errors.lastname"/>
            </div>

            <div>
                <label>Birthday</label>
                <VueDatePicker :enable-time-picker="false" v-model="form.birthday" name="birthday" id="birthday" class="form-control" />
                <Errors v-if="errors" :errors="errors.birthday"/>
            </div>

            <div>
                <label>Phone</label>
                <input type="text" v-model="form.phone" name="phone" id="phone" class="form-control">
                <Errors v-if="errors" :errors="errors.phone"/>
            </div>

            <div>
                <label>Email</label>
                <input type="email" v-model="form.email" name="email" id="email" class="form-control">
                <Errors v-if="errors" :errors="errors.email"/>
            </div>

            <div>
                <label>Password</label>
                <input type="password" v-model="form.password" name="password" id="password" class="form-control">
                <Errors v-if="errors" :errors="errors.password"/>
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
