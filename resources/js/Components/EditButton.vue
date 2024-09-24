<template>
  <button
      class="primary-btn edit-btn"
  >
    <PencilIcon class="w-4 cursor-pointer mr-1"></PencilIcon>Edit <slot />
  </button>
</template>
<script setup>
import {PencilIcon} from "@heroicons/vue/24/solid/index.js";
</script>
