<script setup>
import {computed, onMounted} from "vue";
import {useRoute} from "vue-router";
import {useStore} from "vuex";
import OrderUserDetails from "@/Pages/Cart/Partials/OrderUserDetails.vue";
import OrderDetails from "@/Pages/Cart/Partials/OrderDetails.vue";
import ProductDetails from "@/Pages/Cart/Partials/ProductDetails.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const routeP = useRoute();
const store = useStore();

onMounted(async () => {
    if (routeP.params.id) {
        await store.dispatch('order/getOrderByVendorId', routeP.params.id);
    }
})
const order = computed(()=>{
    return store.getters["order/order"];
})

const authenticated = computed(()=>{
    return store.getters['auth/authenticated'];
})

function getInvoice(order){
    axios.get(route('v1.invoices.order', order.id)).then((resp)=>{
        window.open(resp.data, '_blank');
    }).catch((error)=>{
        console.log(error);
    })
}
</script>
<template>
<div v-if="order">
    <h1 class="text-center font-bold text-lg mb-4">Thank you for order!</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
        <div class="border border-slate-300 p-2 rounded-md">
            <OrderUserDetails :order="order"/>
        </div>
        <div class="border border-slate-300 p-2 rounded-md">
            <OrderDetails :order="order"/>
        </div>
    </div>
    <div class="mt-4">
        <ProductDetails :order="order"/>
    </div>
</div>
<div v-else>
    <h1 class="text-center font-bold text-lg mb-4">Sorry, cannot find this order...</h1>
</div>

<div v-if="authenticated" class="mt-4">
    <PrimaryButton @click="getInvoice(order)">Get Invoice</PrimaryButton>
</div>
</template>
