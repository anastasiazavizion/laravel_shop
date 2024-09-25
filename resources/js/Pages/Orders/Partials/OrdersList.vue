<script setup>
import OrderTableHeader from "@/Pages/Orders/Partials/OrderTableHeader.vue";
import OrderTableRow from "@/Pages/Orders/Partials/OrderTableRow.vue";

import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import LoadingButton from "@/Components/LoadingButton.vue";

const store = useStore();
const loading = ref(true);

const orders = computed(()=>{
    return store.getters['order/orders'];
})

const links = computed(()=>{
    return store.getters['order/links'];
})

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
    loading.value = true;
    await store.dispatch('order/getOrders', {url:url, user_id: props.user ? props.user.id : null});
    loading.value = false;
}
</script>

<template>
    <div class="w-full overflow-x-scroll" v-if="orders && !loading">
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

    <div v-else>
        <LoadingButton/>
    </div>

</template>
