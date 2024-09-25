<script setup>
import {onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import {useRouter} from "vue-router";
import EditButton from "@/Components/EditButton.vue";
import DeleteButton from "@/Components/DeleteButton.vue";
import Swal from "sweetalert2";
const store = useStore();
const router = useRouter();

const categories = ref([]);

onMounted(async () => {
    await store.dispatch('category_admin/getAll');
    categories.value = store.getters['category_admin/categories'];
})


async function deleteCategory(id) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    });
    if (result.isConfirmed) {
        await store.dispatch('category_admin/deleteCategory', {id:id});
        setTimeout(function (){
            router.go(0);
        }, 2000)
    }

}

</script>

<template>
<Header>All categories</Header>
    <Card v-if="categories">
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
                    <div class="flex gap-4 flex-col">
                        <router-link v-if="can('edit category')" :to="{name:'admin.categories.edit', params:{id:category.id}}">
                            <EditButton class="w-full"/>
                        </router-link>
                        <DeleteButton class="w-full" @click="deleteCategory(category.id)" v-if="can('delete category')"/>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </Card>
</template>
