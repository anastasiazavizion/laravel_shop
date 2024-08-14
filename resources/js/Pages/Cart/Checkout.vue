<script setup>
import {onMounted, ref, watch} from "vue";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import paypalFunction from "@/Services/Payment/paypal.js";

const form = ref({
    name:null,
    lastname:null,
    email:null,
    phone:null,
    address:null,
    city:null,
});

const emptyFields = ref([]);

function isEmptyField(field){
    return emptyFields.value.length > 0 && emptyFields.value.includes(field)
}

onMounted(()=>{
    paypalFunction(form, emptyFields);
});

function getInputStyle(field){
    return {border: isEmptyField(field) ? '2px solid red' : '1px solid gray'};
}
</script>

<template>

 <Header>Checkout</Header>
   <div class="grid grid-cols-2 gap-4">
       <div>
           <Card>
           <form>
               <div>
                   <label for="name">Name</label>
                   <input :style="getInputStyle('name')" v-model="form.name" type="text" name="name" id="name" class="form-control" >
               </div>

               <div>
                   <label for="lastname">Lastname</label>
                   <input :style="getInputStyle('lastname')"  v-model="form.lastname" type="text" name="lastname" id="lastname" class="form-control" >
               </div>

               <div>
                   <label for="email">Email</label>
                   <input :style="getInputStyle('email')" v-model="form.email" type="text" name="email" id="email" class="form-control" >
               </div>

               <div>
                   <label for="email">Phone</label>
                   <input :style="getInputStyle('phone')" v-model="form.phone" type="text" name="phone" id="phone" class="form-control" >
               </div>

               <div>
                   <label for="city">City</label>
                   <input :style="getInputStyle('city')" v-model="form.city" type="text" name="city" id="city" class="form-control" >
               </div>

               <div>
                   <label for="address">Address</label>
                   <input :style="getInputStyle('address')" v-model="form.address" type="text" name="address" id="address" class="form-control" >
               </div>
           </form>
           </Card>
       </div>

       <div>
           <div id="paypal-button-container"></div>
       </div>
   </div>

</template>
