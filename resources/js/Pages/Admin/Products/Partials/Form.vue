<script setup>
import {computed, onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import {useRoute} from 'vue-router';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import Errors from "@/Components/Errors.vue";
import BaseListBox from "@/Components/BaseListBox.vue";

const router = useRouter();
const route = useRoute();
const store = useStore();
const product = ref(null);
const errors = ref([]);

const props = defineProps({
    edit: Boolean
})

const form = ref({
    id: null,
    title: "",
    SKU: "",
    description: "",
    price: 0,
    discount: 0,
    quantity: 0,
    categories: [],
    images: [],
    thumbnail:null
});

const categories = ref([]);

    onMounted(async () => {
        await store.dispatch('category/getAll');
        categories.value = store.getters['category/categories'];

        if (props.edit) {
        const id = route.params.id;
        const payload = {
            id: id
        };
        await store.dispatch('product/getProduct', payload);
        product.value = store.getters['product/product'];

        form.value.id = id;
        form.value.title = product.value.title;
        form.value.SKU = product.value.SKU;
        form.value.description = product.value.description;
        form.value.price = product.value.price;
        form.value.discount = product.value.discount;
        form.value.quantity = product.value.quantity;
        form.value.categories = store.getters['product/productCategoriesIds'];
        }
    })

async function handleRequest() {

    let formData = new FormData();

    for (const key in form.value) {
        if (Array.isArray(form.value[key])) {
            form.value[key].forEach((item, index) => {
                formData.append(`${key}[${index}]`, item);
            });
        } else {
            formData.append(key, form.value[key]);
        }
    }

    if (props.edit) {
        await store.dispatch('product/updateProduct', {id: route.params.id, data: formData});
    } else {
       await store.dispatch('product/createProduct', formData);
    }
    errors.value = await store.getters['product/errors'];
    if (Object.keys(errors.value).length === 0) {
        await router.push('/admin/products');
    }
}

const btnTitle = computed(() => {
    return props.edit ? 'Update' : 'Create'
})

const header = computed(() => {
    return props.edit ? 'Edit Product' : 'Create Product'
})

function updateThumbnail(event){
    let files = event.target.files;
    if (files.length){
        form.value.thumbnail = files[0];
    }else{
        form.value.thumbnail = null;
    }
}

function updateImages(event){
    let files = event.target.files;
    if (files.length){
        let arr = [];
        for(let f of files){
            arr.push(f);
        }
        form.value.images = arr;
    }else{
        form.value.images = [];
    }
}

</script>

<template>
    <Header>{{ header }}</Header>
    <Card>
        <form @submit.prevent="handleRequest" class="flex flex-col w-full">
            <div>
                <label for="title">Title</label>
                <input type="text" v-model="form.title" name="title" id="title" class="form-control">
                <Errors :errors="errors.title"/>
            </div>

            <div>
                <label for="SKU">SKU</label>
                <input type="text" v-model="form.SKU" name="SKU" id="SKU" class="form-control">
                <Errors :errors="errors.SKU"/>
            </div>

            <div>
                <label for="description">Description</label>
                <input type="text" v-model="form.description" name="description" id="description" class="form-control">
                <Errors :errors="errors.description"/>
            </div>

            <div>
                <label for="price">Price</label>
                <input type="text" v-model="form.price" name="price" id="price" class="form-control">
                <Errors :errors="errors.price"/>
            </div>

            <div>
                <label for="discount">Discount</label>
                <input type="text" v-model="form.discount" name="discount" id="discount" class="form-control">
                <Errors :errors="errors.discount"/>
            </div>

            <div>
                <label for="quantity">Quantity</label>
                <input type="text" v-model="form.quantity" name="quantity" id="quantity" class="form-control">
                <Errors :errors="errors.quantity"/>
            </div>

            <div>
                <label for="categories">Categories</label>
                <BaseListBox name="categories" id="categories" multiple v-model="form.categories" :options="categories" prop-name="name"></BaseListBox>
                <Errors :errors="errors.categories"/>
            </div>

            <div>
                <label for="thumbnail">Thumbnail</label>
                <input @change="updateThumbnail($event)" type="file" name="thumbnail" id="thumbnail">
                <Errors :errors="errors.thumbnail"/>
            </div>

            <div>
                <label for="images">Images</label>
                <input multiple @change="updateImages($event)" type="file" name="images[]">
                <Errors :errors="errors.images"/>
            </div>

            <div>
                <PrimaryButton type="submit">{{ btnTitle }}</PrimaryButton>
            </div>
        </form>
    </Card>
</template>
