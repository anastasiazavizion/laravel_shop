<template>
    <button
        class="primary-btn bg-red-800 hover:bg-red-700 focus:bg-red-700 active:bg-red-900"
    >
        <XMarkIcon  class="w-4 cursor-pointer mr-1"></XMarkIcon>Delete <slot />
    </button>
</template>
<script setup>
import {XMarkIcon} from "@heroicons/vue/24/solid/index.js";
</script>
