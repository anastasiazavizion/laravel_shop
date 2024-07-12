<script setup>
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import {PencilIcon} from "@heroicons/vue/24/solid";
import {useRouter} from "vue-router";
const store = useStore();
const router = useRouter();

const categories = ref([]);

onMounted(async () => {
    await store.dispatch('category/getAll');
    categories.value = store.getters['category/categories'];
})



async function deleteCategory(id) {
    if(confirm('Are you sure?')){
        await store.dispatch('category/deleteCategory', {id:id});
        router.go(0);
    }
}

</script>

<template>
<Header>All categories</Header>
    <Card>
        <table class="w-full">
            <thead>
            <tr>
                <th>Name</th>
                <th>Parent</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr :key="category.id" v-for="category in categories">
                <td>
                    <router-link :to="{name:'admin.categories.show', params:{id:category.id}}">{{category.name}}</router-link>
                </td>
                <td>{{category.parent ? category.parent.name : ''}}</td>
                <td>
                    <router-link v-if="can('edit category')" :to="{name:'admin.categories.edit', params:{id:category.id}}"><PencilIcon class="w-4 cursor-pointer"></PencilIcon></router-link>
                    <XMarkIcon @click="deleteCategory(category.id)" v-if="can('delete category')" class="w-4 cursor-pointer"></XMarkIcon>
                </td>
            </tr>
            </tbody>
        </table>
    </Card>
</template>
