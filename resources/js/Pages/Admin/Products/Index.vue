<script setup>
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import {PencilIcon} from "@heroicons/vue/24/solid";
import Swal from 'sweetalert2';
const store = useStore();
const router = useRouter();

const products = ref([]);

onMounted(async () => {
    await store.dispatch('product_admin/getAll');
    products.value = store.getters['product_admin/products'];
})

async function deleteProduct(id) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    });
    if (result.isConfirmed) {
        await store.dispatch('product_admin/deleteProduct', {id:id});
        setTimeout(function (){
            router.go(0);
        }, 2000)
    }
}
</script>

<template>
<Header>All products</Header>
    <Card id="products">
        <table class="w-full">
            <thead>
            <tr>
                <th>Title</th>
                <th></th>
                <th>SKU</th>
                <th>Description</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Qantity</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr :key="product.id" v-for="product in products">
                <td>
                    <router-link :to="{name:'admin.products.show', params:{id:product.id}}">{{product.title}}</router-link>
                </td>
                <td>
                    <img :src="product.thumbnail_url" class="w-36">
                </td>
                <td>{{product.SKU}}</td>
                <td>{{product.description}}</td>
                <td>{{product.price}}</td>
                <td>{{product.discount}}</td>
                <td>{{product.quantity}}</td>
                <td>
                    <router-link v-if="can('edit product')" :to="{name:'admin.products.edit', params:{id:product.id}}"><PencilIcon class="w-4 cursor-pointer"></PencilIcon></router-link>
                    <XMarkIcon  @click="deleteProduct(product.id)" v-if="can('delete category')" class="w-4 cursor-pointer"></XMarkIcon>
                </td>
            </tr>
            </tbody>
        </table>
    </Card>
</template>
