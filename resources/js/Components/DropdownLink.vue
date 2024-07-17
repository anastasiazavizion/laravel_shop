<script setup>
import { MenuItem } from "@headlessui/vue";
import { useRouter } from 'vue-router';

defineProps({
    to: [String, Object]
});

const router = useRouter();

function handleClick(to, close) {
    router.push(to);
    close(); // Close the menu after navigation
}
</script>

<template>
    <div class="py-1">
        <MenuItem v-slot="{ active, close }">
            <button @click="handleClick(to, close)" :class="[active ? 'bg-gray-100' : '', 'w-full text-gray-700 block px-4 py-2 text-sm']">
                <slot></slot>
            </button>
        </MenuItem>
    </div>
</template>
