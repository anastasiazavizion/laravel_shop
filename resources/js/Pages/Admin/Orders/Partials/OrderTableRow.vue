<script setup>
defineProps({
    order:Object
})

function getPhone(order){
    return "tel:"+order.phone;
}


</script>

<template>
    <tr>
        <td>
            <router-link :to="{name:'admin.orders.show', params:{id:order.id}}">{{order.id}}</router-link>
        </td>
        <td>{{order.name}}</td>
        <td>{{order.lastname}}</td>
        <td>{{order.email}}</td>
        <td><a :href="getPhone(order)">{{order.phone}}</a></td>
        <td>{{order.city}}</td>
        <td>{{order.total}}</td>
        <td>{{order.created_at}}</td>
    </tr>
</template>
