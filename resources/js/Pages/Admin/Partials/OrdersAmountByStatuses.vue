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

onMounted(async () => {
    await store.dispatch('admin_charts/ordersAmountByStatuses');
    const ordersAmountByStatuses = await computed(()=>{
        return store.getters['admin_charts/ordersAmountByStatuses'];
    })

    const labels = ordersAmountByStatuses.value.map(obj => obj['name']);
    const amounts = ordersAmountByStatuses.value.map(obj => obj['total']);
    const backgrounds = ordersAmountByStatuses.value.map(obj => obj['color']);

    chartData.value = {
        labels: labels,
        datasets: [
            {
                data: amounts,
                backgroundColor:backgrounds
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
    <Pie  v-if="!isEmpty"  :data="chartData" :options="options" />
</template>
