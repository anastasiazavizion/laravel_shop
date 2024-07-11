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

const parentCategories = ref([]);
const errors = ref([]);
const category = ref(null);

const form = ref({
    name: "",
    parent_id:null,
    id:null
});

const props = defineProps({
    edit:Boolean
})

onMounted(async () => {
    await store.dispatch('category/getAll');
    parentCategories.value = store.getters['category/categories'];  //todo remove own id

    if(props.edit) {
        const id = route.params.id;
        const payload = {
            id: id
        };

        parentCategories.value = parentCategories.value.filter((item)=>item.id != id); //don't include

        await store.dispatch('category/getCategory', payload);
        category.value = store.getters['category/category'];
        form.value.name = category.value.name;
        form.value.parent_id = category.value.parent_id;
        form.value.id = id;
    }
})

async function handleRequest() {
    if (props.edit) {
        await store.dispatch('category/updateCategory', { id: route.params.id, data: form.value });
    }else {
        await store.dispatch('category/createCategory', form.value);
    }
    errors.value = await store.getters['category/errors'];
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
                    <option value="">Select</option>
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
