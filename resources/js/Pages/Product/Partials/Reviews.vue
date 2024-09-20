<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {StarIcon} from "@heroicons/vue/24/solid/index.js";
import {onMounted, ref} from "vue";
import Header from "@/Components/Header.vue";
import {useStore} from "vuex";

const props = defineProps({
    product:Object
})

const reviews = ref([]);

onMounted(async () => {
    await store.dispatch('review/getReviews', props.product.slug);
    reviews.value = await store.getters['review/reviews'];
})

const reviewForm = ref({
    id:props.product.id ?? 0,
    description:null,
    rate:props.product.rate ?? null
});
const store = useStore();

function addReview(){
    store.dispatch('review/addReview', reviewForm.value);
}

const ratings =  Array(5).fill().map((_, i) => i + 1);

function starHover(value){
    reviewForm.value.rate = value;
}
</script>

<template>
    <Header class="mt-4">Reviews</Header>
    <form class="mb-4" @submit.prevent="addReview">
        <div>
            <StarIcon
                :class="{'text-yellow-800':(index + 1 ) <= reviewForm.rate}"

                @mouseover="starHover(index + 1)" class="w-8 cursor-pointer" :key="rating" v-for="(rating,index) in ratings"></StarIcon>
        </div>

        <div>
            <label for="title">Review text</label>
            <textarea  v-model="reviewForm.description" name="description" id="description" class="form-control"></textarea>
        </div>

        <div>
            <PrimaryButton type="submit">Add</PrimaryButton>
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
            <div>{{review.user}} <span class="text-sm text-slate-800">{{review.date}}</span></div>
        </div>

        <div v-if="review.description">{{review.description}}</div>
    </div>
</template>
