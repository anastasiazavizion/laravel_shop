<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {StarIcon} from "@heroicons/vue/24/solid/index.js";
import {computed, onMounted, ref} from "vue";
import Header from "@/Components/Header.vue";
import {useStore} from "vuex";
import Errors from "@/Components/Errors.vue";

const store = useStore();

const props = defineProps({
    product:Object
})

async function getReviews() {
    await store.dispatch('review/getReviews', props.product.id);
}
onMounted(async () => {
    await getReviews();
})

const reviews = computed(()=>{
    return store.getters['review/reviews'];
})

const reviewForm = ref({
    id:props.product.id ?? 0,
    description:null,
    rate:props.product.rate ?? null
});

const user = computed(()=>{
    return store.getters['auth/user'];
})

const errors = computed(()=>{
    return store.getters['review/errors'];
})

const currentUserGaveReview = computed(()=>{
    return user.value && reviews.value.map((item)=>item.user.id).includes(user.value.id);
})

async function addReview() {
    await store.dispatch('review/addReview', reviewForm.value);
    await getReviews();
}

const ratings =  Array(5).fill().map((_, i) => i + 1);

function starHover(value){
    reviewForm.value.rate = value;
}
</script>

<template>

    <Header class="mt-4">Reviews</Header>
    <form class="mb-8" @submit.prevent="addReview">
        <div>
            <StarIcon
                :class="{'text-yellow-800':(index + 1 ) <= reviewForm.rate, 'cursor-pointer':!currentUserGaveReview}"

            @mouseover="!currentUserGaveReview ? starHover(index + 1): null" class="w-8" :key="rating" v-for="(rating,index) in ratings"></StarIcon>
            <Errors :errors="errors.rate"/>
        </div>

        <div v-if="!currentUserGaveReview">
            <div>
                <label for="title">Review text</label>
                <textarea  v-model="reviewForm.description" name="description" id="description" class="form-control"></textarea>
                <Errors :errors="errors.description"/>
            </div>

            <div class="mt-4">
                <PrimaryButton type="submit">Add</PrimaryButton>
            </div>
        </div>

    </form>

    <div class="mb-4" :key="index" v-for="(review,index) in reviews">
        <div class="flex justify-between">
           <div>
               <StarIcon
                   :class="{'text-yellow-800':(index + 1 ) <= review.rate}"
                   class="w-8" :key="rating" v-for="(rating,index) in ratings">
               </StarIcon>
           </div>
            <div>{{review.user.name}} <span class="text-sm text-slate-800">{{review.date}}</span></div>
        </div>

        <div v-if="review.description">{{review.description}}</div>
    </div>
</template>
