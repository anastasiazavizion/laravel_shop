<script setup>
import {onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import {PencilIcon} from "@heroicons/vue/24/solid";

const store = useStore();
const router = useRouter();

const products = ref([]);

onMounted(async () => {
    await store.dispatch('product/getAll');
    products.value = store.getters['product/products'];
})

async function deleteProduct(id) {
    if(confirm('Are you sure?')){
        await store.dispatch('product/deleteProduct', {id:id});
        router.go(0);
    }
}

</script>

<template>
<Header>All products</Header>
    <Card>
        <table class="w-full">
            <thead>
            <tr>
                <th>Title</th>
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
