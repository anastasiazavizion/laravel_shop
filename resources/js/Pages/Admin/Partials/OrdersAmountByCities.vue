<script setup>
import {computed, onMounted, ref} from "vue";
import {useIsEmpty} from '@/hooks/utils.js';

const chartData = ref(null);
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import {useStore} from "vuex";
const store = useStore();

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

const isEmpty = useIsEmpty(chartData); // Use the custom hook to check if chartData is empty

onMounted(async () => {
    await store.dispatch('admin_charts/ordersAmountByCities');
    const ordersAmountByCities = await computed(()=>{
        return store.getters['admin_charts/ordersAmountByCities'];
    })

    const labels = Object.keys(ordersAmountByCities.value);
    const amounts = Object.values(ordersAmountByCities.value);
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim();

    chartData.value = {
        labels: labels,
        datasets: [
            {
                label: 'Orders Amount By Cities',
                backgroundColor: primaryColor,
                data: amounts
            }
        ]
    };
})
</script>

<template>
    <Bar v-if="!isEmpty" :data="chartData" />
</template>
