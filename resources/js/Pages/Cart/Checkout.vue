<script setup>
import {computed, onMounted, ref} from "vue";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import paypalFunction from "@/hooks/paypal.js";
import {useStore} from "vuex";
import Errors from "@/Components/Errors.vue";
import {useRoute} from "vue-router";
const store = useStore();

const user = computed(()=>{
    return store.getters['auth/user'];
})
const route = useRoute();

const id = route.params.id;

if(id){
    store.dispatch('order/deleteOrderByVendorOrderId', { id: id });
}

const errors = ref({});

const form = ref({
    name:user.value.name ?? null,
    lastname:user.value.lastname ?? null,
    email:user.value.email ?? null,
    phone:user.value.phone ?? null,
    address:null,
    city:null,
});

const emptyFields = ref([]);

const cartItems = computed(()=>{
    return store.getters['cart/cartItems']
})

const cartItemsNotEmpty = computed(()=>{
    return cartItems.value.length > 0;
})

function isEmptyField(field){
    return emptyFields.value.length > 0 && emptyFields.value.includes(field)
}

onMounted(()=>{
    if(cartItemsNotEmpty.value){
        paypalFunction(form, emptyFields,errors);
    }
});

function getInputStyle(field){
    return {border: isEmptyField(field) ? '2px solid red' : '1px solid gray'};
}
</script>

<template>

 <Header>Checkout</Header>
   <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" v-if="cartItemsNotEmpty">
       <div>
           <Card>
           <form>
               <div>
                   <label for="name">Name</label>
                   <input :style="getInputStyle('name')" v-model="form.name" type="text" name="name" id="name" class="form-control">
                   <Errors :errors="errors.name"/>
               </div>

               <div>
                   <label for="lastname">Lastname</label>
                   <input :style="getInputStyle('lastname')"  v-model="form.lastname" type="text" name="lastname" id="lastname" class="form-control">
                   <Errors :errors="errors.lastname"/>
               </div>

               <div>
                   <label for="email">Email</label>
                   <input :style="getInputStyle('email')" v-model="form.email" type="text" name="email" id="email" class="form-control">
                   <Errors :errors="errors.email"/>
               </div>

               <div>
                   <label for="email">Phone</label>
                   <input :style="getInputStyle('phone')" v-model="form.phone" type="text" name="phone" id="phone" class="form-control">
                   <Errors :errors="errors.phone"/>
               </div>

               <div>
                   <label for="city">City</label>
                   <input :style="getInputStyle('city')" v-model="form.city" type="text" name="city" id="city" class="form-control">
                   <Errors :errors="errors.city"/>
               </div>

               <div>
                   <label for="address">Address</label>
                   <input :style="getInputStyle('address')" v-model="form.address" type="text" name="address" id="address" class="form-control">
                   <Errors :errors="errors.address"/>
               </div>
           </form>
           </Card>
       </div>
       <div>
           <div id="paypal-button-container"></div>
           <div class="error" v-if="errors.server">{{errors.server}}</div>
       </div>
   </div>
    <div class="text-center" v-else>
        <p class="text-lg">Your cart is empty</p>
        <router-link class="btn btn-style" :to="{name:'products.index'}">All products</router-link>
    </div>
</template>
