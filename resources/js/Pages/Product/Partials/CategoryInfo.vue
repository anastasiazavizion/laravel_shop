<script setup>

const props = defineProps({
    checkedCategories:{
        type:Array,
        default:[]
    },
    categories: {
        type:Array,
        default:[]
    },
    categoryName: {
        type: [String, null],
        default:null,
    }
})

function getCkbxId(id) {
    return "filter-category-" + id;
}

const isChecked = (category) => {
    const index = props.checkedCategories.indexOf(category.id);
    return (props.categoryName !== ''  && (props.categoryName === category.slug)) || (index !== -1);
};

const emits = defineEmits(['handle-ckbx']);
</script>

<template>
    <div class="category" v-for="category in categories" :key="category.id">
        <input :disabled="categoryName !== ''" :checked="isChecked(category) " @click="emits('handle-ckbx',category.id)"
               :id="getCkbxId(category.id)" name="category[]" type="checkbox">
        <label :for="getCkbxId(category.id)">{{ category.name }}</label>
        <CategoryInfo
            :checked-categories="checkedCategories"
            :category-name="categoryName"
            v-if="category.children && category.children.length"
            :categories="category.children"
            @handle-ckbx="emits('handle-ckbx', $event)"
        />
    </div>
</template>
