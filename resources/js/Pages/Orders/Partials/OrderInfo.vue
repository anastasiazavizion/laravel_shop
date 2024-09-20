<script setup>
import {computed, onMounted} from "vue";
import {useRoute} from "vue-router";
import {useStore} from "vuex";

import PrimaryButton from "@/Components/PrimaryButton.vue";
import OrderUserDetails from "@/Pages/Orders/Partials/OrderUserDetails.vue";
import OrderDetails from "@/Pages/Orders/Partials/OrderDetails.vue";
import ProductDetails from "@/Pages/Orders/Partials/ProductDetails.vue";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";

const store = useStore();

const props = defineProps({
    thanks:{
        type:Boolean,
        default:false
    },
    vendor:{
        type:Boolean,
        default:false
    },
    admin:{
        type:Boolean,
        default:false
    }
})

const route = useRoute();

onMounted(async () => {
    if (route.params.id) {
        await store.dispatch(props.vendor ? 'order/getOrderByVendorId' : "order/getOrder",{id:route.params.id});
    }
})

const order =  computed(()=>{
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
        <h1 v-if="thanks" class="text-center font-bold text-lg mb-4">Thank you for order!</h1>
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

        <Card  class="mt-4" v-if="order.transaction && admin">
            <Header>Orders Transaction</Header>
            <div class="flex justify-between mb-4">
                <div>{{order.transaction.payment_system}}</div>
                <div>{{order.transaction.status}}</div>
            </div>
        </Card>

        <div v-if="authenticated && !admin" class="mt-4">
            <PrimaryButton @click="getInvoice(order)">Get Invoice</PrimaryButton>
        </div>
    </div>
    <div v-else>
        <h1 class="text-center font-bold text-lg mb-4">Sorry, cannot find this order...</h1>
    </div>

</template>
