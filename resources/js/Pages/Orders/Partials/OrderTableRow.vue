<script setup>
import {computed} from "vue";

const props = defineProps({
    order:Object,
    admin:{
        type:Boolean,
        default:false
    }
})

function getPhone(order){
    return "tel:"+order.phone;
}

import {InformationCircleIcon} from '@heroicons/vue/24/solid';
import Swal from "sweetalert2";
import {useStore} from "vuex";
import {useRouter} from "vue-router";
import StatusLabel from "@/Pages/Orders/Partials/StatusLabel.vue";
import DeleteButton from "@/Components/DeleteButton.vue";

const orderLink = computed(()=>{
    if(props.admin){
        return {name:'admin.orders.show', params:{id:props.order.id}};
    }
    return {name:'user.orders.show', params:{id:props.order.id}};
})

const store = useStore();
const router = useRouter();

async function deleteOrder(id) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    });
    if (result.isConfirmed) {
        await store.dispatch('admin_orders/deleteOrder', {id:id});
        setTimeout(function (){
            router.go(0);
        }, 2000)
    }
}

</script>

<template>
    <tr>
        <td>
            <router-link :to="orderLink">{{order.id}}</router-link>
        </td>
        <td>{{order.name}}</td>
        <td>{{order.lastname}}</td>
        <td>{{order.email}}</td>
        <td><a :href="getPhone(order)">{{order.phone}}</a></td>
        <td>{{order.city}}</td>
        <td>{{order.total}}</td>
        <td>{{order.created_at}}</td>
        <td><StatusLabel class="w-full" :status="order.status"/></td>
        <td>
            <router-link :to="orderLink">
                <InformationCircleIcon class="w-8 cursor-pointer"></InformationCircleIcon>
            </router-link>
        </td>
        <td v-if="admin && can('delete order')">
            <DeleteButton @click="deleteOrder(order.id)"/>
        </td>
    </tr>
</template>
