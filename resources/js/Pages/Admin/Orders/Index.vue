<script setup>
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import OrderTableHeader from "@/Pages/Admin/Orders/Partials/OrderTableHeader.vue";
import OrderTableRow from "@/Pages/Admin/Orders/Partials/OrderTableRow.vue";

const orders = ref([]);
const links = ref([]);
const store = useStore();

onMounted(async () => {
    await loadOrders();
})

async function loadOrders(url = null) {
    await store.dispatch('order_admin/getOrders', {url});
    orders.value = await store.getters['order_admin/orders'];
    links.value = await store.getters['order_admin/links'];
}
</script>

<template>
<div v-if="orders">
    <table class="w-full">
      <OrderTableHeader/>
        <tbody>
        <OrderTableRow :key="order.id" v-for="order in orders" :order="order"/>
        </tbody>
    </table>

    <div class="mt-8 flex gap-1 flex-wrap sm:flex-none">
        <a  @click.prevent="loadOrders(link.url)" v-if="links.length > 3" :class="{'pagination-link-active':link.active, 'opacity-25':!link.url, 'bg-white': !link.active}"  v-html="link.label" class="pagination-link"  v-for="(link,index) in links" :key="index" :href="link.url ? link.url : ''"/>
    </div>
</div>
</template>
