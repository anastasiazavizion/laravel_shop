<script setup>
import {computed, onMounted, ref} from "vue";
import {useStore} from "vuex";
import {Pie} from 'vue-chartjs'
import {ArcElement, Chart as ChartJS, Legend, Tooltip} from 'chart.js'
import {useIsEmpty} from '@/hooks/utils.js';

const store = useStore();

const chartData = ref(null);

ChartJS.register(ArcElement, Tooltip, Legend)

const isEmpty = useIsEmpty(chartData); // Use the custom hook to check if chartData is empty

function generateRandomHexColor() {
    const randomColor = Math.floor(Math.random() * 0xFFFFFF);
    return `#${randomColor.toString(16).padStart(6, '0')}`;
}


onMounted(async () => {
    await store.dispatch('admin_charts/ordersAmountByCategories');
    const ordersAmountByCategories = await computed(() => {
        return store.getters['admin_charts/ordersAmountByCategories'];
    })

    const labels = Object.keys(ordersAmountByCategories.value);
    const amounts = Object.values(ordersAmountByCategories.value);
    const backgrounds = labels.map(() => generateRandomHexColor());

    chartData.value = {
        labels: labels,
        datasets: [
            {
                data: amounts,
                backgroundColor: backgrounds
            }
        ]
    };
})

const options = {
    responsive: true,
    maintainAspectRatio: false
}
</script>

<template>
    <Pie v-if="!isEmpty" :data="chartData" :options="options"/>
</template>
