<script setup>
import {useStore} from "vuex";

const props = defineProps({
    product:Object
})
import {HeartIcon, CurrencyDollarIcon} from "@heroicons/vue/24/solid";
import {computed} from "vue";

const store = useStore();

const emits = defineEmits(['delete-from-wish-list'])

function addToWishList(type){
    if(type === 'price'){
        props.product.is_in_wish_list_price = true;
    }else{
        props.product.is_in_wish_list_exist = true;
    }
    store.dispatch('product/addToWishList', {product:props.product.id, type:type});
}
function removeFromWishList(type){
    console.log('removeFromWishList');
    if(type === 'price'){
        props.product.is_in_wish_list_price = false;
    }else{
        props.product.is_in_wish_list_exist = false;
    }
    store.dispatch('product/removeFromWishList', {product:props.product.id, type:type});

    if(!props.product.is_in_wish_list_price  && !props.product.is_in_wish_list_exist){
        emits('delete-from-wish-list');
    }
}
const authenticated = computed(()=>{
    return store.getters['auth/authenticated'];
})

</script>

<template>
    <div v-if="authenticated">
    <button title="Add to favourite" @click="product.is_in_wish_list_exist ? removeFromWishList('exist') : addToWishList('exist')">
        <HeartIcon :class="{'text-green-500':product.is_in_wish_list_exist}" class="h-8"></HeartIcon>
    </button>
    <button title="Follow on prices change" @click="product.is_in_wish_list_price ? removeFromWishList('price') : addToWishList('price')">
        <CurrencyDollarIcon :class="{'text-green-500':product.is_in_wish_list_price}" class="h-8"></CurrencyDollarIcon>
    </button>
    </div>
</template>
