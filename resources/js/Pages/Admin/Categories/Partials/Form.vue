<script setup>
import Card from "@/Components/Card.vue";
import Errors from "@/Components/Errors.vue";
import Header from "@/Components/Header.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {computed, onMounted, ref} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";
import { useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const store = useStore();

const errors = ref([]);

const form = ref({
    name: "",
    parent_id:null,
    id:null
});

const props = defineProps({
    edit:Boolean
})

const parentCategories  = computed(()=>{
    let allCategories = store.getters['category_admin/categories'];
    if (props.edit) {
        const childrenCategoryIds = allCategories.filter(item =>
            item.parent && item.parent.id == route.params.id
        ).map(item => item.id); // Extract only the IDs
        allCategories = allCategories.filter(item => !childrenCategoryIds.includes(item.id));
    }
    return allCategories;
});

const category  = computed(()=>{
    return store.getters['category_admin/category'];
});

onMounted(async () => {
    await store.dispatch('category_admin/getAll');

    if(props.edit) {
        const id = route.params.id;
        const payload = {
            id: id
        };
        parentCategories.value = parentCategories.value.filter((item)=>item.id != id); //don't include current category
        await store.dispatch('category_admin/getCategory', payload);
        form.value.name = category.value.name;
        form.value.parent_id = category.value.parent ? category.value.parent.id : null;
        form.value.id = id;
    }
})

async function handleRequest() {
    if (props.edit) {
        await store.dispatch('category_admin/updateCategory', { id: route.params.id, data: form.value });
    }else {
        await store.dispatch('category_admin/createCategory', form.value);
    }
    errors.value = await store.getters['category_admin/errors'];
    if(Object.keys(errors.value).length === 0){
        await router.push('/admin/categories');
    }
}

const btnTitle = computed(()=>{
    return props.edit ? 'Update' : 'Create'
})

const header = computed(()=>{
    return props.edit ? 'Edit Category' : 'Create Category'
})
</script>

<template>
    <Header>{{header}}</Header>
    <Card>
        <form @submit.prevent="handleRequest" class="flex flex-col w-full">
            <div>
                <label for="name">Name</label>
                <input type="text" v-model="form.name" name="name" id="name" class="form-control">
                <Errors :errors="errors.name"/>
            </div>
            <div>
                <label for="parent_id">Parent category</label>
                <select v-model="form.parent_id" name="parent_id">
                    <option :value="null">Select</option>
                    <option :key="category.id" v-for="category in parentCategories" :value="category.id">{{category.name}}</option>
                </select>
                <Errors :errors="errors.parent"/>
            </div>
            <div>
                <PrimaryButton type="submit">{{btnTitle}}</PrimaryButton>
            </div>
        </form>
    </Card>
</template>
