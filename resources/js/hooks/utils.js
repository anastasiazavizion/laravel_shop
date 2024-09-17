import { computed } from 'vue';

function useIsEmpty(data) {
    return computed(() => data.value === null || data.value === undefined || Object.keys(data.value).length === 0);
}

export  {useIsEmpty}
