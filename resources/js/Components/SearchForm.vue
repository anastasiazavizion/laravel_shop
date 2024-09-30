<script setup>
const emits = defineEmits(['handle-keyup'])
let timeoutId = null;
defineProps({
    value:{
        type:[String,null]
    }
})
const handleKeyup = (event) => {
    if (timeoutId) {
        clearTimeout(timeoutId);
    }
     timeoutId = setTimeout(() => {
        emits('handle-keyup', event.target.value)
    }, 500);
};

</script>

<template>
    <form>
        <label class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input :value="value" @keyup="handleKeyup" type="search"  class="block w-full p-4 ps-10  form-control rounded-lg" placeholder="Search..." required />
        </div>
    </form>
</template>
