<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Login</h1>
                        <hr/>
                        <form action="javascript:void(0)" class="row" method="post">
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="text" v-model="auth.email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" v-model="auth.password" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" :disabled="processing" @click="login" class="btn btn-primary btn-block">
                                    {{ processing ? "Please wait" : "Login" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label>Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {mapActions, useStore} from 'vuex'
import {ref} from "vue";
import {useRouter} from "vue-router";
const router = useRouter();
const store = useStore();

const auth = ref({
    email: "",
    password: ""
});
const processing = ref(false);




const login = async () => {
    processing.value = true;
    try {
        await axios.get('/sanctum/csrf-cookie');
        // Send login request with auth data
        const response = await axios.post('/api/login', auth.value);
        const userData = response.data; // Assuming response contains user data

        // Dispatch login action to update Vuex store
        await store.dispatch('login'); // Pass user data to action

        // Redirect to target route upon successful login
        await router.push('/test');
    } catch (error) {
        console.log(error);
    } finally {
        processing.value = false;
    }
};


</script>
