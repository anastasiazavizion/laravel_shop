<script setup>
import {onMounted, ref, watch} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import {PencilIcon} from "@heroicons/vue/24/solid";
import Swal from 'sweetalert2';
import ProductLink from "@/Pages/Admin/Products/Partials/ProductLink.vue";
import SortIcons from "@/Components/SortIcons.vue";

const store = useStore();
const router = useRouter();

const products = ref([]);

const sortData = ref({
    column:null,
    direction:null
});

async function loadProducts() {
    await store.dispatch('product_admin/getAll', {sort:sortData.value});
    products.value = store.getters['product_admin/products'];
}


onMounted(async () => {
    await loadProducts();
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

function setSortData(column, direction){
    sortData.value.column = column;
    sortData.value.direction = direction;
}

watch(sortData, ()=>{
    loadProducts();
},{ deep: true })

</script>

<template>
<Header>All products</Header>
    <Card id="products" class="overflow-x-auto">
        <table class="w-full">
            <thead>
            <tr>
                <th>
                    <SortIcons @set-sort-data="setSortData" :sort-data="sortData" column="title"/>
                    Title
                </th>
                <th></th>
                <th>SKU</th>
                <th>Description</th>
                <th>
                    <SortIcons @set-sort-data="setSortData" :sort-data="sortData" column="price"/>
                    Price
                </th>
                <th>
                    <SortIcons @set-sort-data="setSortData" :sort-data="sortData" column="discount"/>
                    Discount
                </th>
                <th>Qantity</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr :key="product.id" v-for="product in products">
                <td>
                    <ProductLink :product="product"/>
                </td>
                <td>
                    <img :src="product.thumbnail_url" class="w-36" :alt="product.title">
                </td>
                <td>{{product.SKU}}</td>
                <td>{{product.description}}</td>
                <td>{{product.price}}</td>
                <td>{{product.discount}}</td>
                <td>{{product.quantity}}</td>
                <td>
                    <router-link v-if="can('edit product')" :to="{name:'admin.products.edit', params:{id:product.slug}}"><PencilIcon class="w-4 cursor-pointer"></PencilIcon></router-link>
                    <XMarkIcon  @click="deleteProduct(product.slug)" v-if="can('delete category')" class="w-4 cursor-pointer"></XMarkIcon>
                </td>
            </tr>
            </tbody>
        </table>
    </Card>
</template>
