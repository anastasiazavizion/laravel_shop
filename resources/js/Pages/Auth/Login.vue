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

            <div class="flex items-center gap-4">
                <PrimaryButton type="submit">Login</PrimaryButton>
                <PrimaryButton class="bg-white text-black hover:bg-slate-100 hover:text-black border border-slate-300" type="button" @click="useAuthProvider('google', null)">
                    <GoogleIcon/>
                    Continue with Google
                </PrimaryButton>
            </div>

            <div v-if="errors.auth" class="text-red-600 font-bold">
                Something is wrong...
            </div>
        </form>
    </Card>
</template>

<script setup>
import {useStore} from 'vuex'
import {computed, onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import Errors from "@/Components/Errors.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Card from "@/Components/Card.vue";
import Header from "@/Components/Header.vue";
import GoogleIcon from "@/Components/Icons/GoogleIcon.vue";

const router = useRouter();
const store = useStore();

onMounted(async () => {
    await store.dispatch('auth/clearErrors');
})

const auth = ref({
    email: "",
    password: ""
});

const errors = computed(()=>{
    return store.getters['auth/errors'];
})

const errorsAuth = ref(false);

async function actionsAfterLogin() {
    await store.dispatch('cart/setExistingCartItemsForUser');
    await store.dispatch('cart/getCartItemsForUser');
    await router.push('/');
}
const login = async () => {
    errorsAuth.value = false;
    await axios.get('/sanctum/csrf-cookie');
    await store.dispatch('auth/login', auth.value);
    if(Object.keys(errors.value).length === 0){
      await actionsAfterLogin();
    }
}

import {Providers} from 'universal-social-auth'
import {getCurrentInstance} from 'vue'
const globalProperties = getCurrentInstance()
const box = globalProperties.appContext.config.globalProperties

const perData = {provider: '', code: ''}

const responseData = ref(perData)
const hash = ref('')
const data = ref({tok: ''})

function useAuthProvider(provider, proData) {
    const ProData = proData || Providers[provider]
    box.$Oauth
        .authenticate(provider, ProData)
        .then((response) => {
            const rsp = response
            if (rsp.code) {
                responseData.value.code = rsp.code
                responseData.value.provider = provider
                useSocialLogin()
            }
        })
        .catch((err) => {
            console.log(err);
            errors.value = {auth:true};
        })
}

function useSocialLogin() {
    const pdata = {code: responseData.value.code, otp: data.value.tok, hash: hash.value}
    box.$axios
        .post(route('v1.auth.social.callback',responseData.value.provider), pdata)
        .then(async (response) => {
            if (response.data.status === 444) {
                hash.value = response.data.hash
            } else if (response.data.status === 445) {
            } else {
                await store.dispatch('auth/userInfo');
                await actionsAfterLogin();
            }
        })
        .catch((err) => {
            console.log(err);
            errors.value = {auth:true};
        })
}
</script>
