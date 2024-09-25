<script setup>
import {ref} from "vue";
import NavbarLinks from "@/Layouts/NavbarLinks.vue";
const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="border-b border-gray-100">
        <div class="default-component">
            <div class="flex justify-between items-center h-16">
                <div class="hidden space-x-8  sm:flex sm:items-center sm:justify-between w-full">
                    <NavbarLinks/>
                </div>

                <div class="sm:hidden">&nbsp;</div>

                <div class="pr-4 flex items-center sm:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white focus:outline-none focus:bg-gray-600 transition duration-150 ease-in-out"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown
                                        }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown
                                        }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="sm:hidden p-4 pt-0"
        >
            <NavbarLinks @close-dropdown="showingNavigationDropdown = false" :mobile="true"/>
        </div>
    </nav>
</template>
