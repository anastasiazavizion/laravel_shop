<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import Header from "@/Components/Header.vue";
import Price from "@/Components/Price.vue";

import {TrashIcon} from "@heroicons/vue/24/solid";
import Card from "@/Components/Card.vue";
import ProductDetail from "@/Pages/Product/Partials/ProductDetail.vue";

const store = useStore();

const cartItems = computed(()=>{
    return store.getters['cart/cartItems']
})

const products = ref([]);

onMounted(async () => {
    if(cartItems.value.length > 0){
        const productIds = computed(() => {
            return store.getters['cart/cartItemsProductIds'];
        })

        await store.dispatch('product/getAll', {ids: productIds.value})

        products.value = store.getters['product/products'];

        const updatedCartItems = products.value.map((product, index) => {
            return {
                ...cartItems.value[index],
                final_price: product.final_price,
                quantity: product.quantity,
                title: product.title,
            };
        });

        await store.dispatch('cart/updateCart', updatedCartItems)
    }
})

const cartTotalPrice = computed(()=>{
    return store.getters['cart/cartTotalPrice']
})
function removeFromCart(item){
    store.dispatch('cart/removeFromCart', item)
}
function updateCount(event, id){
    store.dispatch('cart/updateCount', {id:id, amount:parseInt(event.target.value)})
}
function productUrl(product){
    return {name:'products.show', params:{id:product.id}};
}

</script>

<template>
    <Header class="text-center"><span class="text-3xl">Cart</span></Header>

    <div v-if="cartItems.length > 0">
        <div class="grid grid-cols-1 sm:grid-cols-6 gap-4">
            <div class="sm:col-span-4 grid gap-4">
                <div class="py-8 px-4 border border-slate-300 rounded-md grid grid-cols-2 sm:grid-cols-6 gap-4 items-center justify-center" v-for="(item, index) in cartItems">
                    <div>
                        <router-link :to="productUrl(item)"> <img :alt="item.title" class="h-24" :src="item.thumbnail_url"></router-link>
                    </div>
                    <div>
                        <router-link :to="productUrl(item)">{{item.title}}</router-link>
                    </div>
                    <div>
                        <input
                            class="form-control"
                            :value="item.amount"
                            @input="updateCount($event, item.id)"
                            type="number"
                            min="1"
                            :max="item.quantity ?? ''"
                        />
                    </div>
                    <div>
                        <Price>{{item.final_price}}</Price>
                    </div>
                    <div>
                        <Price> {{item.amount * item.final_price}}</Price>
                    </div>
                    <div>
                        <button title="Delete product from cart" @click="removeFromCart(item)"><TrashIcon class="text-black h-8"/></button>
                    </div>
                </div>
            </div>

            <div class="sm:col-span-2  bg-slate-50 p-2 sm:px-4">
                <Header class="text-3xl">Order Summary</Header>

                <div class="grid grid-cols-2 border-b mb-2 pb-2">
                    <div>Total</div>
                    <div><Price>{{cartTotalPrice}}</Price></div>
                </div>




                <div>
                    <button class="btn btn-checkout w-full">Proceed To Checkout</button>
                </div>
            </div>


        </div>
        </div>


    <div v-else>Not yet added products.... </div>




</template>
