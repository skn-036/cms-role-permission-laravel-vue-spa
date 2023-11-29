<script setup>
import { computed } from 'vue';
import LayoutFull from './LayoutFull.vue';
import LayoutDashboard from './LayoutDashboard.vue';

import useAppRouter from '../composables/useAppRouter';
const { routeMeta } = useAppRouter();

const layout = computed(() =>
    routeMeta.value?.layout ? routeMeta.value.layout : 'full',
);
</script>

<template>
    <div>
        <LayoutDashboard v-if="layout === 'dashboard'" />

        <!-- full layout -->
        <LayoutFull v-else-if="layout === 'full'" />
    </div>
</template>
