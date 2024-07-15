<script setup>
import {computed} from 'vue'
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import {ChevronUpDownIcon, CheckIcon} from "@heroicons/vue/20/solid/index.js";

const props = defineProps({
    options:Array,
    modelValue:[String, Number, Array],
    multiple:Boolean,
    propName: {
        type:String,
        default:'label'
    }
})

const selectedOptionLabel = computed(()=>{
    return  props.options.filter((option) => {
        if (Array.isArray(props.modelValue)) {
            return props.modelValue.includes(option.id)
        }
        return props.modelValue === option.id;
    }).map(option => option[props.propName]).join(',');
});

const emit = defineEmits(['update:modelValue'])
</script>
<template>
    <Listbox
        :multiple="multiple"
        @update:modelValue="value => emit('update:modelValue', value)"
        :model-value="props.modelValue">
        <div class="relative mt-1">
            <ListboxButton
                class="relative w-full cursor-default rounded-lg bg-white py-2 pl-3 pr-10 text-left shadow-md focus:outline-none focus-visible:border-indigo-500 focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-orange-300"
            >
                <span v-if="selectedOptionLabel" class="block truncate">{{selectedOptionLabel}}</span>
                <span v-else class="block truncate text-gray-500">Select option</span>
                <span
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                >
            <ChevronUpDownIcon
                class="h-5 w-5 text-gray-400"
                aria-hidden="true"
            />
          </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="z-10 absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none"
                >
                    <ListboxOption
                        v-slot="{ active, selected }"
                        v-for="option in options"
                        :key="option[propName]"
                        :value="option.id"
                        as="template"
                    >
                        <li
                            :class="[
                  active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
                  'relative cursor-default select-none py-2 pl-10 pr-4',
                ]"
                        >
                <span
                    :class="[
                    selected ? 'font-medium' : 'font-normal',
                    'block truncate',
                  ]"
                >{{ option[propName] }}</span
                >
                            <span
                                v-if="selected"
                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
                            >
                  <CheckIcon class="h-5 w-5" aria-hidden="true" />
                </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>
