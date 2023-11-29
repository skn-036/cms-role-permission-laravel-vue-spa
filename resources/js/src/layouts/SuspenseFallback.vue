<script setup>
import { defineAsyncComponent, computed } from 'vue';

const components = computed(() => {
    return {
        default: defineAsyncComponent(
            () => import('./suspense-fallback/Default.vue'),
        ),
    };
});

const fallbackComponent = computed(() => {
    return components.value.default;
});
</script>

<template>
    <Component :is="fallbackComponent" />
</template>
