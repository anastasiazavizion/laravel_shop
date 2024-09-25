<script setup>
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {ChevronDownIcon} from "@heroicons/vue/20/solid/index.js";

defineProps({
    title:String,
    mobile:{
        type:Boolean,
        default:false
    }
})

</script>

<template>
    <Menu as="div" :class="{'inline-block': !mobile}" class="relative text-left dropdown-menu">
        <div>
            <MenuButton  :class="{'justify-center': !mobile}" class="inline-flex w-full gap-x-1.5 rounded-md  py-2 sm:py-0 text-sm font-semibold text-white shadow-sm">
                {{title}}
                <ChevronDownIcon class="-mr-1 h-5 w-5 text-gray-400" aria-hidden="true" />
            </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems :class="{'right-50':mobile, 'right-0':!mobile}" class="absolute z-10 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg focus:outline-none">
               <slot></slot>
            </MenuItems>
        </transition>
    </Menu>
</template>
