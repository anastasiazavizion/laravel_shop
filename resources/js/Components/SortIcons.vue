<script setup>
import {ArrowDownIcon, ArrowUpIcon} from "@heroicons/vue/24/solid";
const emits = defineEmits(['set-sort-data'])
function setSortData(column, direction){
    emits('set-sort-data', column, direction)
}
const props = defineProps({
    column:String,
    sortData:Object
})
function isActiveSortColumn(direction){
    return (props.sortData.column === props.column) && (props.sortData.direction === direction);
}
</script>
<template>
   <div>
       <ArrowDownIcon stroke="2" :class="{'text-red-500':isActiveSortColumn('ASC')}" @click="setSortData(column,'ASC')"
                      class="bold w-4 mr-2 cursor-pointer"></ArrowDownIcon>
       <ArrowUpIcon :class="{'text-red-500':isActiveSortColumn('DESC')}"  @click="setSortData(column,'DESC')" class="bold w-4 cursor-pointer"></ArrowUpIcon>
   </div>
</template>
