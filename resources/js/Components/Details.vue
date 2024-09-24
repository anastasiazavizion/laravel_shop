<script setup>
defineProps({
  label:String
})
</script>

<template>
  <div class="flex justify-between">
    <div>{{label}}</div>
    <div><slot></slot></div>
  </div>
</template>
