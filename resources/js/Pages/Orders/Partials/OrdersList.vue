<script setup>
import OrderTableHeader from "@/Pages/Orders/Partials/OrderTableHeader.vue";
import OrderTableRow from "@/Pages/Orders/Partials/OrderTableRow.vue";

import {onMounted, ref} from "vue";
import {useStore} from "vuex";

const orders = ref([]);
const links = ref([]);
const store = useStore();

onMounted(async () => {
    await loadOrders();
})

const props = defineProps({
    user:Object,
    admin:{
        type:Boolean,
        default:false
    }
})

async function loadOrders(url = null) {
    await store.dispatch('order/getOrders', {url:url, user_id: props.user ? props.user.id : null});
    orders.value = await store.getters['order/orders'];
    links.value = await store.getters['order/links'];
}

</script>

<template>
    <div v-if="orders">
        <table class="w-full text-center">
            <OrderTableHeader :admin="admin"/>
            <tbody>
            <OrderTableRow :admin="admin" :key="order.id" v-for="order in orders" :order="order"/>
            </tbody>
        </table>

        <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
            <a  @click.prevent="loadOrders(link.url)" v-if="links.length > 3" :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"  v-html="link.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link.url ? link.url : ''"/>
        </div>
    </div>
</template>
