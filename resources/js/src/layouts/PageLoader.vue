<script setup>
import { computed, ref, watch } from 'vue';
const props = defineProps({
    loading: {
        type: Boolean,
        default: () => false,
    },
});

const show = ref(props.loading);
const width = ref(0);
const counter = ref(0);

watch(
    () => props.loading,
    (value, oldValue) => {
        if (value) {
            show.value = true;
            increamentCounter();
        } else if (!value && oldValue) {
            setTimeout(() => {
                show.value = false;
                width.value = 0;
                counter.value = 0;
            }, 400);
            width.value = 98;
        }
    },
);

watch(
    () => counter.value,
    () => {
        if (counter.value <= 5) width.value = counter.value * 10;
        else if (counter.value > 5) width.value = 50 + (counter.value - 5) * 5;
    },
);

const increamentCounter = () => {
    if (!props.loading || counter.value > 11) return;

    counter.value++;
    if (counter.value <= 5) setTimeout(increamentCounter, 100);

    if (counter.value > 5) {
        setTimeout(increamentCounter, 1000);
    }
};

const loaderWidth = computed(() => `${width.value}%`);
</script>

<template>
    <div
        v-if="show"
        class="h-1 absolute top-0 left-0 page-loader transition-all duration-100"
        :class="[
            show
                ? 'z-[9999] dark:bg-active bg-active-light'
                : 'z-0 bg-transparent',
        ]"
    ></div>
</template>

<style scoped>
.page-loader {
    width: v-bind('loaderWidth') !important;
}
</style>
